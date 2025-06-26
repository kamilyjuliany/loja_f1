<?php
session_start();
include '../db/conexao.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["erro" => "Método não permitido"]);
  exit;
}

$dados = json_decode(file_get_contents("php://input"), true);

if (!isset($dados['carrinho']) || !isset($dados['pagamento'])) {
  http_response_code(400);
  echo json_encode(["erro" => "Dados incompletos"]);
  exit;
}

$forma_pagamento = $dados['pagamento'];
$carrinho = $dados['carrinho'];
$data_compra = date('Y-m-d H:i:s');
$_SESSION['ultima_compra'] = $data_compra;

foreach ($carrinho as $item) {
  $nome = $conn->real_escape_string($item['nome']);
  $valor = floatval($item['valor']);
  $qtd = intval($item['quantidade']);

  if (isset($_SESSION['id_cliente'])) {
    $sql = "INSERT INTO compras (nome_produto, preco, quantidade, forma_pagamento, data_compra, id_cliente)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdissi", $nome, $valor, $qtd, $forma_pagamento, $data_compra, $_SESSION['id_cliente']);
  } else {
    $sql = "INSERT INTO compras (nome_produto, preco, quantidade, forma_pagamento, data_compra)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiss", $nome, $valor, $qtd, $forma_pagamento, $data_compra);
  }

  $stmt->execute();
  
}

$_SESSION['ultima_compra'] = $data_compra;

echo json_encode(["redirect" => "php/comprovante.php"]);
