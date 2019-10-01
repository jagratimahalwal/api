<?php
/***********************
 * Creating the database connection in this file.
 * Using PostgresSQL for the database
 *********************/
include_once '../log/generateLog.php';

class Database{

  private $connectorStructure;
  public $conn;
 
    // get the database connection
  public function getConnection(){

    //Defining Database connections
    $this->connectorStructure['host'] = "localhost";
    $this->connectorStructure['dbname'] = "restaurants";
    $this->connectorStructure['dbPort'] = 5432;
    $this->connectorStructure['dbUser'] = "postgres";
    $this->connectorStructure['password'] = "root";

    $connectorString = "host=" . $this->connectorStructure['host'] . " port=" . $this->connectorStructure['dbPort'] . " dbname=" . $this->connectorStructure['dbname'] . " user=" . $this->connectorStructure['dbUser'] . " password=" . $this->connectorStructure['password'];
    $this->conn = pg_connect($connectorString);
    
    if(!$this->conn){
      http_response_code(500);
      echo json_encode(
        array("message" =>"An error occurred while making connection to the DB","status"=>500)
      );

      outputLog("Error occured while making connection with the DB"); // Error Logging 
     exit;

    }else{
      return $this->conn;
    }
  }
}
?>