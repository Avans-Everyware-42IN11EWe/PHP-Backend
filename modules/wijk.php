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

    $stmt = $db->query("select `id`, `name`, `status`, FLOOR(RAND()*100)/CEIL(RAND()*20) as distance, FLOOR(RAND()*100)/100 as percentage from districts");

    echo json_encode($stmt->fetchAll(PDO::FETCH_OBJ), JSON_NUMERIC_CHECK);
});

ob_start();
?>
    {
    "id": 1,
    "name": "Den Bosch Wallen",
    "status": "action",
    "percentage": 0.5,
    "participants": 50,
    "plaatjes": [
    {
    'id': 1,
    'plaatje': 'http://glas.mycel.nl/uploads/plaatjes/132.png'
    },
    {
    'id': 2,
    'plaatje': 'http://graph.facebook.com/100000644333726/picture'
    }
    ]
    }
<?php

$blaat = ob_get_contents();
ob_end_clean();
doc(
    "wijk",
    "Wijkinformatie <span class='label label-success'>Af</span>",
    "GET <code>/district?id=1</code>",
    "<h4>Return:</h4>
    <pre>".$blaat."</pre>");

$app->get('/district', function() {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');


    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        select
            `id`,
            `name`,
            `status`,
            (select count(id) from residents where district_id = districts.id) / goal as percentage,
            (select count(id) from residents where district_id = districts.id) as participants
        from districts
        where id = ?");

    $stmt->execute(array($_GET["id"]));
    $result =  $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $db->prepare("
        select r.id, r.plaatje
        from residents r
        where district_id = ? and NOT EXISTS (select * from facebook f where r.id = f.resident_id) and plaatje is not null

        union all

        select resident_id, concat('http://graph.facebook.com/', userid, '/picture') from facebook

        ");
    $stmt->execute(array($_GET["id"]));

    $result->plaatjes = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($result, JSON_NUMERIC_CHECK);

});

doc(
    "wijk",
    "GEO <span class='label label-warning'>Nep</span>",
    "GET <code>/geo?district=1</code>",
    "<h4>Return:</h4>
    <pre>komt nog</pre>");
$app->get('/geo', function() {
    global $app;
    \Helpers\DatabaseHelper::CreateGISConnection("mycel.nl", "school", "welkom", "glasaanhuis");

    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetGISConnection();

    /**
     * Exporteren naar JSON:
     * http://postgis.org/docs/ST_AsGeoJSON.html
     *
     * Samenvoegen van coordinaten (net zoiets als COUNT, SUM, ...)
     * http://postgis.org/docs/ST_Collect.html
     */

    //
    $postcodes = [5211, 5212, 5213, 5222, 5223];//$_GET['code']
//    $postcodes = [5402, 5403,5404];

    $wijken = [];
    /**
     * Krijg de rand om de kaart
     * http://postgis.net/docs/RT_ST_ConvexHull.html
     */
    foreach($postcodes as $code){
        $sth = $db->prepare("
        select
            ST_AsGeoJson(
                ST_ConcaveHull(ST_Collect(geo), 0.99)
            ) as geo,
            ST_AsGeoJson(ST_Centroid(
                ST_Collect(geo)
            )) as center
        from postcode
        where pnum = ?;");
        $sth->execute(array($code));

        $result = $sth->fetch();
        if(isset($result["geo"])){
            $wijken[] = [
                "code" => $code,
                "percentage" => rand(0, 100),
                "center" => json_decode($result["center"])->coordinates,
                "bound" => json_decode($result["geo"])->coordinates[0]
            ];
        }

    }

    /**
     * Krijg het middenpunt
     * http://postgis.org/docs/ST_Centroid.html
     */
    $sth = $db->prepare('
    select
        ST_AsGeoJson(
            ST_Centroid(
                ST_Collect(geo)
            )
        )
    from postcode
    where pnum in ('.join(',', $postcodes).');');
    $sth->execute(array());

    $centroid = json_decode($sth->fetchColumn(0))->coordinates;


    echo json_encode(
        array(
            "wijken" => $wijken,
            "centroid" => $centroid
        )
    );
});

doc(
    "wijk",
    "Video's <span class='label label-danger'>Niet</span>",
    "GET <code>/videos?district=1</code>",
    "<h4>Return:</h4>
    <pre>
[
    {
        'id': 123455,
        'url': 'http://glas.mycel.nl/uploads/videos/123455.mp4',
        'thumb_url': 'http://glas.mycel.nl/uploads/videos/123455.mp4.jpg'
    },
    {
        'id': 123456,
        'url': 'http://glas.mycel.nl/uploads/videos/123456.mp4',
        'thumb_url': 'http://glas.mycel.nl/uploads/videos/123456.mp4.jpg'
    }
]</pre>");
$app->get("/videos", function(){
    ?>
[
    {
    'id': 123455,
    'url': "http://glas.mycel.nl/uploads/videos/123455.mp4",
    'thumb_url': "http://glas.mycel.nl/uploads/videos/123455.mp4.jpg"
    },
    {
    'id': 123456,
    'url': "http://glas.mycel.nl/uploads/videos/123456.mp4",
    'thumb_url': "http://glas.mycel.nl/uploads/videos/123456.mp4.jpg"
    }
]
<?php
});
/*
doc(
    "wijk",
    "De foto's van wijkbewoners",
    "GET <code>/plaatjes?district=1</code>",
    "<h4>Return:</h4>
    <pre>
[
    {
        \"resident_id\": 1,
        \"facebook\": '100000644333726'
    },
    {
        \"resident_id\": 2,
        \"facebook\": '100002085564993'
    }
]</pre>");
$app->get("/plaatjes", function(){
    ?>
[
    {
    'resident_id': 1,
    'facebook': '100000644333726'
    },
    {
    'resident_id': 2,
    'facebook': '100002085564993'
    }
]
<?php
});*/