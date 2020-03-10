<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2016/12/13 22:10
// +----------------------------------------------------------------------
// | TITLE: 角色
// +----------------------------------------------------------------------

namespace apps\backend\modules\admin\controllers;

use apps\backend\helps\Tree;
use common\models\admin\AdminRule;
use Yii;
use common\models\admin\AdminRole;
use yii\web\Response;

class AdminRoleController extends \apps\backend\controllers\BaseController
{


    /**
     * 角色列表
     * @return string
     */
    public function actionIndex()
    {
        $AdminRole = AdminRole::find();
        $models = $AdminRole->where(['status' => 1])->all();
        return $this->render('index', ['model' => $models]);
    }

    /**
     * 创建角色
     * @return array|string
     */
    public function actionCreate()
    {
        $AdminRole = new AdminRole(['scenario' => 'create']);
        if (Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post('AdminRole');
            $name = $data['name'];
            if(empty($name))
            {
                return ['code' => 400, 'message' => '角色名称不得为空'];
            }
            $Info = $AdminRole::find()->where("name='$name'")->one();
            if(!empty($Info))
            {
                return ['code' => 400, 'message' => '角色名称已存在'];
            }
            if ($AdminRole->load(Yii::$app->request->post()) && $AdminRole->validate()) {
                if ($AdminRole->save()) {
                    return ['code' => 200, 'message' => '添加成功'];
                } else {
                    return ['code' => 400, 'message' => array_values($AdminRole->getFirstErrors())[0]];
                }
            }else{
                return ['code' => 400, 'message' => array_values($AdminRole->getFirstErrors())[0]];
            }
        }  else {
            $ruleAll = AdminRule::find()->where(['status' => 1])->asArray()->all();
            $arr = [];
            foreach ($ruleAll as $k=>$v){
                $tmp = ['id'=>$v['id'],'pId'=>$v['pid'],'name'=>$v['title'],'open'=>true];
                array_push($arr,$tmp);
            }
            return $this->render('create', ['ruleAll' => json_encode($arr)]);
        }

    }

    /**
     * 更新角色
     * @return array|string
     */
    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        $model = AdminRole::findOne($id);
        $model->scenarios('update');
        if (Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post('AdminRole');
            if(empty($data['name']))
            {
                return ['code' => 400, 'message' => '角色名称不得为空'];
            }
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    return ['code' => 200, 'message' => '修改成功'];
                } else {
                    return ['code' => 400, 'message' => array_values($model->getFirstErrors())[0]];
                }
            }else{
                return ['code' => 400, 'message' => array_values($model->getFirstErrors())[0]];
            }
        }  else {
            $myRole = explode(',',$model->rule);
            $ruleAll = AdminRule::find()->where(['status' => 1])->asArray()->all();
            $arr = [];
            foreach ($ruleAll as $k=>$v){
                $checked = in_array($v['id'],$myRole) ? "true": "false";
                $tmp = ['id'=>$v['id'],'pId'=>$v['pid'],'name'=>$v['title'],'open'=>true,'checked'=>$checked];
                array_push($arr,$tmp);
            }
            return $this->render('update', ['model' => $model,'ruleAll'=> json_encode($arr)]);
        }
    }

    /**
     * 删除 角色
     * @return array
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (AdminRole::deleteRole($id)) {
            return ['code' => 200, 'message' => '成功'];
        } else {
            return ['code' => 400, 'message' => '错误'];
        }
    }

    /**
     * 设置权限
     * @return array|string
     */
    public function actionSetRule()
    {

        $roleId = Yii::$app->request->get('id');
        if (empty($roleId)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['code' => 400, 'message' => '参数错误'];
        }
        $model = AdminRole::findOne($roleId);
        $model->rule = explode(',', $model->rule);
        if (Yii::$app->request->post()) {
            $rule = Yii::$app->request->post('rule');
            $rule = array_filter($rule);
            krsort($rule);
            $rule = implode(',', $rule);
            $model->scenario = 'update';
            $model->rule = $rule;
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!$model->save()) {
                return ['code' => 400, 'message' => '修改失败'];
            } else {
                return ['code' => 200, 'message' => '修改成功'];
            }

        } else {
            $ruleAll = AdminRule::find()->where(['status' => 1])->asArray()->all();
            $ruleAll = array_map(function ($item) use ($model) {
                (in_array($item['id'], $model->rule)) ?
                    $item['state'] = ['checked' => true] : '';
                $item['text'] = $item['title'];
                return $item;
            }, $ruleAll);
            $ruleAll = Tree::makeTree($ruleAll, ['children_key' => 'nodes']);
            return $this->render('setRule2', ['ruleAll' => $ruleAll, 'model' => $model]);
        }

    }



}