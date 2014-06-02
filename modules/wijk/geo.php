<?php
doc(
    "wijk",
    "GEO <span class='label label-success'>Af</span>",
    "GET <code>/geo?id=2</code>",
    '<h4>Return:</h4>
    <pre>
{"percentage":"0.00","center":[5.3078641627167,51.697292324137],"bound":[[5.3101337250289,51.696483780955],[5.3056438692415,51.697965480639],[5.3078148938797,51.697427710818],[5.3101337250289,51.696483780955]]}</pre>');
$app->get('/geo', function() {
    global $app;
    // only create here, so that the rest of the application will not notice.
    \Helpers\DatabaseHelper::CreateGISConnection("mycel.nl", "school", "welkom", "glasaanhuis");

    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $geo = \Helpers\DatabaseHelper::GetGISConnection();

    $sth = $db->prepare("select round((select count(id) from residents where district_id = districts.id) / goal, 2) as percentage from districts where id = ?");
    $sth->execute(array($_GET["id"]));
    $wijk = $sth->fetch();

    $sth = $db->prepare("select postcode from district_postcodes where district_id = ?");
    $sth->execute(array($_GET["id"]));
    $postcodes = array_values($sth->fetchAll(PDO::FETCH_COLUMN, 0));
    $postcodes = array_map(function($a) { return "'" . $a . "'"; }, $postcodes);


    /**
     * Exporteren naar JSON:
     * http://postgis.org/docs/ST_AsGeoJSON.html
     *
     * Samenvoegen van coordinaten (net zoiets als COUNT, SUM, ...)
     * http://postgis.org/docs/ST_Collect.html
     */
//    $postcodes = ["'5211AA'", "'5212AB'", "'5213AC'", "'5222AD'", "'5223AD'"];

    $wijken = [];
    /**
     * Krijg de rand om de kaart
     * http://postgis.net/docs/RT_ST_ConvexHull.html
     */
    $sth = $geo->prepare("
    WITH searching_codes AS (
            VALUES (".join('), (', $postcodes).")
        )
    select
        ST_AsGeoJson(
            ST_ConcaveHull(ST_Collect(geo), 0.99)
        ) as geo,
        ST_AsGeoJson(ST_Centroid(
            ST_Collect(geo)
        )) as center
    from postcode p
    join searching_codes s on p.postcode = s.column1;");
//
//    echo "
//    WITH searching_codes AS (
//            VALUES (".join('), (', $postcodes).")
//        )
//    select
//        ST_AsGeoJson(
//            ST_ConcaveHull(ST_Collect(geo), 0.99)
//        ) as geo,
//        ST_AsGeoJson(ST_Centroid(
//            ST_Collect(geo)
//        )) as center
//    from postcode p
//    join searching_codes s on p.postcode = s.column1;";

    $sth->execute(array());

    $result = $sth->fetch();
    if(isset($result["geo"])){
        $wijken = [
            "percentage" => $wijk["percentage"],
            "center" => json_decode($result["center"])->coordinates,
            "bound" => json_decode($result["geo"])->coordinates[0]
        ];
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
    where postcode in ('.join(',', $postcodes).');');
    $sth->execute(array());

//    $centroid = json_decode($sth->fetchColumn(0))->coordinates;


    echo json_encode(
        $wijken, JSON_NUMERIC_CHECK
    );
});
