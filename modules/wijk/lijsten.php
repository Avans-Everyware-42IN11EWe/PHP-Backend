<?php

doc(
    "wijk",
    "Wijk zoeken <span class='label label-success'>Af</span>",
    "GET <code>/districts?search=5211AA</code>",
    "<h4>Return:</h4>
     <pre>
[
    { 'id': 1, 'name': 'Wallen', 'status': 'action', 'distance': 0, 'percentage': 0.5 },
    { 'id': 2, 'name': 'Centrum', 'status': 'unknown', 'distance': 2.123, 'percentage': 0.4 },
    { 'id': 3, 'name': 'West', 'status': 'infrastructural_possible', 'distance': 3.55, 'percentage': 0.2 }
]</pre>
    Mogelijke wijkstatussen:
        <code>unknown</code>,
        <code>infrastructural_impossible</code>,
        <code>infrastructural_possible</code>,
        <code>action</code>,
        <code>commited</code>,
        <code>success</code>
"
);
doc(
    "wijk",
    "Wijken in de buurt <span class='label label-warning'>Nep</span>",
    "GET <code>/districts?lat=51.983333&long=5.916667</code>",
    "                <h4>Return:</h4>
                <pre>
[
    { 'id': 1, 'name': 'Den Bosch Spijkerkwartier', 'status': 'action', 'distance': 0, 'percentage': 0.5 },
    { 'id': 2, 'name': 'Den Bosch Centrum', 'status': 'unknown', 'distance': 2.123, 'percentage': 0.4 },
    { 'id': 3, 'name': 'Den Bosch West', 'status': 'infrastructural_possible', 'distance': 3.55, 'percentage': 0.2 }
]</pre>
    Mogelijke wijkstatussen:
        <code>unknown</code>,
        <code>infrastructural_impossible</code>,
        <code>infrastructural_possible</code>,
        <code>action</code>,
        <code>commited</code>,
        <code>success</code>
"
);
$app->get("/districts", function(){
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $arr = array("5211", "5212", "5213", "5222", "5223");
    $bool = false;

    if(isset($_GET["lat"], $_GET["long"])) {
        $bool = true;
    }

    foreach($arr as $el ){
        if(isset($_GET["search"])) {
            $bool = $bool || (strpos($_GET["search"], $el) !== FALSE);
        }
    }
    if(!$bool) {
        echo "[]";
        die();
    }

    $db = \Helpers\DatabaseHelper::GetPDOConnection();

    $stmt = $db->query("select `id`, `name`, `status`, `image` as `plaatje`, FLOOR(RAND()*100)/CEIL(RAND()*20) as distance, FLOOR(RAND()*100)/100 as percentage from districts");

    echo json_encode($stmt->fetchAll(PDO::FETCH_OBJ), JSON_NUMERIC_CHECK);
});
