<?php
namespace app\controllers;

use app\models\Dish;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class DishController extends Controller{

    public function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;
        if(! $req->isAjax) {
            throw new ForbiddenHttpException('非法请求！');
        }
    }

    public function actionList($id = '', $page = 1)
    {
        $pageSize = Yii::$app->params['pageSize'];
        $pageNo = $page < 1 ? 0 : $page-1;
        $inwhere = [0, (date('j')<=15)?1:2];
        $query = Dish::find()
            ->select(['id', 'dish_name', 'dish_price', 'dish_click_count'])
            ->where(['dish_menu_id' => $id, 'dish_open_time'=>$inwhere]);

        $countQuery = clone $query;

        $dishs = $query->orderBy('dish_click_count desc')
            ->addOrderBy('dish_price')
            ->offset($pageNo * $pageSize)
            ->limit($pageSize)
            ->all();

        return [
            'ret' => 0,
            'dataset' => $dishs,
            'page' => $page,
            'pageSize' => $pageSize,
            'totalPages' => ceil($countQuery->count()/$pageSize)
        ];
    }

    /*
     * 增加一个菜品
     */
    public function actionAdddish()
    {
        $dish = new Dish();
        $req = Yii::$app->request;
        $dish->dish_name = $req->post('dishName');
        $dish->dish_price = $req->post('price', 0);
        $dish->dish_open_time  = $req->post('openOn', 0);
        $dish->dish_menu_id = $req->post('menuid');

        $b = $dish->save();
        if($b) {
            return [
                'ret' => 0,
                'msg' => 'ok',
            ];
        }

    }

    /*
     * 更新一个菜品
     */
    public function actionSavedish()
    {

    }
    /*
     * 删除一个菜品
     */
    public function actionDeldish($id = '')
    {
        $dish = Dish::findOne($id);
        if($dish->delete()) {
            return [
                'ret' => 0,
                'msg' => '删除成功！'
            ];
        }
    }
}