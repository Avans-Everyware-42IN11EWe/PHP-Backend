<?php



doc(
    "wijkbewoner",
    "Facebook <span class='label label-success'>Af</span>",
    "POST <code>/facebook</code>",
    '<h4>Meegeven:</h4>
                <pre>
{
    "district_id": "1",
    "access_token": "CAAKNJIG6TKMBAE00HOVfARdRYq4dkIZAKKLKotZB1ftBQl16Gd9WFuTbvTsIjx2PgSejeD7dqS184KqAo93Jv5PnJvGoJXRmSSF31BYM9cWmN8ZAG79RnxuPiJrUbX4BKuyx6Vgc76ScJdI37X58kjzbKk2ads2bJDsutJ3nQTd5H3P8Mq6iKicubj2GUvLcUCeHq53pa8ZBTZAfX4NrcRjtZBZA2lf3lFL9QuLgPtfzwZDZD"
}</pre>


<h4>Return:</h4>
<pre>{ "user_id": 34, "auth_token": "blaat123" }</pre>');
$app->post('/facebook', function(){
    global $app, $fbid, $fbsecret;
    $db = \Helpers\DatabaseHelper::GetPDOConnection();

    $app->response->headers->set('Content-Type', 'application/json');

    $config = array(
        'appId' => $fbid,
        'secret' => $fbsecret,
        'fileUpload' => false, // optional
        'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
    );

    $facebook = new Facebook($config);

    $input = json_decode(file_get_contents("php://input"));


    if(isset($input->access_token)){
        $token = $input->access_token;

        $facebook->setAccessToken($token);
        $user_id = $facebook->getUser();

        $user_profile = $facebook->api('/me','GET');

        $random = md5(rand());

        $sth = $db->prepare("INSERT INTO residents (`id`, `district_id`, `email`, `name`, `address`, `token`) VALUES (NULL, ?, ?, ?, ?, ?);");
        $sth->execute(array($input->district_id, $user_profile["email"],  $user_profile["name"], $random));

        $sth2 = $db->query('SELECT LAST_INSERT_ID() as last_id');
        $last_id = $sth2->fetchAll();
        $last_id = intval($last_id[0]['last_id']);

        $sth3 = $db->prepare('INSERT INTO facebook (resident_id, userid, access) VALUES(?, ?, ?);');
        $sth3->execute(array($last_id, $user_id, $token));

        echo json_encode(array("user_id" => $last_id, "user_token" => $random));



    }
});