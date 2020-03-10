<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2016/12/18 19:02
// +----------------------------------------------------------------------
// | TITLE: 用户管理
// +----------------------------------------------------------------------

namespace apps\backend\modules\admin\controllers;

use common\models\admin\AdminUserSearch;
use Yii;
use common\models\admin\AdminUser;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\admin\AdminRole;

/**
 * Class AdminUserController
 * @package backend\controllers
 */
class AdminUserController extends \apps\backend\controllers\BaseController
{
    /**
     * Lists all LoveQuestionnaireSys models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single AdminUser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * 创建用户
     * @return array|string
     */
    public function actionCreate()
    {
        $AdminUser = new AdminUser(['scenario' => AdminUser::SCENARIO_CREATE]);
        if (Yii::$app->request->isPost){

            $AdminUserData = Yii::$app->request->post('AdminUser');
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(strlen($AdminUserData['password']) < 6 ||strlen($AdminUserData['password']) >20 ){
                return ['code' => 400, 'message' => '密码长度为6到20位'];
            }

            if ($AdminUserData['repassword'] != $AdminUserData['password']){
                return ['code' => 400, 'message' => '密码跟重复密码不一致'];
            }
//            if (strlen($AdminUserData['code']) != 4){
//                return ['code' => 400, 'message' => '推荐码填写不正确'];
//            }
            if (empty($AdminUserData['role_id'])){
                return ['code' => 400, 'message' => '请选择角色'];
            }
            if (empty($AdminUserData['mobile'])){
                return ['code' => 400, 'message' => '请填写手机号'];
            }
            $Info1 = $AdminUser::find()->where(['=', 'username', $AdminUserData['username']])->one();
            if ($Info1){
                return ['code' => 400, 'message' => '用户名已存在，请填写其它用户名！'];
            }
//            $Info2 = $AdminUser::find()->where(['=', 'code', $AdminUserData['code']])->one();
//            if ($Info2){
//                return ['code' => 400, 'message' => '推荐码已存在，请填写其它推荐码！'];
//            }
            $AdminUser->role_id = implode(',',$AdminUserData['role_id']);
            $AdminUser->username = $AdminUserData['username'];
            $AdminUser->mobile = $AdminUserData['mobile'];
            $AdminUser->password_hash = Yii::$app->security->generatePasswordHash($AdminUserData['password']);
            if ($AdminUser->save()) {
                return ['code' => 200, 'message' => '添加成功'];
            }else{
                return ['code' => 400, 'message' => $error=array_values($AdminUser->getFirstErrors())[0]];
            }
        }else {
            return $this->render('create', ['model' => $AdminUser]);
        }
    }


    /**
     * 更新角色
     * @return array|string
     */
    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        $model = AdminUser::findOne($id);
        $model->scenarios( AdminUser::SCENARIO_UPDATE);
        if (Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $AdminUser= Yii::$app->request->post('AdminUser');
            if (!empty($AdminUser['password'])) {
                if ($AdminUser['repassword'] != $AdminUser['password']){
                    return ['code' => 400, 'message' => '密码跟重复密码不一致'];
                }
                if(strlen($AdminUser['password']) < 6 ||strlen($AdminUser['password']) >20 ){
                    return ['code' => 400, 'message' => '密码长度为6到20位'];
                }
                $model->setPassword($AdminUser['password']);
            }
            if (empty($AdminUser['mobile'])){
                return ['code' => 400, 'message' => '请填写手机号'];
            }
//            if (strlen($AdminUser['code']) != 4){
//                return ['code' => 400, 'message' => '推荐码填写不正确'];
//            }
//            $Info2 = Tool::queryOne("db","select code from admin_user where id <> $id and  code = ".$AdminUser['code']);
//            if ($Info2){
//                return ['code' => 400, 'message' => '推荐码已存在，请填写其它推荐码！'];
//            }
            $model->status = isset( $AdminUser['status']) ? $AdminUser['status'] : 0;
            $model->role_id = implode(',',$AdminUser['role_id']);
            $model->username = $AdminUser['username'];
            $model->mobile = $AdminUser['mobile'];
            if ($model->save()){
                return ['code' => 200, 'message' => '修改成功'];
            }else{
                return ['code' => 400, 'message' => $error=array_values($model->getFirstErrors())[0]];
           }
        }else {
            return $this->render('update', ['model' => ArrayHelper::toArray($model),'role_id'=>explode(',',$model->role_id)]);
        }
    }

    /**
     * Deletes an existing AdminUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}