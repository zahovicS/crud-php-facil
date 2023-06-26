<?php

class DataBase {

    private $result;

    private function getConnection(){
        $dsn = "mysql:dbname=".DATA_BASE_NAME.";host=".DATA_BASE_HOST.";port=".DATA_BASE_PORT."";
        try {
            return new PDO($dsn, DATA_BASE_USER, DATA_BASE_PASSWORD, DATA_BASE_OPTIONS);
        } catch (PDOException $e) {
            throw new PDOException("Error Database: ".$e->getMessage());
        }
    }

    function queryExecute(string $queryString, array $params = []){
        $connection = $this->getConnection();
        $query = $connection->prepare($queryString);
        $query->execute($params);
        $this->result = $query;
        return $this;
    }

    function queryCount(){
        return $this->result->rowCount();
    }

    function queryGetAllResult($mode = PDO::FETCH_OBJ){
        return $this->result->fetchAll($mode);
    }

    function queryGetFirstResult($mode = PDO::FETCH_OBJ){
        return $this->result->fetch($mode);
    }
}
