<?php

/**
 * bewaren voor beheerinterface!!!
 */
$app->get('/geo.html', function(){
   ?>
    <!DOCTYPE html><html><head><title></title><link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"><script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script><script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script><script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js"></script><script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.1/mapbox.js'></script><link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.1/mapbox.css' rel='stylesheet' /><style>body { margin:0; padding:0; }#map { position:absolute; top:0; bottom:0; width:100%; }</style><script>
            $(function() {
                var map = L.mapbox.map('map', 'nanne.i84f0he3');
                $.get('/geo', function(data){map.setView(data.centroid.reverse(), 14);
                    for (var i = 0; i < data.wijken.length; i++) {
                        var wijk = data.wijken[i];var p = wijk.percentage;
                        var red = Math.ceil((100 - Math.max(50, p)) * (255/50));
                        var green = Math.ceil(Math.min(50, p) * (255/50));

                        L.marker(wijk.center.reverse()).addTo(map)
                            .bindPopup(wijk.code + "")
                            .openPopup();

                        var polygon = L.polygon(_.map(wijk.bound, function(a) { return a.reverse(); })).addTo(map);
                        polygon.setStyle({color: "black",weight: 3,fillColor: "rgb("+red+","+green+",0)",fillOpacity: 0.7});
                    }
                });
            });

        </script>
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />

    </head><body><div id="container"><div id="map"></div></div></body></html>
   <?php
});

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
