<?php


class QueryBuilder
{
    private static$instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO(DBConnect['driver'].':host='.DBConnect['host'] .";dbname=".DBConnect['dbname'],DBConnect['username'],DBConnect['password']);
        }catch (PDOException $exception){
            die($exception->getMessage());
        }
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new QueryBuilder();
        }
        return self::$instance;
    }

    public function getById($table, $id){
        $sql = "SELECT * FROM {$table} where id = :id";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $result = $statement->fetch(PDO::FETCH_OBJ);
    }

    public function get($table, $where){
        $keys = array_keys($where);
        $string = "";

        foreach ($keys as $key) {
            $string .= $key.'=:'.$key;
        }
        $keys = rtrim($string, ',');

        $sql = "SELECT * FROM {$table} WHERE {$keys}";
        $statement = $this->pdo->prepare($sql);
        $statement -> execute($where);
        return $statement->fetch(PDO::FETCH_OBJ);



    }

    public function getAll($table){
        $sql = "SELECT * FROM {$table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);


    }

    public function create($table, $data){
        $keys = implode(',',array_keys($data));
        $tags = ":". implode(',:',array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tags})";

        $statement = $this->pdo->prepare($sql);
        $statement -> execute($data);
    }

    public function update($table, $data, $id){

        $keys = array_keys($data);
        $string = "";

        foreach ($keys as $key) {
            $string .= $key.'=:'.$key.',';
        }
        $keys = rtrim($string, ',');

        $data['id'] = (int)$id;

        $sql = "UPDATE {$table} SET {$keys} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);

    }

    public function delete($table, $id){

        $sql = "DELETE FROM {$table} where id = :id";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

    }

    public function insert($table, $data)
    {
        $keys = array_keys($data);

        $string = "";

        foreach ($keys as $key) {
            $string .= ':'.$key.', ';
        }

        $keys = rtrim($string, ', ');


        $sql = "INSERT INTO {$table} (". implode(', ',array_keys($data)) . ") VALUES ({$keys})";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);

    }

    public function count($table){
        $sql = "SELECT * FROM {$table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->rowCount();
    }

}
