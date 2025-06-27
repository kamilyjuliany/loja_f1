<?php
// php/login_cliente.php
session_start();
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $cpf = $_POST['cpf'] ?? '';
  $senha = $_POST['senha'] ?? '';

  // Consulta cliente pelo CPF
  $sql = "SELECT id, senha FROM clientes WHERE cpf = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $cpf);

  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {

    $cliente = $result->fetch_assoc();

    // Verifica a senha (assumindo que está com password_hash)
    if (password_verify($senha, $cliente['senha'])) {
      $_SESSION['id_cliente'] = $cliente['id'];

      // Redireciona para a loja (cliente.php)
      header("Location: ../cliente.php");
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
  <style>
    body {
      background-color: #f0f2f5;
      font-family: Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .login-box {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-box h1 {
      text-align: center;
      color: green;
      margin-bottom: 20px;
    }

    .login-box label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .login-box input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .login-box button {
      width: 100%;
      background-color: green;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .login-box p {
      color: red;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="login-box">
    <h1>Login do Cliente</h1>

    <?php if (isset($erro)): ?>
      <p><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
      <label for="cpf">CPF:</label>
      <input type="text" name="cpf" id="cpf" required>

      <label for="senha">Senha:</label>
      <input type="password" name="senha" id="senha" required>

      <button type="submit">Entrar</button>
    </form>
  </div>
</body>

</html>
