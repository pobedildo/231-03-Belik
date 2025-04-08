<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'cwp1_231');
define('DB_USER', 'root'); 
define('DB_PASS', ''); 


session_start();


function getDB() {
    static $db = null;
    
    if ($db === null) {
        try {
            $db = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', 
                DB_USER, 
                DB_PASS
            );
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }
    
    return $db;
}
?>