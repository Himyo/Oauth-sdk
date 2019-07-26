<?php
require_once('./ProviderInterface.php');

abstract class AbstractProvider implements ProviderInterface {


    public function getProviderName(): string {
        return $this->name;
    }

    public function setProviderName($name) {
        $this->name = $name;
    }

    public function getAuthorizationUrl(): string {
        $authorization_url = $this->authorization_url;
        $authorization_url .= "client_id={$this->client_id}";
        $authorization_url .= "&redirect_uri={$this->redirect_uri}";
        $authorization_url .= "&state={$this->state}";
        return $authorization_url;
    }
    public function getAccessTokenUrl(): string {
        $token_url = $this->token_url; 
        $token_url .= "client_id={$this->client_id}";
        $token_url .= "&redirect_uri={$this->redirect_uri}";
        $token_url .= "&client_secret={$this->client_secret}";
        $token_url .= "&code={$this->code}";
        $token_url .= "&state={$this->state}";

        return $token_url;
    }
    public function getUsersInfo(): array {
        return [];
    }
    public function setCode($code) {
        $this->code = $code;
    }
    public function setToken($token) {
        $this->token = $token;
    }
}