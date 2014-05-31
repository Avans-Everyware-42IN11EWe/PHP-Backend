<?php


doc(
    "wijk",
    "FAQ <span class='label label-warning'>Zal wel</span>",
    "GET <code>/faq?district=1</code>",
    "<h4>Return:</h4>
    <pre>
[
    'la lala laalal la la la la',
    'nog meer informatie'
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
