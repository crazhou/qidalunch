<?php
namespace app\models;


use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
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
            ])->execute();

            // 更新菜品被点次数
            $dish_ids = implode(',', array_keys(ArrayHelper::map($rows, 'dish_id', 'dish_count')));
            $db->createCommand('update dish A set A.dish_click_count = (select sum(B.dish_count) from order_record B where B.dish_id = A.id) where A.id in '
            . "({$dish_ids})"
            )->execute();

            $transaction->commit();

            return TRUE;

        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /*
     * 取消订单
     */
    public function cancelOrder($orderId)
    {

    }
}