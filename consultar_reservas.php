// consultar_reservas.php
<?php
include 'conectar.php';

echo "<link rel='stylesheet' href='styles.css'>";
echo "<div class='container'>";

// Función para verificar si una tabla está vacía
function isTableEmpty($conn, $tableName) {
    $result = $conn->query("SELECT 1 FROM $tableName LIMIT 1");
    return $result->num_rows == 0;
}

// Verificar si las tablas VUELO y HOTEL están vacías
if (isTableEmpty($conn, 'VUELO') || isTableEmpty($conn, 'HOTEL')) {
    echo "<p>Las tablas VUELO o HOTEL están vacías. Por favor, inserte algunos datos primero.</p>";
    $conn->close();
    echo "<div class='align-right'><a href='index.html' class='btn-rojo'>Regresar al Inicio</a></div>";
    echo "</div>";
    exit;
}

// Obtener IDs existentes de VUELO y HOTEL
$vuelos = $conn->query("SELECT id_vuelo FROM VUELO")->fetch_all(MYSQLI_ASSOC);
$hoteles = $conn->query("SELECT id_hotel FROM HOTEL")->fetch_all(MYSQLI_ASSOC);

if ($vuelos && $hoteles) {
    echo "<p>Vuelo y Hotel IDs obtenidos con éxito.</p>";
} else {
    echo "<p>Error al obtener IDs de Vuelo y Hotel.</p>";
}

// Insertar 10 reservas de ejemplo si la tabla RESERVA está vacía
if (isTableEmpty($conn, 'RESERVA')) {
    echo "<h2>Insertando reservas de ejemplo...</h2>";
    for ($i = 1; $i <= 10; $i++) {
        $id_cliente = rand(1, 100);
        $id_vuelo = $vuelos[array_rand($vuelos)]['id_vuelo'];
        $id_hotel = $hoteles[array_rand($hoteles)]['id_hotel'];
        
        $sql = "INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) 
                VALUES (?, CURDATE(), ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $id_cliente, $id_vuelo, $id_hotel);
        
        if ($stmt->execute()) {
            echo "Reserva $i insertada con éxito.<br>";
        } else {
            echo "Error al insertar reserva $i: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
    echo "<hr>";
}

// Mostrar todas las reservas
$sql = "SELECT * FROM RESERVA";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Todas las Reservas</h2>";
    echo "<table><tr><th>ID Reserva</th><th>ID Cliente</th><th>Fecha Reserva</th><th>ID Vuelo</th><th>ID Hotel</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id_reserva"]."</td><td>".$row["id_cliente"]."</td><td>".$row["fecha_reserva"]."</td><td>".$row["id_vuelo"]."</td><td>".$row["id_hotel"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>0 resultados en la tabla RESERVA</p>";
}

// Consulta avanzada: Hoteles con más de dos reservas
$sql = "SELECT h.id_hotel, h.nombre, COUNT(r.id_reserva) as num_reservas 
        FROM HOTEL h 
        LEFT JOIN RESERVA r ON h.id_hotel = r.id_hotel 
        GROUP BY h.id_hotel 
        HAVING num_reservas > 2";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Hoteles con más de dos reservas</h2>";
    echo "<table><tr><th>ID Hotel</th><th>Nombre</th><th>Número de Reservas</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id_hotel"]."</td><td>".$row["nombre"]."</td><td>".$row["num_reservas"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay hoteles con más de dos reservas</p>";
}

$conn->close();

echo "<div class='align-right'><a href='index.html' class='btn-rojo'>Regresar al Inicio</a></div>";
echo "</div>";
?>
