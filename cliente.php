<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Loja F1 - T-shirts</title>
  <link rel="stylesheet" href="css/style.css">
  <script>
    let carrinho = [];

    function adicionarAoCarrinho(id, nome, preco) {
      carrinho.push({ id, nome, preco });
      alert(`Produto "${nome}" adicionado ao carrinho!`);
    }

    function finalizarCompra() {
      fetch('php/simular_compra.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(carrinho)
      })
      .then(res => res.text())
      .then(msg => alert(msg));
    }
  </script>

  <header>
    <img src="img/logo_loja_f1.png" alt="Logo" class="logo">
    <a href="carrinho.html" id="carrinho-btn">🛒 Ver Carrinho</a>
  </header>
  
</head>


<body>
  <h2>Produtos Disponíveis</h2>

  <?php include 'php/listar_produtos.php'; ?>

  
  <br><br>
  <a href="cadastro_cliente.html">Cadastrar Cliente</a>

  <div id="modal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" onclick="fecharModal()">&times;</span>
    <img id="modal-img" src="" alt="" style="width:200px;height:200px;object-fit:contain;">
    <h2 id="modal-nome"></h2>
    <p id="modal-equipe"></p>
    <p id="modal-tamanho"></p>
    <p id="modal-preco" style="font-weight:bold;"></p>
    <button onclick="adicionarAoCarrinho()">Adicionar ao Carrinho</button>
  </div>
</div>


<footer>
    Loja F1 &copy; <?= date("Y") ?> — Desenvolvido para trabalho acadêmico
  </footer>

</body>
</html>

<script>
  let produtoSelecionado = null;

function abrirModal(produto) {
  produtoSelecionado = produto;
  document.getElementById('modal-img').src = "img/produtos/" + produto.imagem;
  document.getElementById('modal-nome').innerText = produto.nome;
  document.getElementById('modal-equipe').innerText = "Equipe: " + produto.equipe;
  document.getElementById('modal-tamanho').innerText = "Tamanho: " + produto.tamanho;
  document.getElementById('modal-preco').innerText = "R$ " + Number(produto.valor).toFixed(2).replace('.', ',');

  document.getElementById('modal').style.display = "flex";
}

function fecharModal() {
  document.getElementById('modal').style.display = "none";
}

function adicionarAoCarrinho() {
  let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  carrinho.push(produtoSelecionado);
  localStorage.setItem("carrinho", JSON.stringify(carrinho));
  alert("Produto adicionado ao carrinho!");
  fecharModal();
}

  </script>
