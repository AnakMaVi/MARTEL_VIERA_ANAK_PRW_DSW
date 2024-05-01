<?php
session_start();
include_once 'BD_conection.php';

// Función para obtener una sala por su IDfunction getClassroomsByProfessorId($conn, $professorId) {
    function getClassroomsByProfessorId($conn, $professorId) {
    $sql = "SELECT * FROM sala WHERE ID_USER_PROFESOR = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $professorId);
    $stmt->execute();
    $result = $stmt->get_result();

    $classrooms = [];
    while ($row = $result->fetch_assoc()) {
        $classrooms[] = $row;
    }
    $stmt->close();
    return $classrooms;
}

// Manejo de la solicitud GET para obtener las salas por el ID del profesor
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase();
    $professorId = $_GET['id'];

    $classrooms = getClassroomsByProfessorId($conn, $professorId);
    
    header('Content-Type: application/json');
    if ($classrooms) {
        // Guarda la información de las salas en la sesión
       
        // echo json_encode($classrooms);
        header("HTTP/1.1 200 OK");
        echo json_encode(array("message" => "Salas encontradas", "data" => $classrooms));
    } else {
        echo json_encode(array("message" => "No se encontraron salas"));
    }

    $conn->close();
}