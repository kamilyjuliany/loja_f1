<?php
include '../db/conexao.php';

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($produto = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h3>{$produto['nome']}</h3>";
    echo "<p>R$ {$produto['valor']} - Tamanho: {$produto['tamanho']} - Equipe: {$produto['equipe']}</p>";
    echo "<button onclick=\"adicionarAoCarrinho({$produto['id']}, '{$produto['nome']}', {$produto['valor']})\">Adicionar ao Carrinho</button>";
    echo "</div><hr>";
  }
} else {
  echo "Nenhum produto encontrado.";
}

$conn->close();
?>
