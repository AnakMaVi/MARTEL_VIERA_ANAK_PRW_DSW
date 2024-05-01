<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="validatecookie.js"></script>

    <title>Salas</title>
    <style>/* Contenedor de las tarjetas para salas */
#classroomsContainer {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-around;
    margin: 20px;
}

/* Estilo individual de las tarjetas de las salas */
.card {
   
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    width: 400px;
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

@media (max-width: 768px) {
    .card {
        width: calc(50% - 40px);
    }
}

@media (max-width: 480px) {
    .card {
        width: 100%;
    }
}


    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<button id="backButton">Volver Atrás</button>
<script>
    document.getElementById('backButton').addEventListener('click', function() {
        window.history.back();
    });
</script>

<button id="logoutButton">Logout</button>

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
    <h1>Salas</h1>
    <div id="classroomsContainer"></div>

    <table id="petitionTable">
        <!-- Tus filas y celdas irán aquí -->
    </table>

    <script>
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
        var ID= <?php echo json_encode($cookieId); ?>;
    var url = `http://localhost/TICKETS_FCT/api/get_classroom_by_id_user_profesor.php?id=${ID}` ;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            var classroomsContainer = document.getElementById('classroomsContainer');
            if (data.message === "Salas encontradas") {
                data.data.forEach(function(classroom) {
                    var card = document.createElement('div');
                    card.className = 'card';
                    card.innerHTML = '<h2>' + classroom.Titulo_Clase + '</h2>' +
                        '<p>ID de la sala: ' + classroom.ID  + '</p>' +
                        '<button class="deleteButton">Eliminar</button>' +
                        '<button class="editButton">Editar</button>'; // Agrega esta línea

                    classroomsContainer.appendChild(card);

                    card.querySelector('.deleteButton').addEventListener('click', function(e) {
                        e.stopPropagation(); // Evita que se active el evento click de la tarjeta

                        var url = `http://localhost/TICKETS_FCT/api/delete_classroom.php?ID=${classroom.ID}`;

                        fetch(url, {
                            method: 'DELETE',
                        })
                            .then(response => {
                                if (!response.ok || response.status === 204) {
                                    throw new Error('No content');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.message === 'Sala eliminada') {
                                    card.remove();
                                } else {
                                    alert('Error al eliminar la sala');
                                }
                            })
                            .catch(error => {
                                if (error.message === 'No content') {
                                    card.remove();
                                } else {
                                    console.error('Error:', error);
                                }
                            });
                    });

                    card.querySelector('.editButton').addEventListener('click', function(e) {
                        e.stopPropagation(); // Evita que se active el evento click de la tarjeta

                       
                        window.location.href = `http://localhost/TICKETS_FCT/html/edit_classroom.php?ID=${classroom.ID}&titulo=${classroom.Titulo_Clase}`;
                       
                    });

                    card.addEventListener('click', function() {
                        var url = 'http://localhost/TICKETS_FCT/api/get_classroom_by_id.php?id=' + classroom.ID;

                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                document.cookie = `classroomId=${classroom.ID}; path=/`;
                                window.location.href = 'Dudas_classroom.php';
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });
            } else {
                classroomsContainer.innerHTML = '<p>No se encontró ninguna sala.</p>';
            }
        })
        .catch(error => console.error('Error:', error));
</script>
</body>
</html>