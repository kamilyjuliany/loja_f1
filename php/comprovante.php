<?php
session_start();
include '../db/conexao.php';

if (!isset($_SESSION['id_cliente'])) {
  die("Cliente não autenticado.");
}

$id_cliente = $_SESSION['id_cliente'];

// Recebe os dados da compra (vindo via POST do carrinho)
$dados = json_decode(file_get_contents("php://input"), true);

if (!$dados || !isset($dados['carrinho']) || !isset($dados['pagamento'])) {
  die("Dados inválidos.");
}

$carrinho = $dados['carrinho'];
$forma_pagamento = $dados['pagamento'];

// Insere cada item da compra no banco
foreach ($carrinho as $item) {
  $nome = $item['nome'];
  $valor = $item['valor'];
  $qtd = $item['quantidade'];

  $stmt = $conn->prepare("INSERT INTO compras (id_cliente, nome_produto, preco, quantidade, forma_pagamento) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("isdss", $id_cliente, $nome, $valor, $qtd, $forma_pagamento);
  $stmt->execute();
}

// Redireciona para gerar o comprovante
header("Location: comprovante.php");
exit;
