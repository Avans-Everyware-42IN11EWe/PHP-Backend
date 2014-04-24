<?php
require 'vendor/autoload.php';

require 'helpers/database.helper.php';
require 'builders/query.builder.php';

require 'managers/user.manager.php';

// Create database connection
if(!\Helpers\DatabaseHelper::CreateDatabaseConnection("nas.eye2web.nl", "school", "welkom", "glasaanhuis"))
{
	echo "Database connection failed.";
	exit;
}

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

require('modules/docs.php');
require('modules/video.php');
require('modules/geo.php');
require('modules/facebook.php');

// POST routes

// Login
$app->post('/login', function () {

	$jObj = json_decode($_POST["json"]);
	if(isset($jObj->token))
	{
		Managers\UserManager::Login($jObj->token);
	}
    else
		json_encode(array("response" => "err", "message" => "Missing post data"));
});

// Register
$app->post('/register', function () {
    $jObj = json_decode($_POST["json"]);
	if(isset($jObj->name) && isset($jObj->email))
	{
		Managers\UserManager::Register($jObj->name, $jObj->email);
	}
    else
		json_encode(array("response" => "err", "message" => "Missing post data"));
});




// Chat
$app->post('/chat/getmessages', function () {

    $jObj = json_decode($_POST["json"]);

});

$app->post('/chat/hasnewmessages', function () {

    $jObj = json_decode($_POST["json"]);

});

$app->post('/chat/sendmessage', function () {

    $jObj = json_decode($_POST["json"]);

});

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
