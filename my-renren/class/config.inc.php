<?php
/*
 * 总体配置文件，包括API Key, Secret Key，以及所有允许调用的API列表
 * This file for configure all necessary things for invoke, including API Key, Secret Key, and all APIs list
 *
 * @Modified by Edison tsai on 16:34 2011/01/13 for remove call_id & session_key in all parameters.
 * @Created: 17:21:04 2010/11/23
 * @Author:	Edison tsai<dnsing@gmail.com>
 * @Blog:	http://www.timescode.com
 * @Link:	http://www.dianboom.com
 */
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
$config				= new stdClass;

# modify by tom.wang at 2011-05-12 : add relate url for oauth flow
$config->AUTHORIZEURL = 'https://graph.renren.com/oauth/authorize';  //进行连接授权的地址，不需要修改
$config->ACCESSTOKENURL = 'https://graph.renren.com/oauth/token'; //获取access token的地址，不需要修改
$config->SESSIONKEYURL = 'https://graph.renren.com/renren_api/session_key'; //获取session key的地址，不需要修改
$config->CALLBACK = DF_CALLBACK; //回调地址，注意和您申请的应用一致

$config->APIURL		= 'http://api.renren.com/restserver.do'; //RenRen网的API调用地址，不需要修改
$config->APIKey		= DF_APIKEY;	//你的API Key，请自行申请
$config->SecretKey	= DF_SECRETKEY;	//你的API 密钥
$config->APIVersion	= '1.0';	//当前API的版本号，不需要修改
$config->decodeFormat	= 'json';	//默认的返回格式，根据实际情况修改，支持：json,xml
/*
 *@ 以下接口内容来自http://wiki.dev.renren.com/wiki/API，编写时请遵守以下规则：
 *  key  (键名)		: API方法名，直接Copy过来即可，请区分大小写
 *  value(键值)		: 把所有的参数，包括required及optional，除了api_key,method,v,format不需要填写之外，
 *					  其它的都可以根据你的实现情况来处理，以英文半角状态下的逗号来分割各个参数。
 */
$config->APIMapping		= array( 
		'admin.getAllocation' => '',
		'connect.getUnconnectedFriendsCount' => '',
		'friends.areFriends' => 'uids1,uids2',
		'friends.get' => 'page,count',
		'friends.getFriends' => 'page,count',
		'notifications.send' => 'to_ids,notification',
		'users.getInfo'	=> '',//获取当前用户信息
		'feed.get'	=> 'page,count,type',//获取当前用户新鲜事
		'status.set'	=> 'status',//用户状态更新   users.isAppUser
		'users.isAppUser'	=> '',//用户授权情况  
		'users.hasAppPermission'	=> 'ext_perm',//具体应用授权
		'status.gets'	=> 'uid,count,page',//获取用户状态列表
		'users.getProfileInfo'	=> '',//获取用户信息
		'status.getEmoticons'	=> '',//获取表情
		'like.like'	=> 'url',//对url喜欢
		'like.unlike'	=> 'url',//取消喜欢
		
		'photos.addComment'	=> 'uid,aid,pid,content',//照片评论
		'status.addComment'	=> 'owner_id,status_id,content',//状态评论
		'blog.addComment'	=> 'uid,id,content',//日志评论
		'share.addComment'	=> 'user_id,share_id,content',//分享评论
		
		'share.share'	=> 'type,user_id,ugc_id,comment,url',//分享功能
		'photos.upload'	=> 'upload',//图片上传
		
		
		
		
		
		/* 更多的方法，请自行添加 
		   For more methods, please add by yourself.
		*/
);
?>