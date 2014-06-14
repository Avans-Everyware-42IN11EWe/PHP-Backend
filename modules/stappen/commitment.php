<?php

// POST routes
doc(
    "stappen",
    "Commitment <span class='label label-success'>Af</span>",
    "POST <code>/commitment?id=1&auth_token=blaat123</code>",
    "
Meegeven:
<pre>
{
 'naam': 'Henk de Vries',
 'adres': 'Maarten Jansz Kosterstraat 18'
}
</pre>

<h4>Return:</h4>
<pre>ok</pre>");
// Register
$app->post('/commitment', function() {
    global $app;
//    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        UPDATE residents
        SET `status` = 3, `name` = ?, `address` = ?
        where id = ? and token = ? and (`status` = 1 or `status` = 2)");

    $input = json_decode(file_get_contents("php://input"));
    $stmt->execute(array($input->naam, $input->adres, $_GET['id'], $_GET['auth_token']));


    echo "ok";

});
