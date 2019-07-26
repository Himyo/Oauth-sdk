<?php

require('./GenericProvider.php');
$providerName = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

$json = file_get_contents('./conf.json');
$conf = json_decode($json, true);

if($providerName == '') {
    ?>
    <div class="mx-auto mt-4" style="padding: 1rem; background-color: #eeeeee; border: 1px solid #bbbbbb    ; border-radius: 4px; display: flex; flex-direction: column; align-items: center; width: 300px;">
        <div>
            <h1>SDK</h1>
            <hr>
        </div>

        <div class="mt-2">
            <a class="btn btn-info mr-2" href="/facebook?provider=authorization">Facebook</a>
            <a class="btn btn-success" href="/github?provider=authorization">Github</a>
        </div>

        <a href="https://m.me/2282859145292393" target="_blank" class="mt-3 btn btn-danger">CHATBOT</a>

    </div>
<?php
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
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
