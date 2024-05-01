<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peticiones de la Sala</title>
    <link rel="stylesheet" href="style.css">

</head>
<script src="validatecookie.js"></script>

<body>
<button id="backButton">Volver Atrás</button>
<script>
    document.getElementById('backButton').addEventListener('click', function() {
        window.history.back();
    });
</script>

    <button onclick="location.reload();">Refrescar</button>
    <h1><?php echo $_SESSION['titulo']; ?></h1><br>
    <h3>ID: <?php echo  $_SESSION['id_sala'];?></h3>
    <table id="petitionTable">
        <tr>
            <th>Alumno</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Opciones</th>
        </tr>
    </table>
    <button id="askQuestionButton">Hacer pregunta</button>
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

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        var currentUserId = getCookie('id');
        var currentUserType = getCookie('tipo');

        var url = 'http://localhost/TICKETS_FCT/api/get_petition_by_id.php?ID=' + getCookie('classroomId');

        fetch(url)
            .then(response => response.json())
            .then(data => {
                var petitionTable = document.getElementById('petitionTable');
                if (data.message) {
                    var row = petitionTable.insertRow(-1);
                    var cell = row.insertCell(-1);
                    cell.colSpan = 2;
                    cell.textContent = data.message;
                } else {
                    data.forEach(petition => {
                        var row = petitionTable.insertRow(-1);
                        row.insertCell(-1).textContent = petition.ID_User;
                        row.insertCell(-1).textContent = petition.Titulo_Peticion;
                        row.insertCell(-1).textContent = petition.Descripcion;
                        // Si el ID del usuario de la petición coincide con el ID del usuario actual, añade los botones de "Editar" y "Eliminar"
                        if (petition.ID_User == currentUserId) {
                            var editButton = document.createElement('button');
                            editButton.textContent = 'Editar';
                            editButton.addEventListener('click', function () {
                                // Aquí puedes redirigir al usuario a una página de edición, o abrir un formulario de edición
                                window.location.href = `http://localhost/TICKETS_FCT/html/edit_petition.php?ID=${petition.ID}&Titulo=${petition.Titulo_Peticion}&Descripcion=${petition.Descripcion}`;
                            });
                            row.appendChild(editButton);

                            var deleteButton = document.createElement('button');
                            deleteButton.textContent = 'Eliminar';
                            deleteButton.addEventListener('click', function () {
                                var url = `http://localhost/TICKETS_FCT/api/delete_petition.php?ID=${petition.ID}`;

                                fetch(url, {
                                    method: 'DELETE',
                                })
                                    .then(response => {
                                        // Verifica si la respuesta está vacía
                                        if (!response.ok || response.status === 204) {
                                            throw new Error('No content');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.message === 'Petición eliminada') {
                                            location.reload();
                                        } else {
                                            alert('Error al eliminar la petición');
                                        }
                                    })
                                    .catch(error => {
                                        if (error.message === 'No content') {
                                            // Si la respuesta estaba vacía, elimina la fila de la tabla
                                            row.remove();
                                        } else {
                                            console.error('Error:', error);
                                        }
                                    });
                            });
                            row.appendChild(deleteButton);
                        }

                        // Si el usuario es un profesor, añade el botón de "Resuelta"
                        if (currentUserType == 'profesor') {
                            var resolvedButton = document.createElement('button');
                            resolvedButton.textContent = 'Resuelta';
                            resolvedButton.addEventListener('click', function () {
                                var url = `http://localhost/TICKETS_FCT/api/delete_petition.php?ID=${petition.ID}`;

                                fetch(url, {
                                    method: 'DELETE',
                                })
                                    .then(response => {
                                        // Verifica si la respuesta está vacía
                                        if (!response.ok || response.status === 204) {
                                            throw new Error('No content');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.message === 'Petición marcada como resuelta') {
                                            location.reload();
                                        } else {
                                            alert('Error al marcar la petición como resuelta');
                                        }
                                    })
                                    .catch(error => {
                                        if (error.message === 'No content') {
                                            // Si la respuesta estaba vacía, elimina la fila de la tabla
                                            row.remove();
                                        } else {
                                            console.error('Error:', error);
                                        }
                                    });
                            });
                            row.appendChild(resolvedButton);
                        }
                    });
                }
            })
            .catch(error => console.error('Error:', error));

        document.getElementById('askQuestionButton').addEventListener('click', function () {
            window.location.href = 'classroom.php';
        });
    </script>
    <button id="logoutButton">Logout</button>

    <script>
        document.getElementById('logoutButton').addEventListener('click', function () {
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

</html>