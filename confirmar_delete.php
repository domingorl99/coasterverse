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
    <h3>¿Seguro que quieres borrar esta montaña rusa?</h3>
    <nav>
        <?php echo "<a href='delete.php?id=".$_GET['id']."'><button>Confirmar</button></a>"?>
        
        <a href="index.php"><button>Volver a inicio</button></a>
    </nav>
    <?php
        include "footer.html";
    ?>
</body>
</html>