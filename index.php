<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coasterverse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include "header.php"; // Aquí asumo que $conn es tu conexión PDO
    ?>
    <main>
        <section>
            <article>
                <h3>Bienvenido a coasterverse</h3>
                <p>
                    Aquí podrás ver la información sobre las montañas rusas que tanto nos gustan, 
                    además de poder puntuarlas.
                </p>
            </article>
        </section>
        <section>
            <ul>
            <?php
                // Variables para el paginador
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 0;
                $limit = 5;
                $offset = $page * $limit;

                // Preparar y ejecutar consulta para obtener montañas rusas
                $sql = "SELECT * FROM coaster LIMIT :limit OFFSET :offset";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $n = $offset + 1;

                if (count($resultados) > 0) {
                    foreach ($resultados as $row) {
                        echo "<li><a href='coasterview.php?id=" . htmlspecialchars($row["idcoaster"]) . "'>" . ($n++) . ". " . htmlspecialchars($row["nombre"]) . "</a> | ";
                        
                        // Mostrar estrellas encendidas
                        for ($i = 0; $i < $row['nota']; $i++) { 
                            echo "<span class='onstar'>*</span>";
                        }
                        // Mostrar estrellas apagadas
                        for ($i = 0; $i < (10 - $row['nota']); $i++) { 
                            echo "<span class='offstar'>*</span>";
                        }
                        echo "</li>";
                    }
                } else {
                    echo "<li>No hay resultados.</li>";
                }
            ?>
            </ul>
            <?php
                // Contar total de registros en coaster
                $contar = "SELECT COUNT(*) AS total_registros FROM coaster";
                $countStmt = $conn->query($contar);
                $fila = $countStmt->fetch(PDO::FETCH_ASSOC);
                $total_registros = $fila ? (int)$fila['total_registros'] : 0;

                // Botones de paginación
                if ($page > 0) {
                    echo "<a href='index.php?page=" . ($page - 1) . "'><button>Anterior</button></a>";
                }

                if (($offset + $limit) < $total_registros) {
                    echo "<a href='index.php?page=" . ($page + 1) . "'><button>Siguiente</button></a>";
                }
            ?>
        </section>
    </main>

    <?php
        include "footer.html";
    ?>
</body>
</html>
