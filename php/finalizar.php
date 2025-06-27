<?php
session_start();
include __DIR__ . '/../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Valida se os dados foram enviados
  if (!isset($_POST['produtos'], $_POST['pagamento'])) {
    die("Dados incompletos.");
  }

  $produtos = json_decode($_POST['produtos'], true);
  $forma_pagamento = $_POST['pagamento'];
  $data_compra = date('Y-m-d H:i:s');

  // Salva a data da compra na sessão para recuperar depois
  $_SESSION['ultima_compra'] = $data_compra;

  // Salva os produtos no banco
  foreach ($produtos as $p) {
    $nome = $conn->real_escape_string($p['nome'] ?? '');
    $valor = floatval($p['valor'] ?? 0);
    $qtd = intval($p['quantidade'] ?? 1);

    $stmt = $conn->prepare("INSERT INTO compras (nome_produto, preco, quantidade, forma_pagamento, data_compra) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdiss", $nome, $valor, $qtd, $forma_pagamento, $data_compra);
    $stmt->execute();
  }

  header("Location: comprovante.php");
  exit;
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Finalizar Compra</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .pagamento-box {
      max-width: 600px;
      margin: 40px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background: #fff;
    }
    .pagamento-box h2 { text-align: center; }
    .metodo {
      margin: 15px 0;
    }
    .metodo label { margin-left: 8px; }
    .pix-img, .boleto-img {
      display: none;
      margin-top: 10px;
      max-width: 300px;
    }
    .form-cartao {
      display: none;
      margin-top: 10px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
      background: green;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="pagamento-box">
    <h2>Escolha a forma de pagamento</h2>
    <form method="POST" action="">
      <input type="hidden" name="produtos" id="produtos-hidden">

      <div class="metodo">
        <input type="radio" name="pagamento" value="Pix" id="pix" required>
        <label for="pix">Pix</label><br>
        <img src="../img/qrcode.png" alt="Pix QR Code" class="pix-img" id="img-pix">
      </div>

      <div class="metodo">
        <input type="radio" name="pagamento" value="Cartão" id="cartao">
        <label for="cartao">Cartão de Crédito</label>
        <div class="form-cartao" id="form-cartao">
          <input type="text" placeholder="Nome no cartão"><br>
          <input type="text" placeholder="Número do cartão"><br>
          <input type="text" placeholder="Validade"><br>
          <input type="text" placeholder="CVV"><br>
        </div>
      </div>

      <div class="metodo">
        <input type="radio" name="pagamento" value="Boleto" id="boleto">
        <label for="boleto">Boleto Bancário</label><br>
        <img src="../img/boleto.png" alt="Boleto" class="boleto-img" id="img-boleto">
      </div>

      <button type="submit">Confirmar Pagamento</button>
    </form>
  </div>

  <script>
    const radioPix = document.getElementById('pix');
    const radioCartao = document.getElementById('cartao');
    const radioBoleto = document.getElementById('boleto');
    const imgPix = document.getElementById('img-pix');
    const imgBoleto = document.getElementById('img-boleto');
    const formCartao = document.getElementById('form-cartao');

    document.querySelectorAll('input[name="pagamento"]').forEach(radio => {
      radio.addEventListener('change', () => {
        imgPix.style.display = radioPix.checked ? 'block' : 'none';
        imgBoleto.style.display = radioBoleto.checked ? 'block' : 'none';
        formCartao.style.display = radioCartao.checked ? 'block' : 'none';
      });
    });

    // Enviar produtos para o PHP
    const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
    document.getElementById('produtos-hidden').value = JSON.stringify(carrinho);
  </script>

  
</body>
</html>

