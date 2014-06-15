<?php


doc(
    "stappen",
    "Provider lijst <span class='label label-success'>Af</span>",
    "GET <code>/providers?district=1</code> of GET <code>/providers?user_id=1</code>",
    '

<h4>Return:</h4>
    <pre>
[
    {"id": 1, "name": "UPC", "score": 2},
    {"id": 2, "name": "Chello", "score": 2}
]</pre>');
$app->get("/providers", function(){
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    if(!isset($_GET['district']) && isset($_GET['user_id'])) {
        $db = \Helpers\DatabaseHelper::GetPDOConnection();
        $stmt = $db->prepare("
        select
            `district_id`
        from residents
        where id = ?");

        $stmt->execute(array($_GET['user_id']));
        $d = $stmt->fetch(PDO::FETCH_COLUMN);
    } else {
        $d = $_GET['district'];
    }

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        SELECT
            dp.id,
            `name`,
            (select sum(`order`)/count(*) from resident_provider r where r.provider_id = dp.id) as score
        FROM district_providers dp
        JOIN providers p ON p.id = dp.provider_id
        WHERE dp.district_id = ?");

    $stmt->execute(array($d));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($result, JSON_NUMERIC_CHECK);
});

doc(
    "stappen",
    "Provider kiezen <span class='label label-success'>Af</span> 2.0",
    "POST <code>/providers?user_id=1&auth_token=blaat123</code>",
    '
<h4>Meegeven:</h4>
<pre>[1, 2]</pre>

<h4>Return:</h4>
<pre>ok</pre>');
$app->POST("/providers", function(){
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        UPDATE residents
        SET `status` = 4
        where id = ? and token = ? and (`status` = 3)");

    if(!$stmt->execute(array($_GET['user_id'], $_GET['auth_token']))) echo "stuk";

    $stmt = $db->prepare("
        INSERT INTO resident_provider
        VALUES (?, ?, ?)
        ");

    $input = json_decode(file_get_contents("php://input"));

    $i = 1;
    foreach($input as $a) {
        $stmt->execute(array($_GET['user_id'], $a, $i++));
    }

    echo 'ok';
});

