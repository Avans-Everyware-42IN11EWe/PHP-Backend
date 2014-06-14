<?php
doc(
    "wijk",
    "Wijk ID's <span class='label label-success'>Af</span>",
    "GET <code>/district_ids</code>",
    "<h4>Return:</h4>
    <pre>[1, 2, 3]</pre>");

$app->get('/district_ids', function() {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');


    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("select `id` from districts");

    $stmt->execute(array());
    $result =  $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($result, JSON_NUMERIC_CHECK);

});