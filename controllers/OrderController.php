<?php
namespace app\controllers;

use app\models\Dish;
use app\models\Order;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use app\models\Ye;
use app\models\Menu;
use yii\web\JsonResponseFormatter;
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

        // 判断时效
        if($this->countdown < 0 ) {
            return [
                'ret' => 1,
                'errorMsg' => '点餐时间已过,明天早点过来吧'
            ];
        }

        if($req->post('force', 100) === 100) {
            $res = Order::todayOrder($user_id);
            $count = count($res);
            if($count > 0 ) {
                return [
                    'ret' => 2,
                    'errorMsg' => '你今天已经点了<span class="color-red"> '.$count.'</span> 单，还要再点吗？',
                ];
            }
        }


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
                'created_at' => new Expression('NOW()'),
                'updated_at' => new Expression('NOW()'),
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

        Order::addOrder($rows, (float)$req->post('order_volume'));

        return [
            'ret' => 0,
            'msg' => '订单创建成功！',
        ];

    }

    /*
     *  个人订单历史
     */
    public function actionHistory()
    {
        $sess = Yii::$app->session;

        $data = [
            'user' => $sess->get('current_user')
        ];
        return $this->render('history', $data);
    }

    /*
     * 当日订单汇总
     */
    public function actionTotal()
    {
        $sess = Yii::$app->session;

        $menus = Order::todayUseMenu();
        $dishs = Order::todayUseDish();
        $userDishs = Order::todayUserDish();

        $data = [
            'user' => $sess->get('current_user'),
            'menus' => $menus,
            'dishs' => $dishs,
            'userdishs' => $userDishs,
        ];
        return $this->render('total', $data);
    }

    public function actionTodaycount()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $q = Order::todayCount();

       return [
           'ret' => 0,
           'dataset' => $q,
       ];
    }
}