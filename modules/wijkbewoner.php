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
    "latlong": [1.233, 4.222],
    "district_id": 3
}</pre>

<p class="bg-info">district_id staat voor wijknummer</p>

<h4>Return:</h4>
<pre>{ "user_id": 34 }</pre>');
// Register
$app->post('/register', function() {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $db->beginTransaction();

    $sth = $db->prepare("INSERT INTO residents (`id`, `district_id`, `email`, `name`, `address`, `token`) VALUES (NULL, ?, ?, ?, ?, NULL);");

    $input = json_decode(file_get_contents("php://input"));
    $sth->execute(array($input->district_id, $input->email, $input->name, json_encode($input->latlong)));
    $db->commit();

    $sth2 = $db->query('SELECT LAST_INSERT_ID() as last_id');
    $last_id = $sth2->fetchAll();

    $userid = intval($last_id[0]['last_id']);

    echo json_encode(array("user_id" => $userid));//'{ "user_id": 34 }';
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

doc("wijkbewoner",
    "Chatberichten ophalen",
    "GET <code>/chat?resident_id=1</code> optioneel: <code>&from=20</code> waar from de ID is",
    '
    <h4>Return:</h4>
<pre>[{"from": {"id": 2, "name":"Henk", "photo": "http://google.nl/image.jpg"}, "timestamp":1234434, "message": "afsd;afsdjadfslk"} ]</pre>
');
$app->get("/chat", function(){
    global $app;
    $db = \Helpers\DatabaseHelper::GetPDOConnection();

    $app->response->headers->set('Content-Type', 'application/json');

    $has_parameters = isset($_GET["from"])&&$_GET["from"]!="";
    $stmt = $db->prepare("
    select *
    from chat
    where receiver_id = ?" . ($has_parameters ? " AND id >= ?" : ""));
    $p = array($_GET["resident_id"]);
    if($has_parameters) {
        array_push($p, $_GET["from"]);
    }
    $stmt->execute($p);

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($result, JSON_NUMERIC_CHECK);
});

doc("wijkbewoner",
    "Chatberichten sturen",
    "POST <code>/chat</code> optioneel: <code>&from=20</code> waar from de ID is",
    '
<h4>Meegeven:</h4>
 <pre>
{
    "sender_id": 1,
    "receiver_id": 2,
    "message": "berichtje!!"
}</pre>
<small>(sender_id gaat verdwijnen als inloggen werkt)</small>

<h4>Return:</h4>
<pre>ok</pre>
');
$app->post("/chat", function(){
    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $db->beginTransaction();

    $sth = $db->prepare("INSERT INTO `chat` (`receiver_id`, `sender_id`, `message`) VALUES (?, ?, ?);");

    $input = json_decode(file_get_contents("php://input"));
    $sth->execute(array($input->receiver_id, $input->sender_id, $input->message));
    $db->commit();
    echo "ok";
});


doc(
    "wijkbewoner",
    "Facebook",
    "POST <code>/facebook</code>",
    '<h4>Meegeven:</h4>
                <pre>
{
    "district_id": "1",
    "access_token": "CAAKNJIG6TKMBAE00HOVfARdRYq4dkIZAKKLKotZB1ftBQl16Gd9WFuTbvTsIjx2PgSejeD7dqS184KqAo93Jv5PnJvGoJXRmSSF31BYM9cWmN8ZAG79RnxuPiJrUbX4BKuyx6Vgc76ScJdI37X58kjzbKk2ads2bJDsutJ3nQTd5H3P8Mq6iKicubj2GUvLcUCeHq53pa8ZBTZAfX4NrcRjtZBZA2lf3lFL9QuLgPtfzwZDZD"
}</pre>


<h4>Return:</h4>
<pre>{ "user_id": 34 }</pre>');

$app->post('/facebook', function(){
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

    $input = json_decode(file_get_contents("php://input"));


    if(isset($input->access_token)){
        $token = $input->access_token;

        $facebook->setAccessToken($token);
        $user_id = $facebook->getUser();

        $user_profile = $facebook->api('/me','GET');

        $sth = $db->prepare("INSERT INTO residents (`id`, `district_id`, `email`, `name`, `address`, `token`) VALUES (NULL, ?, ?, ?, ?, NULL);");
        $sth->execute(array($input->district_id, $user_profile["email"],  $user_profile["name"], "" ));

        $sth2 = $db->query('SELECT LAST_INSERT_ID() as last_id');
        $last_id = $sth2->fetchAll();
        $last_id = intval($last_id[0]['last_id']);

        $sth3 = $db->prepare('INSERT INTO facebook (resident_id, userid, access) VALUES(?, ?, ?);');
        $sth3->execute(array($last_id, $user_id, $token));

        echo json_encode(array("user_id" => $last_id));

    }




//
//    $db = \Helpers\DatabaseHelper::GetPDOConnection();
//    $db->beginTransaction();
//
//    $sth = $db->prepare("INSERT INTO residents (`id`, `district_id`, `email`, `name`, `address`, `token`) VALUES (NULL, ?, ?, ?, ?, NULL);");
//
//    $input = json_decode(file_get_contents("php://input"));
//    $sth->execute(array($input->district_id, $input->email, $input->name, json_encode($input->latlong)));
//    $db->commit();
//
//    $sth2 = $db->query('SELECT LAST_INSERT_ID() as last_id');
//    $last_id = $sth2->fetchAll();
//
//    $userid = intval($last_id[0]['last_id']);
//
//    echo json_encode(array("user_id" => $userid));//'{ "user_id": 34 }';
});


 