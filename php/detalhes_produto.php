<?php
include '../db/conexao.php';

if (!isset($_GET['id'])) {
  echo "Produto não encontrado.";
  exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  echo "Produto não encontrado.";
  exit;
}

$produto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($produto['nome']) ?></title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .detalhes {
      max-width: 600px;
      margin: 40px auto;
      text-align: center;
    }

    .detalhes img {
      width: 300px;
      height: 300px;
      object-fit: contain;
      border-radius: 8px;
    }

    .detalhes h1 {
      margin-top: 20px;
    }

    .detalhes .valor {
      font-size: 24px;
      font-weight: bold;
      margin: 10px 0;
    }

    .detalhes button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: green;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="detalhes">
    <img src="../img/produtos/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
    <h1><?= htmlspecialchars($produto['nome']) ?></h1>
    <p>Tamanho: <?= htmlspecialchars($produto['tamanho']) ?></p>
    <p>Equipe: <?= htmlspecialchars($produto['equipe']) ?></p>
    <p class="valor">R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>

    <form action="adicionar_carrinho.php" method="POST">
      <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
      <button type="submit">Adicionar ao Carrinho</button>
    </form>
  </div>
</body>
</html>
