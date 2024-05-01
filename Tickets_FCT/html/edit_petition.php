<?php
// edit_petition.php

// Obtén el ID de la petición de la cadena de consulta
$id = $_GET['ID'];
$titulo = $_GET['Titulo'];
$descripcion = $_GET['Descripcion'];


?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="css/form_crearduda.css">

<head>
    <title>Editar petición</title>
</head>
<script src="validatecookie.js"></script>

<body>
<button id="backButton">Volver Atrás</button>
<script>
    document.getElementById('backButton').addEventListener('click', function() {
        window.history.back();
    });
</script>

    <h1>Editar petición</h1>

    <form action="http://localhost/TICKETS_FCT/api/update_petition.php" method="get">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>"><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea><br>

        <input type="submit" value="Actualizar">
    </form>

    <script>
        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault();
            const id = document.getElementById("id").value;
            const titulo = document.getElementById("titulo").value;
            const descripcion = document.getElementById("descripcion").value;



            const url = `http://localhost/TICKETS_FCT/api/update_petition.php?id=${id}&titulo=${titulo}&descripcion=${descripcion}`;

            fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.message === "Petición actualizada con éxito") {
                        window.location.href = "dudas_classroom.php";
                    } else {
                        alert("Error al actualizar la petición");
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
    </script>
</body>

</html>