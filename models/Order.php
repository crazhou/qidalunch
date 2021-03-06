<?php
namespace app\models;


use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class Order extends ActiveRecord {

    public static function tableName()
    {
        return '{{%order_record}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }
    /*
     * 创建订单
     */
    public static function addOrder($rows, $volume)
    {
        $db = self::getDb();
        $transaction = $db->beginTransaction();

        $user_id = $rows[0]['user_id'];

        try {
            // 创建订单
            $db->createCommand()->batchInsert(self::tableName(), array_keys($rows[0]), $rows)->execute();

            // 扣除余额
            $db->createCommand('UPDATE fund set user_balance = user_balance - :volume where user_id = :user_id;')
                ->bindValues([':volume'=>$volume, ':user_id'=>$user_id])
                ->execute();
            // 写入记录
            $db->createCommand()->insert('recharge_record', [
                'change_amount' => $volume * -1,
                'user_id' => $user_id,
                'createor' => $user_id,
                'type' => 1,
                'created_at' => new Expression('NOW()'),
                'updated_at' => new Expression('NOW()'),
            ])->execute();

            // 更新菜品被点次数
            $dish_ids = implode(',', array_keys(ArrayHelper::map($rows, 'dish_id', 'dish_count')));
            $db->createCommand('update dish A set A.dish_click_count = (select sum(B.dish_count) from order_record B where B.dish_id = A.id) where A.id in '
            . "({$dish_ids})"
            )->execute();

            $transaction->commit();

        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /*
     * 取消订单
     */
    public static function cancelOrder($orderId)
    {

    }

    /*
     * 查找指定用户今日订单
     */
    public static function todayOrder($user_id)
    {
        $db = self::getDb();

        $result = $db->createCommand('SELECT id, type, user_id FROM recharge_record WHERE user_id = :user_id AND date(created_at) = curdate() AND type = 1 ', [
            ':user_id' => $user_id,
        ])->queryAll();

        return $result;
    }

    /*
     * 今天总订单数
     */
    public static function todayCount() {
        $db = self::getDb();
        $result = $db->createCommand('SELECT count(id) as Volume FROM recharge_record WHERE date(created_at) = curdate() and type = 1')
            ->queryOne();
        return $result;
    }

    /*
     * 今天被点的菜单
     */
    public static function todayUseMenu()
    {
        $db = self::getDb();
        $q = $db->createCommand(
            'select id, menu_name,menu_telephone from dish_menu where id in (select distinct dish_menu_id from order_record where date(created_at) = curdate())'
        )->queryAll();
        return $q;
    }

    /*
     * 今日点的菜汇总
     */
    public static function todayUseDish()
    {
        $db = self::getDb();
        $q = $db->createCommand(
            'select id as order_id,user_id,dish_id, dish_name, dish_price, SUM(dish_count) as volume, dish_menu_id from order_record where date(created_at) = curdate() group by dish_id;'
        )->queryAll();
        return $q;
    }

    /*
     * 每个菜由哪些用户点了
     */
    public static function todayUserDish()
    {
        $db = self::getDb();
        $q = $db->createCommand(
            'select B.user_id ,A.user_name, B.dish_id, B.dish_count from order_record B INNER JOIN user A on date(B.created_at) = curdate() AND B.user_id = A.id;'
        )->queryAll();
        return $q;
    }
}