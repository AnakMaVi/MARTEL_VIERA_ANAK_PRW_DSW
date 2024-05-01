<?php
include_once 'BD_conection.php';

// Función para obtener todas las peticiones
function getAllPetitions($conn) {
    $sql = "SELECT * FROM petición";
    $result = $conn->query($sql);

    $petitions = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $petitions[] = $row;
        }
    }
    return $petitions;
}

// Manejo de la solicitud GET para obtener todas las peticiones
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase();
    $petitions = getAllPetitions($conn);

    header('Content-Type: application/json');
    echo json_encode($petitions);

    $conn->close();
}
?>
