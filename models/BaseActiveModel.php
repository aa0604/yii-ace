<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/11/26
 * Time: 11:12
 */

namespace xing\ace\models;


class BaseActiveModel extends \xing\helper\yii\MyActiveRecord
{
    use \xing\helper\yii\MyCacheTrait;


    public $autoUpdateTime = false;

    public function generateSearchParams($params)
    {
        $formName = $this->formName();
        return [$formName => $params];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            // 自动更新时间
            if ($this->autoUpdateTime) {
                $fields = $this->attributeLabels();
                if($this->isNewRecord){
                    if (array_key_exists('createTime', $fields) && empty($this->createTime)) $this->createTime = time();
                } else {
                    if (array_key_exists('updateTime', $fields) && empty($this->updateTime)) $this->updateTime = time();
                }
            }
            return true;
        }else{
            return false;
        }
    }
}