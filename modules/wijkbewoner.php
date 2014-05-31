<?php



//// Login
//doc(
//    "wijkbewoner",
//    "Inloggen <span class='label label-success'>Af</span>",
//    "GET <code>/login?user_id=34</code>",
//    '                <h4>Situatie 1:</h4>
//                <b>Gebruiker heeft e-mail verificatie gedaan</b>
//                <pre>{ "token": "blaat123" }</pre>
//
//                <h4>Situatie 2:</h4>
//                <b>Gebruiker moet e-mail verificatie nog doen</b>
//                <pre>fail</pre>');
//$app->post('/login', function () {
//    global $app;
//    $app->response->headers->set('Content-Type', 'application/json');
//
//    echo '{ "token": "blaat123" }';
//    return;
//
//
//    //    $length = 10;
//    //$token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
//
//
//    $jObj = json_decode($_POST["json"]);
//    if(isset($jObj->token))
//    {
//        Managers\UserManager::Login($jObj->token);
//    }
//    else
//        json_encode(array("response" => "err", "message" => "Missing post data"));
//});







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


 