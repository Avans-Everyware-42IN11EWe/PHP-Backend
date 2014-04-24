<?php
$app->get('/facebook', function () {
    global $app, $fbid, $fbsecret;

    $db = \Helpers\DatabaseHelper::GetPDOConnection();

    $app->response->headers->set('Content-Type', 'application/json');

    $config = array(
        'appId' => $fbid,
        'secret' => $fbsecret,
        'fileUpload' => false, // optional
        'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
    );

    $facebook = new Facebook($config);

    if(isset($_GET['accesstoken'])){
        $sth = $db->prepare('INSERT INTO facebook (userid, access) VALUES(?, ?) ON DUPLICATE KEY UPDATE access = ?');

        $facebook->setAccessToken($_GET['accesstoken']);
        $user_id = $facebook->getUser();
        $sth->execute(array($user_id, $_GET['accesstoken'], $_GET['accesstoken']));

//        $user_profile = $facebook->api('/me','GET');
//        echo json_encode($user_profile);
    }
    $pageid = "1450066045229608";
//
    $response = $facebook->api(
        "/".$pageid
    );

    $sth = $db->prepare('select userid from facebook');
    $sth->execute(array());
    $result = $sth->fetchAll(PDO::FETCH_COLUMN);
    $plaatjes = $result;
    echo json_encode(array(
        'plaatjes' => $plaatjes,
        'about' => $response['about'],
        'page' => $response,
        'feed' => $facebook->api("/".$pageid.'/feed'),
        'photos' => $facebook->api("/".$pageid.'/photos')["data"]
    ));
});