<?php
// Verificamos si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Datos de conexión a la base de datos (ajusta estos valores según tu configuración)
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $base_de_datos = "veterinaria_cli";

    // Conexión a la base de datos
    $conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }
    // Obtener los datos enviados desde el formulario
    $cedula = $_POST["cedula"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $direccion = $_POST["dirrecion"]; // Corregimos el nombre del campo (dirrecion -> direccion)
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $tipo = $_POST["tipo"];

    // Consulta para insertar los datos en la base de datos
    $consulta = "INSERT INTO persona (cedula, nombre, apellido, direccion, telefono, correo,tipo) 
                 VALUES ('$cedula','$nombres', '$apellidos', '$direccion', '$telefono', '$correo','$tipo')";

    if ($conexion->query($consulta) === TRUE) {
        echo "Registro exitoso. Los datos se han guardado en la base de datos.";
    } else {
        echo "Error en el registro: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}
?>
