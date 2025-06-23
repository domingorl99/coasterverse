<?php
include 'logindb.php'; // $conn es un objeto PDO

// Validar y sanitizar el parámetro
$idFoto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idFoto > 0) {
    try {
        // Obtener la ruta de la foto y el id del coaster
        $stmtSelect = $conn->prepare("SELECT * FROM fotos WHERE idfotos = :id");
        $stmtSelect->execute([':id' => $idFoto]);
        $foto = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if ($foto) {
            $idCoaster = $foto['id_coaster'];

            // Eliminar archivo físico si existe
            if (file_exists($foto['foto'])) {
                unlink($foto['foto']);
            }

            // Borrar de la base de datos
            $stmtDelete = $conn->prepare("DELETE FROM fotos WHERE idfotos = :id");
            $stmtDelete->execute([':id' => $idFoto]);

            header('Location: coasterview.php?id=' . $idCoaster);
            exit;
        } else {
            echo "Foto no encontrada.";
        }

    } catch (PDOException $e) {
        echo "Error al eliminar la foto: " . $e->getMessage();
    }
} else {
    echo "ID no válido.";
}
?>
