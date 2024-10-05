<?php
/* La clase `Base de datos` en PHP establece una conexión a una base de datos MySQL utilizando el host,
el nombre de usuario, la contraseña y el nombre de la base de datos proporcionados. */
class Database {
    private $host = "localhost"; // Cambiar según tu configuración
    private $username = "root"; // Cambiar según tu configuración
    private $password = ""; // Cambiar según tu configuración
    private $dbname = "zoovet"; // Cambiar según tu configuración

    /**
     * El fragmento de código muestra un constructor de clases PHP que llama automáticamente a un
     * método de conexión al crear una instancia.
     */
    public $conn;

    /**
     * La función PHP anterior es un constructor que llama al método de conexión cuando se crea un
     * objeto.
     */
    public function __construct() {
        $this->connect();
    }

    /**
     * La función establece una conexión a una base de datos MySQL usando mysqli en PHP.
     */
    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    /**
     * La función de cierre se utiliza para cerrar la conexión en PHP.
     */
    public function close() {
        $this->conn->close();
    }
}
?>