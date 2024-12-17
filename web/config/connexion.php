<?php 
class Connexion{
    
    private $host = "localhost";
    private $db_name = "saes3-aviau";
    private $username = "saes3-aviau";
    private $password = "ymPVbOHi9IjBplOm";
    public $connexion;

    public function getConnection(){
        $this->connexion = null;

        try{
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connexion->exec("set names utf8"); 
        }catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->connexion;
    }   
}
?>