<?php

doc(
"stappen",
"Progress <span class='label label-success'>Af</span>",
"GET <code>/progress?id=1&auth_token=blaat123</code>",
'
<pre>
{ "status": 1 }
</pre>

<h3>Mogelijke statussen:</h3>
<table class="table">
<thead>
<tr>
    <th>Id</th>
    <th>Naam</th>
</tr>
</thead>
<tbody>
<tr>
    <td>1</td>
    <td>Heeft account</td>
</tr>
<tr>
    <td>2</td>
    <td>Geen deelnemer</td>
</tr>
<tr>
    <td>3</td>
    <td>Wel deelnemer</td>
</tr>
<tr>
    <td>4</td>
    <td>Provider gekozen</td>
</tr>
</tbody>
</table>

<img src="/static/img/Wijkbewoner_1.2.jpg">
');
$app->get('/progress', function () {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');


    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        select
            `status`
        from residents
        where id = ? and token = ?");



    $stmt->execute(array($_GET['id'], $_GET['auth_token']));
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK);
//    echo '{ "status": 1 }';
});