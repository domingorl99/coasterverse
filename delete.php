<?php
include "logindb.php"; // $conn debe ser un objeto PDO

// Validar el parámetro
$idCoaster = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idCoaster <= 0) {
    echo "ID de montaña rusa inválido.";
    exit;
}

try {
    // Paso 1: Obtener y borrar archivos físicos de fotos
    $stmtFotos = $conn->prepare("SELECT foto FROM fotos WHERE id_coaster = :id");
    $stmtFotos->execute([':id' => $idCoaster]);
    $fotos = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fotos as $foto) {
        if (file_exists($foto['foto'])) {
            unlink($foto['foto']);
        }
    }

    // Paso 2: Borrar fotos de la base de datos
    $stmtDeleteFotos = $conn->prepare("DELETE FROM fotos WHERE id_coaster = :id");
    $stmtDeleteFotos->execute([':id' => $idCoaster]);

    // Paso 3: Borrar montaña rusa
    $stmtDeleteCoaster = $conn->prepare("DELETE FROM coaster WHERE idcoaster = :id");
    $stmtDeleteCoaster->execute([':id' => $idCoaster]);

    // Redirigir al index si todo fue bien
    header('Location: index.php');
    exit;

} catch (PDOException $e) {
    echo "Error al borrar la montaña rusa: " . $e->getMessage();
}
?>