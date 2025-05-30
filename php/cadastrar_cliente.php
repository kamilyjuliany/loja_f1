<?php
include '../db/conexao.php';

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$sql = "INSERT INTO clientes (nome, cpf, email, senha) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $cpf, $email, $senha);

if ($stmt->execute()) {
    echo "Cliente cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$conn->close();
?>
