<?php
// include 'BD_conection.php'; // Ajustar el nombre según la configuración de conexión real

// Función para crear un nuevo usuario
function createUser($conn, $data) {
    $sql = "INSERT INTO users (TOKEN,NOMBRE, SITIOCLASE, PASSWORD, TIPO) VALUES (?,?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        return false;
    }

    // Suponiendo que la contraseña debe ser hasheada
    $hashedPassword = $data['PASSWORD'];

    $stmt->bind_param("sssss",$data['TOKEN'], $data['NOMBRE'], $data['SITIOCLASE'], $hashedPassword, $data['TIPO']);
    $executeSuccess = $stmt->execute();

    if ($executeSuccess) {
        $lastInsertedId = $stmt->insert_id;
        $stmt->close();
        return $lastInsertedId;
    } else {
        $stmt->close();
        return false;
    }
}

// Manejo de la solicitud POST para crear un usuario
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase(); // Asegúrate de tener esta función en 'BD_conection.php'
    $userData = array(
        'TOKEN' => createToken($conn),
        'NOMBRE' => $_GET['NOMBRE'],
        'SITIOCLASE' => $_GET['SITIOCLASE'],
        'PASSWORD' => $_GET['PASSWORD'],
        'TIPO' => $_GET['TIPO']
    );

    $result = createUser($conn, $userData);

    if ($result) {
        header("HTTP/1.1 201 Created");
        echo json_encode(array("message" => "Usuario creado con éxito", "id" => $result));
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al crear usuario"));
    }

    $conn->close();
}

function connectToDatabase() {
    $servername = "localhost";
    $username = "ANAK"; 
    $password = "1234"; 
    $database = "bd_ticket"; 
    
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
      
        return $conn;
        
    }

    function executeSQLQuery($conn, $sql) {
        $result = $conn->query($sql);
        if ($result === false) {
            die("Error executing SQL query: " . $conn->error);
        }
        return $result;
    }
    
function createToken($conn) {
    // Generar un token alfanumérico
    function generateAlphanumericToken($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $max)];
        }

        return $token;
    }

    // Obtener la fecha actual
    $createdDate = date('d/m/Y');
    // Obtener la fecha de mañana
    $expiredDate = date('d/m/Y', strtotime('+1 day'));
    // Generar el token alfanumérico
    $newToken = generateAlphanumericToken();

    // Preparar y ejecutar la consulta SQL para insertar el nuevo token
    $sql = "INSERT INTO token (TOKEN, CREATED_DATE, EXPIRED_DATE) VALUES (?, ?, ?)";
    $stmt =  $conn->prepare($sql);
    $stmt->bind_param("sss", $newToken, $createdDate, $expiredDate);
    $stmt->execute();
    $stmt->close();
    
    // Devolver el nuevo token generado
    return $newToken;
}

function deleteToken($conn, $tokenId) {
    // Preparar y ejecutar la consulta SQL para eliminar el token
    $sql = "DELETE FROM token WHERE TOKEN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tokenId);
    $stmt->execute();
    $stmt->close();
}
?>
