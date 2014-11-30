<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Dish extends ActiveRecord {


    public static function tableName()
    {
        return '{{%dish_menu}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}