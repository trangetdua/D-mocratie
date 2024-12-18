<?php 
class Connexion{
    
    static private $host = 'localhost';
    static private $db_name = 'saes3-aviau';
    static private $username = 'saes3-aviau';
    static private $password = 'ymPVbOHi9IjBplOm';
    static public $pdo;

    static public function getConnection(){
        self::$pdo = null;

        try{
            self::$pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
            self::$pdo->exec("set names utf8"); 
        }catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return self::$pdo;
    }   
}
?>