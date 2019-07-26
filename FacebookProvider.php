<?php
require_once('./AbstractProvider.php');

class FacebookProvider extends AbstractProvider {

    protected $authorization_url = "https://www.facebook.com/v3.3/dialog/oauth?";
    protected $token_url = "https://graph.facebook.com/v3.3/oauth/access_token?";
    protected $client_id = "2487039177993579";
    protected $redirect_uri= "http://localhost:8093/facebook";
    protected $client_secret = "8a02a373af8bc36176c54ff5c2590739";
    protected $state = "\"{st=state123abc,ds=286159500}\"";
    protected $code;

    public function getProviderName(): string {
        return "Facebook";
    }

    public function setCode($code) {
        $this->code = $code;
    }
}