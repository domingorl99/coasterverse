<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coasterverse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include "header.php";
    ?>
    <form action="insert_user.php" method="get">
        Nombre: <input type="text" name="nombre" id="nombre"><br>
        Apellidos: <input type="text" name="apellidos" id="apellidos"><br>
        Fecha de nacimiento: <input type="date" name="fechanacimiento" id="fechanacimiento"><br>
        Nombre de usuario: <input type="text" name="user" id="user"><br>
        Contraseña: <input type="password" name="contrasena" id="contrasena"><br>
        <input type="submit" value="Enviar">
    </form>
    <?php
        include "footer.html";
    ?>
</body>
</html>