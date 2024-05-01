<?php
include 'BD_conection.php';
// Función para crear un nuevo usuario<?php
function loginUser($conn, $data) {
    $sql = "SELECT * FROM users WHERE NOMBRE = ? AND PASSWORD = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        return false;
    }

    // Suponiendo que la contraseña debe ser hasheada
    $hashedPassword =$data['PASSWORD'];

    $stmt->bind_param("ss", $data['NOMBRE'], $hashedPassword);
   

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function createToken($conn, $username, $hashedPassword) {
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
    
    // Actualizar el token en la tabla users
    $sql = "UPDATE users SET TOKEN = ? WHERE NOMBRE = ? AND PASSWORD = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $newToken, $username, $hashedPassword);
    $stmt->execute();
    $stmt->close();
    
    // Devolver el nuevo token generado
    return $newToken;
}


function getTokenforUser($conn, $username, $hashedPassword) {
    // Primero, obtén el token del usuario
    $sql = "SELECT TOKEN FROM users WHERE NOMBRE = ? AND PASSWORD = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        return false;
    }

    $stmt->bind_param("ss", $username, $hashedPassword);
    $executeSuccess = $stmt->execute();

    if ($executeSuccess) {
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            // Si se encontró un usuario, obtén el token
            $user = $result->fetch_assoc();
            $token = $user['TOKEN'];

            // Ahora, obtén la fecha de caducidad del token
            $sql = "SELECT EXPIRED_DATE FROM token WHERE TOKEN = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                error_log("Error al preparar la consulta: " . $conn->error);
                return false;
            }

            $stmt->bind_param("s", $token);
            $executeSuccess = $stmt->execute();

            if ($executeSuccess) {
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows > 0) {
                    // Si se encontró un token, obtén la fecha de caducidad
                    $tokenData = $result->fetch_assoc();
                    return array(
                        'token' => $token,
                        'expiration_date' => $tokenData['EXPIRED_DATE']
                    );
                }
            }
        }
    }

    return false;
}
function getUserTypeAndToken($conn, $username, $hashedPassword) {
    $sql = "SELECT TIPO, ID , TOKEN FROM users WHERE NOMBRE = ? AND PASSWORD = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        return false;
    }

    $stmt->bind_param("ss", $username, $hashedPassword);
    $executeSuccess = $stmt->execute();

    if ($executeSuccess) {
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            // Si se encontró un usuario, retorna el tipo de usuario y el token
            $user = $result->fetch_assoc();
            return array(
                'userType' => $user['TIPO'],
                'token' => $user['TOKEN'],
                'id' => $user['ID'],
            );
        } else {
            // Si no se encontró un usuario, retorna false
            return false;
        }
    } else {
        $stmt->close();
        return false;
    }
}


// Manejo de la solicitud POST para crear un usuario
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = connectToDatabase(); // Asegúrate de tener esta función en 'BD_conection.php'
    $userData = array(
        'NOMBRE' => $_GET['NOMBRE'],
       
        'PASSWORD' => $_GET['PASSWORD'],
        
    );

    $result = loginUser($conn, $userData);

    
    if ($result) {
        $userDetails = getUserTypeAndToken($conn, $userData['NOMBRE'], $userData['PASSWORD']);
        $TokenDetails= getTokenforUser($conn, $userData['NOMBRE'], $userData['PASSWORD']);
        
        if($userDetails ) {
            setcookie("id", $userDetails['id'], time() + (86400 * 30), "/");
            setcookie("tipo", $userDetails['userType'], time() + (86400 * 30), "/");
            setcookie("token", $userDetails['token'], time() + (86400 * 30), "/");
            $redirectUrl = $userDetails['userType'] === 'profesor' ? 'profesor_home.html' : 'alumno_home.html';
            if ($TokenDetails) {
                // Comprueba si el token ha caducado
                $expirationDate = DateTime::createFromFormat('d/m/Y', $TokenDetails['expiration_date']);
                if (new DateTime() < $expirationDate) {
                    setcookie("token", $userDetails['token'], time() + (86400 * 30), "/");
                } else {
                    $newToken = createToken($conn, $userData['NOMBRE'], $userData['PASSWORD']);
                    setcookie("token", $newToken['TOKEN'], time() + (86400 * 30), "/");
                }
            header("HTTP/1.1 201 Created");
            echo json_encode(array("message" => "Login correcto", "id" => $result, "url" => $redirectUrl));
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("message" => "Error al crear usuario"));
        }
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Error al crear usuario"));
    }
    
    $conn->close();
    
}

}

