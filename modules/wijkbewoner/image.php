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
            if (file_exists("uploads/plaatjes/" . $_FILES["file"]["name"])){
                http_response_code(402);
            } else {
                http_response_code(201);

                $path = $_FILES['file']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);

                $name = time();
                $video = 'uploads/plaatjes/'.$name.".".$ext;//.'.mp4';

                //echo shell_exec("avconv -i $source -c:v libx264 -profile:v baseline -c:a libfaac -ar 44100 -ac 2 -b:a 128k -movflags faststart $video 2>&1") . "<br>";
                move_uploaded_file($_FILES["file"]["tmp_name"], $video); $source = $video;
//                shell_exec("avconv -i $source -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
                echo "http://glas.mycel.nl/".$video;

                $stmt = $db->prepare("
                    update residents
                    set plaatje = ?
                    where id = ? and token = ?");
                $stmt->execute(array("http://glas.mycel.nl/".$video, $_GET['id'], $_GET['auth_token']));
            }
        }
    }
    else
    {
        http_response_code(400);
    }
});
