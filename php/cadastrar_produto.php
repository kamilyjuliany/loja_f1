<?php
include '../db/conexao.php';

$nome = $_POST['nome'];
$valor = $_POST['valor'];
$tamanho = $_POST['tamanho'];
$equipe = $_POST['equipe'];

$sql = "INSERT INTO produtos (nome, valor, tamanho, equipe) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdss", $nome, $valor, $tamanho, $equipe);

if ($stmt->execute()) {
    echo "Produto cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$conn->close();
?>
