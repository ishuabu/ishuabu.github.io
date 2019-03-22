<?
header ( "Content-type: text/html; charset=utf-8" );
session_start ();
ob_start ();

if (isset ( $_GET ['logtu'] ) && $_GET ['logtu'] == "true") {
	SetCookie ( "userid", "", time () - 9999 );
	header ( "location:./" );
	exit ();
}

?>
<html>
<head>

<title>步数提交与绑定</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title>WeUI</title>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="http://weui.github.io/weui/weui.css" />
<link rel="stylesheet" href="http://weui.github.io/weui/example.css" />


</head>
<body>

	<div class="hd" style="display: none" >
	
		<h2 class="page_title">在线刷步数</h2>

	</div>
	
		<div class="weui_msg">
			<div class="weui_icon_area">
				<i class="weui_icon_safe weui_icon_safe_success"></i>
				<h2 class="page_title">在线刷步数</h2>
			</div>
		</div>
	
	
		<?
    //
    //{"access_token":"c9f913e341f8199d1610c6ad465bda82","expire_in":1587870970,"new_created":false,"refresh_token":"ac84bd81351e8c676040c21c55a0431e","timestamp":1494558970,"token_type":"bearer","user_id":"f117fab7-37d8-4335-8233-063bc9aa651b"}
		// header("Content-type: text/html; charset=UTF-8");
		// $Method = $_SERVER['REQUEST_METHOD']; // 获取请求类型
		
    /**
		if (! isset ( $_COOKIE ['username'] ) || ! isset ( $_COOKIE ['password'] )) { // 是否有键
			echo "请从正规途径访问！";
			header ( "location:./" );
			exit ();
		} else if (! isset ( $_COOKIE ['token'] ) || ! isset ( $_COOKIE ['userid'] )) {
			echo "请从正规途径访问！";
			header ( "location:./" );
			exit ();
		} else if (empty ( $_COOKIE ['username'] ) || empty ( $_COOKIE ['password'] )) { // 值 是否为空
			echo "登录失效!";
			header ( "location:./" );
			exit ();
		} else if (empty ( $_COOKIE ['token'] ) || empty ( $_COOKIE ['userid'] )) {
			echo "登录失效!";
			header ( "location:./" );
			exit ();
		}
		**/
		$access_token = $_COOKIE ['access_token'];
		$userid = $_COOKIE ['user_id'];
		
		$username = $_COOKIE ['username'];
		$userpwd = $_COOKIE ['password'];
		
		/**
		 * if($Method =="POST")
		 * {
		 * $access_token = $_POST['token'];
		 * $userid = $_POST['userid'];
		 *
		 * } else if($Method =="GET")
		 * {
		 * $access_token = $_GET['token'];
		 * $userid = $_GET['userid'];
		 * }
		 */
		
    
    /**
		// 查询账号绑定信息
		$get_bind_accounts = jsonpost ( "http://api.codoon.com/api/get_bind_accounts", "", $access_token );
		
		$ob_getbind = json_decode ( $get_bind_accounts, TRUE ); // 解析绑定信息
		                                                        
		// 查看用户绑定信息
    // {"status":"OK","data":{"mobilenumber":"13244774793","email":"821731808@qq.com","external_accounts":[{"access_token_key":"","source":"wx","catalog":"codoon_oauth_2.0","external_user_id":"oO3PDjoIPwqM55lDjdB2syOdmjw4","access_token_secret":""}]},"description":""}
		if ($ob_getbind ["status"] == "OK") {
			
			// 查看是否绑定邮箱，绑定qq {做提示}
			// $mobilenumber = $ob_getbind['data']['mobilenumber']; // 手机号
			// $email = $ob_getbind['data']['email'];
			// count isset
			
			$ob_info = $ob_getbind ['data'] ['external_accounts'];
			$is_qq = "";
			$is_wx = "";
			$bangdincontext = "";
			
			for($i = 0; $i < count ( $ob_info ); $i ++) { // source qq2 sina wx
				if ($ob_info [$i] ["source"] == "qq2") {
					$is_qq = "ok";
					$bangdincontext = $bangdincontext . "已绑定【QQ健康】 | ";
				} else if ($ob_info [$i] ["source"] == "wx") {
					$is_wx = "ok";
					$bangdincontext = $bangdincontext . "已绑定【微信运动】 | ";
				} else if ($ob_info [$i] ["source"] == "sina") {
					$bangdincontext = $bangdincontext . "已绑定【微博】 | ";
				}
			}
			
			if ($is_wx == "") {
				// 发送请求获取二维码 (显示二维码图片)
				$strMww = jsonpost ( "http://api.codoon.com/api/get_device_qrcode", "{}", $access_token );
				$objww = json_decode ( $strMww, TRUE ); // 解析关注二维码
				$strweixinurl = $objww ['data'] ['qrticket']; // 显示二维码地址
				$Wurl = "http://qr.liantu.com/api.php?bg=f3f3f3&fg=ff0000&gc=222222&el=l&w=200&m=10&text=" . $strweixinurl;
				echo '<br>首次使用<font size="4px" color="#FF0000">请用微信扫描下方二维码</font>绑定设备，后刷新页面!<br>';
				echo '<img src=' . $Wurl . ' alt="二维码" /><br>';
				// echo $Wurl;
				exit (); // 停止
			}
			
			// http://sso.codoon.com/oauth/qq2
			// http://www.codoon.com/user/bind_weibo
			// http://www.codoon.com/login
			if ($is_qq == "") {
				// 显示绑定QQ
				echo '<form action="http://sso.codoon.com/login" method="POST" target="_blank">';
				echo '<div class="reg-form-element fl" style="display: none" >';
				echo '<input type="text" name="login_id" value="' . $username . '" placeholder="手机" />';
				echo '<input type="password" name="password" value="' . $userpwd . '" />';
				echo '<input type="hidden" name="app_id" value="www"/>';
				echo '<input type="hidden" name="next" value="http://sso.codoon.com/oauth/qq2"/>';
				echo '</div>';
				echo '<input type="submit"  hidefocus="true"  value="点击绑定【QQ健康】"  ></input>';
				echo '</form>';
			}
			
			$qqtext = $is_qq == '' ? '| 未绑定【QQ健康】 | ' : '';
			// $email = $email==""?"未绑定【邮箱】":$email;
		} else if (isset ( $ob_getbind ["error_description"] )) { // 显示错误信息
		     // {"error_description":"Token doesn't exist","error_code":1002,"error":"invalid_token"}
			echo $ob_getbind ["error_description"];
			exit (); // 停止登陆页面，转跳主页
		} else {
			
			echo $get_bind_accounts;
			exit (); // 停止登陆页面，转跳主页
		}
		
		// 查询步数
		$url = 'http://api.codoon.com/api/get_mobile_steps_detail';
		$data_string = '{"end_date":"' . thisdate () . '","start_date":"' . thisdate () . '"}'; // 开始天数，结束天数
		$strData = jsonpost ( $url, $data_string, $access_token );
		
		// echo $strData;
		
		$obj = json_decode ( $strData, TRUE ); // 解析查询步数
		                                     
		// $strString = $obj->data;
		// echo '<br/>';
		 // echo print_r($strString);
		 **/     
    
		// 显示历史步数
		$strtsep = '';
		if (count ( $obj ['data'] ) != 0) { // 步数数组大于0 显示
			$strtsep = $obj ['data'] [0] ['steps'];
		}
		
		echo '<br/><br/><br/><form action="./stepsupload.php" method="post">';
		// echo '<div style="display:none;" >';
		// echo '您的用户ID：<input type="text" name="userid" value="'.$userid.'" readonly="readonly" ><br>';
		// echo '您的Cookie：<input type="text" name="token" value="'.$access_token.'" readonly="readonly" ><br>';
		// echo '</div>';
		// " style="width:200px; height:20px;" style="display:none" readonly="readonly"
		$strtsep = $strtsep + 0;
		
		echo '<input type="number"  name="xdd" value="' . $strtsep . '"  readonly="readonly" style="display:none" >';
		// echo '<input type="number" onkeyup="value=value.replace(/[^\d]/g,"")" name="step" value="" placeholder="增加步数" style="width:60px;" > = ';
		// echo '<input type="submit" value="提交步数">';
		echo '<div class="weui_cell ">';
		echo '<div class="weui_cell_hd"><label class="weui_label"> 增加数 </label></div>';
		echo '<div class="weui_cell_bd weui_cell_primary">';
		echo '<input class="weui_input" onkeyup="value=value.replace(/[^\d]/g,"")" type="number" name="step" placeholder="增加步数"/>';
		echo '</div>';
		echo '<div class="weui_cell_ft">';
		echo '<a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default">当前步:' . $strtsep . '</a>';
		echo '</div>';
		echo '</div>';
		
		echo '<div class="bd spacing">';
		echo '<input id="submit" class="weui_btn weui_btn_primary" type="submit"  value="提交步数" />';
		echo '</div>';
		echo '</form>';
		
		// 登陆状态
		echo '<div  class="hd">';
		echo '<p id="xxxxx" class="page_desc">'; // weui_cells_tips page_desc
		echo $qqtext . $bangdincontext ;//. "<a href='mian.php?logtu=true'>退出登陆</a>"; // . '手机号：' .$mobilenumber. ' | 登陆邮箱：' .$email ;
		echo '</p></div>';
		
		// echo '<br/><br/><br/><br/>';
		function jsonpost($url, $data_string, $Bearer) {
			$ch = curl_init ( $url );
			curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data_string );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
					'Content-Type: application/json',
					'Authorization: Bearer ' . $Bearer,
					'Content-Length: ' . strlen ( $data_string ) 
			) );
			
			$result = curl_exec ( $ch );
			curl_close ( $ch );
			return $result;
		}
		function thisdate() { // 获取当前日期
		                      // "date": "2015-11-18",
		                      // echo date("y-m-d h:i:s",time());
			$time = time ();
			return date ( "Y-m-d", $time ); // 2010-08-29
		}
		
		?>

<div class="weui_cells weui_cells_access">

		<a class="weui_cell" href="mian.php?logtu=true">
			<div class="weui_cell_hd">
				<img
					src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII="
					alt="" style="width: 20px; margin-right: 5px; display: block">
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<p>cell </p>
			</div>
			<div class="weui_cell_ft">退出登陆</div>
		</a> 
		
		<a class="weui_cell" href="javascript:;">
			<div class="weui_cell_hd">
				<img
					src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII="
					alt="" style="width: 20px; margin-right: 5px; display: block">
			</div>
			<div class="weui_cell_bd weui_cell_primary">
				<p>cell </p>
			</div>
			<div class="weui_cell_ft">关于</div>
		</a>
	</div>


	<div class="hd">
		<p class="page_desc">【爱刷步】虚拟刷步系统</p>
	</div>

	<script type="text/javascript"
		src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
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

			if (getCookie("username") != null) {
				document.getElementById("user").value = getCookie("username");
			}
			if (getCookie("password") != null) {
				document.getElementById("pwd").value = ""+ getCookie("password");
			}
			if (getCookie("pc") != null) {
				document.getElementById("pc").value = "" + getCookie("pc");
			}

		})();
        
        
        
		window.shareData = {  
			"moduleName":"Index",
			"moduleID": "0",
			"imgUrl": "", 
			"timeLineLink": "http://www.37wei.cn/index.php?g=Wap&m=Index&a=index&token=xdgkiy1444014268",
			"sendFriendLink": "http://www.37wei.cn/index.php?g=Wap&m=Index&a=index&token=xdgkiy1444014268",
			"weiboLink": "http://www.37wei.cn/index.php?g=Wap&m=Index&a=index&token=xdgkiy1444014268",
			"tTitle": "",
			"tContent": "",
			"timeline_hide": "1"
		};
</script>
	<script type="text/javascript">
	wx.ready(function () {
	  // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
	  /*document.querySelector('#checkJsApi').onclick = function () {
	    wx.checkJsApi({
	      jsApiList: [
	        'getNetworkType',
	        'previewImage'
	      ],
	      success: function (res) {
	        //alert(JSON.stringify(res));
	      }
	    });
	  };*/
	  // 2. 分享接口
	  
	  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
	    wx.onMenuShareAppMessage({
			title: window.shareData.tTitle,
			desc: window.shareData.tContent,
			link: window.shareData.sendFriendLink,
			imgUrl: window.shareData.imgUrl,
		    type: '', // 分享类型,music、video或link，不填默认为link
		    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		    success: function () { 
				shareHandle('frined');
		    },
		    cancel: function () { 
		        //alert('分享朋友失败');
		    }
		});


	  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareTimeline({
			title: window.shareData.fTitle?window.shareData.fTitle:window.shareData.tTitle,
			link: window.shareData.sendFriendLink,
			imgUrl: window.shareData.imgUrl,
		    success: function () { 
				shareHandle('frineds');
		        //alert('分享朋友圈成功');
		    },
		    cancel: function () { 
		        //alert('分享朋友圈失败');
		    }
		});	

	  // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareWeibo({
			title: window.shareData.tTitle,
			desc: window.shareData.tContent,
			link: window.shareData.sendFriendLink,
			imgUrl: window.shareData.imgUrl,
		    success: function () { 
				shareHandle('weibo');
		       	//alert('分享微博成功');
		    },
		    cancel: function () { 
		        //alert('分享微博失败');
		    }
		});
		
		if(window.shareData.timeline_hide == '1'){
		 //隐藏分享到朋友圈
			wx.hideMenuItems({
			  menuList: [
				'menuItem:share:timeline',
				'menuItem:favorite'
			  ],
			});
			wx.hideOptionMenu();
			wx.showAllNonBaseMenuItem();
		}
		wx.showMenuItems({
			menuList: ['menuItem:profile','menuItem:addContact'] // 要显示的菜单项，所有menu项见附录3
		});
		
		wx.hideMenuItems({
			menuList: [] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
		});
	});
		
		// config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
		wx.error(function (res) {
			/*if(res.errMsg == 'config:invalid signature'){
				wx.hideOptionMenu();
			}else if(res.errMsg == 'config:invalid url domain'){
				wx.hideOptionMenu();
			}else{
				wx.hideOptionMenu();
				//alert(res.errMsg);
			}*/
			
			if(res.errMsg){
				wx.hideOptionMenu();
			}else{
				alert(res+'打开失败，请联系管理员！');
			}
			
		});

	function shareHandle(to) {
		var submitData = {
			module: window.shareData.moduleName,
			moduleid: window.shareData.moduleID,
			token:'xdgkiy1444014268',
			wecha_id:'',
			url: window.shareData.sendFriendLink,
			to:to
		};

		$.post('index.php?g=Wap&m=Share&a=shareData&token=xdgkiy1444014268&wecha_id=',submitData,function (data) {},'json');
		if(window.shareData.isShareNum == 1){
			var ShareNum = {
				token:'xdgkiy1444014268',
				ShareNumData:window.shareData.ShareNumData
			}
			$.post('index.php?g=Wap&m=Share&a=ShareNum&token=xdgkiy1444014268&wecha_id=',ShareNum,function (data) {},'json');
		}
	}
</script>
</body>
</html>
