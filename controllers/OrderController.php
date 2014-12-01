<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Ye;

class OrderControler extends Controller {


    public function init()
    {
        $this->countdown = Ye::getCountdown();
    }

    /*
     * 创建定单
     */
    public function actionAddOrder()
    {

    }

    /*
     * 列出今日定单
     */
    public function actionListOrder()
    {

    }
}