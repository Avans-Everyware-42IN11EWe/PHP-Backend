<?php

// POST routes

// Login
$app->post('/login', function () {
    echo '{ "token": "blaat123" }';
    return;

    $jObj = json_decode($_POST["json"]);
    if(isset($jObj->token))
    {
        Managers\UserManager::Login($jObj->token);
    }
    else
        json_encode(array("response" => "err", "message" => "Missing post data"));
});

// Register
$app->post('/register', function () {
    echo '{ "user_id": 34 }';
    return;
    $jObj = json_decode($_POST["json"]);
    if(isset($jObj->name) && isset($jObj->email))
    {
        Managers\UserManager::Register($jObj->name, $jObj->email);
    }
    else
        json_encode(array("response" => "err", "message" => "Missing post data"));
});

 