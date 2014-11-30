<?php

namespace app\controllers;

use Yii;
use app\models\Ye;
use yii\web\Controller;
use app\models\User;
use app\models\Menu;

class EntryController extends Controller
{
    private $countdown = 0;

    public function init()
    {
        $this->countdown = Ye::getCountdown();
        $sess = Yii::$app->session;
        $cache = Yii::$app->cache;
        if($sess->has('current_user') AND $cache->exists('admin_user')) {
            if($sess->get('current_user')->getAttribute('id') === $cache->get('admin_user')) {
                $this->redirect('user/admin');
            } else {
                $this->redirect('user/dian');
            }
        }
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
            $data['error'] = '找到不指定用户';
            return $this->render('error', $data);
        }
    }

    public function actionChooseMenu($id)
    {
        $sess = Yii::$app->session;
        $cache = Yii::$app->cache;
        $data= [
            'hasCount' => FALSE,
            'countdown' => $this->countdown,
            'menus' => Menu::find()->orderBy('updated_at desc')->all(),
        ];

        // 设置管理员和当前用户
        $user = User::findByUsername($id);
        // 设置当前用户
        $sess->set('current_user', $user);
        // 设置管理员
        $cache->set('admin_user', $user->getAttribute('id'), 3600);
        $cache->set('admin_name', $user->getAttribute('user_name'), 3600);

        return $this->render('choosemenu', $data);
    }

    public function actionClear()
    {
        Yii::$app->cache->flush();
        return '缓存清除成功！';
    }

    public function actionError()
    {
        $data = [
            'hasCount' => FALSE,
            'error' => '发生了一个错误'
        ];

        return $this->render('error', $data);
    }
}
