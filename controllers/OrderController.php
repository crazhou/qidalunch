<?php
namespace app\controllers;

use app\models\Dish;
use app\models\Order;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\models\Ye;
use app\models\Menu;
use yii\web\Response;

class OrderController extends Controller {

    private $countdown = 0;

    public function init()
    {
        $this->countdown = Ye::getCountdown();
    }

    /*
     * 创建定单
     */
    public function actionAddOrder()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;
        $sess = Yii::$app->session;
        $user_id = $sess->get('current_user')->getAttribute('id');

        $menu = Menu::findOne($req->post('menuid'));
        $order_detail = $req->post('order_detail');
        $dishids = [];
        $rows = [];

        foreach(explode('|', $order_detail) as $k => $v) {
            $tmp = explode(':', $v);
            // 菜单ID 列表
            $dishids[]  = $tmp[0];
            // 订单中的多条记录
            $rows[] = [
               'user_id'=> $user_id,
               'dish_menu_id' => $menu->getAttribute('id'),
               'dish_menu_name' => $menu->getAttribute('menu_name'),
               'dish_id' => (int)$tmp[0],
               'dish_count' => $tmp[1],
               'dish_name' => 0,
               'dish_price' => 0,
            ];
        }
        $dishDB = Dish::findAll($dishids);
        foreach($dishDB as $v) {
            $dishs[$v->id] = $v;
        }
        foreach($rows as $k=>$v) {
            $rows[$k]['dish_name'] = $dishs[$v['dish_id']]->dish_name;
            $rows[$k]['dish_price'] = $dishs[$v['dish_id']]->dish_price;
        }

        // TODO 点餐时限判断， 二次点餐提醒

        Order::addOrder($rows, (float)$req->post('order_volume'));

    }

    /*
     * 列出今日定单
     */
    public function actionListOrder()
    {

    }
}