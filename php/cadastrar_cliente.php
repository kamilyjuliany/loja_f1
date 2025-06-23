<?php
// php/cadastrar_cliente.php
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $cpf = $_POST['cpf'];
  $email = $_POST['email'];
  $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO clientes (nome, cpf, email, senha) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $nome, $cpf, $email, $senha);

  if ($stmt->execute()) {
    echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='../cliente.php';</script>";
  } else {
    echo "Erro ao cadastrar: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Cliente</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .form-box {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background: #f9f9f9;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
    }
    button {
      width: 100%;
      padding: 10px;
      background: green;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Cadastro de Cliente</h2>
    <form method="POST">
      <input type="text" name="nome" placeholder="Nome completo" required>
      <input type="text" name="cpf" placeholder="CPF" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button type="submit">Cadastrar</button>
    </form>
  </div>
</body>
</html>
