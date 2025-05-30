<?php
session_start();
include '../db/conexao.php';

// Verifica se cliente está logado
if (!isset($_SESSION['cliente_id'])) {
  header("Location: ../index.html");
  exit;
}

$cliente_id = $_SESSION['cliente_id'];
$cliente_nome = $_SESSION['cliente_nome'];

// Buscar histórico de compras
$sql_compras = "SELECT nome_produto, preco, data_compra FROM compras WHERE cliente_id = ? ORDER BY data_compra DESC";
$stmt_compras = $conn->prepare($sql_compras);
$stmt_compras->bind_param("i", $cliente_id);
$stmt_compras->execute();
$result_compras = $stmt_compras->get_result();

// Buscar carrinho (exemplo simplificado: tabela `carrinho` opcional)
$sql_carrinho = "SELECT nome_produto, preco FROM carrinho WHERE cliente_id = ?";
$stmt_carrinho = $conn->prepare($sql_carrinho);
$stmt_carrinho->bind_param("i", $cliente_id);
$stmt_carrinho->execute();
$result_carrinho = $stmt_carrinho->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Painel do Cliente</title>
  <link rel="stylesheet" href="../css/estilo.css">
  <style>
    .painel {
      display: flex;
      gap: 30px;
      padding: 30px;
    }

    .cliente-info {
      width: 250px;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .cliente-info h3 {
      margin: 0 0 5px;
      color: #d40000;
    }

    .painel-conteudo {
      flex: 1;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .secao {
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border-bottom: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f0f0f0;
    }
  </style>
</head>
<body>
  <div class="painel">
    <!-- Informações do Cliente -->
    <div class="cliente-info">
      <h3><?= htmlspecialchars($cliente_nome) ?></h3>
      <p>CPF: <?= htmlspecialchars($_SESSION['cpf_cliente']) ?? "Não informado" ?></p>
    </div>

    <!-- Conteúdo Principal -->
    <div class="painel-conteudo">
      <!-- Histórico de Compras -->
      <div class="secao">
        <h2>Histórico de Compras</h2>
        <?php if ($result_compras->num_rows > 0): ?>
          <table>
            <tr>
              <th>Produto</th>
              <th>Preço</th>
              <th>Data</th>
            </tr>
            <?php while ($compra = $result_compras->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($compra['nome_produto']) ?></td>
                <td>R$ <?= number_format($compra['preco'], 2, ',', '.') ?></td>
                <td><?= date("d/m/Y H:i", strtotime($compra['data_compra'])) ?></td>
              </tr>
            <?php endwhile; ?>
          </table>
        <?php else: ?>
          <p>Você ainda não realizou nenhuma compra.</p>
        <?php endif; ?>
      </div>

      <!-- Carrinho Atual -->
      <div class="secao">
        <h2>Carrinho Atual</h2>
        <?php if ($result_carrinho->num_rows > 0): ?>
          <table>
            <tr>
              <th>Produto</th>
              <th>Preço</th>
            </tr>
            <?php while ($item = $result_carrinho->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($item['nome_produto']) ?></td>
                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
              </tr>
            <?php endwhile; ?>
          </table>
        <?php else: ?>
          <p>Seu carrinho está vazio.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
