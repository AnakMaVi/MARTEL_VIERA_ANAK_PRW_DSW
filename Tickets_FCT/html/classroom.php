<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Petición</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/form_crearduda.css">

    
</head>
<body>
<button id="backButton">Volver Atrás</button>
<script>
    document.getElementById('backButton').addEventListener('click', function() {
        window.history.back();
    });
</script>

    <h1>Clase de <?php echo $_SESSION['titulo'] ?></h1>
    <form id="requestForm">
     
        <label for="requestTitle">Título de la Petición:</label>
        <input type="text" id="requestTitle" name="requestTitle" required>

        <label for="description">Descripción:</label>
        <textarea id="description" name="description" required></textarea>

        <input type="submit" value="Crear Petición">
    </form>
    <button id="logoutButton">Logout</button>
    <script src="validatecookie.js"></script>

<script>
    document.getElementById('logoutButton').addEventListener('click', function() {
        // Eliminar todas las cookies
        var cookies = document.cookie.split(";");

        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }

        // Redirigir a index.html
        window.location.href = 'index.html';
    });
</script>
</body>
<script>
        // Pasa el valor de la sesión a JavaScript
        var sessionId = <?php echo json_encode($_SESSION['id_sala']); ?> ;
        var sessionTitle = <?php echo json_encode($_SESSION['titulo']); ?>;
        <?php
if (isset($_COOKIE['id'])) {
     $cookieId = $_COOKIE['id'];
    // Ahora puedes usar la variable $cookieId
} else {
    // Manejo del caso en que no hay cookie 'id'
    $cookieId = null;
    header("Location: index.html");
    exit;

}
?>



    document.getElementById("requestForm").addEventListener("submit", function (event) {
          event.preventDefault();
        const ID_USER =  <?php echo json_encode($cookieId); ?>;
        const ID_SALA =sessionId;
        const Titulo_Clase= sessionTitle;
        const Titulo_Peticion = document.getElementById("requestTitle").value;
        const Descripcion = document.getElementById("description").value;
        const url = `http://localhost/TICKETS_FCT/api/create_petition.php?ID_User=${ID_USER}&ID_Sala=${ID_SALA}&Titulo_Peticion=${Titulo_Peticion}&Descripcion=${Descripcion}`;
          fetch(url, {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => response.json())
            .then((data) => {
            alert(JSON.stringify(data));
            window.location.href = 'Dudas_classroom.php';
            })
            .catch((error) => console.error("Error:", error));
        });

        
    </script>
</html>