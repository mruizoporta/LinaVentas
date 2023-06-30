<?php
class Db{
		
	private $dbHost     = "68.66.224.22";
    private $dbUsername = "blessja2_adminsofventas";
    private $dbPassword = "adminsofventas2023$";
    private $dbName     = "blessja2_softventas";
	protected $p; 
	protected $dbh; 
	
    public function __construct(){
        if(!isset($this->dbh)){
            // Connect to the database
            try{
	
	            date_default_timezone_set('America/Caracas');
                setlocale(LC_ALL,"es_VE.UTF-8","es_VE","esp");
	
                $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->dbh = $conn;
            }catch(PDOException $e){
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }
	
		public function SetNames()
	{
		return $this->dbh->query("SET NAMES 'utf8'");
	}

###### FIN DE CLASE #####	

}	
?>