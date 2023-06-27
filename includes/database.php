<?php

class DataBase {

    private $result;
    private $execute;
    private $errorMessage;

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
        try {
            $this->execute = $query->execute($params);
            $this->result = $query;
            return $this;
        } catch (PDOException $pdoe) {
            $this->execute = false;
            $this->result = null;
            $this->errorMessage = $pdoe->getMessage();
            return $this;
        }
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

    function isSuccess(){
        return $this->execute;
    }

    function getError(){
        return $this->errorMessage;
    }

    function isRowExists($tableName, $column, $value) {
        $queryString = "SELECT COUNT(*) as count FROM {$tableName} WHERE {$column} = ?";
        $result = $this->queryExecute($queryString, [$value]);
        
        if ($result->isSuccess()) {
            $count = $result->queryGetFirstResult()->count;
            return $count > 0;
        } else {
            // Manejar el error en caso de que ocurra
            $errorMessage = $result->getError();
            // ... Código de manejo de error ...
            return false;
        }
    }
}
