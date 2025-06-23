<?php
include "logindb.php"; // Asegúrate de que $conn sea un objeto PDO

// Validar y sanitizar los parámetros
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id_coaster = isset($_GET['id_coaster']) ? (int)$_GET['id_coaster'] : 0;

if ($id > 0) {
    try {
        $sql = "DELETE FROM valoraciones WHERE idvaloraciones = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        header('Location: coasterview.php?id=' . $id_coaster);
        exit;
    } catch (PDOException $e) {
        echo "Error al borrar reseña: " . $e->getMessage();
    }
} else {
    echo "ID inválido.";
}
?>
