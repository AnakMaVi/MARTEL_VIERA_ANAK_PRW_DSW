<?php
session_start();
include_once 'BD_conection.php';

// Función para obtener una sala por su ID
function getClassroomById($conn, $classroomId) {
    $sql = "SELECT * FROM sala WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $classroomId);
    $stmt->execute();
    $result = $stmt->get_result();

    $classroom = null;
    if ($result->num_rows == 1) {
        $classroom = $result->fetch_assoc();
    }
    $stmt->close();
    return $classroom;
}

// Manejo de la solicitud GET para obtener una sala por su ID
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase();
    $classroomId = $_GET['id'];

    $classroom = getClassroomById($conn, $classroomId);
    
    header('Content-Type: application/json');
    if ($classroom) {
        // Guarda la información de la sala en la sesión
        $_SESSION['id_sala'] = $_GET['id'];
        $_SESSION['titulo'] = $classroom['Titulo_Clase'];
        $_SESSION['profesor']= $classroom['ID_USER_PROFESOR'];
        // echo json_encode($classroom);
        header("HTTP/1.1 201 Created");
            echo json_encode(array("message" => "Sala encontrada", "url" => "Dudas_classroom.php"));
    } else {
        echo json_encode(array("message" => "Sala no encontrada"));
    }

    $conn->close();
}
