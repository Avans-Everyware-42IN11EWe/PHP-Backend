<?php

$app->get("/admin/graph.json", function(){
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();

    $stmt = $db->query("select id, name,
	(select count(id) from residents where district_id = districts.id) as participants
    from districts
    ORDER BY participants DESC
    LIMIT 10");

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    $print = array();
    foreach($result as $blaat) {
        $stmt = $db->prepare("
 SELECT UNIX_TIMESTAMP(DATE), IFNULL((SELECT count(x.id)             FROM residents x            WHERE x.district_id = r.district_id AND DATE(x.created_at) <= DATE ),0) AS sum FROM ( SELECT date_add('2003-01-01 00:00:00.000', INTERVAL n5.num*10000+n4.num*1000+n3.num*100+n2.num*10+n1.num DAY ) AS DATE FROM (SELECT 0 AS num    UNION ALL SELECT 1    UNION ALL SELECT 2    UNION ALL SELECT 3    UNION ALL SELECT 4    UNION ALL SELECT 5    UNION ALL SELECT 6    UNION ALL SELECT 7    UNION ALL SELECT 8    UNION ALL SELECT 9) n1, (SELECT 0 AS num    UNION ALL SELECT 1    UNION ALL SELECT 2    UNION ALL SELECT 3    UNION ALL SELECT 4    UNION ALL SELECT 5    UNION ALL SELECT 6    UNION ALL SELECT 7    UNION ALL SELECT 8    UNION ALL SELECT 9) n2, (SELECT 0 AS num    UNION ALL SELECT 1    UNION ALL SELECT 2    UNION ALL SELECT 3    UNION ALL SELECT 4    UNION ALL SELECT 5    UNION ALL SELECT 6    UNION ALL SELECT 7    UNION ALL SELECT 8    UNION ALL SELECT 9) n3, (SELECT 0 AS num    UNION ALL SELECT 1    UNION ALL SELECT 2    UNION ALL SELECT 3    UNION ALL SELECT 4    UNION ALL SELECT 5    UNION ALL SELECT 6    UNION ALL SELECT 7    UNION ALL SELECT 8    UNION ALL SELECT 9) n4, (SELECT 0 AS num    UNION ALL SELECT 1    UNION ALL SELECT 2    UNION ALL SELECT 3    UNION ALL SELECT 4    UNION ALL SELECT 5    UNION ALL SELECT 6    UNION ALL SELECT 7    UNION ALL SELECT 8    UNION ALL SELECT 9) n5 ) a  LEFT OUTER JOIN residents r ON r.district_id = ?  WHERE DATE > NOW() - INTERVAL 1 MONTH AND DATE < NOW()  GROUP BY DATE");
        $stmt->execute(array($blaat->id));

        $nieuw = $stmt->fetchAll(PDO::FETCH_NUM);
        array_push($print, array("key"=>$blaat->name, "values" => $nieuw));

    }
    echo json_encode($print, JSON_NUMERIC_CHECK);

//    echo json_encode($stmt->fetchAll(PDO::FETCH_OBJ), JSON_NUMERIC_CHECK);

});

$app->get("/admin", function(){
    echo file_get_contents("views/template.html");
});