<?php
/** 
 * QQzone OAuth Class based OAuth2 protocol
 */ 
class Hybrid_Providers_QQzone extends Hybrid_Provider_Model_OAuth2 {
    
    public $scope = "add_share,add_idol";
    
    public function initialize() {
		parent::initialize();

		$this->api->authorize_url  = "https://graph.qq.com/oauth2.0/authorize";
		$this->api->token_url      = "https://graph.qq.com/oauth2.0/token";
	}
    
    public function getOpenid() {
        $resp = $this->api->api('https://graph.qq.com/oauth2.0/me');
        
        if (isset($resp->error))
            throw new Exception(sprintf('Get QQzone openid failed! %s', $resp->error_description));
        
        return $resp;
    }
    
    public function getUserProfile() {
        $resp = $this->getOpenid();

        $params = array(
            'oauth_consumer_key' => $resp->client_id,
            'openid' => $resp->openid,
            'format' => 'json',
        );
        $data = $this->api->api('https://graph.qq.com/user/get_user_info', 'GET', $params); 
        
		if ($data->ret !== 0)
			throw new Exception("User profile request failed! {$this->providerId} returned an invalid response.", 6);

        $this->user->profile->gender      = $data->gender;
		$this->user->profile->displayName = $data->nickname;
        $this->user->profile->photoURL    = $data->figureurl;
        
		return $this->user->profile;
    }
    
}