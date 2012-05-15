<?php
/**
 * renren oauth flow(web server flow)
 * please oauth2 details here : http://wiki.dev.renren.com/wiki/%E4%BD%93%E9%AA%8C%E4%BA%BA%E4%BA%BAOAuth2.0%E9%AA%8C%E8%AF%81%E6%8E%88%E6%9D%83%E5%9F%BA%E6%9C%AC%E6%B5%81%E7%A8%8B
 *
 * @author tom.wang<superlinyzu@qq.com>
 */
class RenRenOauth extends RESTClient {
	private $_config;
	
	/**
	 * construct function
	 *
	 * @author tom.wang<superlinyzu@qq.com>
	 */
	public function __construct(){
		global $config;
		
		parent::__construct();
		
		$this->_config = $config;
		
		if(empty($this->_config->AUTHORIZEURL) || empty($this->_config->ACCESSTOKENURL) || empty($this->_config->SESSIONKEYURL) || empty($this->_config->CALLBACK)){
			throw new exception('Invalid AUTHORIZEURL or ACCESSTOKENURL or SESSIONKEYURL or CALLBACK, please check config.inc.php');
		}

	}
	/**
	 * get authorize url
	 * please read details at : http://wiki.dev.renren.com/wiki/%E8%8E%B7%E5%8F%96Authorization_Code
	 *
	 * @author tom.wang<superlinyzu@qq.com>
	 * @return string : the url used for user to authorize
	 */
	public function getAuthorizeUrl() {
		$url = $this->_config->AUTHORIZEURL . '?x_renew=true&response_type=code&client_id=' . $this->_config->APIKey . '&redirect_uri=' . urlencode($this->_config->CALLBACK) . '&scope=read_user_status status_update operate_like publish_share read_user_like_history read_user_blog read_user_checkin read_user_feed read_user_guestbook read_user_invitation read_user_message read_user_photo read_user_status read_user_album read_user_comment read_user_share read_user_request publish_blog publish_checkin publish_feed publish_share write_guestbook send_invitation send_request send_message photo_upload status_update create_album publish_comment';
		
		return $url;
	}
	
	/**
	 * get access token
	 * please read details at : http://wiki.dev.renren.com/wiki/%E4%BD%BF%E7%94%A8Authorization_Code%E8%8E%B7%E5%8F%96Access_Token
	 *
	 * @author tom.wang<superlinyzu@qq.com>
	 * @param string $code : the authorized code
	 * @return string : access token
	 */
	public function getAccessToken($code) {
		$url = $this->_config->ACCESSTOKENURL;
		$params = array(
			'client_id' => $this->_config->APIKey,
			'client_secret' => $this->_config->SecretKey,
			'redirect_uri' => $this->_config->CALLBACK,
			'grant_type' => 'authorization_code',
			'code' => $code,
		);
		$ret = $this->call($url, 'POST', $params);
		$ret = json_decode($ret, true);
		
		# check error
		if(isset($ret['error_description'])) {
			throw new Exception($ret['error_description']);
		}
		
		return $ret;
	}
	
	/**
	 * refresh_token access token
	 * please read details at : http://wiki.dev.renren.com/wiki/%E4%BD%BF%E7%94%A8Authorization_Code%E8%8E%B7%E5%8F%96Access_Token
	 *
	 * @author tom.wang<superlinyzu@qq.com>
	 * @param string $refresh_token : refresh_token
	 * @return string : access token refresh_token
	 */
	public function refreshAccessToken($refresh_token) {
		$url = $this->_config->ACCESSTOKENURL;
		$params = array(
			'client_id' => $this->_config->APIKey,
			'client_secret' => $this->_config->SecretKey,
			'grant_type' => 'refresh_token',
			'refresh_token' => $refresh_token,
		);
		$ret = $this->call($url, 'POST', $params);
		$ret = json_decode($ret, true);
		
		# check error
		if(isset($ret['error_description'])) {
			throw new Exception($ret['error_description']);
		}
		
		return $ret;
	}
	
	/**
	 * get session key
	 *
	 * @author tom.wang<superlinyzu@qq.com>
	 * @param string $access_token
	 * @return string : session key
	 */
	public function getSessionKey($access_token) {
		$url = $this->_config->SESSIONKEYURL;
		$params = array(
			'oauth_token' => $access_token,
		);
		$ret = $this->call($url, 'POST', $params);
		$ret = json_decode($ret, true);
		
		# check error
		if(isset($ret['error_description'])) {
			throw new Exception($ret['error_description']);
		}
		
		return $ret;
	}
}
?>