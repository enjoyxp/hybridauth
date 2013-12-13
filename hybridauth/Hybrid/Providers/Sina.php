<?php
/** 
 * Sina OAuth Class based OAuth2 protocol
 */ 
class Hybrid_Providers_Sina extends Hybrid_Provider_Model_OAuth2 {
    
    public function initialize() {
		parent::initialize();

		$this->api->authorize_url  = "https://api.weibo.com/oauth2/authorize";
		$this->api->token_url      = "https://api.weibo.com/oauth2/access_token";
	}
    
    public function getUserProfile() {
        $data = $this->api->api('https://api.weibo.com/2/users/show.json'); 
        
		if (isset($data->error_code))
			throw new Exception("User profile request failed! {$this->providerId} returned an invalid response.", 6);

        $this->user->profile->identifier  = $data->id;
		$this->user->profile->displayName = $data->screen_name;
        $this->user->profile->profileURL  = sprintf('http://www.weibo.com/%s', $data->profile_url);
        $this->user->profile->gender      = $data->gender;
        $this->user->profile->address     = $data->location;
        
		return $this->user->profile;
    }
    
}