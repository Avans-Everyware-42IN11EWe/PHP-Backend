<?php

doc(
    "wijkbewoner",
    "Profiel bekijken <span class='label label-success'>Af</span>",
    "GET <code>/buddy?id=2</code>",
    '
    <pre>
    {
        "naam": "Henk de Vries",
        "leeftijd": 31,
        "woonplaats": "Amsterdam",
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
          r.name AS naam,
          b.leeftijd AS leeftijd,
          b.telefoon AS telefoon,
          d.place AS woonplaats,
          b.email AS email,
          r.plaatje as plaatje,
          b.video AS video
        FROM residents r
        JOIN buddy b ON r.id = b.resident_id
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