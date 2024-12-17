<?php 
class Connexion{
    
    static private $host = 'localhost';
    static private $db_name = 'e132-vda';
    static private $username = 'e132-vda';
    static private $password = '_jIQweT/q1244y1/';

    static private $tabUTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    static private $pdo;
    static public function pdo() {
        return self::$pdo;
    }

    static public function connect(){
        $h = self::$host; $d = self::$db_name; $l = self::$username;
        $p = self::$password; $t = self::$tabUTF8;

        try {
            self::$pdo = new PDO("mysql:host=$h;dbname=$d", $l, $p, $t);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>