<?php
require_once('./AbstractProvider.php');

class GithubProvider extends AbstractProvider {

    protected $authorization_url = "https://github.com/login/oauth/authorize?";
    protected $token_url = "https://github.com/login/oauth/access_token?";
    protected $client_id = "1f9c41cc685523861e4a";
    protected $redirect_uri = "http://localhost:8093/github";
    protected $client_secret = "133f35f53c53ee20176654b6591236884a13ac98";
    protected $state = "OAIIoiojn";
    protected $code;
    
    public function getProviderName(): string {
        return "Github";
    }
    public function setCode($code) {
        $this->code = $code;
    }

}