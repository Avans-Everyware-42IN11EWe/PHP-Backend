<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require 'vendor/autoload.php';
require 'helpers/database.helper.php';

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
header('Access-Control-Allow-Origin: *');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$loader = new Twig_Loader_Filesystem('views/');
$twig = new Twig_Environment($loader);

$docs = array();
function doc($sort, $name, $url, $html) {
    global $docs;
    if(!isset($docs[$sort])) {
        $docs[$sort] = array();
    }
    array_push($docs[$sort], array(
        "name" => $name,
        "url" => $url,
        "html" => $html
    ));
}

require('modules/test/docs.php');

/**
 * wijk
 */
require('modules/wijk/lijsten.php');
require('modules/wijk/wijkinformatie.php');
require('modules/wijk/ids.php');
require('modules/wijk/geo.php');
require('modules/wijk/faq.php');
//require('modules/wijk/buddies.php');

/*
 * wijkbewoner
 */

require('modules/wijkbewoner/profiel.php');
require('modules/wijkbewoner/edit.php');
require('modules/wijkbewoner/chat.php');
require('modules/wijkbewoner/video.php');
require('modules/wijkbewoner/image.php');


require('modules/stappen/status.php');
require('modules/stappen/registreren.php');
require('modules/stappen/facebook.php');
require('modules/stappen/commitment.php');
require('modules/stappen/provider.php');

require('modules/admin/dashboard.php');
require('modules/admin/wijken.php');

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
