<?php
session_start();
include_once 'BD_conection.php';

// Función para crear una nueva sala
function createClassroom($conn,$ID_USER_PROFESOR, $tituloClase, $idPeticion) {
    $sql = "INSERT INTO sala (ID_USER_PROFESOR,titulo_clase, id_peticion) VALUES (?,?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        return null;
    }

    $stmt->bind_param("isi", $ID_USER_PROFESOR,$tituloClase, $idPeticion);
    if ($stmt->execute()) {
        $lastInsertedId = $stmt->insert_id;
        $stmt->close();
        return $lastInsertedId;
    } else {
        $stmt->close();
        return null;
    }
}

// Manejo de la solicitud POST para crear una sala
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase();
    $ID_USER_PROFESOR= $_GET['ID_USER_PROFESOR'];
    $tituloClase = $_GET['titulo'];
    $idPeticion = null;

    $result = createClassroom($conn, $ID_USER_PROFESOR,$tituloClase, $idPeticion);

    if ($result) {
        $_SESSION['ID_USER_PROFESOR'] = $ID_USER_PROFESOR;
        $_SESSION['id_sala'] = $result; 
        $_SESSION['titulo'] = $tituloClase;// Sobrescribe la sesión id_sala con el ID de la nueva sala
        setcookie('classroomId',$result, time() + (86400 * 30), "/"); // Create a cookie named 'classroomId' with the value of $result
        header("HTTP/1.1 201 Created");
        echo json_encode(array("message" => "Sala creada con éxito", "id" => $result));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al crear la sala"));
    }

    $conn->close();
}
?>