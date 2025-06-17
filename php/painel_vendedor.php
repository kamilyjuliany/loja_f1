<?php
session_start();
include '../db/conexao.php';

// Protege o acesso
if (!isset($_SESSION['vendedor_id'])) {
  header("Location: ../index.html");
  exit;
}

// Mensagem de sucesso após cadastro
$mensagem = "";
if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
  $mensagem = "Produto cadastrado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Painel do Vendedor</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      margin: 0;
    }

    header {
      background-color: #165c1f;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .container {
      max-width: 500px;
      margin: 40px auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 30px;
      text-align: center;
    }

    .container h2 {
      margin-bottom: 20px;
      color: #333;
    }

    form input, form select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    form button {
      background-color: #165c1f;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .top-right {
      position: absolute;
      right: 20px;
      top: 20px;
    }

    .top-right a {
      background: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 6px;
      color: #165c1f;
      font-weight: bold;
      border: 2px solid #165c1f;
    }

    .top-right a:hover {
      background-color: #165c1f;
      color: white;
    }
  </style>
</head>
<body>

  <header>
    <h1>Painel do Vendedor</h1>
    <p>Bem-vindo, vendedor CPF: <strong><?= htmlspecialchars($_SESSION['vendedor_cpf']) ?></strong></p>
  </header>

  <div class="top-right">
    <a href="../cliente.php" target="_blank">🛍 Ver Loja</a>
    <a href="logout.php" style="margin-left: 10px;">🚪 Sair</a>
  </div>

  <div class="container">
    <h2>Cadastrar Novo Produto</h2>
    <?php if ($mensagem): ?>
      <p style="color: green; font-weight: bold;"><?= $mensagem ?></p>
    <?php endif; ?>


    <form action="cadastrar_produto.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="imagem" accept="image/*" required>
      <input type="text" name="nome" placeholder="Nome do produto" required>
      <input type="number" name="valor" placeholder="Valor (R$)" step="0.01" required>
      <select name="tamanho" required>
        <option disabled selected>Selecione o tamanho</option>
        <option>P</option>
        <option>M</option>
        <option>G</option>
        <option>GG</option>
      </select>
      <select name="equipe" required>
        <option disabled selected>Selecione a equipe</option>
        <option>Ferrari</option>
        <option>Mercedes</option>
        <option>RedBull</option>
        <option>McLaren</option>
        <option>Stake</option>
        <option>Visa Cash</option>
        <option>Haas</option>
        <option>Williams</option>
      </select>
      <button type="submit">Cadastrar Produto</button>
    </form>
  </div>

  <hr style="margin-top: 40px;">
<h2 style="text-align:center;">Produtos Cadastrados</h2>
<div style="margin-top: 20px; text-align: center;">
  <table style="width:100%; border-collapse: collapse;">
    <tr style="background-color: #f0f0f0;">
      <th style="padding:10px;">Imagem</th>
      <th>Nome</th>
      <th>Valor</th>
      <th>Tamanho</th>
      <th>Equipe</th>
    </tr>
    <?php
    $sql = "SELECT * FROM produtos ORDER BY id DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td><img src='../img/produtos/" . $row['imagem'] . "' width='60'></td>";
      echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
      echo "<td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>";
      echo "<td>" . htmlspecialchars($row['tamanho']) . "</td>";
      echo "<td>" . htmlspecialchars($row['equipe']) . "</td>";
      echo "</tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
