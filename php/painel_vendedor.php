<?php
session_start();
include '../db/conexao.php';

if (!isset($_SESSION['vendedor_id'])) {
  header("Location: ../index.html");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Painel do Vendedor</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .container {
      max-width: 800px;
      margin: auto;
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border-bottom: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f3f3f3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Painel do Vendedor</h1>
    <p>Bem-vindo, vendedor CPF: <strong><?= htmlspecialchars($_SESSION['vendedor_cpf']) ?></strong></p>

    <hr>

    <h2>Cadastrar Novo Produto</h2>
    <form action="cadastrar_produto.php" method="POST">
      <input type="text" name="nome" placeholder="Nome do produto" required><br>
      <input type="number" name="valor" placeholder="Valor (R$)" step="0.01" required><br>
      <select name="tamanho" required>
        <option>P</option>
        <option>M</option>
        <option>G</option>
        <option>GG</option>
      </select><br>
      <select name="equipe" required>
        <option>Ferrari</option>
        <option>Mercedes</option>
        <option>RedBull</option>
        <option>McLaren</option>
        <option>Stake</option>
        <option>Visa Cash</option>
        <option>Haas</option>
        <option>Williams</option>
      </select><br><br>
      <button type="submit">Cadastrar Produto</button>
    </form>

    <hr>

    <h2>Produtos Cadastrados</h2>
    <?php
    $sql = "SELECT * FROM produtos ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
      <table>
        <tr>
          <th>Nome</th>
          <th>Valor</th>
          <th>Tamanho</th>
          <th>Equipe</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td>R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['tamanho']) ?></td>
            <td><?= htmlspecialchars($row['equipe']) ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>Nenhum produto cadastrado ainda.</p>
    <?php endif; ?>
  </div>
</body>
</html>
