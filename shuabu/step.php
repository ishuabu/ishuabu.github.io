<?php

//header ( "Content-type: text/html; charset=utf-8" );
//header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');  
header("P3P","CP=CAO PSA OUR");


//session_start();  
//$_SESSION['code'] = md5(microtime(true));  
session_start ();
ob_start ();

require 'HttpClient.php';

$Method = $_SERVER['REQUEST_METHOD']; // 获取请求类型


$access_token = $_COOKIE ['access_token'];
$user_id = $_COOKIE ['user_id'];
		
$username = $_COOKIE ['username'];
$userpwd = $_COOKIE ['password'];

$step = $_REQUEST ['step'];


if(!$access_token){
$referer = $_SERVER['HTTP_REFERER'];
//echo $referer;

$user_id = getTxtzj($referer,"id=","&acc");
$access_token = getTxtzj($referer,"en=","&end");

}

if( isset($_GET ['access_token'])   ){
    
	$access_token = $_GET ['access_token'];
	$user_id = $_GET ['user_id'];
    
    if( $access_token && $user_id){
		SetCookie("access_token",$access_token,time () + 9999);
		setCookie("user_id",$user_id,time () + 9999);
    
	}

}

if (isset ( $_GET ['logtu'] ) && $_GET ['logtu'] == "true") {
	SetCookie ( "user_id", "", time () - 9999 );
	header ( "location:./" );
	exit ();
}

else if(! $access_token || !$user_id){
	header ( "location:./" );
	exit ();
}



if($step && $Method == 'POST'){
    
    
    if($step > 10000){
    	echo '单次提交请勿超过10000，请分多次提交。';
    	return;
    }
    
    SetCookie ( "step", $step, time () + 9999 );
    
	$url = 'http://cloud.bmob.cn/78fb1dded5aef955/gudongStpeAdd?id=' . $user_id . '&stpe='. $step . '&access_token=' . $access_token;
   
    //$url = 'http://cloud.bmob.cn/c1c1a886eb7be442/gudongStpeAdd?id=q1111&stpe=1111&access_token=1111';
    //echo $url;
    $dat = HttpClient::quickGet($url); 
    //echo '{"data":"","description":"用户名或密码错误","status":"Error"}';
    echo $dat;
    return;
}else if( $Method == 'GET'){
   

}

function getTxtzj($str,$str1,$str2){
$t1 = mb_strpos($str,$str1)+3;
$t2 = mb_strpos($str,$str2);
return $s = mb_substr($str,$t1,$t2-$t1);
}
?>
<html>
<head>

<title>步数提交与绑定</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title>WeUI</title>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="http://2.shop.applinzi.com/weui.css" />
<link rel="stylesheet" href="http://2.shop.applinzi.com/example.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="http://qq.xiaobaiwei.com/static/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="http://qq.xiaobaiwei.com/static/assets/fish_test/css/styles.css" rel="stylesheet">
<link href="https://res.wx.qq.com/open/libs/weui/0.4.2/weui.css" rel="stylesheet">
<link href="http://qq.xiaobaiwei.com/static/styles/weui_example1.css" rel="stylesheet">
<link href="http://qq.xiaobaiwei.com/static/styles/qun.css" rel="stylesheet">
<script src="http://qq.xiaobaiwei.com/static/assets/fish_test/js/lumino.glyphs.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/jquery-2.1.1.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/bootstrap.min.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/plugins/validate/jquery.validate.min.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="http://qq.xiaobaiwei.com/static/assets/fish_test/js/bootstrap-datepicker.js"></script>
</head>
<body>

	<div class="hd" style="display: none" >
	
		<h2 class="page_title">咕咚刷步</h2>

	</div>
	
		<div class="weui_msg">
			<div class="weui_icon_area">
				<i class="weui_icon_safe weui_icon_safe_success"></i>
				<h2 class="page_title">咕咚刷步</h2>
			</div>
		</div>
	
	
		<br/><br/><br/>
    <form id="actForm" role="form" method="post">
        
        <input type="number"  name="xdd" value="0"  readonly="readonly" style="display:none" />
        
        <div class="weui_cell ">
            <div class="weui_cell_hd">
                <label class="weui_label"> 增加数 </label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" id="step" name="step" placeholder="增加步数" value="" />
            </div>
            <div class="weui_cell_ft">
                <a href="https://v.qq.com/x/page/h0502cmistu.html" target="_blank" class="weui_btn weui_btn_mini weui_btn_default">请看教程</a>
            </div>
        </div>
       
        <div class="bd spacing">
            <input class="weui_btn weui_btn_primary" type="submit" id="submitButton"  name="login-button" value="提交步数" />
        </div>
        
   </form>   
        
    <div  class="hd">
        
        <p id="test" class="page_desc"></p>
    </div>
<div class="weui_cells weui_cells_access">

    

    	<a class="weui_cell" href="https://hw.weixin.qq.com/steprank/step/personal?openid=">
			<div class="weui_cell_hd">
				<img
					src="http://1.hongping.sinaapp.com/udid/images/zy1.png"
					alt="" style="width: 20px; margin-right: 5px; display: block">
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<p>查排行榜 </p>
			</div>
			<div class="weui_cell_ft">查看</div>
		</a> 
    
        <a class="weui_cell" href="https://v.qq.com/x/page/h0502cmistu.html">
			<div class="weui_cell_hd">
				<img
					src="http://1.hongping.sinaapp.com/udid/images/zy4.png"
					alt="" style="width: 20px; margin-right: 5px; display: block">
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<p>使用教程</p>
			</div>
			<div class="weui_cell_ft">查看</div>
		</a> 
    
		<a class="weui_cell" href="step.php?logtu=true">
			<div class="weui_cell_hd">
				<img
					src="http://1.hongping.sinaapp.com/udid/images/zy3.png"
					alt="" style="width: 20px; margin-right: 5px; display: block">
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<p>退出登陆 </p>
			</div>
			<div class="weui_cell_ft">退出</div>
		</a> 
		
		<a class="weui_cell" href="javascript:;">
			<div class="weui_cell_hd">
				<img
					src="http://1.hongping.sinaapp.com/udid/images/zy6.png"
					alt="" style="width: 20px; margin-right: 5px; display: block">
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<p>爱刷步</p>
			</div>
			<div class="weui_cell_ft">关于</div>
		</a>
	</div>


	<div class="hd">
		<p class="page_desc">【爱刷步】虚拟刷步系统</p>
	</div>

    <script>
        $(document).ready(function(){
            $("#actForm").validate({
                rules: {
                    step: {
                        required: true,
                        minlength: 1,
                        maxlength: 5
                    }
                },
                messages: {
                    step: {
                        required: "步数不能为空",
                        minlength: "步数不能小于0",
                        maxlength: "步数不能大于99999"
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
            if(document.getElementById("submitButton").value == "正在提交.."){
               return;
            }
            
            $.ajax({
                type : "POST",
                data : $('#actForm').serialize(),
                url : "step.php",
                dataType: 'text',//json
                cache: false,
                beforeSend: function( xhr ) {
                    $('#submitButton').text('正在登陆...').addClass('btn-u-default').attr('disabled', 'disabled');
                    document.getElementById("submitButton").value = "正在提交..";
                },
                success : function(result, textStatus, jqXHR) {
                    console.log(result);
                    var user_id = result.user_id;
                    var access_token = result.access_token;
                    var description =  result.description;
                    
                    var str = JSON.stringify(result);  //var str1 = JSON.parse(str);  
                    setCookie("step", document.getElementById("step").value,365);
                    
                    $("#test").html(result);
                     $('#submitButton').text('提交er').removeClass('btn-u-default').removeAttr('disabled');
                   document.getElementById("submitButton").value = "提交成功";
                    
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    $('#submitButton').text('提交er').removeClass('btn-u-default').removeAttr('disabled');
                    document.getElementById("submitButton").value = "提交er..";
                    document.getElementById("submitButton").value = "重新提交";
                }
            });
        }
    </script>
    
    
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
        
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

			if (getCookie("step") != null) {
				document.getElementById("step").value = getCookie("step");
			}

		})();
        
        
		wx.config({
		  debug: false,
		  appId: 'wx0e54f358b6eb5ce0',
		  timestamp: 1452323220,
		  nonceStr: 'qc7vw6WOOiS5wFlT',
		  signature: '038ed5ba71636544b547de233f0cb7007c70deee',
		  jsApiList: [
	    	'checkJsApi',
		    'onMenuShareTimeline',
		    'onMenuShareAppMessage',
		    'onMenuShareQQ',
		    'onMenuShareWeibo',
			'openLocation',
			'getLocation',
			'addCard',
			'chooseCard',
			'openCard',
			'hideMenuItems',
			'hideOptionMenu',
			'hideAllNonBaseMenuItem'
		  ]
		});
</script>
	
</body>
</html>