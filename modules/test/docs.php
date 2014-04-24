<?php

$app->get('/', function(){
    global $docs;
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

                            <!-- Nav tabs -->
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
                            <?php
                            $i = 0;
                            foreach($docs as $a => $b) {
                                echo "<li><b>".ucfirst($a)."</b>:</li>";
                                foreach($b as $doc) {
                                    echo '<li><a href="#url'.($i++).'" data-toggle="tab">'.$doc["name"].'</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                </div>


                <div class="col-sm-8 col-sm-offset-1">
                <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            Welkom! Klik links voor documentatie.
                        </div>

                        <?php
                        $i = 0;
                        foreach($docs as $a => $b) {
                            foreach($b as $doc) {
                                echo '<div class="tab-pane" id="url'.($i++).'">';
                                echo '<h2>'.$doc["name"].'</h2>';
                                echo 'URL: '.$doc["url"];
                                echo $doc["html"];
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


    </body>
    </html>
    <?php
});