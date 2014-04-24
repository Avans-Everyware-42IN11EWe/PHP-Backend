<?php
namespace Managers;

class UserManager
{

	public static function Register($name, $email)
	{	
		echo json_encode(array("response" => "ok", "user" => array("name" => $name, "email" => $email), "token" => "TODO"));
	}
	
	public static function Login($token)
	{	
		echo json_encode(array("response" => "ok", "token" => "TODO"));
	}



}
?>