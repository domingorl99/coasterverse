<?php
include "logindb.php"; // Asegúrate de tener $conn como instancia PDO

$idcoaster = $_POST['idcoaster'];

try {
    // Actualizar datos de la montaña rusa
    $sql = "UPDATE coaster SET 
        nombre = :nombre,
        altura = :altura,
        velocidad = :velocidad,
        longitud = :longitud,
        lugar = :lugar,
        parque = :parque,
        fabricante = :fabricante,
        apertura = :apertura,
        tipo = :tipo,
        descripcion = :descripcion
        WHERE idcoaster = :idcoaster";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nombre' => $_POST['nombre'],
        ':altura' => $_POST['altura'],
        ':velocidad' => $_POST['velocidad'],
        ':longitud' => $_POST['longitud'],
        ':lugar' => $_POST['lugar'],
        ':parque' => $_POST['parque'],
        ':fabricante' => $_POST['fabricante'],
        ':apertura' => $_POST['apertura'],
        ':tipo' => $_POST['tipo'],
        ':descripcion' => $_POST['descripcion'],
        ':idcoaster' => $idcoaster
    ]);

    // Subir nuevas fotos (si se han enviado)
    foreach ($_FILES["foto"]["name"] as $key => $filename) {
        if (!empty($filename)) {
            $ruta_destino = "fotos/" . basename($filename);
            $tmp_name = $_FILES["foto"]["tmp_name"][$key];

            if (move_uploaded_file($tmp_name, $ruta_destino)) {
                $sql_foto = "INSERT INTO fotos (foto, id_coaster) VALUES (:foto, :id_coaster)";
                $stmt_foto = $conn->prepare($sql_foto);
                $stmt_foto->execute([
                    ':foto' => $ruta_destino,
                    ':id_coaster' => $idcoaster
                ]);
            }
        }
    }

    header('Location: coasterview.php?id=' . $idcoaster);
    exit;

} catch (PDOException $e) {
    echo "Error al actualizar: " . $e->getMessage();
}
?>
