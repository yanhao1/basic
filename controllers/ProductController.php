<?php
namespace app\controllers;
use yii\web\Controller;
class ProductController extends  controller
{

    public function actionIndex(){
        return $this->render("index");
    }
}
?>