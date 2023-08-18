<?php
// Verificamos si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos de conexión a la base de datos (ajusta estos valores según tu configuración)
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "root";
    $base_de_datos = "veterinaria_cli";

    // Conexión a la base de datos
    $conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Obtener los datos enviados desde el formulario
    $codigoHistorial = $_POST["codigohistorial"];
    $codigomas = $_POST["codigomas"];
    $fechaHistorial = $_POST["fechanacimiento"];
    $diagnostico = $_POST["diagnostico"];
    $receta = $_POST["receta"];
    $tratamiento = $_POST["tratamiento"];

    // Consulta para insertar los datos en la base de datos
    $consulta = "INSERT INTO historial
                 VALUES (0, '$codigomas', '$fechaHistorial', '$diagnostico', '$receta', '$tratamiento')";

    if ($conexion->query($consulta) === TRUE) {
        echo "Registro exitoso. Los datos del historial se han guardado en la base de datos.";
    } else {
        echo "Error en el registro: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}
?>
