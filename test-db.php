<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Configuración de la conexión
$servername = 'localhost:3307'; // Cambiar a 127.0.0.1 si es necesario
$username = 'system_admin';        // Usuario de la base de datos
$password = 'system';            // Contraseña del usuario
$database = 'system'; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database '$database'!";
}

// Cerrar la conexión
$conn->close();
?>
