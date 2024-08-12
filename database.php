<?php
// database.php

$servername = "localhost";
$username = "root"; // Altere conforme suas credenciais
$password = "";     // Altere conforme suas credenciais
$dbname = "sistema_pessoas"; // Altere conforme o nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
