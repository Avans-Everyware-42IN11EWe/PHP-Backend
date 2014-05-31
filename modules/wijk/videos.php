<?php


doc(
    "wijk",
    "Video's <span class='label label-danger'>Niet</span>",
    "GET <code>/videos?district=1</code>",
    "<h4>Return:</h4>
    <pre>
[
    {
        'id': 123455,
        'url': 'http://glas.mycel.nl/uploads/videos/123455.mp4',
        'thumb_url': 'http://glas.mycel.nl/uploads/videos/123455.mp4.jpg'
    },
    {
        'id': 123456,
        'url': 'http://glas.mycel.nl/uploads/videos/123456.mp4',
        'thumb_url': 'http://glas.mycel.nl/uploads/videos/123456.mp4.jpg'
    }
]</pre>");
$app->get("/videos", function(){
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
