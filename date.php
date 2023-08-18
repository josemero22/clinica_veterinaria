<?php
date_default_timezone_set('America/Mexico_City');
?>
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
// ... (código anterior)

if (isset($_GET['mascota'])) {
  $codigoMascotaSeleccionada = $_GET['mascota'];
  $informacionMascotaSeleccionada = array();  // Inicializar el arreglo para almacenar la información de la mascota seleccionada

  // Obtener la información de la mascota seleccionada utilizando una consulta (similar a obtener la lista de mascotas)
  $sql_selected_mascota = "SELECT m.cod_mas, m.nombre_mas AS nombreMascota, m.raza AS razaMascota, p.nombre AS nombreCliente, p.apellido AS apellidoCliente 
                           FROM mascota m
                           INNER JOIN persona p ON m.cedula = p.cedula
                           WHERE m.cod_mas = '$codigoMascotaSeleccionada'";
  
  $result_selected_mascota = $conn->query($sql_selected_mascota);

  if ($result_selected_mascota->num_rows > 0) {
      $informacionMascotaSeleccionada = $result_selected_mascota->fetch_assoc();
  }
}
    ?>
     <?php if (!empty($informacionMascotaSeleccionada)) {?>
    <div class="row mt-3">
        <div class="col-md-6">
            <label for="nombreMascota" class="form-label">Nombre de la Mascota</label>
            <div class="form-control" id="nombreMascota" name="nombreMascota"><?php echo $informacionMascotaSeleccionada['nombreMascota']; ?></div>
        </div>
        <div class="col-md-6">
            <label for="razaMascota" class="form-label">Raza de la Mascota</label>
            <div class="form-control" id="razaMascota" name="razaMascota"><?php echo $informacionMascotaSeleccionada['razaMascota']; ?></div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <label for="nombreCliente" class="form-label">Nombre del Cliente</label>
            <div class="form-control" id="nombreCliente" name="nombreCliente"><?php echo $informacionMascotaSeleccionada['nombreCliente']; ?></div>
        </div>
        <div class="col-md-6">
            <label for="apellidoCliente" class="form-label">Apellido del Cliente</label>
            <div class="form-control" id="apellidoCliente" name="apellidoCliente"><?php echo $informacionMascotaSeleccionada['apellidoCliente']; ?></div>
        </div>
    </div>
    <?php } ?>
</div>
          <!-- Información del Historial -->
          <h4 class="mt-4">Registro Historial</h4>
          <form action="php/registro.php" method="post">
<div class="row">
  <div class="col-md-6">
    <label for="codigohistorial" class="form-label"></label>
    <input type="hidden" class="form-control" id="codigohistorial" name="codigohistorial" required>
  </div>
  <div class="col-md-6">
    <label for="codigomas" class="form-label">Código Mascota</label>
    <input type="text" class="form-control" id="codigomas" name="codigomas" value="<?php echo isset($_GET['mascota']) ? $_GET['mascota'] : ''; ?>" required readonly>
  </div>
</div>
<div class="row mt-3">
  <div class="col-md-6">
    <label for="fechanacimiento" class="form-label">Fecha del historial</label>
    <input type="text" class="form-control" id="fechanacimiento" name="fechanacimiento" value="<?php echo date('d-m-Y'); ?>" required>
  </div>
</div>

            <div class="row mt-3">
              <div class="col-md-12">
                <label for="diagnostico" class="form-label">Diagnóstico</label>
                <input class="form-control" type="text" id="diagnostico" name="diagnostico" required>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <label for="receta" class="form-label">Receta</label>
                <input type="text" class="form-control" id="receta" name="receta" required>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-md-12">
                <label for="tratamiento" class="form-label">Tratamiento</label>
                <input type="text" class="form-control" id="tratamiento" name="tratamiento" required>
              </div>
            </div>
  <!-- ... (otros campos del formulario) ... -->
</div>
<!-- Botón de registro -->
<button type="submit" class="btn btn-primary mt-3">Registrar</button>
</form>
<a href=""><button type="submit" class="btn btn-primary mt-3">Historial</button></a>
</div>
</div>
</div>
</div>
</div>
<!-- Incluir archivos JS de Bootstrap desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
