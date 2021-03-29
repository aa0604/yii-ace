
$(function () {

    //全选
    $("#CheckAll").click(function(){
        $("input:checkbox").prop("checked","checked");
    });
    //取消全选
    $("#CheckNo").click(function(){
        $("input:checkbox").removeAttr("checked");
    });
    //反选
    $("#CheckRev").click(function(){
        $("input:checkbox").each(function(){
            this.checked=!this.checked;
        });
    });
    //回退上一步
    $(".backBtn").click(function () {
        window.history.back();
    });

    $('#mySelect').change(function(){
        var p1=$(this).children('option:selected').val();//这就是selected的值
        var thisURL = document.URL;  //当前url的值
        window.location.href = changeURLPar(thisURL,'page_size',p1);  //修改后的分页数量
    })

    //全选反选
    $("#xuan").click(function () {
        if($("#xuan:checked").length == 0){ //去掉全选
            $("input:checkbox").removeAttr("checked");
        }else{  //全选
            $("input:checkbox").prop("checked","checked");
            var storeStr =  getItem('new_store_ids') == null ? "" : getItem('new_store_ids'); //已经选择的商品id
        }
    })

})

/*
  * H5存储
  * @param  string key 键值
  * @param  string val 值
  *
 */
function setItem(key,val) {
   return localStorage.setItem(key, val);
}
/*
 * H5存储删除
 * @param  string key 键值
 */
function removeItem(key) {
     localStorage.removeItem(key);
    localStorage.clear(); //清空所有
}
/*
 * H5存储清空所有
 */
function clear() {
    localStorage.clear(); //清空所有
}
/*
 * H5存储获取
 * @param  string key 键值
 * @param  string val 值
 *
 */
function getItem(key) {
    return  localStorage.getItem(key);
}
/*
  去除重复的数组的值
 */
function unique(arr) {
    var result = [], hash = {};
    for (var i = 0, elem; (elem = arr[i]) != null; i++) {
        if (!hash[elem]) {
            result.push(elem);
            hash[elem] = true;
        }
    }
    //  alert(result);
    return result;
}

/*
 *
 * 功能:删除数组元素.
 * 参数:dx删除元素的值
 * 返回:在原数组上修改数组.
 */
function arrRemove(arr,dx)
{
  //  var array = [2, 5, 9];
    var index = arr.indexOf(dx);
    if (index > -1) {
        return arr.splice(index, 1);
    }else{
        return arr;
    }
}
/*
 验证checkbox是否已选
 */
function validate() {
    if (confirm("提交表单?")) {
        return true;
    } else {
        return false;
    }
}


/*
 选择优惠券
 *@param target string 目标类型
 */
function addCoupon(target,msg) {
    layer.open({
        title:msg,
        type: 2,
        area: ['500px','450px'],
        fixed: true, //不固定
        maxmin: false,
        content: '/account/site/coupon?target='+target
    });
}

/*
 原路返回
 */
function back() {
    window.history.go(-1);
}

/*
 *修改密码
 *@param type 用户类型
 *@param id 用户id
 *
 */
function updatepassword(type,id) {
    layer.open({
        type: 2,
        title:'修改密码',
        area: ['420px','340px'],
        fixed: false, //不固定
        maxmin: false,
        content: '/account/site/password?type='+type+'&id='+id
    });
}

/*
 *修改密码
 *@param type 用户类型
 *@param id 用户id
 *
 */
function updatepassword2(obj) {
   var id = $(obj).attr('id');
   var type = $(obj).attr('type');
    layer.open({
        type: 2,
        title:'修改密码',
        area: ['380px','440px'],
        fixed: false, //不固定
        maxmin: false,
        content: '/account/site/password?type='+type+'&id='+id
    });
}

/*
检查等级配置
 */
function checklevel(callback) {
    var name = $("input[class=name]:last").val(); //选择开始时间最后一个元素值
    var level = $("input[class=level]:last").val(); //选择开始时间最后一个元素值
    var levelScore = $("input[class=levelScore]:last").val(); //选择开始时间最后一个元素值

    if (name == '' || levelScore == '') {
        alert_err('请填写完整等级设置');
        return false;
    }
    var s = /^[0-9]*[1-9][0-9]*$/;
    if (!s.test(levelScore)) {
        alert_err("达成所需积分有错，请检查！");
        return false;
    }
    if (!s.test(level)) {
        alert_err("排序有错，请检查！");
        return false;
    }
    callback();
}
/*
 检测新货源推送配置
 */
function checkgoods(callback) {

    var startTime = $("input[name='startTime[]']:last").val();
    var endTime = $("input[name='endTime[]']:last").val();
    var minInterval = $("input[name='minInterval[]']:last").val();
    var maxCount = $("input[name='maxCount[]']:last").val();

    if (startTime == '' || endTime == '' || minInterval == ''|| maxCount == '' ) {
        alert_err('请填写必填项');
        return false;
    }

    var s = /^\d{1,3}$/;
    if (
        !s.test(startTime)
        || !s.test(endTime)
       || parseInt(startTime) > 24
       || parseInt(endTime) > 24
       || parseInt(startTime) >= parseInt(endTime)
    ) {
        alert_err("时间段有误，请检查！");
        return false;
    }
    if (!s.test(minInterval) || parseInt(minInterval) > 60) {
        alert_err("最少时间间隔有误！");
        return false;
    }
    if (!s.test(maxCount) || parseInt(maxCount) > 60) {
        alert_err("最大次数有误！");
        return false;
    }
    //检测输入的时间范围是否正确
    var k= 0;
    $("input[name='startTime[]']").each(function(i,v){
        var starts = parseInt($(this).val())
        if (i > 0 ){
            $("input[name='endTime[]']").each(function(s,p){
                var ends = parseInt($(this).val())
                if (i == (s+1)){
                    if (starts < ends){
                        k = 1;
                    }
                }

            })
        }
    })
    if (k == 1){
        alert_err("时间范围不正确")
        return false;
    }
    callback();
}


/*
 搜索
 */
function search() {
    $("#out").val('')
    if(typeof($("#start_time").val()) !="undefined"){
        if(validTime($("#start_time").val(),$("#end_time").val()) == false){
            alert_err('搜索开始时间不得大于结束时间');
        }
    }
    $("#search").submit();
}
//刷新当前页
function shua() {
    location.reload();
}
/*
 导出
 */
function excel() {
    // if (parseInt($("#total").html()) > 10000){
    //    alert_err("导出数据多于1万条请联系管理员！")
    // }else{
        $("#out").val('out');
        $("#search").submit();
        $("#out").val('');
    // }
}
/*
判断两个时间大小，开始时间大于结束时间返回false
 */
function validTime(startTime,endTime){
    var arr1 = startTime.split("-");
    var arr2 = endTime.split("-");
    var date1=new Date(parseInt(arr1[0]),parseInt(arr1[1])-1,parseInt(arr1[2]),0,0,0);
    var date2=new Date(parseInt(arr2[0]),parseInt(arr2[1])-1,parseInt(arr2[2]),0,0,0);
    if(date1.getTime()>date2.getTime()) {
        return false;
    }else{
        return true;
    }
    return false;
}
/*
 *多图片上传
 *适用flash上传，必须先在服务器站点根目录放 crossdomain.xml
 *@param fileid 上传图片输入框id
 */
function uploadify2(fileid) {
    $('#'+fileid).uploadify({
        'uploader' : UPLOAD_URL,  //上传服务器地址
        'formData'     : { //额外数据
            // 'timestamp' : '<?php echo $timestamp;?>',
            // 'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
        },
        'fileObjName':'filename',//文件上传名称
        'debug'    : false, //是否开启上传调试
        'height'   : 30, //按钮高度
        'width'   : 70,  //按钮长度
        'multi'    : true,  //是否支持多文件上传
        'buttonClass' : 'upload',  //按钮额外样式
        'buttonText' : '上传',  //按钮文件
        'fileSizeLimit' : '10240KB', //文件限制大小
        'fileTypeDesc' : 'Image Files',  //选择框的图片
        'fileTypeExts' : '*.gif; *.jpg; *.png',  //文件后缀
        'swf'      : '/js/upload/uploadify.swf', //flash插件
        'uploadLimit' : 10 , //最多每次上传多少张
        'onUploadError' : function(file, errorCode, errorMsg, errorString) { //上传出错
            alert_succ('文件' + file.name + ' 不能上传: ' + errorString);
        },
        'onUploadSuccess' : function(file, msg, response) {  //成功返回
            var e =JSON.parse(msg); //json 字符串转对象
            if(e.code == 0){
                //先清空原始预览图片
              //  $('.'+fileid).empty();
                var name = fileid + '[]';
                $('.'+fileid).append("<div style=\"float: left;\"><img id='headimg' src='"+e.data.url+"' style=\"width: 100px;height: 100px;\" '><input type='hidden' name="+name+" value="+e.data.filename+"  ><a  onclick='deleteMyslef(this)'>&nbsp;&nbsp;删除</a> </div>");
            }else{
                alert_err('上传失败请重试');
            }
        }
    });
}

/*
  *单图片上传用到
 *适用flash上传，必须先在服务器站点根目录放 crossdomain.xml
 *@param fileid 上传图片输入框id
 */
function uploadify(fileid) {
    $('#'+fileid).uploadify({
        'uploader' : UPLOAD_URL,  //上传服务器地址
        'formData'     : { //额外数据
            // 'timestamp' : '<?php echo $timestamp;?>',
            // 'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
        },
        'fileObjName':'filename',//文件上传名称
        'debug'    : false, //是否开启上传调试
        'height'   : 30, //按钮高度
        'width'   : 70,  //按钮长度
        'multi'    : false,  //是否支持多文件上传
        'buttonClass' : 'upload',  //按钮额外样式
        'buttonText' : '上传',  //按钮文件
        'fileSizeLimit' : '10240KB', //文件限制大小
        'fileTypeDesc' : 'Image Files',  //选择框的图片
        'fileTypeExts' : '*.gif; *.jpg; *.png',  //文件后缀
        'swf'      : '/js/upload/uploadify.swf', //flash插件
        'uploadLimit' : 10 , //最多每次上传多少张
        'onUploadError' : function(file, errorCode, errorMsg, errorString) { //上传出错
            alert_succ('文件' + file.name + ' 不能上传: ' + errorString);
        },
        'onUploadSuccess' : function(file, msg, response) {  //成功返回
            var e =JSON.parse(msg); //json 字符串转对象
            if(e.code == 0){
                //先清空原始预览图片
                $('.'+fileid).empty();
                $('.'+fileid).append("<div><img id='headimg' src='"+e.data.url+"' style=\"width: 100px;height: 100px;\" '><input type='hidden' name="+fileid+" value="+e.data.filename+"  ><a  onclick='deleteMyslef(this)'>&nbsp;&nbsp;删除</a> </div>");
            }else{
                alert_err('上传失败请重试');
            }
        }
    });
}

/*
 删除图片
 */
function deleteMyslef(o){
    $(o).parent().remove();
}


//跳转url
function tiao(url) {
    window.location.href = BASE_URL+url;
}

//判断是否是100以内正整数
function checkInt(s)
{
    var reg = /^\d{1,3}$/;
    var re = s.value.match(reg);
    if(re){
        if(s.value<1000){
            return true;
        }
    }
    $(s).val(''); //清空
    return false;
}

/**
 * 普通ajax拉取数据
 * @param data 请求参数 数组key-value
 * @param url
 * @param callback
 */
function  ajaxPullData(data,url,callback) {
    //设置csrf
    var index1 = layer.msg('努力中...', {icon: 16,shade: [0.5, '#f5f5f5'],scrollbar: false,offset: '0px', time:100000})
    var cname = $('meta[name=csrf-param]').attr('content');
    var cvalue= $('meta[name=csrf-token]').attr('content');
    data[cname] = cvalue;
    var url = url;
    $.ajax(url, {
        async: false,
        type: 'post',
        dataType: 'json',
        data: data
    }).done(function (e) {
        layer.close(index1);
        callback(e)
    }).fail(function (e) {
        alert_err('网络错误');
    });
}

/*
 * 封装ajax 表单提交
 *@param divId 表单id
 *@param url post 请求网址
 *@param callback 回调函数
 */
function  ajax1(divId,url,callback) {
    var index1 = layer.msg('努力中...', {icon: 16,shade: [0.5, '#f5f5f5'],scrollbar: false,offset: '0px', time:100000})
    var data = $('#'+divId).serialize();
    // var forms = $('#'+divId).serializeArray();
    // var data = {};
    // $.each(forms, function (i, v) {
    //     data[v['name']] = v['value'];
    // });
    //设置csrf
    var cname = $('meta[name=csrf-param]').attr('content');
    var cvalue= $('meta[name=csrf-token]').attr('content');
    //data[cname] = cvalue;
    data = data+"&"+cname+"="+cvalue;
    var url = url;
    $.ajax(url, {
        async: false,
        type: 'post',
        dataType: 'json',
        cache: false,
        data: data
    }).done(function (e) {
        layer.close(index1);
        callback(e)
    }).fail(function (e) {
        alert_err('网络错误');
    });
}

/*
 修改目标URL参数
 destiny是目标字符串，比如是http://www.huistd.com/?id=3&ttt=3
 par是参数名，par_value是参数要更改的值，调用结果如下：
 changeURLPar(test, 'id', 99); // http://www.huistd.com/?id=99&ttt=3
 changeURLPar(test, 'haha', 33); // http://www.huistd.com/?id=99&ttt=3&haha=33
 */
function changeURLPar(destiny, par, par_value)
{
    var pattern = par+'=([^&]*)';
    var replaceText = par+'='+par_value;
    if (destiny.match(pattern))
    {
        var tmp = '/\\'+par+'=[^&]*/';
        tmp = destiny.replace(eval(tmp), replaceText);
        return (tmp);
    }
    else
    {
        if (destiny.match('[\?]'))
        {
            return destiny+'&'+ replaceText;
        }
        else
        {
            return destiny+'?'+replaceText;
        }
    }
    return destiny+'\n'+par+'\n'+par_value;
}
/*
弹框
 */
function iframeopen(width,height,url,titles) {
    layer.open({
        title:titles,
        type: 2,
        area: [width, height],
        fixed: false, //不固定
        maxmin: false,
        content: url
    });
}

//layer弹出子窗口关闭并且刷新父窗口页面
function closeparent() {
   /// parent.$('#parentIframe').text('我被改变了');//给父页面传值
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    parent.location.reload();
    parent.layer.close(index);
    return false;
}


//提示成功
function alert_succ(msg,callback) {
    if (!callback || typeof callback == 'undefined' || callback == undefined){
        window.parent.layer.alert(msg,{icon:1,title:'提示信息'},function (index) {
            window.parent.layer.close(index);
        })
    }else{
        window.parent.layer.alert(msg,{icon:1,title:'提示信息'},function (index) {
            window.parent.layer.close(index);
            callback();
        })
    }
}
/*
重新js替换函数
 var str = '2016-09-19';
 var result = str.replaceAll('-','');
 结果 20160919
 */
String.prototype.replaceAll = function (FindText, RepText) {
    regExp = new RegExp(FindText,"g");
    return this.replace(regExp, RepText);
}
//提示失败
function alert_err(msg,callback) {
    if (!callback || typeof callback == 'undefined' || callback == undefined){
        window.parent.layer.alert(msg,{icon:2,title:'提示信息'},function (index) {
            window.parent.layer.close(index);
        })
    }else{
        window.parent.layer.alert(msg,{icon:2,title:'提示信息'},function (index) {
            window.parent.layer.close(index);
            callback();
        })
    }
}
//确认弹框,点击确认回调函数
function alert_confirm(msg,callback){
    if (!callback || typeof callback == 'undefined' || callback == undefined){
        window.parent.layer.confirm(msg,{icon:3,title:'提示信息'},function (index) {
            window.parent.layer.close(index);
        })
    }else{
        window.parent.layer.confirm(msg,{icon:3,title:'提示信息'},function (index) {
            window.parent.layer.close(index);
            callback();
        })
    }
}
//表单转成json字符串
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
