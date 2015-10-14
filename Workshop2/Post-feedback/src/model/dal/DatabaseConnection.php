<?php


namespace model\dal;


abstract class DatabaseConnection
{
    protected $db;

    public function __construct(){
        try{
            $this->db = new \PDO('mysql:host=' . \Settings::DSN . ';dbname=' . \Settings::DATABASE . ';', \Settings::DB_USERNAME, \Settings::DB_PASSWORD, array(\PDO::FETCH_OBJ));
            $this->db->SetAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\Exception $e){
            throw $e;
        }
    }
}
