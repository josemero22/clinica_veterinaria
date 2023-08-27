<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/clinica_veterinaria/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.15/jspdf.plugin.autotable.js"></script>

    <title>Tabla de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="n.cedula"] {
            padding: 5px;            width: 200px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 8px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }
    </style>    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const numceValue = "<?php echo isset($_GET['numce']) ? $_GET['numce'] : ''; ?>";
        document.getElementById("n_cedula").value = numceValue;
});
 
</script>

</head>
<body>
    <!-- Encabezado -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/clinica_veterinaria/index.html">Inicio</a>
            
        <a class="navbar-brand" href="/clinica_veterinaria/cliente.html">Registrar Persona</a>
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
    <br>
    <h1>CONSULTAR HISTORIAL</h1>
  

    <form method="post">
        <label for="n_cedula">N.cedula:</label>
        <input type="text" id="n_cedula" name="n_cedula" required>
        <input type="submit" value="Consultar">
    </form>
    <?php
      session_start();
    function consultarPorCedula($cedula) {
        // Conexión a la base de datos (debes completar los detalles de la conexión)
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "veterinaria_cli";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $verificarQuery = "SELECT * FROM mascota WHERE cedula = ?";
        $verificarStmt = $conn->prepare($verificarQuery);
        $verificarStmt->bind_param("s", $cedula);
        $verificarStmt->execute();
        $verificarResult = $verificarStmt->get_result();

        if ($verificarResult->num_rows > 0) {  
                $mascotas = array();  // Array para almacenar nombres de mascotas únicos
                // Llenar el array con nombres de mascotas únicos
                while ($row = $verificarResult->fetch_assoc()) {
                    $mascotas[$row["cod_mas"]] = $row["nombre_mas"];
                }
                echo "<form method='post'>";
                echo "<label for='select_mascota'>Selecciona una mascota:</label>";
                echo "<select id='select_mascota' name='select_mascota'>";
                foreach ($mascotas as $cod => $nombre) {
                    echo "<option value='$cod'>$nombre</option>";
                }
                echo "</select> ";
                echo "<input type='submit' value='Mostrar Historial'>";
                echo "</form>"; 
            } else {
                echo "No se encontraron resultados para la cédula proporcionada.";
            }
        $verificarStmt->close();
        
    }

    function mostrarHistorialMascota($cod_mas) {
    // Conexión a la base de datos (debes completar los detalles de la conexión)
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "veterinaria_cli";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "SELECT h.receta
              FROM historial h
              INNER JOIN mascota m ON h.cod_mas = m.cod_mas
              WHERE h.cod_mas = ?";
              

            
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $cod_mas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table border='1'>
            <tr>           
                <th>Receta</th>         
            </tr>";
        $row = $result->fetch_assoc();  // Obtener el primer resultado
        echo "<tr>";            
        echo "<td>" . $row["receta"] . "</td>";          
        echo "</tr>";
        echo "</table>";
        ?>
        <a class="btn btn-primary mt-2" href="/clinica_veterinaria/reportes/index.php" target="_blank">IMPRIMIR PDF</a>
        <?php
    } else {
        echo "No se encontraron resultados para la mascota seleccionada.";
    }      
    $stmt->close();
}


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['n_cedula'])) {
            $cedula = $_POST['n_cedula'];
            consultarPorCedula($cedula);
        } else {
            echo "Por favor, ingresa una cédula.";
        }

        if (isset($_POST['select_mascota'])) {
            $cod_mas = $_POST['select_mascota'];
            mostrarHistorialMascota($cod_mas);
            $_SESSION['dola'] = $cod_mas;
        }
       
    }
    
 ?>
</body>
</html>
