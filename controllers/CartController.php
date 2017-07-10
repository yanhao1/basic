<?php
namespace app\controllers;
use yii\web\controller;

class CartController extends controller
{
    public function actionIndex(){
        return $this->render("index");
    }

}

