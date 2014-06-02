<?php
ob_start();
?>
{
    "id": 1,
    "name": "Den Bosch Wallen",
    "status": "action",
    "facebookpageid": 1450066045229608,
    "facebookpageurl": "https://www.facebook.com/glasvezelpaleiskwartier",
    "percentage": 0.5,
    "plaatje": "http://static.panoramio.com/photos/large/47740046.jpg",
    "video":"http:\/\/glas.mycel.nl\/uploads\/videos\/VID_20140422_131531.mp4",
    "participants": 50,
    "plaatjes": [
        {
        'id': 1,
        'plaatje': 'http://glas.mycel.nl/uploads/plaatjes/132.png',
        'is_buddy': 0,
        'has_video': 1
        },
        {
        'id': 2,
        'plaatje': 'http://graph.facebook.com/100000644333726/picture',
        'is_buddy': 0,
        'has_video': 1
        }
    ],
    "stappen":[
        {"naam":"Bewoners verzamelen","percentage":0.5},
        {"naam":"Inschrijven","percentage":0.2},
        {"naam":"Provider selecteren","percentage":0},
        {"naam":"Glasvezel aanleggen","percentage":0},
        {"naam":"Overstappen naar glasvezel","percentage":0}
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
            `facebookpageid`,
            `facebookpageurl`,
            `image` as `plaatje`,

            round((select count(id) from residents where district_id = districts.id) / goal, 2) as percentage,
            (select count(id) from residents where district_id = districts.id) as participants
        from districts
        where id = ?");

    $stmt->execute(array($_GET["id"]));
    $result =  $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $db->prepare("
        select r.id, r.plaatje, r.is_buddy, r.video is not null as has_video
        from residents r
        where district_id = ? and NOT EXISTS (select * from facebook f where r.id = f.resident_id) and plaatje is not null
        and plaatje != ''

        union all

        select
          r.id,
          concat('http://graph.facebook.com/', userid, '/picture'),
          r.is_buddy, r.video is not null as has_video
        from facebook f join residents r on f.resident_id = r.id

        ");
    $stmt->execute(array($_GET["id"]));

    $result->plaatjes = $stmt->fetchAll(PDO::FETCH_OBJ);
    $result->faq = array("vragen", "BLAAT");
    $result->goededoel = array("doel" => "kerk bouwen", "percentage" => rand(0, 80)/100);
//    $result->plaatje = "http://static.panoramio.com/photos/large/47740046.jpg";
    $result->video = "http://glas.mycel.nl/uploads/videos/sample_mpeg4.mp4";

    $p1 = min($result->percentage, 1);
    $p2 = min(rand(0, $p1*100)/100, 1);
    $p3 = min(rand(0, $p2*100)/100, 1);
    $p4 = min(rand(0, $p3*100)/100, 1);
    $p5 = min(rand(0, $p4*100)/100, 1);

    $result->stappen = array(
        array("naam" => "Bewoners verzamelen", "percentage" => $p1),
        array("naam" => "Inschrijven", "percentage" => $p2),
        array("naam" => "Provider selecteren", "percentage" => $p3),
        array("naam" => "Glasvezel aanleggen", "percentage" => $p4),
        array("naam" => "Overstappen naar glasvezel", "percentage" => $p5));
    echo json_encode($result, JSON_NUMERIC_CHECK);

});