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
    include "header.php"; // Asegúrate de que $conn es un objeto PDO y $yo está definido

    // Validar ID de coaster desde la URL
    $idCoaster = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($idCoaster <= 0 || !isset($yo)) {
        echo "<span>Parámetros inválidos</span>";
        include "footer.html";
        exit;
    }

    try {
        // Consultar si ya hay una reseña del usuario
        $sql = "SELECT * FROM valoraciones WHERE id_usuarios = :id_usuario AND id_coaster = :id_coaster";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $yo,
            ':id_coaster' => $idCoaster
        ]);
        $valoracion = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($valoracion) {
            echo "<span>Ya escribiste una reseña</span><br>";
            echo "<a href='coasterview.php?id={$idCoaster}'><button>Volver</button></a>";
        } else {
            echo "
                <form action='insert_comentario.php' method='get'>
                    <label for='nota'>Nota (Del 1 al 10)</label><br>
                    <input type='number' name='nota' id='nota' min='1' max='10' required><br>
                    <label for='comentario'>Comentario</label><br>
                    <textarea name='comentario' id='comentario' required></textarea><br>
                    <input type='hidden' name='id_coaster' value='{$idCoaster}'>
                    <input type='hidden' name='id_usuarios' value='{$yo}'>
                    <input type='submit' value='Enviar'>
                </form>
            ";
        }
    } catch (PDOException $e) {
        echo "Error al consultar: " . $e->getMessage();
    }

    include "footer.html";
    ?>
</body>
</html>
