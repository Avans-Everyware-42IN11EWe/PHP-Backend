<?php


doc("wijkbewoner",
    "Video uploaden <span class='label label-danger'>Eng</span>",
    "POST <code>/video</code>",
    '
<p>In de HTML moet het met
<pre>&lt;input type=&quot;file&quot; name=&quot;file&quot;&gt;</pre>

Ik zou niet weten hoe het moet ruwe HTTP.</p>');
$app->post("/video", function(){
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

                //copy('uploads/thumbnails/test.jpg', 'uploads/thumbnails/'.$_FILES["file"]["name"].'.jpg');
//                $video = "uploads/videos/" . $_FILES["file"]["name"];
                $source = $_FILES["file"]["tmp_name"];

                $name = time();
                $video = 'uploads/videos/'.$name.'.mp4';
                $thumbnail = 'uploads/thumbnails/'.$name.'.jpg';

                //echo shell_exec("avconv -i $source -c:v libx264 -profile:v baseline -c:a libfaac -ar 44100 -ac 2 -b:a 128k -movflags faststart $video 2>&1") . "<br>";
                move_uploaded_file($_FILES["file"]["tmp_name"], $video); $source = $video;
                shell_exec("avconv -i $source -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
                echo $video;
            }
        }
    }
    else
    {
        http_response_code(400);
    }
});
