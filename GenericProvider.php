<?php

require_once('./AbstractProvider.php');

class GenericProvider extends AbstractProvider {
    
    public $name;
    public $authorization_url;
    public $token_url;
    public $redirect_uri;
    public $api_url;
    public $token_as_parameters;

    public $client_id;
    public $client_secret;
    public $app_name;

    public $state;
    public $code;
    public $access_token;


    public function __construct($name = "None") {
        $this->name = $name;
    }

    public function init($provider) {
        $this->authorization_url =  $provider['url']['authorization'];
        $this->token_url =  $provider['url']['token'];
        $this->redirect_uri =  $provider['url']['redirect'];
        $this->api_url =  $provider['url']['api'];
        $this->token_as_parameters = $provider['url']['token_as_parameters'];

        $this->client_id =  $provider['client']['id'];
        $this->client_secret =  $provider['client']['secret'];
        $this->app_name =  $provider['client']['app_name'];

        $this->state = $provider['state'];
    }

    public function setAccessToken($access_token) {
        $this->access_token = $access_token;
    }

    public function getAccessUrl(): string {
        $api_url = $this->token_as_parameters ? 
            $this->api_url.'&access_token='.$this->access_token 
        :
            $this->api_url;
        return $api_url;
    }

    public function getAccessToken(): string {
        return $this->access_token;
    }

    public function curl($url, $header = []) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->app_name);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($curl);
        curl_close($curl);
        
        $json = json_decode($result, true);
        return $json;
    }
}