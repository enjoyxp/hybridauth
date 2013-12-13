<?php
/** 
 * TXweibo OAuth Class based OAuth2 protocol
 */ 
class Hybrid_Providers_TXweibo extends Hybrid_Provider_Model_OAuth2 {
    
    public function initialize() {
		parent::initialize();

		$this->api->authorize_url  = "https://open.t.qq.com/cgi-bin/oauth2/authorize";
		$this->api->token_url      = "https://open.t.qq.com/cgi-bin/oauth2/access_token";
	}
    
    public function getUserProfile() {
        $params = array(
            'oauth_consumer_key' => $this->api->client_id,
            'clientip' => server('remote_addr'),
            'oauth_version' => '2.a',
            'scope' => 'all',
            'format' => 'json',
        );
        $data = $this->api->api('https://open.t.qq.com/api/user/info', 'GET', $params); 

        if ($data->errcode !== 0)
			throw new Exception("User profile request failed! {$this->providerId} returned an invalid response.", 6);

        $data = $data->data;
		$this->user->profile->birthDay    = (int)$data->birth_day;
        $this->user->profile->birthMonth  = (int)$data->birth_month;
        $this->user->profile->birthYear   = (int)$data->birth_year;
        $this->user->profile->address     = $data->location;
        $this->user->profile->displayName = $data->nick ?: $data->name;
        $this->user->profile->profileURL  = sprintf('http://t.qq.com/%s', $data->name);
        $this->user->profile->firstName   = $data->nick;
        $this->user->profile->gender      = $data->sex;
        
		return $this->user->profile;
    }
    
}