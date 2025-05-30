<?php
session_start();
include '../db/conexao.php';

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM clientes WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $cliente = $result->fetch_assoc();
  if (password_verify($senha, $cliente['senha'])) {
    $_SESSION['cliente_id'] = $cliente['id'];
    $_SESSION['cliente_nome'] = $cliente['nome'];
    $_SESSION['cpf_cliente'] = $cliente['cpf']; // novo campo para exibir no painel

    // Redireciona para a nova página do painel do cliente
    header("Location: painel_cliente.php");
    exit;
  }
}

echo "CPF ou senha incorretos.";
?>
