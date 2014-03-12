<?php
namespace Helpers;


class DatabaseHelper {

    private static  $mysqlConn = NULL;

    public static  function CreateDatabaseConnection($host, $username, $password, $database)
    {
        $mysqli = @new \mysqli($host, $username, $password, $database);



        if(mysqli_connect_errno())
        {

            trigger_error('[DatabaseHelper] New connection failed: '.@$mysqli->error);
            return false;
        }

        if(DatabaseHelper::$mysqlConn == null)
        {
            DatabaseHelper::$mysqlConn = $mysqli;
        }

        return $mysqli;
    }

    public static function GetDefaultConnection()
    {
        return DatabaseHelper::$mysqlConn;
    }
	
	public static function Close()
    {
        DatabaseHelper::$mysqlConn->close();
    }
} 