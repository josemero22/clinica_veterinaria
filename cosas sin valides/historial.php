<?php
$selectedMascotaInfo = array();

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
        $sql_mascotas = "SELECT p.cedula, p.nombre AS nombreCliente, p.apellido AS apellidoCliente, m.cod_mas, m.nombre_mas AS nombreMascota, m.raza AS razaMascota 
                         FROM persona p
                         INNER JOIN mascota m ON p.cedula = m.cedula
                         WHERE p.cedula = '$numce'";
        $result_mascotas = $conn->query($sql_mascotas);

        if ($result_mascotas->num_rows > 0) {
            $selectedMascotaInfo = $result_mascotas->fetch_all(MYSQLI_ASSOC);
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Historiales de Mascotas</title>
  <!-- Incluir archivo CSS de Bootstrap desde CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/stilo.css">
</head>
<body>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/clinica_veterinaria/index.html">Inicio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <!-- ... (otros elementos del menú) ... -->
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Contenido del formulario -->
<div class="container mt-5">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-body">
          <h4>Buscador</h4>
          <form method="get">
            <label for="numce" class="form-label">Numero de cedula</label>
            <input type="text" class="form-control" id="numce" name="numce" required><br>
            <input type="submit" class="form-control" value="Buscar">
            <br>
          </form>

          <?php if (!empty($selectedMascotaInfo)) { ?>
          <div class="mt-4">
          
            <form method="get">
              <label for="mascota" class="form-label">Selecciona una mascota:</label>
              <select class="form-control" id="mascota" name="mascota" required>
                <?php foreach ($selectedMascotaInfo as $mascota) { ?>
                <option value="<?php echo $mascota['cod_mas']; ?>"><?php echo $mascota['nombreMascota']; ?></option>
                <?php } ?>
              </select>
              <input type="submit" class="form-control mt-2" value="Mostrar Información">
            </form>

            <?php
            $mascotaInfo = reset($selectedMascotaInfo);
            if (!empty($mascotaInfo)) {
            ?>
            <div class="row mt-3">
              <div class="col-md-6">
                <label for="nombreMascota" class="form-label">Nombre de Mascota</label>
                <div class="form-control" id="nombreMascota" name="nombreMascota"><?php echo $mascotaInfo['nombreMascota']; ?></div>
              </div>
              <div class="col-md-6">
                <label for="razaMascota" class="form-label">Raza de Mascota</label>
                <div class="form-control" id="razaMascota" name="razaMascota"><?php echo $mascotaInfo['razaMascota']; ?></div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6">
                <label for="nombreCliente" class="form-label">Nombre de Cliente</label>
                <div class="form-control" id="nombreCliente" name="nombreCliente"><?php echo $mascotaInfo['nombreCliente']; ?></div>
              </div>
              <div class="col-md-6">
                <label for="apellidoCliente" class="form-label">Apellido de Cliente</label>
                <div class="form-control" id="apellidoCliente" name="apellidoCliente"><?php echo $mascotaInfo['apellidoCliente']; ?></div>
              </div>
            </div>
            <?php } ?>
          </div>
          <?php } ?>

          <!-- Información del Historial -->
          <h4 class="mt-4">Información del Historial</h4>
          <form action="php/registro.php" method="post">
<div class="row">
  <div class="col-md-6">
    <label for="codigohistorial" class="form-label">Código de Historial</label>
    <input type="text" class="form-control" id="codigohistorial" name="codigohistorial" required>
  </div>
  <div class="col-md-6">
    <label for="codigomas" class="form-label">Código Mascota</label>
    <input type="text" class="form-control" id="codigomas" name="codigomas" value="<?php echo isset($_GET['mascota']) ? $_GET['mascota'] : ''; ?>" required readonly>
  </div>
</div>
<div class="row mt-3">
  <div class="col-md-6">
    <label for="fechanacimiento" class="form-label">Fecha del historial</label>
    <input type="text" class="form-control" id="fechanacimiento" name="fechanacimiento" required>
  </div>
  <!-- ... (otros campos del formulario) ... -->
</div>
<!-- Botón de registro -->
<button type="submit" class="btn btn-primary mt-3">Registrar</button>
</form>
</div>
</div>
</div>
</div>
</div>

<!-- Incluir archivos JS de Bootstrap desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
