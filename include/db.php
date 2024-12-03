<?php

class DBException extends Exception {
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class DB {
    private static $instance;
    private $connection;
    private function __construct() {
        $dbhost = "dbhost";
        $dblogin = "dblogin";
        $dbpassword = "dbpw";
        $dbdatabase = "db";

        if (!extension_loaded("mysqli")) {
            throw new DBException("MySqli não está instalado.");
        }

        $this->connection = new mysqli($dbhost, $dblogin, $dbpassword, $dbdatabase);

        if ($this->connection->connect_errno) {
            throw new DBException(
                sprintf("Falha na conexão (%s): %s", $this->connection->connect_errno, $this->connection->connect_error)
            );
        }

        $this->connection->set_charset('utf8mb4');
        $this->connection->query("SET lc_time_names = 'pt_BR';");
    }
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public static function exQuery($sql, $params = []) {
        $connection = self::getInstance()->getConnection();
        $stmt = $connection->prepare($sql);

        if ($stmt === false) {
            throw new DBException("Erro na preparação: {$connection->error}");
        }
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        if (!$stmt->execute()) {
            throw new DBException("Erro de sintaxe: {$stmt->error}");
        }
        $affectedRows = $stmt->affected_rows;
        $result = $stmt->get_result();
        $stmt->close();
        if (preg_match('/^(INSERT|UPDATE|DELETE|REPLACE)/i', $sql)) {
            return $affectedRows > 0;
        }        
        return $result;
    }
    public static function query($sql) {
        $connection = self::getInstance()->getConnection();
        $result = $connection->query($sql);

        if ($result === false) {
            throw new DBException("Query Error: {$connection->error}");
        }

        return $result;
    }
    public static function fetchAll($sql, $params = []) {
        return self::exQuery($sql, $params)->fetch_all(MYSQLI_ASSOC);
    }
    public static function fetchOne($sql, $params = []) {
        return self::exQuery($sql, $params)->fetch_assoc();
    }
    public static function insertID() {
        return self::getInstance()->getConnection()->insert_id;
    }
    public static function affectedRows() {
        return self::getInstance()->getConnection()->affected_rows;
    }
    public static function beginTransaction() {
        self::getInstance()->getConnection()->begin_transaction();
    }
    public static function commit() {
        self::getInstance()->getConnection()->commit();
    }
    public static function rollback() {
        self::getInstance()->getConnection()->rollback();
    }
    public static function __callStatic($name, $args) {
        $connection = self::getInstance()->getConnection();

        if (method_exists($connection, $name)) {
            return call_user_func_array([$connection, $name], $args);
        }

        trigger_error("Metodo não identificado: $name()", E_USER_WARNING);
        return null;
    }
    private function getConnection() {
        return $this->connection;
    }
}
?>