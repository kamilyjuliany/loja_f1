<?php
include '../db/conexao.php';

$sql = "SELECT * FROM produtos ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo '<div class="grid">';
  while ($produto = $result->fetch_assoc()) {
    echo '<div class="card">';
    echo '<img src="img/produtos/' . htmlspecialchars($produto['imagem']) . '" alt="' . htmlspecialchars($produto['nome']) . '">';
    echo '<h3>' . htmlspecialchars($produto['nome']) . '</h3>';
    echo '<p>a partir de:</p>';
    echo '<p class="preco">R$ ' . number_format($produto['valor'], 2, ',', '.') . '</p>';
    echo '</div>';
  }
  echo '</div>';
} else {
  echo "Nenhum produto encontrado.";
}
?>
