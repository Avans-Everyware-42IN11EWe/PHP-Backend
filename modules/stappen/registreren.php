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
    "district_id": 3,
    "is_buddy": true
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


    $sth = $db->prepare("INSERT INTO residents (`id`, `district_id`, `email`, `token`, `is_buddy`) VALUES (NULL, ?, ?, ?, ?);");

    $input = json_decode(file_get_contents("php://input"));

    $is_buddy = 0;

    if(is_string($input->is_buddy) && $input->is_buddy == "true") {
        $is_buddy = 1;
    }
    if(is_int($input->is_buddy) && $input->is_buddy == 1) {
        $is_buddy = 1;
    }
    if(is_bool($input->is_buddy) && $input->is_buddy) {
        $is_buddy = 1;
    }
    $sth->execute(array($input->district_id, $input->email, $random, $is_buddy));
    $db->commit();

    $sth2 = $db->query('SELECT LAST_INSERT_ID() as last_id');
    $last_id = $sth2->fetchAll();

    $userid = intval($last_id[0]['last_id']);

    echo json_encode(array("user_id" => $userid, "user_token" => $random, "auth_token" => $random));//'{ "user_id": 34 }';
});
