<?php
$app->get("/admin/wijken", function(){
    global $twig;

    echo $twig->render('wijken.html');
});

$app->get('/geowijk', function () {
    global $app;
    \Helpers\DatabaseHelper::CreateGISConnection("mycel.nl", "school", "welkom", "glasaanhuis");
    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetGISConnection();

    $sth = $db->prepare("
        select
            ST_AsGeoJson(ST_Centroid(
                ST_Collect(geo)
            )) as geo,
            pnum as postcode
        from postcode group by pnum
        ");
    $sth->execute(array());
    echo json_encode(array_map(function($bla){
        $arr = array_reverse(json_decode($bla->geo)->coordinates);
        array_push($arr, "$bla->postcode");
        return $arr;
    }, $sth->fetchAll(PDO::FETCH_OBJ)));
//    echo json_encode($sth->fetchAll(PDO::FETCH_OBJ));
//
//
//    /**
//     * Krijg het middenpunt
//     * http://postgis.org/docs/ST_Centroid.html
//     */
//    $sth = $db->prepare('
//    select
//        ST_AsGeoJson(
//            ST_Centroid(
//                ST_Collect(geo)
//            )
//        )
//    from postcode
//    where pnum in ('.join(',', $postcodes).');');
//    $sth->execute(array());
//
//    $centroid = json_decode($sth->fetchColumn(0))->coordinates;
//
//
//    echo json_encode(
//        array(
//            "wijken" => $wijken,
//            "centroid" => $centroid
//        )
//    );
});