<?php
include "logindb.php"; // Aquí debes tener $conn como una instancia PDO

$nombre = $_POST["nombre"];
$altura = $_POST["altura"];
$velocidad = $_POST["velocidad"];
$longitud = $_POST["longitud"];
$lugar = $_POST["lugar"];
$parque = $_POST["parque"];
$fabricante = $_POST["fabricante"];
$apertura = $_POST["apertura"];
$tipo = $_POST["tipo"];
$descripcion = $_POST["descripcion"];

try {
    // Insertar la montaña rusa y obtener su ID con RETURNING
    $sql = "INSERT INTO coaster (nombre, altura, velocidad, longitud, lugar, parque, fabricante, apertura, tipo, descripcion)
            VALUES (:nombre, :altura, :velocidad, :longitud, :lugar, :parque, :fabricante, :apertura, :tipo, :descripcion)
            RETURNING idcoaster";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':altura' => $altura,
        ':velocidad' => $velocidad,
        ':longitud' => $longitud,
        ':lugar' => $lugar,
        ':parque' => $parque,
        ':fabricante' => $fabricante,
        ':apertura' => $apertura,
        ':tipo' => $tipo,
        ':descripcion' => $descripcion
    ]);

    $ultimoid = $stmt->fetchColumn(); // ID generado por PostgreSQL

    // Subir múltiples fotos
    foreach ($_FILES["foto"]["name"] as $key => $filename) {
        $ruta_destino = "fotos/" . basename($filename);
        $tmp_name = $_FILES["foto"]["tmp_name"][$key];

        if (move_uploaded_file($tmp_name, $ruta_destino)) {
            $sql_foto = "INSERT INTO fotos (foto, id_coaster) VALUES (:foto, :id_coaster)";
            $stmt_foto = $conn->prepare($sql_foto);
            $stmt_foto->execute([
                ':foto' => $ruta_destino,
                ':id_coaster' => $ultimoid
            ]);
        }
    }

    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    echo "Error al insertar: " . $e->getMessage();
}
?>
