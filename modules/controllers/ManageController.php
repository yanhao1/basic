<?php
namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use app\modules\models\Admin;
use yii\data\Pagination;
use app\modules\controllers\CommonController;

class ManageController extends CommonController
{
    /*
     * 用户列表
     */
    public function actionManagers()
    {
        $this->layout = "layout1";
        $model = Admin::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['manage'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("managers", ['managers' => $managers, 'pager' => $pager]);
    }
    /*
     * 添加用户
     */
    public function actionReg()
    {
        $this->layout = 'layout1';
        $model = new Admin;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            } else {
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }
        $model->adminpass = '';
        $model->repass = '';
        return $this->render('reg', ['model' => $model]);
    }
    /*
     * 删除用户
    */
    public function actionDel()
    {
        $adminid = (int)Yii::$app->request->get("adminid");
        if (empty($adminid) || $adminid == 1) {
            $this->redirect(['manage/managers']);
            return false;
        }
        $model = new Admin;
        if ($model->deleteAll('adminid = :id', [':id' => $adminid])) {
            Yii::$app->session->setFlash('info', '删除成功');
            $this->redirect(['manage/managers']);
        }
    }
    /*
     * 修改邮箱
     */
    public function actionChangeemail()
    {
        $this->layout = 'layout1';
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changeemail($post)) {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $model->adminpass = "";
        return $this->render('changeemail', ['model' => $model]);
    }
    /*
     * 修改密码
     */
    public function actionChangepass()
    {
        $this->layout = "layout1";
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changepass($post)) {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $model->adminpass = '';
        $model->repass = '';
        return $this->render('changepass', ['model' => $model]);
    }


}