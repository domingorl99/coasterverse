<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coasterverse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "header.php"; ?>

    <?php
    // Validar el parámetro
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        echo "<p>ID de montaña rusa inválido.</p>";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM coaster WHERE idcoaster = :id");
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                echo "
                    <form action='update.php' method='POST' enctype='multipart/form-data'>
                        <label>Nombre:</label> <input type='text' name='nombre' id='nombre' value='" . htmlspecialchars($row["nombre"]) . "'><br>
                        <label>Altura:</label> <input type='text' name='altura' id='altura' value='" . htmlspecialchars($row["altura"]) . "'><br>
                        <label>Velocidad:</label> <input type='text' name='velocidad' id='velocidad' value='" . htmlspecialchars($row["velocidad"]) . "'><br>
                        <label>Longitud:</label> <input type='text' name='longitud' id='longitud' value='" . htmlspecialchars($row["longitud"]) . "'><br>
                        <label>Lugar:</label> <input type='text' name='lugar' id='lugar' value='" . htmlspecialchars($row["lugar"]) . "'><br>
                        <label>Parque:</label> <input type='text' name='parque' id='parque' value='" . htmlspecialchars($row["parque"]) . "'><br>
                        <label>Fabricante:</label> <input type='text' name='fabricante' id='fabricante' value='" . htmlspecialchars($row["fabricante"]) . "'><br>
                        <label>Apertura:</label> <input type='date' name='apertura' id='apertura' value='" . htmlspecialchars($row["apertura"]) . "'><br>
                        <label>Tipo:</label> <input type='text' name='tipo' id='tipo' value='" . htmlspecialchars($row["tipo"]) . "'><br>
                        <label>Descripción:</label><br>
                        <textarea name='descripcion' id='descripcion'>" . htmlspecialchars($row["descripcion"]) . "</textarea><br>
                        
                        <input type='hidden' name='idcoaster' id='idcoaster' value='" . (int)$row["idcoaster"] . "'><br>
                        <label>Agregar fotos:</label> <input type='file' name='foto[]' id='foto' accept='image/*' multiple><br><br>
                        <input type='submit' value='Enviar'>
                    </form>
                ";
            } else {
                echo "<p>Montaña rusa no encontrada.</p>";
            }
        } catch (PDOException $e) {
            echo "Error al cargar los datos: " . $e->getMessage();
        }
    }
    ?>

    <?php include "footer.html"; ?>
</body>
</html>
