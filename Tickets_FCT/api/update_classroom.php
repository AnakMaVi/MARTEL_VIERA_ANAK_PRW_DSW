<?php
include_once 'BD_conection.php';

// Función para actualizar una sala
function updateClassroom($conn, $id, $newTitle, $idPetition) {
    $sql = "UPDATE sala SET titulo_clase = ?, id_peticion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $newTitle, $idPetition, $id);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

// Manejo de la solicitud PUT para actualizar una sala
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    
    $id = $_GET['id'];
    $newTitle = $_GET['titulo'];
    $idPetition = null;

    $conn = connectToDatabase();
    $success = updateClassroom($conn, $id, $newTitle, $idPetition);

    if ($success) {
        header("HTTP/1.1 200 OK");
        echo json_encode(array("message" => "Sala actualizada con éxito"));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al actualizar la sala"));
    }

    $conn->close();
}

