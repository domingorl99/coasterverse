<?php
include "logindb.php"; // $conn es un objeto PDO

$user = $_GET["user"] ?? '';
$contrasena = $_GET["contrasena"] ?? '';

if (!$user || !$contrasena) {
    echo "Faltan parámetros.";
    exit;
}

try {
    // Consulta preparada con parámetros
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :user AND contrasena = :contrasena";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user' => $user, ':contrasena' => $contrasena]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $token = hash('sha256', bin2hex(random_bytes(16)));
        $fecha = new DateTime();
        $fecha->modify('+5 minutes');
        $expira = $fecha->format('Y-m-d H:i');

        $sqlUpdate = "UPDATE usuarios SET token = :token, expira = :expira WHERE nombre_usuario = :user";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':token' => $token,
            ':expira' => $expira,
            ':user' => $user
        ]);

        setcookie("sesion", $token);
        header('Location: index.php');
        exit;
    } else {
        echo "Usuario no encontrado";
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>
