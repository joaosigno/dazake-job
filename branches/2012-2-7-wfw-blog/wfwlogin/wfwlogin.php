<?php
/*
Plugin Name:Widget WanfuWang login
Plugin URI:http://blog.wanfuwang.com
Description:A plugin to create wanfuwang login widgets in WordPress
Version:1.0
Author:Micheal
Author URI:http://micheal.dazake.com
License:GPLv2
*/


/*
 * register with hook 'wp_enqueue_scripts' which can be used for front end CSS and JavaScript
 */
add_action('wp_enqueue_scripts', 'wfwlogin_add_my_stylesheet');

/*
 * Enqueue style-file, if it exists.
 */
function wfwlogin_add_my_stylesheet() {
    $myStyleUrl = plugins_url('css/style.css', __FILE__); // Respects SSL, Style.css is relative to the current file
    $myStyleFile = WP_PLUGIN_DIR . '/wfwlogin/css/style.css';
    if ( file_exists($myStyleFile) ) {
        wp_register_style('myStyleSheets', $myStyleUrl);
        wp_enqueue_style( 'myStyleSheets');
    }
}


add_action('wp_enqueue_scripts', 'wfwlogin_add_my_stylesheet2');

/*
 * Enqueue style-file, if it exists.
 */
function wfwlogin_add_my_stylesheet2() {
    $myStyleUrl2 = plugins_url('css/fancybox.css', __FILE__); // Respects SSL, Style.css is relative to the current file
    $myStyleFile2 = WP_PLUGIN_DIR . '/wfwlogin/css/fancybox.css';
    if ( file_exists($myStyleFile2) ) {
        wp_register_style('myStyleSheets2', $myStyleUrl2);
        wp_enqueue_style( 'myStyleSheets2');
    }
}

function wfwlogin_scripts_method2() {
   wp_enqueue_script('main',
     /* WP_PLUGIN_URL . '/someplugin/js/newscript.js', // old way, not SSL compatible */
     plugins_url('/js/main.js', __FILE__), // where the this file is in /someplugin/
     array('scriptaculous'),
     '1.0' );
}    
 
add_action('wp_enqueue_scripts', 'wfwlogin_scripts_method2');


function wfwlogin_scripts_method() {
   wp_enqueue_script('fancybox',
     /* WP_PLUGIN_URL . '/someplugin/js/newscript.js', // old way, not SSL compatible */
     plugins_url('/js/fancybox.js', __FILE__), // where the this file is in /someplugin/
     array('scriptaculous'),
     '1.0' );
}    
 
add_action('wp_enqueue_scripts', 'wfwlogin_scripts_method');

//use widgets_init action hook to execute custom function
add_action('widgets_init','wfwlogin_widget_register_widgets');
//register our widget
function wfwlogin_widget_register_widgets(){
	register_widget('wfwlogin_widget_widget_wfw_login');
}

//wfwlogin_widget_wfw_login class
class wfwlogin_widget_widget_wfw_login extends WP_Widget{

	//process the new widget
	function wfwlogin_widget_widget_wfw_login(){
		$widget_ops=array(
					'classname'=>'wfwlogin_widget_widget_class',
					'description'=>'This widget is for wanfuwang login.'
					);
		$this->WP_Widget('wfwlogin_widget_widget_wfw_login','WFW login',$widget_ops);
	}
	
	//build the widget settings form
	function form(){
		echo '<span>This is the login form in admin</span>';


	}

	//display the widget
	function widget(){

?>
	<script type="text/javascript">
		function goLogin(){
			var link = "http://www.wanfuwang.com/checklogin.php",
			     data = link+"?email="+jQuery("#un").val()+"&"+"password="+jQuery("#pw").val();
			jQuery("#goLogin").attr("href",data);
			// $("#goLogin").trigger("click");
			// frm.submit();
		}

		jQuery(document).ready(function() {
			jQuery("#various1").fancybox({
					'width'					: 370,
					'height'				: '100%',
					'autoScale'				: false,
					'transitionIn'			: 'none',
					'transitionOut'			: 'none',
					'type'					: 'iframe'
				});
				
				
			jQuery("#forgotpass").fancybox({
					'width'					: 340,
					'height'				: 300,//269,
					'autoScale'				: false,
					'transitionIn'			: 'none',
					'transitionOut'			: 'none',
					'type'					: 'iframe'
				});
		});
		function qqlogin() {
			window.open("http://www.wanfuwang.com/SNS/QQauth/index.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1,esizable=1,status=1,titlebar=0,toolbar=0,location=1");
		}
	</script>
	<div class="main-right" style="position: relative;">
	<div class="right-main-inner">
		<h2>登录</h2>
		<h3>欢迎登陆万服网!</h3>
		<form id="login" action="#" method="get" onsubmit="return false;" name="frm">
		<ul>
			<li>
				<label>帐号</label><input type="text" size="10" id="un" name="email" >
			</li>
		
			<li>
				<label>密码</label><input type="password" size="10" id="pw" name="password" />
			</li>
		</ul>
		<span class="forgot-link"><a href="http://www.wanfuwang.com/forgot_password.php" class="joinus" id="forgotpass">忘记密码?</a></span>
		<div style="clear:both;"></div>
		<span class="qqoauth" style="position: absolute;top:52px;right: 20px;"><a href="#" onclick="qqlogin()" id="qqlogin"><img src="http://qzonestyle.gtimg.cn/qzone/vas/opensns/res/img/Connect_logo_6.png" alt="qqlogin"></a></span>

		<a href="#" target="_blank" id="goLogin" class="first" onclick="goLogin();"><img src="http://www.wanfuwang.com/images/submit_btn.png"></a>

		<a href="#" onclick="frm.reset();"><img src="http://www.wanfuwang.com/images/reset_btn.png"></a>
		<input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;">
		</form>
	</div>
	</div>
	<div class="main-right-bottom-inner">
		<span class="headertext">加入我们</span>
		<a href="http://www.wanfuwang.com/form.php" class="joinus" id="various1">
			<img src="http://www.wanfuwang.com/images/button_bottom.png">
		</a>
	</div>

<?php
	}
}
?>