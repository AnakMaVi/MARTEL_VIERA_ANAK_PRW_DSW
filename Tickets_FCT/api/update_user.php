<?php
include_once 'BD_conection.php'; // Incluir la conexión a la base de datos

// Función para actualizar un usuario
function updateUser($conn, $userId, $userData) {
    $updates = "";
    foreach ($userData as $key => $value) {
        $updates .= "$key = '$value', ";
    }
    $updates = rtrim($updates, ", ");
    $sql = "UPDATE users SET $updates WHERE ID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Manejo de la solicitud PUT para actualizar un usuario
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $putData);
    $userId = $_GET['id'];

    $conn = connectToDatabase();
    $success = updateUser($conn, $userId, $putData);

    if ($success) {
        header("HTTP/1.1 200 OK");
        echo json_encode(array("message" => "Usuario actualizado con éxito"));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al actualizar usuario"));
    }

    $conn->close();
}
?>
