// procesar_vuelo.php
<?php
include 'conectar.php';

echo "<link rel='stylesheet' href='styles.css'>";
echo "<div class='container'>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $fecha = $_POST['fecha'];
    $plazas = $_POST['plazas'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssid", $origen, $destino, $fecha, $plazas, $precio);

    if ($stmt->execute()) {
        echo "<p>Vuelo registrado con éxito</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();

echo "<a href='index.html' class='btn-rojo'>Regresar al Inicio</a>";
echo "</div>";
?>
