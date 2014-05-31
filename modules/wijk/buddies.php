<?php

doc(
    "wijk",
    "Buddy's <span class='label label-warning'>blaa</span>",
    "GET <code>/buddies?district=1</code>",
    "<h4>Return:</h4>
    <pre>komt nog...</pre>");
$app->get("/buddies", function(){
    ?>
    [
    {
    'id': 123455,
    'url': "http://glas.mycel.nl/uploads/videos/123455.mp4",
    'thumb_url': "http://glas.mycel.nl/uploads/videos/123455.mp4.jpg"
    },
    {
    'id': 123456,
    'url': "http://glas.mycel.nl/uploads/videos/123456.mp4",
    'thumb_url': "http://glas.mycel.nl/uploads/videos/123456.mp4.jpg"
    }
    ]
<?php
});