<?php
namespace app\controllers;

use app\models\Dish;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class DishController extends Controller{

    public function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    public function actionList($id = '', $page = 1)
    {
        $pageSize = Yii::$app->params['pageSize'];
        $pageNo = $page < 1 ? 0 : $page-1;
        $inwhere = [0, (date('j')<=15)?1:2];
        $dishs = Dish::find()
            ->where(['dish_menu_id' => $id, 'dish_open_time'=>$inwhere])
            ->orderBy('dish_click_count desc')
            ->addOrderBy('dish_price')
            ->offset($pageNo * $pageSize)
            ->limit($pageSize)
            ->all();

        return [
            'ret' => 0,
            'dataset' => $dishs,
            'page' => $page
        ];
    }
}