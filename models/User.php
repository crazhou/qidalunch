<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\Query;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const GENDER_MALE = 'm';
    const GENDER_FEMALE = 'f';
    const GENDER_UNKNOWN = 'x';

    public $id;
    public $short;

    public static function tableName()
    {
        return '{{%user}}';
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

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('此方法未实现');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['user_spell' => $username,'status' => 1]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /*
     * 用户余额列表
     */
    public static function getUserBalance()
    {
        $q = (new Query)
            ->from('user A')
            ->select('A.id, A.user_name, A.user_sex, A.user_spell,B.user_balance as balance')
            ->innerJoin('fund B', 'B.user_id = A.id AND A.status = 1')
            ->orderBy('balance')
            ->all();

        return $q;
    }

    /*
     * 添加用户
     */
    public function addUser()
    {
        $db = static::getDb();
        try {
            if($this->save()) {
                $user_id = $this->getPrimaryKey();
                // 更新用户余额表
                $affect = $db->createCommand()
                    ->insert('fund',[
                        'user_id' => $user_id,
                        'user_balance' => 0,
                        'user_total_amount'=> 0,
                        'created_at' => new Expression('NOW()'),
                        'updated_at' => new Expression('NOW()'),
                    ])
                    ->execute();
                return $affect;
            }
        } catch(Exception $e) {
            return $e->getName();
        }
    }
    /*
     * @volume 金额
     * @createor 充值操作者
     * 为用户充值
     */
    public function charge($volume, $cid)
    {
        $db = self::getDb();
        $user_id = $this->getPrimaryKey();
        $a1 = $db->createCommand()->insert('recharge_record', [
            'user_id' => $user_id,
            'change_amount' => $volume,
            'createor'  => $cid,
            'type' => 2,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
        ])->execute();
        $a2 = $db->createCommand('update fund set user_balance = user_balance + :volume,user_total_amount = user_total_amount + :volume where user_id = :user_id;')
            ->bindValue(':volume', $volume)
            ->bindValue(':user_id', $user_id)
            ->execute();
        return $a1 > 0 AND $a2 > 0;
    }

    /*
     * 点餐记录
     */
    public function getMyOrder()
    {
        $db = self::getDb();
        $user_id = $this->getPrimaryKey();
        $res = $db->createCommand('SELECT user_id, dish_menu_name, dish_name, dish_count, date(created_at) as date FROM order_record WHERE user_id = :user_id limit 100')
            ->bindValue(':user_id', $user_id)
            ->queryAll();
        return $res;
    }

    /*
     * 消费记录
     */
    public function getMyCharge()
    {
        $db = self::getDb();
        $user_id = $this->getPrimaryKey();
        $res = $db->createCommand('SELECT A.user_id, A.createor, A.change_amount, date(A.created_at) as date, weekday(A.created_at) as weekindex,date(A.created_at) = curdate() as today FROM recharge_record A INNER JOIN user B on B.id = A.user_id AND B.id = :user_id order by A.created_at desc limit 100;')
            ->bindValue(':user_id', $user_id)
            ->queryAll();
        return $res;
    }

    public function getMyBalance()
    {
        // $db = self::getDb();
        $user_id = $this->getPrimaryKey();
        $res = (new Query())
            ->select(['user_balance', 'user_total_amount', 'user_id'])
            ->from('fund')
            ->where('user_id=:id',[':id'=> $user_id])
            ->one();
        return $res;
    }
}
