<?php

doc(
    "wijkbewoner",
    "Profiel bekijken <span class='label label-success'>Af</span>",
    "GET <code>/buddy?id=2</code>",
    '
    <small>geen null waardes omdat leroy zat te janken</small>
    <pre>
    {
        "naam": "Henk de Vries",
        "leeftijd": 31,
        "woonplaats": "Amsterdam",
        "adres": "Hoofdstraat 2",
        "telefoon": "06-57107007",
        "email": "peter.buddy@gmail.com",
        "plaatje": "http://glas.mycel.nl/uploads/plaatjes/1402650319.png",
        "video": "http://glas.mycel.nl/uploads/videos/sample_mpeg4.mp4"
    }
    </pre>
    ');
$app->get('/buddy', function () {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        SELECT
          IFNULL(r.name, '') AS naam,
          IFNULL(b.leeftijd, '') AS leeftijd,
          IFNULL(b.telefoon, '') AS telefoon,
          IFNULL(r.address, '') AS adres,
          IFNULL(d.place, '') AS woonplaats,
          IFNULL(r.email, '') AS email,
          if(r.is_buddy=1, 'true', 'false') as is_buddy,
          IF(r.plaatje != '', r.plaatje, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c47.0.160.160/p160x160/252231_1002029915278_1941483569_n.jpg') as plaatje,
          IFNULL(r.video, '') AS video
        FROM residents r
        LEFT JOIN buddy b ON r.id = b.resident_id
        JOIN districts d on r.district_id = d.id
        WHERE r.id = ?");
    $stmt->execute(array($_GET['id']));

    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
//    echo '{
//        "naam": "Henk de Vries",
//        "leeftijd": 31,
//        "woonplaats": "Aawijk",
//        "telefoon": "06-57107007",
//        "email": "peter.buddy@gmail.com",
//        "video": "http://glas.mycel.nl/uploads/videos/sample_mpeg4.mp4"
//    }';
});