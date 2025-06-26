
<?php
session_start();
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dados = json_decode(file_get_contents("php://input"), true);

  if (!isset($dados['carrinho']) || !isset($dados['pagamento'])) {
    http_response_code(400);
    echo "Dados da compra incompletos.";
    exit;
  }

  $carrinho = $dados['carrinho'];
  $forma_pagamento = $dados['pagamento'];
  $data_compra = date('Y-m-d H:i:s');

  $_SESSION['ultima_compra'] = $data_compra;

  foreach ($carrinho as $item) {
    $nome = $conn->real_escape_string($item['nome']);
    $valor = floatval($item['valor']);
    $qtd = intval($item['quantidade']);

    $sql = "INSERT INTO compras (nome_produto, preco, quantidade, forma_pagamento, data_compra";
    $params = "sdiss";
    $values = [$nome, $valor, $qtd, $forma_pagamento, $data_compra];

    if (isset($_SESSION['id_cliente'])) {
      $sql .= ", id_cliente";
      $params .= "i";
      $values[] = $_SESSION['id_cliente'];
    }

    $sql .= ") VALUES (?, ?, ?, ?, ?" . (isset($_SESSION['id_cliente']) ? ", ?" : "") . ")";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($params, ...$values);
    $stmt->execute();
  }

  // Redireciona para o comprovante
  header("Location: comprovante.php");
  exit;
}

echo "Acesso inválido.";
exit;

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Finalizar Compra</title>
  <link rel="stylesheet" href="../css/style.css">
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
    .metodo { margin: 15px 0; }
    .pix-img, .boleto-img { display: none; margin-top: 10px; max-width: 300px; }
    .form-cartao { display: none; margin-top: 10px; }
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
    <form onsubmit="enviarPagamento(event)">
      <div class="metodo">
        <input type="radio" name="pagamento" value="Pix" id="pix" required>
        <label for="pix">Pix</label><br>
        <img src="../img/pix_qrcode_exemplo.png" alt="Pix QR Code" class="pix-img" id="img-pix">
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
        <img src="../img/boleto_exemplo.png" alt="Boleto" class="boleto-img" id="img-boleto">
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

  function enviarPagamento(event) {
    event.preventDefault();

    const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
    const pagamento = document.querySelector('input[name="pagamento"]:checked');

    if (!pagamento) {
      alert("Selecione uma forma de pagamento.");
      return;
    }

    fetch("salvar_compra.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        carrinho: carrinho,
        pagamento: pagamento.value
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.redirect) {
        localStorage.removeItem("carrinho");
        window.location.href = data.redirect;
      } else {
        alert("Erro: " + (data.erro || "Erro inesperado"));
      }
    })
    .catch(() => alert("Erro ao finalizar a compra."));
  }
</script>


  
</body>
</html>
