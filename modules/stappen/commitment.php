<?php

// POST routes
doc(
    "stappen",
    "Commitment <span class='label label-success'>(half) Af</span>",
    "POST <code>/commitment?id=1&auth_token=blaat123</code>",
    '
<h4>Return:</h4>
<pre>\'ok\'</pre>');
// Register
$app->post('/commitment', function() {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        UPDATE residents
        SET `status` = 3
        where id = ? and token = ? and `status` = 1");

    $stmt->execute(array($_GET['id'], $_GET['auth_token']));
    echo "'ok'";

});
