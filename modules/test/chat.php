<?php
// Chat
$app->post('/chat/getmessages', function () {

    $jObj = json_decode($_POST["json"]);

});

$app->post('/chat/hasnewmessages', function () {

    $jObj = json_decode($_POST["json"]);

});

$app->post('/chat/sendmessage', function () {

    $jObj = json_decode($_POST["json"]);

});