<?php
$app->get("/districts", function(){
    ?>
[
    { 'id': 1, 'name': 'Wallen', 'status': "action", 'distance': 0 },
    { 'id': 2, 'name': 'Centrum', 'status': "unknown", 'distance': 2.123 },
    { 'id': 3, 'name': 'West', 'status': "infrastructural_possible", 'distance': 3.55 }
]
<?php
});

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

$app->get("/pictures", function(){
    ?>
[
    {
    'resident_id': 1,
    'facebook': '100000644333726'
    },
    {
    'resident_id': 2,
    'facebook': '100002085564993'
    }
]
<?php
});

$app->get('/district', function() {
?>
{
    "plaatjes":[
    "100000644333726",
    "100002085564993",
    "100004316252521",
    "638983792"
    ],
    "about":"Glasvezel voor de buurt Paleiskwartier",
    "page":{
    "id":"1450066045229608",
    "about":"Glasvezel voor de buurt Paleiskwartier",
    "can_post":false,
    "category":"Community",
    "checkins":0,
    "has_added_app":false,
    "is_community_page":false,
    "is_published":true,
    "likes":5,
    "link":"https:\/\/www.facebook.com\/glasvezelpaleiskwartier",
    "name":"Glasvezelbuurt Paleiskwartier Den Bosch",
    "talking_about_count":0,
    "username":"glasvezelpaleiskwartier",
    "were_here_count":0
    },
    "feed":{   },
    "photos":[
    {
    "id":"1451730748396471",
    "from":{
    "category":"Community",
    "name":"Glasvezelbuurt Paleiskwartier Den Bosch",
    "id":"1450066045229608"
    },
    "picture":"https:\/\/fbcdn-photos-a-a.akamaihd.net\/hphotos-ak-ash3\/t1.0-0\/1979672_1451730748396471_1888089831_s.jpg",
    "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t1.0-9\/s720x720\/1979672_1451730748396471_1888089831_n.jpg",
    "height":479,
    "width":720,
    "images":[
    { "height":853, "width":1280, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t31.0-8\/10010071_1451730748396471_1888089831_o.jpg" },
    { "height":720, "width":1080, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t31.0-8\/p720x720\/10010071_1451730748396471_1888089831_o.jpg"},
    { "height":600, "width":900, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t31.0-8\/p600x600\/10010071_1451730748396471_1888089831_o.jpg"},
    { "height":480, "width":720, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t31.0-8\/p480x480\/10010071_1451730748396471_1888089831_o.jpg"},
    { "height":320, "width":480, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t1.0-9\/p320x320\/1979672_1451730748396471_1888089831_n.jpg"},
    { "height":540, "width":810, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t31.0-8\/p180x540\/10010071_1451730748396471_1888089831_o.jpg"},
    { "height":130, "width":195, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t1.0-9\/p130x130\/1979672_1451730748396471_1888089831_n.jpg"},
    { "height":225, "width":338, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-ash3\/t1.0-9\/p75x225\/1979672_1451730748396471_1888089831_n.jpg"}
    ],
    "link":"https:\/\/www.facebook.com\/glasvezelpaleiskwartier\/photos\/a.1450066865229526.1073741825.1450066045229608\/1451730748396471\/?type=1",
    "icon":"https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yz\/r\/StEh3RhPvjk.gif",
    "created_time":"2014-03-17T09:20:27+0000",
    "updated_time":"2014-03-17T09:20:27+0000"
    },
    {
    "id":"1450066875229525",
    "from":{
    "category":"Community",
    "name":"Glasvezelbuurt Paleiskwartier Den Bosch",
    "id":"1450066045229608"
    },
    "picture":"https:\/\/fbcdn-photos-e-a.akamaihd.net\/hphotos-ak-frc1\/t1.0-0\/1897837_1450066875229525_1116177832_s.jpg",
    "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-frc1\/t1.0-9\/s720x720\/1897837_1450066875229525_1116177832_n.jpg",
    "height":540,
    "width":720,
    "images":[
    { "height":585, "width":780, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-frc1\/t1.0-9\/1897837_1450066875229525_1116177832_n.jpg" },
    { "height":480, "width":640, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-frc1\/t1.0-9\/p480x480\/1897837_1450066875229525_1116177832_n.jpg" },
    { "height":320, "width":426, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-frc1\/t1.0-9\/p320x320\/1897837_1450066875229525_1116177832_n.jpg" },
    { "height":540, "width":720, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-frc1\/t1.0-9\/p180x540\/1897837_1450066875229525_1116177832_n.jpg" },
    { "height":130, "width":173, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-frc1\/t1.0-9\/p130x130\/1897837_1450066875229525_1116177832_n.jpg" },
    { "height":225, "width":300, "source":"https:\/\/scontent-a.xx.fbcdn.net\/hphotos-frc1\/t1.0-9\/p75x225\/1897837_1450066875229525_1116177832_n.jpg" }
    ],
    "link":"https:\/\/www.facebook.com\/glasvezelpaleiskwartier\/photos\/a.1450066865229526.1073741825.1450066045229608\/1450066875229525\/?type=1",
    "icon":"https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yz\/r\/StEh3RhPvjk.gif",
    "created_time":"2014-03-12T10:16:31+0000",
    "updated_time":"2014-03-16T11:55:35+0000"
    }
    ]
}
<?php
});