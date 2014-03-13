<?php

$app->get('/geo', function () {
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

    /**
     * Krijg de rand om de kaart
     * http://postgis.net/docs/RT_ST_ConvexHull.html
     */
    $sth = $db->prepare('
    select
        ST_AsGeoJson(
            ST_ConvexHull(
                ST_Collect(geo)
            )
        )
    from postcode
    where pnum = ?;');
    $sth->execute(array($_GET['code']));

    print_r($sth->fetchColumn(0));
    $convexhull = json_decode($sth->fetchColumn(0))->coordinates[0];

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
    where pnum = ?;');
    $sth->execute(array($_GET['code']));

    $centroid = json_decode($sth->fetchColumn(0))->coordinates;

    /**
     * Krijg alle postcode coordinaten
     */
    $sth = $db->prepare('
    select
        ST_AsGeoJson(
            ST_Collect(geo)
        )
    from postcode
    where pnum = ?;');
    $sth->execute(array($_GET['code']));

    $points = json_decode($sth->fetchColumn(0))->coordinates[0];

    echo json_encode(
        array(
            "convexhull" => $convexhull,
            "points" => $points,
            "centroid" => $centroid
        )
    );
});
