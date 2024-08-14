<?php

class DBConnection
{
  private $servername = "";
  private $username = "";
  private $password = "";
  private $dbname = "";
  private $conn;

  public function connect()
  {
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

    if ($this->conn->connect_error) {
      die("Ошибка подключения: " . $this->conn->connect_error);
    }
  }

  public function getConnection()
  {
    return $this->conn;
  }
}
