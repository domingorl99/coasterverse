<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Coasterverse</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
include "header.php"; // Aquí debe estar $conn con PDO
$idCoaster = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

// Actualizar nota media
$sqlNotaMedia = "SELECT AVG(nota) AS media FROM valoraciones WHERE id_coaster = :id_coaster";
$stmtNotaMedia = $conn->prepare($sqlNotaMedia);
$stmtNotaMedia->execute([':id_coaster' => $idCoaster]);
$rowNota = $stmtNotaMedia->fetch(PDO::FETCH_ASSOC);

$mediaNota = $rowNota['media'] ?? 0;
$newNotaSql = "UPDATE coaster SET nota = :media WHERE idcoaster = :idcoaster";
$stmtUpdateNota = $conn->prepare($newNotaSql);
$stmtUpdateNota->execute([':media' => $mediaNota, ':idcoaster' => $idCoaster]);
?>

<main>
    <section class="coasterview">
    <?php
    // Mostrar datos de la montaña rusa
    $sqlCoaster = "SELECT * FROM coaster WHERE idcoaster = :idcoaster";
    $stmtCoaster = $conn->prepare($sqlCoaster);
    $stmtCoaster->execute([':idcoaster' => $idCoaster]);
    $coasterData = $stmtCoaster->fetch(PDO::FETCH_ASSOC);

    if ($coasterData) {
        echo "<table>
                <tr rowspan='2'>
                    <td><h3>" . htmlspecialchars($coasterData["nombre"]) . " | ";
        for ($i=0; $i < (int)$coasterData['nota']; $i++) {
            echo "<span class='onstar'>*</span>";
        }
        for ($i=0; $i < (10-(int)$coasterData['nota']); $i++) {
            echo "<span class='offstar'>*</span>";
        }
        echo "</h3></td>
            </tr>
            <tr><td>Altura</td><td>" . htmlspecialchars($coasterData["altura"]) . "</td></tr>
            <tr><td>Velocidad</td><td>" . htmlspecialchars($coasterData["velocidad"]) . "</td></tr>
            <tr><td>Longitud</td><td>" . htmlspecialchars($coasterData["longitud"]) . "</td></tr>
            <tr><td>Lugar</td><td>" . htmlspecialchars($coasterData["lugar"]) . "</td></tr>
            <tr><td>Parque</td><td>" . htmlspecialchars($coasterData["parque"]) . "</td></tr>
            <tr><td>Fabricante</td><td>" . htmlspecialchars($coasterData["fabricante"]) . "</td></tr>
            <tr><td>Apertura</td><td>" . htmlspecialchars($coasterData["apertura"]) . "</td></tr>
            <tr><td>Tipo</td><td>" . htmlspecialchars($coasterData["tipo"]) . "</td></tr>
            <tr><td>Descripción</td><td>" . htmlspecialchars($coasterData["descripcion"]) . "</td></tr>
        </table>";

        if (isset($rol) && $rol === "admin") {
            echo "<a href='form_update.php?id={$idCoaster}'><button>Modificar montaña rusa</button></a>
                  <a href='confirmar_delete.php?id={$idCoaster}'><button>Borrar montaña rusa</button></a>";
        }
    } else {
        echo "Montaña rusa no encontrada.";
    }
    ?>
    <aside>
    <?php
    // Variables para el paginador de fotos
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 0;
    $limit = 1;
    $offset = $page * $limit;

    // Contar fotos
    $sqlCountFotos = "SELECT COUNT(*) AS total_registros FROM fotos WHERE id_coaster = :id_coaster";
    $stmtCountFotos = $conn->prepare($sqlCountFotos);
    $stmtCountFotos->execute([':id_coaster' => $idCoaster]);
    $totalFotos = $stmtCountFotos->fetch(PDO::FETCH_ASSOC)['total_registros'] ?? 0;

    // Mostrar fotos
    $sqlFotos = "SELECT * FROM fotos WHERE id_coaster = :id_coaster LIMIT :limit OFFSET :offset";
    $stmtFotos = $conn->prepare($sqlFotos);
    $stmtFotos->bindValue(':id_coaster', $idCoaster, PDO::PARAM_INT);
    $stmtFotos->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmtFotos->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmtFotos->execute();
    $fotos = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);

    if ($fotos) {
        foreach ($fotos as $foto) {
            echo "<img src='" . htmlspecialchars($foto['foto']) . "' alt='Foto montaña rusa' />";

            // Botones de paginación
            if ($page > 0) {
                echo "<a href='coasterview.php?id={$idCoaster}&page=" . ($page - 1) . "'><button>Anterior</button></a>";
            }
            if (($page + 1) < $totalFotos) {
                echo "<a href='coasterview.php?id={$idCoaster}&page=" . ($page + 1) . "'><button>Siguiente</button></a>";
            }
            if (isset($rol) && $rol === "admin") {
                echo "<a href='delete_foto.php?id=" . (int)$foto['idfotos'] . "'><button>Borrar foto</button></a>";
            }
        }
    } else {
        echo "<p>No hay fotos disponibles.</p>";
    }
    ?>
    </aside>
    </section>

    <section class="comentarios">
        <h3>RESEÑAS</h3>
        <?php
        if (isset($rol) && $rol === "usuario") {
            echo "<a href='form_comentario.php?id={$idCoaster}'><button>Pon una reseña</button></a>";
        }

        // Mostrar comentarios
        $sqlComentarios = "SELECT * FROM valoraciones WHERE id_coaster = :id_coaster";
        $stmtComentarios = $conn->prepare($sqlComentarios);
        $stmtComentarios->execute([':id_coaster' => $idCoaster]);
        $comentarios = $stmtComentarios->fetchAll(PDO::FETCH_ASSOC);

        if ($comentarios) {
            foreach ($comentarios as $comentario) {
                // Consultar nombre de usuario del comentario
                $sqlUser = "SELECT nombre_usuario FROM usuarios WHERE idusuarios = :id_usuario";
                $stmtUser = $conn->prepare($sqlUser);
                $stmtUser->execute([':id_usuario' => $comentario['id_usuarios']]);
                $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

                $nombre_usuario = $user['nombre_usuario'] ?? 'Desconocido';

                echo "<div class='resena'><h3 class='nombre_comentario'>" . htmlspecialchars($nombre_usuario) . " | ";
                for ($i = 0; $i < (int)$comentario['nota']; $i++) {
                    echo "<span class='onstar'>*</span>";
                }
                for ($i = 0; $i < (10 - (int)$comentario['nota']); $i++) {
                    echo "<span class='offstar'>*</span>";
                }
                echo "</h3><br>
                      <p class='comentario'>" . nl2br(htmlspecialchars($comentario['comentario'])) . "</p></div>";

                if (isset($yo) && $comentario['id_usuarios'] == $yo) {
                    echo "<a href='borrar_comentario.php?id=" . (int)$comentario['idvaloraciones'] . "&id_coaster={$idCoaster}'>
                            <button>Borrar</button>
                          </a>";
                }
            }
        } else {
            echo "<p>No hay reseñas aún.</p>";
        }
        ?>
    </section>
</main>

<?php
include "footer.html";
?>
</body>
</html>
