<?php
$datos = array(
    'codigo' => '',
    'cedula' => '',
    'nombre_mascota' => '',
    'fecha_nacimiento' => '',
    'sexo' => '',
    'especie' => '',
    'raza' => '',
    'color' => '',
    'peso' => ''
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
        $sql = "SELECT * FROM mascota WHERE cedula = '$numce'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            if ($result->num_rows > 1) {
                // Si hay más de un registro, mostramos opciones para elegir
                echo "Hay más de un registro. Por favor, elige cuál actualizar:<br>";
                while ($row = $result->fetch_assoc()) {
                    echo "<a href=\"?numce=$numce&cod={$row['cod_mas']}\">{$row['nombre_mas']}</a><br>";

                }
            } else {
                $row = $result->fetch_assoc();
                $datos = array(
                    'codigo' => $row['cod_mas'],
                    'cedula' => $row['cedula'],
                    'nombre_mascota' => $row['nombre_mas'],
                    'fecha_nacimiento' => $row['fecha_na'],
                    'sexo' => $row['sexo'],
                    'especie' => $row['especie'],
                    'raza' => $row['raza'],
                    'color' => $row['color'],
                    'peso' => $row['peso']
                );
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nombre_mascota = $_POST['nombre_mascota'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $color = $_POST['color'];
    $peso = $_POST['peso'];

    $sql = "UPDATE mascota SET nombre_mas = '$nombre_mascota', fecha_na = '$fecha_nacimiento', sexo = '$sexo', especie = '$especie', raza = '$raza', color = '$color', peso = '$peso' WHERE cod_mas = '$codigo'";
    if ($conn->query($sql) === TRUE) {
        echo "Datos actualizados exitosamente.";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

if (isset($_GET['numce']) && isset($_GET['cod'])) {
    $numce = $_GET['numce'];
    $cod = $_GET['cod'];
    $sql = "SELECT * FROM mascota WHERE cedula = '$numce' AND cod_mas = '$cod'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $datos = array(
            'codigo' => $row['cod_mas'],
            'cedula' => $row['cedula'],
            'nombre_mascota' => $row['nombre_mas'],
            'fecha_nacimiento' => $row['fecha_na'],
            'sexo' => $row['sexo'],
            'especie' => $row['especie'],
            'raza' => $row['raza'],
            'color' => $row['color'],
            'peso' => $row['peso']
        );
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/clinica_veterinaria/css/style.css">
    <link rel="stylesheet" href="/clinica_veterinaria/css/stilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/clinica_veterinaria/style.css">
    <title>Registro de Cliente</title>
</head>
<body>
  <br>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/clinica_veterinaria/index.html">Inicio</a>
      
      <a class="navbar-brand" href="  /clinica_veterinaria/cliente.html">Registrar Persona</a>
        <a class="navbar-brand" href="/clinica_veterinaria/mascota.php">Registrar Mascota</a> 
        <a class="navbar-brand" href="/clinica_veterinaria/date.php"> Registar Historial</a> 
        <a class="navbar-brand" href="/clinica_veterinaria/php/cohis2.php">Consultar Historial</a> 
        <a class="navbar-brand" href="/clinica_veterinaria/elegir.html">Actualizar Datos</a> 
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
  
          </li>
        </ul>
      </div>
    </div>
  </nav>
    
    <form class="form-register" method="get">
        <h4>Buscar Datos.</h4>
        <label for="numce" class="form-label">Numero de cedula</label> 
        <input type="text" class="form-control" id="numce" name="numce" required><br>
        <input type="submit" class="form-control" value="Buscar">
        <br>
    </form>
    
    <form class="form-register" method="post">
        <h4>Actualizar Datos.</h4>
        <input type="hidden" name="codigo" value="<?php echo $datos['codigo']; ?>">
        <label for="cedula">Cedula:</label>
        <input class="controls" type="text" name="cedula" id="cedula" placeholder="Ingrese su cedula" value="<?php echo $datos['cedula']; ?>"><br>
        <label for="nombre_mascota">Nombre de Mascota:</label>
        <input class="controls" type="text" name="nombre_mascota" id="nombre_mascota" placeholder="Ingrese el nombre es" value="<?php echo $datos['nombre_mascota']; ?>"><br>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input class="controls" type="text" name="fecha_nacimiento" id="fecha_nacimiento"  value="<?php echo $datos['fecha_nacimiento']; ?>"><br>
        <label for="sexo">Sexo:</label>
        <input class="controls" type="text" name="sexo" id="sexo" placeholder=" su sexo" value="<?php echo $datos['sexo']; ?>"><br>
        <label for="especie">Especie:</label>
        <input class="controls" type="text" name="especie" id="especie" placeholder="su especie" value="<?php echo $datos['especie']; ?>"><br>
        <label for="raza">Raza:</label>
        <input class="controls" type="text" name="raza" id="raza" placeholder="su raza" value="<?php echo $datos['raza']; ?>"><br>
        <label for="color">Color:</label>
        <input class="controls" type="text" name="color" id="color" placeholder="su color" value="<?php echo $datos['color']; ?>"><br>
        <label for="peso">Peso:</label>
        <input class="controls" type="text" name="peso" id="peso" placeholder="su peso" value="<?php echo $datos['peso']; ?>"><br>
        <input type="submit" value="Actualizar">
    </form>

</body>
</html>
