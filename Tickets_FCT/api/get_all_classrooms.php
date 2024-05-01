<?php
include_once 'BD_conection.php';

// Función para obtener todas las salas
function getAllClassrooms($conn) {
    $sql = "SELECT * FROM sala";
    $result = $conn->query($sql);

    $classrooms = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $classrooms[] = $row;
        }
    }
    return $classrooms;
}

// Manejo de la solicitud GET para obtener todas las salas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase();
    $classrooms = getAllClassrooms($conn);

    header('Content-Type: application/json');
    echo json_encode($classrooms);

    $conn->close();
}
?>
