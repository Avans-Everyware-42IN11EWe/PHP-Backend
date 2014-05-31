<?php

doc(
    "wijkbewoner",
    "Commitment <span class='label label-danger'>Niet</span>",
    "POST <code>/commitment</code>",
    '                <h4>Situatie 1:</h4>
                <b>Gebruiker heeft e-mail verificatie gedaan</b>
                <pre>{ "token": "blaat123" }</pre>

                <h4>Situatie 2:</h4>
                <b>Gebruiker moet e-mail verificatie nog doen</b>
                <pre>fail</pre>');
$app->post('/login', function () {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    echo '{ "token": "blaat123" }';
    return;


    //    $length = 10;
    //$token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);


    $jObj = json_decode($_POST["json"]);
    if(isset($jObj->token))
    {
        Managers\UserManager::Login($jObj->token);
    }
    else
        json_encode(array("response" => "err", "message" => "Missing post data"));
});