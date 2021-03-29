<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2016/12/13 22:25
// +----------------------------------------------------------------------
// | TITLE: this to do?
// +----------------------------------------------------------------------
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use xing\ace\AdminAsset;
\xing\ace\AdminRoleAsset::register($this);
list(, $url) = Yii::$app->assetManager->publish((new AdminAsset())->sourcePath);

$this->registerJsFile($url . '/js/jquery.nestable.min.js', [
    'depends' => 'xing\ace\AdminAsset'
]);
?>

<?php $this->beginBlock('head'); ?>

<?php $this->endBlock(); ?>
    <!--===========================================-->
    <!--html-->
    <div class="main-container" id="main-container">
        <!-- /section:basics/sidebar -->
        <div class="main-content">
            <div class="main-content-inner">

                <div class="page-content">

                    <div class="page-header">
                        <h1>
                            角色
                            <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                角色资料
                            </small>
                        </h1>
                    </div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <?php $form =  ActiveForm::begin(
                                ['id' => 'admin-role-form',
                                    'action'=>Url::to(['admin-role/update','id'=>$model->id ]),
                                    'enableAjaxValidation' => true,
                                ])?>
                                <!-- #section:elements.form -->
                                <div class="row form-horizontal">
                                    <div class="col-xs-10 col-lg-offset-1">
                                        <div class="widget-box">
                                            <div class="widget-header">
                                                <h4 class="widget-title">角色资料</h4>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <div class="form-group field-form-field-1 required">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">*角色名称:</label>
                                                        <input id="form-field-1" class="col-md-offset-1  col-sm-3" value="<?= $model->name?>" name="AdminRole[name]" placeholder="角色名称" aria-required="true" type="text">
                                                        <div class="help-block"></div>
                                                    </div>
                                                    <div class="form-group field-form-field-1 required" >
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">*选择权限:</label>
                                                        <div class="col-md-offset-1  col-sm-3">
                                                            <ul id="treeDemo" class="ztree"  style="height:400px;"></ul>
                                                        </div>
                                                    </div>
                                                    <div class="form-group field-form-field-1 required"  style="display: none">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">*角色编号:</label>
                                                        <input id="form-field-1" class="col-md-offset-1  col-sm-3" name="AdminRole[code]" value="<?=  $model->code; ?>" readonly="readonly" placeholder="角色编号" aria-required="true" type="text">

                                                        <div class="help-block"></div>
                                                    </div>
                                                    <div class="form-group field-form-field-1" style="display: none">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">描述:</label>
                                                        <input id="form-field-1" class="col-md-offset-1  col-sm-3" name="AdminRole[des]" placeholder="描述" type="text">

                                                        <div class="help-block"></div>
                                                    </div>
                                                    <div class="clearfix ">
                                                        <div class="col-md-offset-3 col-md-9">
                                                            <button class="btn btn-info ajaxForm" type="button">
                                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                                提交
                                                            </button>&nbsp;
                                                            <button class="btn" type="reset">
                                                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                                                重置
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="hr hr-24"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.span -->
                                </div><!-- /.row -->
                            <?php ActiveForm::end();?>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.page-content -->
            </div>
        </div><!-- /.main-content -->


    </div><!-- /.main-container -->
    <!--html-->
    <!--===========================================-->
<?php $this->beginBlock('footer'); ?>

<?php $this->endBlock(); ?>



<!--载入树插件-->
<script>

    var zNodes = <?= $ruleAll ?>;
</script>
<?php
$js = <<<JAVASCRIP

    var setting = {
        check: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true
            }
        },
        callback:{
            //onCheck:onCheck
        }

    };



    $(document).ready(function(){
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);

    });
    //获取选中数据
    function onCheck(){
        var treeObj=$.fn.zTree.getZTreeObj("treeDemo"),
            nodes=treeObj.getCheckedNodes(true),
            v="";
        for(var i=0;i<nodes.length;i++){
            v += nodes[i].id + ","; //获取name值
        }
        return v; //获取选中节点的值
    }

    //提交数据
    $('.ajaxForm').bind('click',function () {
        var s = onCheck();
        if (s  == ""){
            alert_err("权限不得为空！");
            return false;
        }

        var data = {};
        data['AdminRole[name]'] = $("input[name='AdminRole[name]']").val();
        data['AdminRole[code]'] = $("input[name='AdminRole[code]']").val();
        data['AdminRole[rule]'] = s.substring(0,s.length-1);
        ajaxPullData(data,$('#admin-role-form').attr('action'),function (data) {
            if (data.code == 200 ){
                alert_succ(data.message,function () {
                    window.location.href = '/admin/admin-role/index';
                })
            }else{
                alert_err(data.message);
            }
        })


    });
JAVASCRIP;

$this->registerJs($js, \yii\web\View::POS_END);
?>


