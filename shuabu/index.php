<?php

//header ( "Content-type: text/html; charset=utf-8" );
//header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');  
header("P3P","CP=CAO PSA OUR");
//session_start();  
//$_SESSION['code'] = md5(microtime(true));  
SetCookie("weixin",'vipwangxd',time () + 9999);
session_start ();
ob_start ();

require 'HttpClient.php';
//header("Content-type: text/html; charset=utf-8");
$title = '咕咚刷步';
$user = '';
$pwd = '';
$b = '';
$cmd = '';
$context = '';




if (isset ( $_REQUEST ['user'] )) {
	$user = $_REQUEST ['user'];
}
if (isset ( $_REQUEST ['pwd'] )) {
	$pwd = $_REQUEST ['pwd'];
}

$arr1 = array (
		"status" => "false",
		"message" => "<div class='err'><span class='err-icon'>!</span>您提交的激活码不存在<br></div>",
		"mac" => $code 
);
$arr2 = array (
		"status" => "true",
		"ret" => "<div class='tit'>您使用的是 月卡 到期时间: 2017-05-12<div class='ok'><img src='http://wx.qlogo.cn/mmhead/ver_1/NofyX0yMNmD2dtNYlSnPM2taQCkASScPnSy4HFkwRcBwQ95jE5hRtrShgOhrh0BmKxPPpC55VB3j34Sfrnsown1SzGs9vT6TP9hwV2l4j4M/132' width='80' height='80'><br>五花肉<br>WXID:wxid_sntspem8a1lc12<br>上次使用时间:2017-04-19 14:11:38</div>",
		"mac" => $code 
);


if($user && $pwd){
    
    $url = "http://cloud.bmob.cn/78fb1dded5aef955/gudongLogin?user=" . $user . "&pwd=".$pwd;
      
    $dat = HttpClient::quickGet($url); 
    
    //{"access_token":"c9f913e341f8199d1610c6ad465bda82","expire_in":1587870970,"new_created":false,"refresh_token":"ac84bd81351e8c676040c21c55a0431e","timestamp":1494558970,"token_type":"bearer","user_id":"f117fab7-37d8-4335-8233-063bc9aa651b"}
    //{"data":"","description":"用户名或密码错误","status":"Error"}
    
    /**
	if (! empty ( $dat )) { // 存在该激活码
		echo json_encode ( $arr2 );
		return;
	}else{
		echo json_encode ( $dat );
	return;
    }
    **/
    
    $obj = json_decode($dat); // 判断登录状态 , TRUE
    
    if(isset($obj->user_id)){	// 登录成功

		// 用户基本信息
		$user_id = $obj->user_id;
		$access_token = $obj->access_token;
		$refresh_token = $obj->refresh_token;
        
        
                        SetCookie("access_token",$access_token,time () + 9999);
                        setCookie("user_id",$user_id,time () + 9999);
                        
                        setCookie("username",$user ,time () + 9999);
                        setCookie("password", $pwd,time () + 9999);
        
        
    }
   echo $dat;
    return;
}else{

	if (isset ( $_COOKIE ['access_token'] ) &&  isset ( $_COOKIE ['user_id'] ) ) { // 是否有键
			header ( "location:./step.php" );
			exit ();
	}
    
}


?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="http://qq.xiaobaiwei.com/static/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="http://qq.xiaobaiwei.com/static/assets/fish_test/css/styles.css" rel="stylesheet">
<link href="https://res.wx.qq.com/open/libs/weui/0.4.2/weui.css" rel="stylesheet">
<link href="http://qq.xiaobaiwei.com/static/styles/weui_example1.css" rel="stylesheet">
<link href="http://qq.xiaobaiwei.com/static/styles/qun.css" rel="stylesheet">
<meta charset="utf-8">
<script src="http://qq.xiaobaiwei.com/static/assets/fish_test/js/lumino.glyphs.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/jquery-2.1.1.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/bootstrap.min.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/plugins/validate/jquery.validate.min.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/fish_test/js/bootstrap-datepicker.js"></script>
<style>.error{color:red;font-weight:400px;}body{max-width:1080px;margin:auto;background:#FFFFFF;}.weui_navbar{max-width:1080px;margin:atto;}</style>
<title><? echo $title;?></title>
</head>
<body>
<div class="weui_navbar" style="margin-bottom:100px;">
<div class="weui_navbar" style="margin-bottom:100px;">
<div class="weui_navbar_item weui_bar_item_on"><? echo $title;?> 系统</div>
</div>
</div>
<div class="hd">
<form id="actForm" role="form" method="get">
<div class="weui_cells weui_cells_form">
    
<div class="weui_cell">
<div class="weui_cell_hd">
<label class="weui_label">咕咚账号：</label>
</div>
<div class="weui_cell_bd weui_cell_primary">
<input type="text" class="weui_input" name="user" id="user" placeholder="请输入手机号">
<input type="hidden" class="weui_input" name="ac_type" id="ac_type" value="11">
</div>
</div>
    
<div class="weui_cell">
<div class="weui_cell_hd">
<label class="weui_label">咕咚密码：</label>
</div>
<div class="weui_cell_bd weui_cell_primary">
<input type="password" class="weui_input" name="pwd" id="pwd" placeholder="请输入咕咚密码">
<input type="hidden" class="weui_input" name="ac_type" id="ac_type" >
</div>
</div> 
    
</div>
<div id="error">
</div>
    
<div class="button-group" style="margin:20px;">
<button class="weui_btn weui_btn_primary" type="submit" name="login-button" id="submitButton">登陆</button>

</div>
    
</form>
    
<br>
    
<a href="http://www.codoon.com/regist" class="weui_btn weui_btn_primary" target="_blank">用户注册/找回密码</a>
    
    
</div>
<script>
    //http://www.codoon.com/regist
        $(document).ready(function(){
            $("#actForm").validate({
                rules: {
                    user: {
                        required: true,
                        minlength: 11,
                        maxlength: 12
                    }
                },
                messages: {
                    user: {
                        required: "用户名不能为空",
                        minlength: "用户名不小于11",
                        maxlength: "用户名不超过11"
                    }
                },
                submitHandler: function(form) {
                    action();
                },

                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
        });

        function action() {
            $.ajax({
                type : "POST",
                data : $('#actForm').serialize(),
                url : "",
                dataType: 'json',
                cache: false,
                beforeSend: function( xhr ) {
                    $('#submitButton').text('正在登陆...').addClass('btn-u-default').attr('disabled', 'disabled');
                },
                success : function(result, textStatus, jqXHR) {
                    console.log(result);
                    var user_id = result.user_id;
                    var access_token = result.access_token;
                    var description =  result.description;
                    
                    $("#test").html(result.message);
                    
                    if (description == undefined) {
                        setCookie("access_token",access_token,365);
                        setCookie("user_id",user_id,365);
                        
                        setCookie("username", document.getElementById("user").value,365);
                        setCookie("password", document.getElementById("pwd").value,365);
                        
                        window.location.href = "step.php?user_id=" + user_id + "&access_token=" + access_token + "&end=0";
                        //window.top.location = "step.php?user_id=" + user_id + "&access_token=" + access_token;
                        $('#submitButton').text('登陆ok').removeClass('btn-u-default').removeAttr('disabled');
                        
                    } else {
                        $('#error').html(result.description);
                        $('#submitButton').text('登 陆').removeClass('btn-u-default').removeAttr('disabled');
                    }
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    $('#submitButton').text('登陆er').removeClass('btn-u-default').removeAttr('disabled');
                }
            });
        }
    </script>

<!--
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
-->
<script>
    /**
    //写cookies
function setCookie(name,value)
{
var Days = 30;
var exp = new Date();
exp.setTime(exp.getTime() + Days*24*60*60*1000);
document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

    //读取cookies
function getCookie(name)
{
var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
if(arr=document.cookie.match(reg))
return unescape(arr[2]);
else
return null;
}
    **/
    
    function setCookie(c_name,value,expiredays)
{
var exdate=new Date()
exdate.setDate(exdate.getDate()+expiredays)
document.cookie=c_name+ "=" +escape(value)+
((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

//取回cookie
function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=")
  if (c_start!=-1)
	{ 
	c_start=c_start + c_name.length+1 
	c_end=document.cookie.indexOf(";",c_start)
	if (c_end==-1) c_end=document.cookie.length
	return unescape(document.cookie.substring(c_start,c_end))
	} 
  }
return ""
}
    
    
    (function() {

			if (getCookie("username") != null) {
				document.getElementById("user").value = getCookie("username");
			}
			if (getCookie("password") != null) {
				document.getElementById("pwd").value = ""+ getCookie("password");
			}

		})();
    
    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>
</body>
</html>