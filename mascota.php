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
$password = "root"; // Cambia esto a la contraseña de la base de datos
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
        <a class="navbar-brand" href="/clinica_veterinaria/mascota.php">Registrar Mascota</a> 
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
<div  class="form-register">
  <h4>datos del cliente</h4>
    <label for="nombres">Nombres:</label>
    <input class="controls" type="text" name="nombres" id="nombres" placeholder="Ingrese su nombres"
           value="<?php echo $datos['nombres']; ?>"/>

    <label for="apellidos">Apellidos:</label>
    <input class="controls" type="text" name="apellidos" id="apellidos" placeholder="Ingrese su apellidos"
           value="<?php echo $datos['apellidos']; ?>"/>
 </div>


 <form action="php/regimas.php" method="post"    class="form-register">
    <h4>Registro de Mascota</h4>
        <input class="controls" type="hidden" name="cod_mascota" id="cod_mascota" placeholder="Ingrese el codigo" required>
        <input value="<?php echo $datos['cedula']; ?>" class="controls" type="text" name="cedula" id="cedula"
           placeholder="Ingrese su cedula"/>
        <input class="controls" type="text" name="nombre_de_mascota" id="nombre_de_mascota" placeholder="Ingrese nombre de mascota">
        <input class="controls" type="text" name="fecha_de_nacimiento" id="fecha_de_nacimiento" placeholder="Ingrese la fecha de nacimiento">
        <select class="controls" name="sexo" id="sexo">
            <option value="Hembra">Hembra</option>
            <option value="Macho">Macho</option>
        </select>


        <input class="controls" type="text" name="especie" id="especie" placeholder="Ingrese su especie">
        <input class="controls" type="text" name="raza" id="raza" placeholder="Ingrese su raza">
        <input class="controls" type="text" name="color" id="color" placeholder="Ingrese su color">
        <input class="controls" type="text" name="peso" id="peso" placeholder="Ingrese su peso">
        <input class="botons" type="submit" value="Registrar">
        <a href="php/actualizar_mascota.php"><div class="bttn-unite bttn-md bttn-primary">Actualizar Datos</div></a> 
    </form>
    


</body>
</html>
