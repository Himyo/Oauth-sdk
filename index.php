<?php


require('./GenericProvider.php');
$providerName = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

$json = file_get_contents('./conf.json');
$conf = json_decode($json, true);

if($providerName == '') {
    echo '<a href="/facebook?provider=authorization">Facebook</a><br />';
    echo '<a href="/github?provider=authorization">Github</a><br />';
}

if(isset($conf[$providerName])){
    $provider = new GenericProvider($providerName);
    $provider->init($conf[$providerName]);
}

if($_GET['provider'] == 'authorization') {
    header("Location: {$provider->getAuthorizationUrl()}");
}

if($_GET['code']) {
    $provider->setCode($_GET['code']);
    $tokenUrl = $provider->getAccessTokenUrl();
    $request = $provider->curl($tokenUrl, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    if(isset($request['access_token'])) {
        $provider->setAccessToken($request['access_token']);
        $accessUrl = $provider->getAccessUrl();
        $request = $provider->curl($accessUrl, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: token '.$provider->getAccessToken()
        ]);
        echo "<pre>";
        var_dump($request);
    }
    else {
        echo "Error with access_token request";
    }
}
