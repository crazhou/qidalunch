<?php
namespace app\models;

use Yii;
use yii\base\Object;

class Ye extends Object {

    /*
     * 获取剩余的秒数
     */
    public static function getCountdown()
    {
        $startTime = Yii::$app->params['startTime'];
        $endTime = Yii::$app->params['endTime'];
        $reqtime = $_SERVER['REQUEST_TIME'];
        $stime = (new \DateTime($startTime))->getTimestamp();
        $etime = (new \DateTime($endTime))->getTimestamp();

        if( $reqtime > $stime AND $reqtime < $etime) {
            return $etime - $reqtime;
        } else {
            return -1;
        }

    }
}