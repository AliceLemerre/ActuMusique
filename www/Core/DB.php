<?php
namespace App\Core;
use Dotenv\Dotenv; 

class DB
{
    private ?object $pdo = null;
    private string $table;

    public function __construct()
    {

        
        //connexion à la bdd via pdo
        try{
            $this->pdo = new \PDO("pgsql:host=bdd;dbname=postgres;port=5432;", "postgres", "postgres");
        }catch (\PDOException $e) {
            echo "Erreur SQL : ".$e->getMessage();
        }

        $table = get_called_class();
        $table = explode("\\", $table);
        $table = array_pop($table);
        $this->table = "esgi_".strtolower($table);
    }

    public function setTable(string $tableName)
    {
        $this->table = $tableName;
    }

    public function getDataObject(): array
    {
        return array_diff_key(get_object_vars($this), get_class_vars(get_class()));
    }

    public function save()
    {
        $data = $this->getDataObject();

        if (isset($data['id']) && ($data['id'] === 0 || $data['id'] === null)) {
            unset($data['id']);
        }
    
        if (empty($this->getId())) {
            // Insert new record
            $sql = "INSERT INTO " . $this->table . "(" . implode(",", array_keys($data)) . ") 
                    VALUES (:" . implode(",:", array_keys($data)) . ")";
        } else {
            // Update existing record
            $sql = "UPDATE " . $this->table . " SET ";
            foreach ($data as $column => $value) {
                if ($column !== 'id') {  // Skip 'id' in the SET clause
                    $sql .= $column . "=:" . $column . ",";
                }
            }
            $sql = rtrim($sql, ',');
            $sql .= " WHERE id = :id";
        }
    
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($data);
    
        // If it was an insert, set the new ID
        if (empty($this->getId())) {
            $this->setId($this->pdo->lastInsertId());
        }
    }

    public function isAdmin(string $email): bool
    {
        $sql = "SELECT * FROM esgi_user WHERE email = :email";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute(['email' => $email]);

        $user = $queryPrepared->fetch();

        if ($user && $user['role'] == '1') {
            return true;
        }

        return false;
    }

    public function isSuperAdmin(string $email): bool
    {
        $sql = "SELECT * FROM esgi_user WHERE email = :email";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute(['email' => $email]);

        $user = $queryPrepared->fetch();

        if ($user && $user['role'] == '0') {
            return true;
        }

        return false;
    }

    public static function populate(int $id): object
    {
        $class = get_called_class();
        $object = new $class();
        return $object->getOneBy(["id"=>$id], "object");
    }

    //$data = ["id"=>1] ou ["email"=>"y.skrzypczyk@gmail.com"]
    public function getOneBy(array $data, string $return = "array")
    {
        $sql = "SELECT * FROM ".$this->table. " WHERE ";
        foreach ($data as $column=>$value){
            $sql .= " ".$column."=:".$column. " AND";
        }
        $sql = substr($sql, 0, -3);
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($data);
        if($return == "object"){
            $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        }

        return $queryPrepared->fetch();

    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute(['id' => $id]);
    }

    
    public function getAllData(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->setFetchMode(\PDO::FETCH_ASSOC);
        $queryPrepared->execute();

        return $queryPrepared->fetchAll();
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();

        return $queryPrepared->fetchColumn();
    }
    //getAll

    //getOneById
    //getCommentByArticleId
    //deleteCommentByArticleId
    //isAdmin
    //count
    //countWithParams
    //countWithParamsBetween

}












