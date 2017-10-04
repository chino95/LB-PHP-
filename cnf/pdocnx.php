<?php

class ConnectionManager {
    
    private $server="localhost";
    private $usr="root";
    private $psw="";
    private $db="bdlb";
    
    public function connectMysql()
    {
        try{
            $dbCnx = new PDO("mysql:host=$this->server;dbname=$this->db;", $this->usr, $this->psw);
            $dbCnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbCnx;
        }
        catch(PDOException $e){
            echo $e;
            die();
            return null;
        }
    }
}