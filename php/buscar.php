<?php
function verificarRegistro($cedula) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "veterinaria_cli";
    
    // Crear la conexión a la base de datos
    $conexion = new mysqli($servername, $username, $password, $dbname);
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
    
    // Escapar el valor de la cédula para prevenir inyecciones SQL
    $cedula = $conexion->real_escape_string($cedula);
    
    // Consulta SQL para verificar si el registro existe
    $query = "SELECT COUNT(*) AS total FROM persona WHERE cedula = '$cedula'";
    $result = $conexion->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
        
        // Si el total es mayor a 0, el registro existe
        if ($total > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    
    $conexion->close();
}



function obtenerDatos($cedula) {
    $servername = "127.0.0.1"; // Cambia esto al nombre de tu servidor MySQL
    $username = "root"; // Cambia esto al nombre de usuario de la base de datos
    $password = ""; // Cambia esto a la contraseña de la base de datos
    $dbname = "veterinaria_cli"; // Cambia esto al nombre de tu base de datos
    
    $conexion = new mysqli($servername, $username, $password, $dbname);
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $cedula = $conexion->real_escape_string($cedula);
    
  
    $query = "SELECT * FROM persona WHERE cedula = '$cedula'";
    $result = $conexion->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return array(); // Retorna un arreglo vacío si no se encuentra ningún registro
    }
    
    $conexion->close();
}

// Verificar si se envió la cédula desde el formulario
if (isset($_GET['numce'])) {
    $cedula = $_GET['numce'];
    
    if (verificarRegistro($cedula)) {
        echo "El registro con la cédula $cedula existe en la base de datos.";
        obtenerDatos($cedula);
    } else {
        echo "El registro con la cédula $cedula no existe en la base de datos.";
    }
} else {
    echo "No se proporcionó la cédula.";
}
?>
