<?php


doc("wijkbewoner",
    "Video uploaden <span class='label label-success'>Af</span>",
    "POST <code>/video?id=1&auth_token=blaat123</code>",
    '
<form method="post" enctype="multipart/form-data" action="/video?id=1&auth_token=blaat123">
    <input type="file" name="file">
    <br>
    <button class="btn btn-primary">Opslaan</button>
</form>');
$app->post("/video", function(){
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
        if ($_FILES["file"]["error"] > 0)
        {
            http_response_code(401);
        }else{
            if (file_exists("uploads/videos/" . $_FILES["file"]["name"])){
                http_response_code(402);
            } else {
//                echo "uploads/videos/" . $_FILES["file"]["name"];
                http_response_code(201);

                $source = $_FILES["file"]["tmp_name"];
                $name = time();
                $video = 'uploads/videos/'.$name.'.mp4';
                $thumbnail = 'uploads/thumbnails/'.$name.'.jpg';

//                $cmd = "ffmpeg -i $source -y -s 432x320 -vcodec libx264 -s qvga -acodec libfaac -ab 96k -ac 2 -b 200K -threads 4 -flags +loop -cmp +chroma -partitions 0 -me_method epzs -subq 1 -trellis 0 -refs 1 -coder 0 -me_range 16 -g 300 -keyint_min 25 -sc_threshold 40 -i_qfactor 0.71 -maxrate 10M -bufsize 10M -rc_eq 'blurCplx^(1-qComp)' -qcomp 0.6 -qmin 10 -qmax 51 -qdiff 4 -level 30 $video";
                $cmd = "ffmpeg -i $source -s 480x320 -vcodec libx264 -acodec libfaac -ac 1 -ar 16000 -r 13 -ab 32000 -aspect 3:2 $video  2>&1";
//                $cmd = "ffmpeg -i $source -codec:v libx264 -profile: high -preset slow -b:v 500k -maxrate 500k -bufsize 1000k -s 432x320 -threads 0 -codec:a libfaac -b:a 128k $video 2>&1";
//                $cmd = "
//                ffmpeg -y \\
//                    -i $source \\
//                    -s 432x320 \\
//                    -b 384k \\
//                    -vcodec libx264 \\
//                    -flags +loop+mv4 \\
//                    -cmp 256 \\
//                    -partitions +parti4x4+parti8x8+partp4x4+partp8x8 \\
//                    -subq 6 \\
//                    -trellis 0 \\
//                    -refs 5 \\
//                    -bf 0 \\
//                    -flags2 +mixed_refs \\
//                    -coder 0 \\
//                    -me_range 16 \\
//                    -g 250 \\
//                    -keyint_min 25 \\
//                    -sc_threshold 40 \\
//                    -i_qfactor 0.71 \\
//                    -qmin 10 -qmax 51 \\
//                    -qdiff 4 \\
//                    -acodec libfaac \\
//                    -ac 1 \\
//                    -ar 16000 \\
//                    -r 13 \\
//                    -ab 32000 \\
//                    -aspect 3:2 \\
//                     $video 2>&1";
//                echo $cmd;

//                echo shell_exec("ffmpeg -i $source -profile:v baseline -s 720x480 -ar 44100 -ac 2 -b:a 128k $video 2>&1") . "<br>";
                shell_exec($cmd);//. "<br>";

//                move_uploaded_file($_FILES["file"]["tmp_name"], $video); $source = $video;
//                shell_exec("ffmpeg -i $video -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
                echo $video;

                $stmt = $db->prepare("
                    update residents
                    set video = ?
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
