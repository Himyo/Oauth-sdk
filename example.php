<?php

$isHome = strtok($_SERVER['REQUEST_URI'], '?') == "/";

function facebook(){
    require('./FacebookProvider.php');
    $provider = new FacebookProvider();
    $authUrl = $provider->getAuthorizationUrl();
    if($isHome) {
        header("Location: {$authUrl}");
    }
    if($_GET['code']) {
        $code = $_GET['code'];
        $provider->setCode($code);
        $curl = curl_init();
        $token_url = $provider->getAccessTokenUrl();
        curl_setopt($curl, CURLOPT_URL, $token_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        $res = curl_exec($curl);

        $json = json_decode($res, true);
        var_dump($json);
        $access_token = $json['access_token']; 
        if($access_token) {
            $access_url = "https://graph.facebook.com/v3.3/me?fields=id,name&access_token=".$access_token;
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $access_url);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Oauth');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: token '.$access_token
            ]);
            $res = curl_exec($curl);
            curl_close($curl);
            $json = json_decode($res, true);
            echo "<pre>";
            var_dump($json);
        }
    }
}





function github() {
    require('./GithubProvider.php');
    $provider = new GithubProvider();
    $authUrl = $provider->getAuthorizationUrl();

    if($isHome){
        header("Location: {$authUrl}");
    }

    if($_GET["code"] ) { 
        $code = $_GET["code"];
        $provider->setCode($code);
        $curl = curl_init();
        $tokenUrl = $provider->getAccessTokenUrl();

        curl_setopt($curl, CURLOPT_URL, $tokenUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        $res = curl_exec($curl);
        if(curl_errno($curl)){
            echo "Error: {curl_error($curl)}";
        }
        curl_close($curl);
        $json = json_decode($res, true);
        $access_token = $json['access_token']; 
        if($access_token) {
            $access_url = "https://api.github.com/user" ;
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $access_url);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Oauth-sdk');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: token '.$access_token
            ]);
            $res = curl_exec($curl);
            curl_close($curl);
            $json = json_decode($res, true);
            echo "<pre>";
            var_dump($json);
        }
    }
}