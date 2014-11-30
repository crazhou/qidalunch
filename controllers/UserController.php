<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Menu;
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
        $sess = Yii::$app->session;
        $cache = Yii::$app->cache;
        $data = [
            'hasCount' => TRUE,
            'countdown' => $this->countdown,
            'fixed'  => TRUE,
        ];
        if($short !== '') {
            $user = User::findByUsername($short);
            $sess->set('current_user', $user);
            $data['user'] = $user;
            if(is_null($user)) {
                return $this->redirect('/entry/error');
            }
        } else {
            $data['user'] = $sess->get('current_user');
        }
        $data['menus'] = $cache->get('menus');
        return $this->render('dian', $data);
    }

    /*
     * 管理员点餐
     */
    public function actionAdmin($menuid = '')
    {
        $cache = Yii::$app->cache;
        $sess = Yii::$app->session;

        $data = [
            'hasCount' => TRUE,
            'countdown' => $this->countdown,
            'fixed' => TRUE, // 使用固定布局
        ];
        if(!empty($menuid)) {
            $menus = explode(',', $menuid);
            $cache->set('menu_ids', $menuid, 3600);
        } else {
            $menus = explode(',', $cache->get('menu_ids'));
        }

        $data['user'] = $sess->get('current_user');
        $data['menus'] = Menu::findAll($menus);

        $cache->set('menus', $data['menus'], 3600);

        return $this->render('admin' , $data);
    }

    public function actionList()
    {

    }
}
