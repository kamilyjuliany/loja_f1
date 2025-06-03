<?php
session_start();
include '../db/conexao.php';

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];

// Consulta o vendedor no banco
$sql = "SELECT * FROM vendedores WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $vendedor = $result->fetch_assoc();

  // Verifica a senha (pode ser hash ou texto simples)
  if (password_verify($senha, $vendedor['senha']) || $senha === $vendedor['senha']) {
    $_SESSION['vendedor_id'] = $vendedor['id'];
    $_SESSION['vendedor_cpf'] = $vendedor['cpf'];

    // Redireciona para o painel
    header("Location: painel_vendedor.php");
    exit;
  }
}

// Se CPF ou senha forem incorretos
echo "CPF ou senha incorretos.";
?>
