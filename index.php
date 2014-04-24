<?php
require 'vendor/autoload.php';

require 'helpers/database.helper.php';
require 'builders/query.builder.php';

require 'managers/user.manager.php';

if(!file_exists("config.php")) {
    die("Je moet het 'config.php'-bestandje uit dropbox halen en de hoofdmap stoppen.");
}
require 'config.php';

// Create database connection
if(!\Helpers\DatabaseHelper::CreateDatabaseConnection($dbhost, $dbuser, $dbpass, $dbname))
{
	echo "Database connection failed.";
	exit;
}

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$docs = array("wijk" => array(), "wijkbewoner" => array());
function doc($sort, $name, $url, $html) {
    global $docs;
    array_push($docs[$sort], array(
        "name" => $name,
        "url" => $url,
        "html" => $html
    ));
}

require('modules/test/docs.php');

require('modules/wijk.php');
require('modules/wijkbewoner.php');

require('modules/test/video.php');
require('modules/test/geo.php');
require('modules/test/facebook.php');

require('modules/test/chat.php');

$app->run();
\Helpers\DatabaseHelper::Close();


/*
// GET route
$app->get('/',
    function () {

        echo "werkt!!";
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);
*/
