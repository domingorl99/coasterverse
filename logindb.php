<?php
    // $servername = "localhost";
    // $username = "root";
    // $password = "root";
    // $dbname = "coasters";
    
    // $conn = new mysqli($servername, $username, $password, $dbname);
    
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    $host = 'localhost';
    $port = '5432';
    $dbname = 'coasterverse_sql';
    $user = 'postgres';
    $password = 'root';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $conn = new PDO($dsn, $user, $password);

        // Configura para que lance excepciones en errores
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        die("❌ Error de conexión: " . $e->getMessage());
    }
?>