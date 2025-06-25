<?php
session_start();
include '../db/conexao.php';


// Verifica se a data da compra foi enviada via GET
if (!isset($_GET['data'])) {
  die("Dados inválidos.");
}
$data_compra = $_GET['data'];

// Consulta os dados da compra
$sql = "SELECT nome_produto, preco, quantidade, forma_pagamento, data_compra 
        FROM compras 
        WHERE id_cliente = ? AND data_compra = ?
        ORDER BY data_compra DESC";

$stmt = $conn->prepare("INSERT INTO compras (nome_produto, preco, quantidade, forma_pagamento) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sdss", $nome, $valor, $qtd, $forma_pagamento);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Comprovante de Compra</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body { font-family: Arial; padding: 40px; background: #f5f5f5; }
    h1 { text-align: center; color: green; }
    .compra { margin: 20px auto; max-width: 600px; background: white; padding: 20px; border-radius: 10px; }
    .item { border-bottom: 1px solid #ccc; padding: 10px 0; }
    .total { font-size: 18px; font-weight: bold; text-align: right; }
    .voltar {
      text-align: center;
      margin-top: 30px;
    }
    .voltar button {
      padding: 10px 20px;
      background-color: green;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>Comprovante de Compra</h1>
  <div class="compra">
    <?php
    $total = 0;
    while ($row = $result->fetch_assoc()):
      $subtotal = $row['preco'] * $row['quantidade'];
      $total += $subtotal;
    ?>
      <div class="item">
        <strong><?= $row['nome_produto'] ?></strong><br>
        Quantidade: <?= $row['quantidade'] ?><br>
        Preço unitário: R$ <?= number_format($row['preco'], 2, ',', '.') ?><br>
        Subtotal: R$ <?= number_format($subtotal, 2, ',', '.') ?><br>
        Forma de pagamento: <?= $row['forma_pagamento'] ?><br>
        Data: <?= date('d/m/Y H:i', strtotime($row['data_compra'])) ?>
      </div>
    <?php endwhile; ?>
    <p class="total">Total da compra: R$ <?= number_format($total, 2, ',', '.') ?></p>
  </div>

  <div class="voltar">
    <button onclick="voltarParaInicio()">Voltar para Loja</button>
  </div>

  <script>
    function voltarParaInicio() {
      localStorage.removeItem("carrinho");
      window.location.href = "../cliente.php";
    }
  </script>
</body>
</html>
