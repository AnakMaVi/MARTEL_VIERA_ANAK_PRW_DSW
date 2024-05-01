<?php
include_once 'BD_conection.php'; // Incluir la conexión a la base de datos

// Función para eliminar un usuario

function deleteUser($conn, $userId) {
    
    $sql = "DELETE FROM sala WHERE ID_Peticion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $sql = "DELETE FROM users WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Manejo de la solicitud DELETE para eliminar un usuario
if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $userId = $_GET['ID'];

    $conn = connectToDatabase();
    $success = deleteUser($conn, $userId);

    if ($success) {
        header("HTTP/1.1 204 No Content");
        echo json_encode(array("message" => "Usuario eliminado con éxito"));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al eliminar usuario"));
    }

    $conn->close();
}
?>
