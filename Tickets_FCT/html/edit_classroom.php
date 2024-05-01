<?php
session_start();

// Obtén los datos de la petición desde la URL
$petitionId = $_GET['ID'];
$petitionTitle = $_GET['titulo'];

// Aquí puedes obtener más datos de la petición desde la base de datos usando $petitionId si es necesario

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Petición</title>
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

    <h1>Editar nombre de la sala</h1>

    <form action="ver_classrooms.php" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo $petitionId; ?>">
        <label for="title">Título:</label>
        <textarea  type="text" id="titulo" name="title"><?php echo $petitionTitle; ?></textarea>
        <!-- Aquí puedes agregar más campos si es necesario -->
        <input type="submit" value="Actualizar">
    </form>
</body>
<script>
        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault();
            const id =  document.getElementById("id").value;
            const titulo = document.getElementById("titulo").value;
          



            const url = `http://localhost/TICKETS_FCT/api/update_classroom.php?id=<?php echo $_GET['ID'] ?>&titulo=${titulo}`;

            fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.message === "Sala actualizada con éxito") {
                        window.location.href = "ver_classrooms.php";
                    } else {
                        alert("Error al actualizar la Sala");
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
    </script>

</html>