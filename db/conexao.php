<?php
$host = "localhost";
$user = "root";
$senha = ""; 
$banco = "loja_f1";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}
?>
