<?php
include_once 'BD_conection.php'; // Ajustar el nombre según la configuración de conexión real

// Función para obtener todos los usuarios
function getAllUsers($conn) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $users = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Manejo de la solicitud GET para obtener todos los usuarios
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase(); // Asegúrate de tener esta función en 'BD_conection.php'
    $users = getAllUsers($conn);

    header('Content-Type: application/json');
    echo json_encode($users);

    $conn->close();
}
?>
