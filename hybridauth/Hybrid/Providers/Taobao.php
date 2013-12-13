<?php
/** 
 * Taobao OAuth Class based OAuth2 protocol
 */ 
class Hybrid_Providers_Taobao extends Hybrid_Provider_Model_OAuth2 {
    
    public function initialize() {
		parent::initialize();

		$this->api->authorize_url  = "https://oauth.taobao.com/authorize";
		$this->api->token_url      = "https://oauth.taobao.com/token";
	}
    
    public function getUserProfile() {
		$this->user->profile->identifier  = $this->api->taobao_user_id;
        $this->user->profile->displayName = $this->api->taobao_user_nick;
        
		return $this->user->profile;
    }
    
}