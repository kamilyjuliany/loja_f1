<?php
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !is_array($data)) {
  echo "Erro: carrinho inválido.";
  exit;
}

// Apenas simula — você pode salvar no banco se quiser
$total = 0;
foreach ($data as $item) {
  $total += floatval($item['preco']);
}

echo "Compra simulada com sucesso! Total: R$ " . number_format($total, 2, ',', '.');
?>
