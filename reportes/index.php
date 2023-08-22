<?php
session_start();
if (isset($_SESSION['dola'])) {
    $valor = $_SESSION['dola'];
}
?>

<?php
require('fpdf/fpdf.php'); // Asegúrate de que el archivo FPDF está en el mismo directorio o ajusta la ruta si es necesario
// Crear la clase extendiendo FPDF
class PDF extends FPDF {
    function Header() {
        // Encabezado del PDF
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Historial de Mascotas', 0, 1, 'C');
        
    }

    function Footer() {
        // Pie de página del PDF
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function imprimirDato($datos) {
        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(200, 220, 255); // Color de fondo para las celdas de encabezado
        $this->SetTextColor(0); // Color del texto para las celdas de encabezado
    
        // Encabezado de la tabla
        $this->Cell(15, 10, 'Codigo', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Fecha Historial', 1, 0, 'C', true);
        $this->Cell(20, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Fecha Nacimiento', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Diagnostico', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Receta', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Tratamiento', 1, 1, 'C', true); // Salto de línea después de la última celda del encabezado
    
        $this->SetFillColor(255); // Restaurar el color de fondo predeterminado
        $this->SetTextColor(0); // Restaurar el color de texto predeterminado
    
        // Datos de la tabla
        foreach ($datos as $row) {
            $this->Cell(15, 30, $row['cod_mas'], 1, 0, 'C');
            $this->Cell(30, 30, $row['fecha_his'], 1, 0, 'C');
            $this->Cell(20, 30, $row['nombre_mas'], 1, 0, 'C');
            $this->Cell(30, 30, $row['fecha_na'], 1, 0, 'C');
            $this->Cell(30, 30, $row['diagnostico'], 1, 0, 'C');
            $this->Cell(30, 30, $row['receta'], 1, 0, 'C');
            $this->Cell(30, 30, $row['tratamiento'], 1, 1, 'C'); // Salto de línea después de la última celda de la fila
        }
    }
}

// Crear el objeto PDF
$pdf = new PDF();
$pdf->AddPage();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "veterinaria_cli";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "SELECT h.cod_mas, h.fecha_his, m.nombre_mas, m.fecha_na, h.diagnostico, h.receta, h.tratamiento
FROM historial h
INNER JOIN mascota m ON h.cod_mas = m.cod_mas
WHERE $valor = h.cod_mas";

$result = $conn->query($query);
$datos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
}

$conn->close();

// Imprimir datos en el PDF
$pdf->imprimirDato($datos);

// Salida del PDF
$pdf->Output();
?>
