<?php
include 'conectar.php';

echo "<link rel='stylesheet' href='styles.css'>";
echo "<div class='container'>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones = $_POST['habitaciones'];
    $tarifa = $_POST['tarifa'];

    $sql = "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssid", $nombre, $ubicacion, $habitaciones, $tarifa);

    if ($stmt->execute()) {
        echo "<p>Hotel registrado con éxito</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();

echo "<a href='index.html' class='btn-rojo'>Regresar al Inicio</a>";
echo "</div>";
?>