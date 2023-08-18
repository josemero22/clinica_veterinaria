<?php
$datos = array(
    'cedula' => '',
    'nombres' => '',
    'apellidos' => '',
    'direccion' => '',
    'telefono' => '',
    'correo' => '',
    'tipo' => ''
);
$servername = "127.0.0.1"; // Cambia esto al nombre de tu servidor MySQL
$username = "root"; // Cambia esto al nombre de usuario de la base de datos
$password = ""; // Cambia esto a la contraseña de la base de datos
$dbname = "veterinaria_cli"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['numce'])) {
        $numce = $_GET['numce'];
        $sql = "SELECT * FROM persona WHERE cedula = '$numce'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $datos = array(
                'cedula' => $row['cedula'],
                'nombres' => $row['nombre'],
                'apellidos' => $row['apellido'],
                'direccion' => $row['direccion'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'tipo' => $row['tipo']
            );
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $tipo = $_POST['tipo'];


    $sql = "UPDATE persona SET nombre = '$nombres', apellido = '$apellidos', direccion = '$direccion', telefono = '$telefono', correo = '$correo', tipo ='$tipo' WHERE cedula = '$cedula'";
    if ($conn->query($sql) === TRUE) {
        echo "Datos actualizados exitosamente.";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/clinica_veterinaria/css/style.css"/>
    <link rel="stylesheet" href="/clinica_veterinaria/css/stilo.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css"/>
    <title>Registro de Cliente</title>
</head>
<body>
<br/>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="/clinica_veterinaria/index.html">Inicio</a>

        <a class="navbar-brand" href="/clinica_veterinaria/cliente.html">Registrar Persona</a>
        <a class="navbar-brand" href="/clinica_veterinaria/mascota.html">Registrar Mascota</a> 
        <a class="navbar-brand" href="/clinica_veterinaria/date.php"> Registar Historial</a> 
        <a class="navbar-brand" href="/clinica_veterinaria/php/cohis2.php">Consultar Historial</a> 
        <a class="navbar-brand" href="/clinica_veterinaria/elegir.html">Actualizar Datos</a> 

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"></li>
            </ul>
        </div>
    </div>
</nav>

<form class="form-register" method="get">
    <h4>Buscar Datos.</h4>
    <label for="numce" class="form-label">Numero de cedula</label>
    <input type="text" class="form-control" id="numce" name="numce" required/><br/>
    <input type="submit" class="form-control" value="Buscar"/>
    <br/>
</form>

<form class="form-register" method="post">
    <h4>Actualizar Datos.</h4>
    <label for="cedula">Cédula:</label>
    <input value="<?php echo $datos['cedula']; ?>" class="controls" type="text" name="cedula" id="cedula"
           placeholder="Ingrese su cedula"/><br/>

    <label for="nombres">Nombres:</label>
    <input class="controls" type="text" name="nombres" id="nombres" placeholder="Ingrese su nombres"
           value="<?php echo $datos['nombres']; ?>"/><br/>

    <label for="apellidos">Apellidos:</label>
    <input class="controls" type="text" name="apellidos" id="apellidos" placeholder="Ingrese su apellidos"
           value="<?php echo $datos['apellidos']; ?>"/><br/>

    <label for="dirrecion">Dirección:</label>
    <input class="controls" type="text" name="direccion" id="direccion" placeholder="Ingrese su dirección"
           value="<?php echo $datos['direccion']; ?>"/><br/>

    <label for="telefono">Teléfono:</label>
    <input class="controls" type="text" name="telefono" id="telefono" placeholder="Ingrese su teléfono"
           value="<?php echo $datos['telefono']; ?>"/><br/>

    <label for="correo">Correo:</label>
    <input class="controls" type="text" name="correo" id="correo" placeholder="Ingrese su correo"
           value="<?php echo $datos['correo']; ?>"/><br/>
           <label for="correo">Tipo:</label>
    <input class="controls" type="text" name="tipo" id="tipo" placeholder="Ingrese su correo"
           value="<?php echo $datos['tipo']; ?>"/><br/>

    <input type="submit" value="Actualizar"/>
</form>

</body>
</html>
