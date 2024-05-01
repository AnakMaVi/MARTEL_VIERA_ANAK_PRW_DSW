<?php
include_once 'BD_conection.php';

// Función para eliminar una petición
function deletePetition($conn, $petitionId) {
    $sql = "DELETE FROM petición WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petitionId);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

// Manejo de la solicitud DELETE para eliminar una petición
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $petitionId = $_GET['ID'];

    $conn = connectToDatabase();
    $success = deletePetition($conn, $petitionId);

    if ($success) {
        header("HTTP/1.1 204 No Content");
        echo json_encode(array("message" => "Petición eliminada con éxito"));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al eliminar la petición"));
    }

    $conn->close();
}
?>
