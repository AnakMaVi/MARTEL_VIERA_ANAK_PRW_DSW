<?php
include_once 'BD_conection.php';

// Función para actualizar una petición
function updatePetition($conn, $id, $titulo, $descripcion) {
    $sql = "UPDATE petición SET Titulo_Peticion = ?, Descripcion = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $titulo, $descripcion, $id);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

// Manejo de la solicitud PUT para actualizar una petición
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $putData);
    $id = $_GET['id'];
    $titulo = $_GET['titulo'];
    $descripcion = $_GET['descripcion'];

    $conn = connectToDatabase();
    $success = updatePetition($conn, $id, $titulo, $descripcion);

    if ($success) {
        header("HTTP/1.1 200 OK");
        echo json_encode(array("message" => "Petición actualizada con éxito"));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al actualizar la petición"));
    }

    $conn->close();
}
?>
