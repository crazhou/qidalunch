<?php

namespace app\controllers;

use Yii;
use app\models\Ye;
use yii\web\Controller;
use app\models\User;
use app\models\Dish;

class EntryController extends Controller
{
    private $countdown = 0;

    public function init()
    {
        $this->countdown = Ye::getCountdown();
    }
    /*
     * 用户统欢迎页
     */
    public function actionIndex()
    {
        $users = User::findAll(['status'=>1]);
        return $this->render('index1', [
            'users' => $users,
            'countdown' => $this->countdown,
            'hasCount' => FALSE,
        ]);
    }

    /*
     * 指定用户欢迎页
     */
    public function actionU($short)
    {
        $user = User::findByUsername($short);
        $data = [
            'user' => $user,
            'hasCount' => FALSE,
            'countdown' => $this->countdown,
        ];

        if(!is_null($user)) {
            return $this->render('index',$data);
        } else {
            return $this->render('empty', $data);
        }
    }

    public function actionChooseMenu() {

        $data= [
            'hasCount' => FALSE,
            'countdown' => $this->countdown,
            'menus' => Dish::find()->orderBy('updated_at desc')->all(),
        ];
        return $this->render('choosemenu', $data);
    }

    public function actionError() {
        return '发生了一个错误！';
    }
}
