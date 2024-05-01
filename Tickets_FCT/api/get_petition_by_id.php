<?php
include_once 'BD_conection.php';

// Función para obtener una petición por su ID

function getPetitionByIdSala($conn, $petitionId) {
    $sql = "SELECT * FROM petición WHERE ID_Sala = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petitionId);
    $stmt->execute();
    $result = $stmt->get_result();

    $petitions = array();
    while ($row = $result->fetch_assoc()) {
        $petitions[] = $row;
    }
    $stmt->close();
    return $petitions;
}


// Manejo de la solicitud GET para obtener una petición por su ID

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase();
    $petitionId = $_GET['ID'];

    $petitions = getPetitionByIdSala($conn, $petitionId);
    
    header('Content-Type: application/json');
    if (count($petitions) > 0) {
        echo json_encode($petitions);
    } else {
        echo json_encode(array("message" => "Petición no encontrada"));
    }

    $conn->close();
}
?>

