<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\User;
use app\models\Ye;

class UserController extends Controller
{

    private $countdown = 0;

    public function init()
    {
        $this->countdown = Ye::getCountdown();
    }
    /*
     * 普通用户点餐
     */
    public function actionDian($short = '')
    {
        $data = [
            'hasCount' => TRUE,
            'countdown' => $this->countdown,
        ];
        if($short !== '') {
            $data['user'] = User::findByUsername($short);
            $this->render('dian', $data);
        } else {
            return $this->render('/entry/empty');
        }
    }

    /*
     * 管理员点餐
     */
    public function actionAdmin($short= '')
    {
        $data = [
            'hasCount' => TRUE,
            'countdown' => $this->countdown,
        ];

        if($short !== '') {
            $data['user'] = User::findByUsername($short);
            $this->render('admin', $data);
        } else {
            return $this->render('/entry/empty');
        }
    }
}
