<?php


// POST routes
doc(
    "stappen",
    "Registeren <span class='label label-success'>Af</span>",
    "POST <code>/register</code>",
    '<h4>Meegeven:</h4>
 <pre>
{
    "email": "bill@microsoft.com",
    "district_id": 3
}</pre>

<p class="bg-info">district_id staat voor wijknummer</p>

<h4>Return:</h4>
<pre>{ "user_id": 34, "auth_token": "blaat123" }</pre>');
// Register
$app->post('/register', function() {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $db->beginTransaction();

    $random = md5(rand());

    $sth = $db->prepare("INSERT INTO residents (`id`, `district_id`, `email`, `token`) VALUES (NULL, ?, ?, ?);");

    $input = json_decode(file_get_contents("php://input"));
    $sth->execute(array($input->district_id, $input->email, $random));
    $db->commit();

    $sth2 = $db->query('SELECT LAST_INSERT_ID() as last_id');
    $last_id = $sth2->fetchAll();

    $userid = intval($last_id[0]['last_id']);

    echo json_encode(array("user_id" => $userid, "user_token" => $random, "auth_token" => $random));//'{ "user_id": 34 }';
});
