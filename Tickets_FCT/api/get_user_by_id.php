<?php
include_once 'BD_conection.php'; // Asegurar la correcta inclusión de la conexión a la base de datos

// Función para obtener un usuario por su ID
function getUserById($conn, $userId) {
    $sql = "SELECT * FROM users WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = null;
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    }
    return $user;
}

// Manejo de la solicitud GET para obtener un usuario por su ID
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase();
    $userId = $_GET['id'];

    $user = getUserById($conn, $userId);
    
    header('Content-Type: application/json');
    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(array("message" => "Usuario no encontrado"));
    }

    $conn->close();
}
?>
