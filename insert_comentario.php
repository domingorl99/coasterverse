<?php
    include "logindb.php"; // Asegúrate que $conn es una instancia de PDO

    // Validación y saneamiento de entrada
    $nota = isset($_GET["nota"]) ? (int)$_GET["nota"] : null;
    $comentario = isset($_GET["comentario"]) ? trim($_GET["comentario"]) : '';
    $id_coaster = isset($_GET["id_coaster"]) ? (int)$_GET["id_coaster"] : 0;
    $id_usuarios = isset($_GET["id_usuarios"]) ? (int)$_GET["id_usuarios"] : 0;

    // Validaciones básicas
    if ($nota < 1 || $nota > 10 || $id_coaster <= 0 || $id_usuarios <= 0 || empty($comentario)) {
        echo "Datos inválidos.";
        exit;
    }

    try {
        $sql = "INSERT INTO valoraciones (comentario, nota, id_coaster, id_usuarios)
                VALUES (:comentario, :nota, :id_coaster, :id_usuarios)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':comentario' => $comentario,
            ':nota' => $nota,
            ':id_coaster' => $id_coaster,
            ':id_usuarios' => $id_usuarios
        ]);

        header('Location: coasterview.php?id=' . $id_coaster);
        exit;
    } catch (PDOException $e) {
        echo "Error al insertar comentario: " . $e->getMessage();
    }
?>
