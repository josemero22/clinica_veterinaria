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
    $codigomascota = $_POST["cod_mascota"];
    $cedula = $_POST["cedula"];
    $nombremascota = $_POST["nombre_de_mascota"];
    $fechanacimiento = $_POST["fecha_de_nacimiento"];
    $sexo = $_POST["sexo"];
    $especie = $_POST["especie"];
    $raza = $_POST["raza"];
    $color = $_POST["color"];
    $peso = $_POST["peso"];

    // Consulta para insertar los datos en la base de datos
    $consulta = "INSERT INTO mascota (cod_mas, cedula , nombre_mas, fecha_na, sexo, especie, raza, color, peso) 
                 VALUES ('$codigomascota','$cedula', '$nombremascota','$fechanacimiento','$sexo','$especie','$raza','$color','$peso')";

    if ($conexion->query($consulta) === TRUE) {
        echo "Registro exitoso. Los datos de la mascota se han guardado en la base de datos.";
    } else {
        echo "Error en el registro: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}
?>
