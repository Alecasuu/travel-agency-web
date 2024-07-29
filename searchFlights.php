<?php
function searchFlights($origin, $destination, $departureDate) {
    $db = new mysqli('localhost', 'user', 'password', 'database');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $sql = "SELECT * FROM flights WHERE origin = ? AND destination = ? AND departure_date = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sss", $origin, $destination, $departureDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $flights = [];
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }

    $stmt->close();
    $db->close();

    return $flights;
}
?>
