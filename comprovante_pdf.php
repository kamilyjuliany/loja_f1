<?php
require '../vendor/autoload.php';

use Dompdf\Dompdf;

session_start();
include '../db/conexao.php';

if (!isset($_SESSION['id_cliente'])) {
  die("Cliente não autenticado.");
}

$id_cliente = $_SESSION['id_cliente'];

if (!isset($_GET['data'])) {
  die("Dados inválidos.");
}
$data_compra = $_GET['data'];

// Buscar os produtos dessa compra
$sql = "SELECT nome_produto, preco, quantidade, forma_pagamento, data_compra
        FROM compras
        WHERE id_cliente = ? AND data_compra = ?
        ORDER BY data_compra DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id_cliente, $data_compra);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$html = '<h2 style="text-align:center; color:green;">Comprovante de Compra</h2>';
$html .= '<div style="font-family:Arial; font-size:14px;">';

while ($row = $result->fetch_assoc()) {
  $subtotal = $row['preco'] * $row['quantidade'];
  $total += $subtotal;
  $html .= "<p><strong>{$row['nome_produto']}</strong><br>
           Quantidade: {$row['quantidade']}<br>
           Preço unitário: R$ " . number_format($row['preco'], 2, ',', '.') . "<br>
           Subtotal: R$ " . number_format($subtotal, 2, ',', '.') . "<br>
           Forma de pagamento: {$row['forma_pagamento']}<br>
           Data: " . date('d/m/Y H:i', strtotime($row['data_compra'])) . "</p><hr>";
}

$html .= "<p style='text-align:right; font-weight:bold;'>Total da compra: R$ " . number_format($total, 2, ',', '.') . "</p>";
$html .= '</div>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("comprovante_compra.pdf", ["Attachment" => false]);
exit;

<div class="voltar" style="margin-top: 20px;">
  <a href="comprovante_pdf.php?data=<?= urlencode($data_compra) ?>" target="_blank">
    <button style="background: navy;">Gerar PDF</button>
  </a>
</div>
