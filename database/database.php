<?php

class Database{
  private $servername = "localhost";
  private $username = "root";
  private $password = "";
  private $dbname = "bank_db";
  private $stmt = null;
  private $conn = null;
  private $result = null;


  function openDatabase() {
    try {
      $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
      
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo "Connected successfully";
    } catch(PDOException $e) {
      // echo "Connection failed: " . $e->getMessage();
      echo "<div class='alert alert-dismissible alert-danger'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Oh snap!</strong> <u>PDO snapped,</u> try again later.
          </div>";
    }

  }

  function stmtExecute($str_stmt) {
    $this->stmt = $this->conn->prepare($str_stmt);
    $this->stmt->execute();
    $this->result = $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
  }


  function getAssocResult(){
    return $this->result;
     
  }


  function closeDatabase() {
    // echo "Database Closed.";
    $this->stmt = null;
    $this->result = null;
    $this->conn = null;
  }

}

  ?>