<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
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
        return static::findOne(['id' => $id]);
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
}
