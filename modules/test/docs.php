<?php

$app->get('/', function(){
    ?>
    <!DOCTYPE html>
    <html><head><title>Glas aan Huis API</title><link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"><script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script><script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script><script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js"></script><script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.1/mapbox.js'></script><link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.1/mapbox.css' rel='stylesheet' /><style>body { margin:0; padding:0; }#map { position:absolute; top:0; bottom:0; width:100%; }</style>
    </head>
    <body>

    <div class="container">

        <div class="blog-header">
            <h1 class="blog-title">Glas aan Huis API</h1>
            <p class="lead blog-description">Hier al onze prachtige API documentatie.</p>
        </div>

        <div class="row">
            <div class="col-sm-3 blog-sidebar">
                <div class="sidebar-module">
                    <h4>Documentatie</h4>
                    <ol class="list-unstyled">
                        <li><b>Wijk</b></li>
                        <li><a href="#a1">Wijken in de buurt</a></li>
                        <li><a href="#a2">GEO</a></li>
                        <li><a href="#a3">Video</a></li>
                        <li><a href="#a4">De foto's van wijkbewoners</a></li>
                        <li><a href="#a5">Wijkinformatie</a></li>
                        <li><b>Wijkbewoner</b></li>
                        <li><a href="#b1">Registreren</a></li>
                        <li><a href="#b2">Facebook</a></li>
                        <li><a href="#b3">Inloggen</a></li>

                    </ol>
                </div>
                <div class="sidebar-module">
                    <h4>Anders</h4>
                    <ol class="list-unstyled">
                        <li><a href="/geo.html">Geo</a></li>
                    </ol>
                </div>
            </div>

            <div class="col-sm-8 col-sm-offset-1">
                <h2>Wijk</h2>

                <h3 id="a1">Wijken in de buurt</h3>
                GET <code>/districts?lat=51.983333&long=5.916667</code>

                <h4>Return:</h4>
                <pre>
[
    { 'id': 1, 'name': 'Wallen', 'status': "action", 'distance': 0 },
    { 'id': 2, 'name': 'Centrum', 'status': "unknown", 'distance': 2.123 },
    { 'id': 3, 'name': 'West', 'status': "infrastructural_possible", 'distance': 3.55 }
]</pre>

                Mogelijke wijkstatussen: <code>unknown</code>, <code>infrastructural_impossible</code>, <code>infrastructural_possible</code>, <code>action</code>, <code>commited</code>, <code>success</code>

                <hr>
                <h3 id="a2">GEO</h3>
                <p>komt nog...</p>

                <hr>

                <h3 id="a3">Video</h3>
                GET <code>/videos?district=1</code>

                <h4>Return:</h4>
                <pre>
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
]</pre>

                <hr>
                <h3 id="a4">De foto's van wijkbewoners</h3>
                GET <code>/pictures?district=1</code>

                <h4>Return:</h4>
                <pre>
[
    {
        'resident_id': 1,
        'facebook': '100000644333726'
    },
    {
        'resident_id': 2,
        'facebook': '100002085564993'
    }
]</pre>

                <hr>
                <h3 id="a5">Wijkinformatie</h3>
                GET <code>/district?id=1</code>

                <h4>Return:</h4>
                <pre>
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
}</pre>

<p>Ja, veel geluk.</p>

                <hr>
                <h2>Wijkbewoner en gebruiker</h2>
                <p>De wijkbewoner is de gebruiker, je hebt alleen <b>registreren</b>. Je hebt daarom ook geen wachtwoord. Een
                e-mail adres of facebookaccount is genoeg.</p>

                <hr>
                <h3 id="b1">Registreren</h3>
                POST <code>/register</code>

                <h4>Meegeven:</h4>
                <pre>
{
    "email": "bill@microsoft.com",
    "name": "Bill Gates",
    "address": "Kerkstraat 1, Amsterdam",
    "district_id": 5
}</pre>


                <p class="bg-info">district_id staat voor wijknummer</p>
                <h4>Return:</h4>
                <pre>{ "user_id": 34 }</pre>

                <hr>
                <h3 id="b2">Facebook</h3>

                <h4>Meegeven:</h4>
                <pre>
{
    "user_id": "34",
    "access_token": "CAAKNJIG6TKMBAE00HOVfARdRYq4dkIZAKKLKotZB1ftBQl16Gd9WFuTbvTsIjx2PgSejeD7dqS184KqAo93Jv5PnJvGoJXRmSSF31BYM9cWmN8ZAG79RnxuPiJrUbX4BKuyx6Vgc76ScJdI37X58kjzbKk2ads2bJDsutJ3nQTd5H3P8Mq6iKicubj2GUvLcUCeHq53pa8ZBTZAfX4NrcRjtZBZA2lf3lFL9QuLgPtfzwZDZD"
}</pre>


                <h4>Return:</h4>
                <pre>{ "token": "blaat123" }</pre>

                <hr>
                <h3 id="b3">Inloggen</h3>
                GET <code>/login?user_id=34</code>

                <h4>Situatie 1:</h4>
                <b>Gebruiker heeft e-mail verificatie gedaan</b>
                <pre>{ "token": "blaat123" }</pre>

                <h4>Situatie 2:</h4>
                <b>Gebruiker moet e-mail verificatie nog doen</b>
                <pre>fail</pre>



            </div><!-- /.blog-main -->


        </div><!-- /.row -->

    </div><!-- /.container -->


    </body></html>
<?php
});