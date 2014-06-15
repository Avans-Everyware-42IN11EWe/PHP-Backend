<?php

doc(
    "wijkbewoner",
    "Profiel aanpassen <span class='label label-success'>Af</span>",
    "POST <code>/profile?user_id=1&auth_token=blaat123</code>",
    '
    meegeven:
    <pre>
    {
        "naam": "Henk de Vries",
        "leeftijd": 31,
        "adres": "Hoofdstraat 2",
        "telefoon": "06-57107007",
        "email": "peter.buddy@gmail.com",
        "is_buddy": false
    }
    </pre>
    ');
$app->post('/profile', function () {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $input = json_decode(file_get_contents("php://input"));

    $db = \Helpers\DatabaseHelper::GetPDOConnection();

    $stmt = $db->prepare("
        update residents
        set email = ?, `name` = ?, `address` = ?, `is_buddy` = ?
        where id = ? and token = ?");

    $is_buddy = false;
    if(is_string($input->is_buddy) && $input->is_buddy == "true") {
        $is_buddy = true;
    }
    if(is_int($input->is_buddy) && $input->is_buddy == 1) {
        $is_buddy = true;
    }
    if(is_bool($input->is_buddy) && $input->is_buddy) {
        $is_buddy = true;
    }

    if($stmt->execute(array($input->email, $input->naam, $input->adres, $is_buddy ? 1 : 0, $_GET['user_id'], $_GET['auth_token']))) {
        $stmt = $db->prepare("
        INSERT INTO buddy (resident_id, leeftijd, telefoon) VALUES (?, ?, ?)
          ON DUPLICATE KEY UPDATE leeftijd = ?, telefoon = ?;");

        if($stmt->execute(array($_GET['user_id'], $input->leeftijd, $input->telefoon, $input->leeftijd, $input->telefoon))) echo "ok";
    }
});