<?php
session_start();
include('../db/conexao.php');


$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cpf = $_POST['cpf'];
  $senha = $_POST['senha'];

  $stmt = $conn->prepare("SELECT id, senha FROM clientes WHERE cpf = ?");
  $stmt->bind_param("s", $cpf);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
      $_SESSION['id_cliente'] = $usuario['id'];
      header('Location: ../cliente.php');
      exit;
    } else {
      $erro = "Senha incorreta.";
    }
  } else {
    $erro = "CPF não encontrado.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login Cliente</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 400px;
      margin: 60px auto;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    input {
      display: block;
      width: 100%;
      padding: 10px;
      margin: 15px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background: #0056b3;
    }
    .erro {
      color: red;
      margin-top: 10px;
    }
    .links {
      margin-top: 20px;
    }
    .links a {
      display: inline-block;
      margin: 5px;
      color: #007bff;
      text-decoration: none;
    }
    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Login do Cliente</h2>
    <form method="POST" action="">
      <input type="text" name="cpf" placeholder="CPF" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>
    <?php if ($erro): ?>
      <p class="erro"><?= $erro ?></p>
    <?php endif; ?>

    <div class="links">
      <a href="cadastrar_cliente.php">Não tem conta? Cadastre-se</a><br>
      <a href="../cliente.php">Voltar para a Loja</a>
    </div>
  </div>
</body>
</html>
