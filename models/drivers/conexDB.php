<?php
namespace App\models\drivers;

use mysqli;

class ConexDB {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dataBase = 'proyecto_2_db';
    private $conex = null;

    public function __construct(){
        $this->connect();
    }

    private function connect() {
        $this->conex = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->dataBase
        );

        if ($this->conex->connect_error) {
            throw new \Exception("Connection failed: " . $this->conex->connect_error);
        }

        // Set timeout values
        $this->conex->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        $this->conex->query("SET SESSION wait_timeout=30");
        $this->conex->query("SET SESSION interactive_timeout=30");
    }

    private function checkConnection() {
        if (!$this->conex || $this->conex->ping() === false) {
            $this->connect();
        }
    }

    public function getConexion() {
        $this->checkConnection();
        return $this->conex;
    }

    public function close(){
        if ($this->conex) {
            $this->conex->close();
        }
    }

    public function exeSQL($sql){
        $this->checkConnection();
        $result = $this->conex->query($sql);
        
        if ($result === false) {
            throw new \Exception("Query failed: " . $this->conex->error);
        }
        
        return $result;
    }

    public function getLastId() {
        $this->checkConnection();
        return $this->conex->insert_id;
    }
}

