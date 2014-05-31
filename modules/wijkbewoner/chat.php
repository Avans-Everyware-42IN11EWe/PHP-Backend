<?php

doc("wijkbewoner",
    "Chatberichten ophalen <span class='label label-success'>Af</span>",
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
    "Chatberichten sturen <span class='label label-success'>Af</span>",
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
