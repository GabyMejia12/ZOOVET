<?php 
    /**
     * La función "conectar_db" crea un nuevo objeto de Base de Datos y devuelve la propiedad de
     * conexión de ese objeto.
     * 
     * @return La función `conectar_db` devuelve el objeto de conexión de la base de datos
     * (`->conn`).
     */
    function conectar_db()
    {
        $database = new Database();
        return $database->conn;
    }

    /**
     * La función `cerrar_db` cierra la conexión a la base de datos usando una instancia de la clase
     * `Database`.
     * 
     * @return La función `cerrar_db()` devuelve el resultado de llamar al método `close()` en un
     * objeto `Database`.
     */
    function cerrar_db()
    {
        $database = new Database();
        return $database->close();
    }

?>