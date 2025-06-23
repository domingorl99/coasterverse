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
    <form action="insert.php" method="POST" enctype="multipart/form-data">
        Nombre: <input type="text" name="nombre" id="nombre"><br>
        Altura: <input type="text" name="altura" id="altura"><br>
        Velocidad: <input type="text" name="velocidad" id="velocidad"><br>
        Longitud: <input type="text" name="longitud" id="longitud"><br>
        Lugar: <input type="text" name="lugar" id="lugar"><br>
        Parque: <input type="text" name="parque" id="parque"><br>
        Fabricante:<input type="text" name="fabricante" id="fabricante"><br>
        Apertura: <input type="date" name="apertura" id="apertura"><br>
        Tipo: <input type="text" name="tipo" id="tipo"><br>
        Descripción: <textarea name="descripcion" id="descripcion"></textarea><br>
        Agregar fotos: <input type="file" name="foto[]" id="foto" accept="image/*" multiple><br>
        <input type="submit" value="Enviar">
    </form>
    <?php
        include "footer.html";
    ?>
</body>
</html>