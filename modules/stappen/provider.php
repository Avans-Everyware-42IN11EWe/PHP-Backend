<?php


doc(
    "stappen",
    "Provider lijst <span class='label label-success'>Af</span>",
    "GET <code>/providers?district=1</code> of GET <code>/providers?user_id=1</code>",
    '<h4>Return:</h4>
    <pre>
[
    {"id": 1, "name": "UPC", "voters": 2},
    {"id": 2, "name": "Chello", "voters": 2}
]</pre>');
$app->get("/providers", function(){
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $d = 0;
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
    $stmt = $db->prepare("SELECT dp.id, name, (select count(*) from residents r where r.chozen_provider = dp.id and r.district_id = dp.district_id) as voters FROM district_providers dp JOIN providers p ON p.id = dp.provider_id WHERE dp.district_id = ?");

    $stmt->execute(array($d));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($result, JSON_NUMERIC_CHECK);
});

doc(
    "stappen",
    "Provider kiezen <span class='label label-success'>Af</span>",
    "POST <code>/providers?user_id=1&auth_token=blaat123&provider_id=1</code>",
    '<h4>Return:</h4>
    <pre>ok</pre>');
$app->POST("/providers", function(){
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        UPDATE residents
        SET `status` = 4, chozen_provider = ?
        where id = ? and token = ? and (`status` = 3)");

    $stmt->execute(array($_GET['provider_id'], $_GET['user_id'], $_GET['auth_token']));

    echo '[
    {"id": 1, "name": "UPC", "voters": 2},
    {"id": 2, "name": "Chello", "voters": 2}
]';
});

