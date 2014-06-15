<?php


doc("wijkbewoner",
    "Plaatje uploaden <span class='label label-success'>Af</span>",
    "POST <code>/image?id=1&auth_token=blaat123</code>",
    '
<br><br>
<b>Test formuliertje:</b>
<form method="post" enctype="multipart/form-data" action="/image?id=1&auth_token=blaat123">
    <input type="file" name="file">
    <br>
    <button class="btn btn-primary">Opslaan</button>
</form>
');
$app->post("/image", function(){
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');


    $db = \Helpers\DatabaseHelper::GetPDOConnection();
    $stmt = $db->prepare("
        select count(`id`)
        from residents
        where id = ? and token = ?");
    $stmt->execute(array($_GET['id'], $_GET['auth_token']));
    if($stmt->fetch()[0] != 1) {
        http_response_code(403);
        die("foute access code of id");
    }

    if ($_FILES["file"]["size"] < 8589934592)
    {
        if ($_FILES["file"]["error"] > 0) {
            http_response_code(401);
        } else {
            http_response_code(201);

            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            $name = time();
//                $image = 'uploads/plaatjes/'.$name.".".$ext;//.'.mp4';
            $target = 'uploads/plaatjes/'.$name.".jpg";

            if(in_array($ext, array("jpeg", "jpg"))) {
                $source = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
            } elseif($ext == "png") {
                $source = imagecreatefrompng($_FILES["file"]["tmp_name"]);
            } elseif($ext == "gif"){
                $source = imagecreatefromgif($_FILES["file"]["tmp_name"]);
            } else {
                http_response_code(401);
                die("stuk");
            }

//                $source = $image;
            $newwidth = 400;
            $newheight = 400;
            list($width, $height) = getimagesize($_FILES["file"]["tmp_name"]);
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            imagejpeg($thumb, $target);

            $stmt = $db->prepare("
                update residents
                set plaatje = ?
                where id = ? and token = ?");
            $stmt->execute(array("http://glas.mycel.nl/".$target, $_GET['id'], $_GET['auth_token']));
            echo "http://glas.mycel.nl/".$target;
        }
    }
    else
    {
        http_response_code(400);
    }
});
