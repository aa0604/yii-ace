<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2016/12/13 22:25
// +----------------------------------------------------------------------
// | TITLE: 设置权限
// +----------------------------------------------------------------------
use yii\helpers\Url;


$AdminRole = new \xing\ace\models\AdminRole;
use yii\bootstrap\ActiveForm;
?>

<!DOCTYPE html>
<HTML>
<HEAD>
	<TITLE> ZTREE DEMO - checkbox</TITLE>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="<?= Url::base() ?>/js/zTree_v3-master/css/demo.css" type="text/css">
	<link rel="stylesheet" href="<?= Url::base() ?>/js/zTree_v3-master/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="<?= Url::base() ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?= Url::base() ?>/js/zTree_v3-master/js/jquery.ztree.core.js"></script>
	<script type="text/javascript" src="<?= Url::base() ?>/js/zTree_v3-master/js/jquery.ztree.excheck.js"></script>

</HEAD>

<BODY>
<h1>Checkbox 勾选操作</h1>
<h6>[ 文件路径: excheck/checkbox.html ]</h6>
<div class="content_wrap">
	<div class="zTreeDemoBackground left">
		<ul id="treeDemo" class="ztree"></ul>
	</div>

	<input type="button" onclick="onCheck()" value="测试">

</div>


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

		var zNodes =[
			{ id:1, pId:0, name:"随意勾选 1", open:true},
			{ id:11, pId:1, name:"随意勾选 1-1", open:true},
			{ id:111, pId:11, name:"随意勾选 1-1-1"},
			{ id:112, pId:11, name:"随意勾选 1-1-2"},
			{ id:12, pId:1, name:"随意勾选 1-2", open:true},
			{ id:121, pId:12, name:"随意勾选 1-2-1"},
			{ id:122, pId:12, name:"随意勾选 1-2-2"},
			{ id:2, pId:0, name:"随意勾选 2", checked:true, open:true},
			{ id:21, pId:2, name:"随意勾选 2-1"},
			{ id:22, pId:2, name:"随意勾选 2-2", open:true},
			{ id:221, pId:22, name:"随意勾选 2-2-1", checked:true},
			{ id:222, pId:22, name:"随意勾选 2-2-2"},
			{ id:23, pId:2, name:"随意勾选 2-3"}
		];

		
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);

		});

		function onCheck(){
			var treeObj=$.fn.zTree.getZTreeObj("treeDemo"),
				nodes=treeObj.getCheckedNodes(true),
				v="";
			for(var i=0;i<nodes.length;i++){
				v += nodes[i].id + ","; //获取name值
			}
			alert(v); //获取选中节点的值
		}
JAVASCRIP;

$this->registerJs($js);
?>
</BODY>
</HTML>