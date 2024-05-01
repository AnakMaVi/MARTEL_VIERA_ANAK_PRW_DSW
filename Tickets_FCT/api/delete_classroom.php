<?php
include_once 'BD_conection.php';

// Función para eliminar una sala
function deleteClassroom($conn, $classroomId) {
    $sql = "DELETE FROM sala WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $classroomId);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

// Manejo de la solicitud DELETE para eliminar una sala
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $classroomId = $_GET['ID'];

    $conn = connectToDatabase();
    $success = deleteClassroom($conn, $classroomId);

    if ($success) {
        header("HTTP/1.1 204 No Content");
        echo json_encode(array("message" => "Sala eliminada con éxito"));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al eliminar la sala"));
    }

    $conn->close();
}
?>
