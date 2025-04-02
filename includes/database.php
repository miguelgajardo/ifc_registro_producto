<?php
require_once 'config.php';

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $this->connection = new PDO(
            'mysql:host=localhost;dbname=ifc_registro_productos;charset=utf8',
            'root',
            ''
        );
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        } else {
            error_log("Error al obtener la instancia de Base de Datos.");
        }
        return self::$instance->connection;
    }
}
?>