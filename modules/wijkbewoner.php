<?php

// POST routes
doc(
    "wijkbewoner",
    "Registeren",
    "POST <code>/register</code>",
    '<h4>Meegeven:</h4>
 <pre>
{
    "email": "bill@microsoft.com",
    "name": "Bill Gates",
    "address": "Kerkstraat 1, Amsterdam",
    "district_id": 5
}</pre>

<p class="bg-info">district_id staat voor wijknummer</p>

<h4>Return:</h4>
<pre>{ "user_id": 34 }</pre>');
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


// Login
doc(
    "wijkbewoner",
    "Inloggen",
    "GET <code>/login?user_id=34</code>",
    '                <h4>Situatie 1:</h4>
                <b>Gebruiker heeft e-mail verificatie gedaan</b>
                <pre>{ "token": "blaat123" }</pre>

                <h4>Situatie 2:</h4>
                <b>Gebruiker moet e-mail verificatie nog doen</b>
                <pre>fail</pre>');
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


doc(
    "wijkbewoner",
    "Facebook",
    "POST <code>/facebook</code>",
    '<h4>Meegeven:</h4>
                <pre>
{
    "user_id": "34",
    "access_token": "CAAKNJIG6TKMBAE00HOVfARdRYq4dkIZAKKLKotZB1ftBQl16Gd9WFuTbvTsIjx2PgSejeD7dqS184KqAo93Jv5PnJvGoJXRmSSF31BYM9cWmN8ZAG79RnxuPiJrUbX4BKuyx6Vgc76ScJdI37X58kjzbKk2ads2bJDsutJ3nQTd5H3P8Mq6iKicubj2GUvLcUCeHq53pa8ZBTZAfX4NrcRjtZBZA2lf3lFL9QuLgPtfzwZDZD"
}</pre>');
$app->post('/facebook', function(){
    echo '{ "token": "blaat123" }';
});


 