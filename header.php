<header>
    <a href="index.php" class="titulo"><h1>COASTERVERSE</h1></a>
    <?php
    include "logindb.php"; // Asegúrate que aquí tienes la conexión PDO en $conn

    $fecha = new DateTime();
    $hoy = $fecha->format('Y-m-d H:i:s'); // PostgreSQL espera segundos también

    $inicio = isset($_COOKIE["sesion"]) ? $_COOKIE["sesion"] : "hola";

    // Consulta preparada para evitar inyección
    $sql = "SELECT * FROM usuarios WHERE token = :token AND expira > :expira";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':token' => $inicio,
        ':expira' => $hoy
    ]);

    $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($registro) > 0) {
        foreach ($registro as $row) {
            $yo = $row["idusuarios"];
            echo "<span class='hola'>Hola " . htmlspecialchars($row["nombre_usuario"]) . "</span>";

            $newfecha = new DateTime();
            $newfecha->modify('+5 minutes');
            $expira = $newfecha->format('Y-m-d H:i:s');

            $updatedate = "UPDATE usuarios SET expira = :expira WHERE nombre_usuario = :user";
            $updateStmt = $conn->prepare($updatedate);
            $updateResult = $updateStmt->execute([
                ':expira' => $expira,
                ':user' => $row["nombre_usuario"]
            ]);

            if (!$updateResult) {
                echo "Error al actualizar la fecha de expiración.";
            }

            $rol = $row["rol"];
            if ($rol === "admin") {
                echo "<a href='form_insert.php'><button>Insertar montaña rusa</button></a>";
            }
            echo "<a href='cerrar_sesion.php'><button>Cerrar sesión</button></a>";
        }
    } else {
        echo "
        <nav>
            <a href='registrarse.php'><button>Registrarse</button></a>
            <a href='iniciar_sesion.php'><button>Iniciar sesión</button></a>
        </nav>
        ";
    }
    ?>
</header>