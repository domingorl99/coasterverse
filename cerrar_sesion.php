<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coasterverse</title>
</head>
<body>
    <?php
    include "header.php"; // $conn es PDO

    try {
        if (isset($_COOKIE["sesion"])) {
            $token = $_COOKIE["sesion"];

            $sql = "UPDATE usuarios SET token = '' WHERE token = :token";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':token' => $token]);

            header('Location: index.php');
            exit;
        } else {
            echo "No hay sesión iniciada.";
        }
    } catch (PDOException $e) {
        echo "Error al borrar token: " . $e->getMessage();
    }
    ?>
</body>
</html>
