

<?php 

include_once(__DIR__ . '/../config/dbconfig.php');


class Database{
    
    private static $instance = null;
    private $pdo;
    public function __construct(){
        $this->pdo = new PDO(DB_CON,DB_USERNAME,DB_PASSWORD);
    }
    public static function getInstance() {  
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getPdo (){
        return $this->pdo;
    }   
}



?>