<?php
namespace app\modules\controllers;
use app\models\Category;
use yii\web\Controller;
use app\modules\controllers\CommonController;
use Yii;

class CategoryController extends CommonController
{
    /*
     * 商品分类列表
     */
    public function actionList()
    {
        $this->layout = "layout1";
        $model = new Category;
        $cates = $model->getTreeList();
        return $this->render("cates", ['cates' => $cates]);
    }


    public function actionAdd()
    {
        $model = new Category();
        $list = $model->getOptions();
        $this->layout='layout1';
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->add($post)){
                Yii::$app->session->setFlash('info','添加成功');
            }
        }
        return $this->render("add", ['list' => $list, 'model' => $model]);
    }

}