<?php
include_once 'BD_conection.php';

// Función para crear una nueva petición
function createPetition($conn,$ID_USER,$ID_Sala,  $titulo, $descripcion) {
    $sql = "INSERT INTO petición (ID_User ,ID_Sala ,Titulo_Peticion, Descripcion) VALUES (?,?,?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        return false;
    }

    $stmt->bind_param("iiss",$ID_USER,$ID_Sala, $titulo, $descripcion);
    if ($stmt->execute()) {
        $lastInsertedId = $stmt->insert_id;
        $stmt->close();
        return $lastInsertedId;
    } else {
        $stmt->close();
        return false;
    }
}

// Manejo de la solicitud GET para crear una petición
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase();
    $ID_USER= $_GET['ID_User'];
    $ID_Sala = $_GET['ID_Sala'];
    $titulo = $_GET['Titulo_Peticion'];
    $descripcion = $_GET['Descripcion'];

    $result = createPetition($conn,$ID_USER,$ID_Sala, $titulo, $descripcion);

    if ($result) {
        header("HTTP/1.1 201 Created");
        echo json_encode(array("message" => "Petición creada con éxito", "id" => $result));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al crear la petición"));
    }

    $conn->close();
}
?>
