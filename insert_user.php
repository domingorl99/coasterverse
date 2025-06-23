<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Coasterverse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include "logindb.php"; // $conn debe ser una instancia de PDO

        // Recoger y validar datos
        $nombre = isset($_GET["nombre"]) ? trim($_GET["nombre"]) : '';
        $apellidos = isset($_GET["apellidos"]) ? trim($_GET["apellidos"]) : '';
        $fechanacimiento = isset($_GET["fechanacimiento"]) ? $_GET["fechanacimiento"] : '';
        $user = isset($_GET["user"]) ? trim($_GET["user"]) : '';
        $contrasena = isset($_GET["contrasena"]) ? $_GET["contrasena"] : '';

        // Validación básica
        if (empty($nombre) || empty($apellidos) || empty($fechanacimiento) || empty($user) || empty($contrasena)) {
            echo "<p>Por favor, completa todos los campos.</p>";
            exit;
        }

        // Opcional: hashear la contraseña (recomendado)
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO usuarios (nombre, apellidos, fecha_nacimiento, nombre_usuario, contrasena, rol)
                    VALUES (:nombre, :apellidos, :fecha_nacimiento, :nombre_usuario, :contrasena, 'usuario')";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':fecha_nacimiento' => $fechanacimiento,
                ':nombre_usuario' => $user,
                ':contrasena' => $hashed_password
            ]);

            header('Location: iniciar_sesion.php');
            exit;
        } catch (PDOException $e) {
            echo "<p>Error al registrar el usuario: " . $e->getMessage() . "</p>";
        }
    ?>
</body>
</html>
