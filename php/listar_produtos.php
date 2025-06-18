<?php
include 'db/conexao.php';
$sql = "SELECT * FROM produtos ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo '<div class="product-grid">';
  while ($p = $result->fetch_assoc()) {
    // cada card recebe um atributo data-team
    echo '<div class="product-card" data-team="'.htmlspecialchars($p['equipe']).'">';
    echo '<img src="img/produtos/'.htmlspecialchars($p['imagem']).'" alt="'.htmlspecialchars($p['nome']).'">';
    echo '<h3>'.htmlspecialchars($p['nome']).'</h3>';
    echo '<p class="preco">a partir de:</p>';
    echo '<p class="preco-valor">R$ '.number_format($p['valor'],2,',','.').'</p>';
    echo '</div>';
  }
  echo '</div>';
} else {
  echo '<p style="text-align:center;">Nenhum produto encontrado.</p>';
}
?>
