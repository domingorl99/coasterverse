<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include "header.php";
    ?>
    <form action="comprobar_usuario.php" method="get">
        Nombre de usuario: <input type="text" name="user" id="user"><br> 
        Contraseña: <input type="password" name="contrasena" id="contrasena"><br>
        <input type="submit" value="Enviar">
    </form>
    <?php
        include "footer.html";
    ?>
</body>
</html>