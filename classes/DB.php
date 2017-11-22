<?php
namespace Guestbook\Classes;

class DB
{
    protected $conn = null;
    private $host = HOST;
    private $dbname = DBNAME;
    private $user = USER;
    private $password = PASSWORD;
    private $error;

    public function __construct()
    {
        $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8";
        try {
            $this->conn = new \PDO($dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            $this->conn = null;
            $this->error = $e->getMessage();
        }
    }

    public function getError()
    {
        return $this->_error;
    }

    public function getMaxLegth($table, $column)
    {
        $stmt = $this->conn->prepare('select COLUMN_NAME, CHARACTER_MAXIMUM_LENGTH 
                                    from information_schema.columns
                                    where table_schema = DATABASE() AND
                                    table_name = :table AND COLUMN_NAME = :column');
        $stmt->execute(array("table" => $table, "column" => $column));
        $column = $stmt->fetch(\PDO::FETCH_LAZY);
        return $column['CHARACTER_MAXIMUM_LENGTH'];
    }
}
