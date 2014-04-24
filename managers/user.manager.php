<?php
namespace Managers;

class UserManager
{

	public static function Register($name, $email)
	{
	
		/*
		// Test query
		$qBuilder = new Builders\QueryBuilder("SELECT * FROM users");
			
		if($qBuilder->Execute())
		{
			$fetchedArray = $qBuilder->GetFetchedArray();
			$qBuilder->Close();
				
			var_dump($fetchedArray);	
	}*/
	
		echo array("response" => "ok", "token" => "TODO");
	}
	
	public static function Login($token)
	{	

			/*
	// Test query
	$qBuilder = new Builders\QueryBuilder("SELECT * FROM users");
		
	if($qBuilder->Execute())
	{
		$fetchedArray = $qBuilder->GetFetchedArray();
		$qBuilder->Close();
			
		var_dump($fetchedArray);	
	}*/
	
		echo array("response" => "ok", "token" => "TODO");
	}



}
?>