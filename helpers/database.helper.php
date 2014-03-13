<?php
namespace Helpers;


use PDO;
use PDOException;

class DatabaseHelper {

    private static $mysqlConn = NULL;
    private static $PDOConn = NULL;
    private static $GISConn = NULL;

    public static function CreateDatabaseConnection($host, $username, $password, $database)
    {
        $mysqli = @new \mysqli($host, $username, $password, $database);
        $db = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
        if(mysqli_connect_errno())
        {
            trigger_error('[DatabaseHelper] New connection failed: '.@$mysqli->error);
            return false;
        }

        if(DatabaseHelper::$mysqlConn == null)
        {
            DatabaseHelper::$mysqlConn = $mysqli;
        }
        if(DatabaseHelper::$PDOConn == null)
        {
            DatabaseHelper::$PDOConn = $db;
        }
        return true;
    }

    public static function CreateGISConnection($host, $username, $password, $database)
    {

        try {
            $db = new PDO('pgsql:host='.$host.';dbname='.$database, $username, $password);
            if(DatabaseHelper::$GISConn == null)
            {
                DatabaseHelper::$GISConn = $db;
            }
            return true;
        } catch (PDOException $e) {
            trigger_error('[DatabaseHelper] New connection failed: '.$e->getMessage());

            return false;
        }

    }

    public static function GetDefaultConnection()
    {
        return DatabaseHelper::$mysqlConn;
    }

    /**
     * @return PDO
     */
    public static function GetPDOConnection()
    {
        return DatabaseHelper::$PDOConn;
    }

    /**
     * @return PDO
     */
    public static function GetGISConnection()
    {
        return DatabaseHelper::$GISConn;
    }
	
	public static function Close()
    {
        DatabaseHelper::$mysqlConn->close();
    }
} 