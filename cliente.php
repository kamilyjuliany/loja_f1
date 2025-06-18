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

<!-- filtro de equipes -->
<div class="filter-bar">
  <button class="filter-btn active" data-team="All">Todas</button>

  <button class="filter-btn" data-team="Ferrari">
    <img src="img/equipes/ferrari.jpg" alt="Ferrari">
  </button>

  <button class="filter-btn" data-team="Mercedes">
    <img src="img/equipes/mercedes.jpg" alt="Mercedes">
  </button>

  <button class="filter-btn" data-team="RedBull">
    <img src="img/equipes/redbull.jpg" alt="Red Bull">
  </button>

  <button class="filter-btn" data-team="McLaren">
    <img src="img/equipes/mclaren.png" alt="McLaren">
  </button>

  <button class="filter-btn" data-team="Haas">
    <img src="img/equipes/haas.jpg" alt="Haas">
  </button>

  <button class="filter-btn" data-team="Williams">
    <img src="img/equipes/williams.png" alt="Williams">
  </button>

  <button class="filter-btn" data-team="Stake">
    <img src="img/equipes/stake.jpg" alt="Stake">
  </button>

  <button class="filter-btn" data-team="Visa Cash">
    <img src="img/equipes/visacash.png" alt="Visa Cash">
  </button>

  <button class="filter-btn" data-team="Aston Martin">
    <img src="img/equipes/astonmartin.png" alt="Aston Martin">
  </button>

  <button class="filter-btn" data-team="Alpine">
    <img src="img/equipes/alpine.jpg" alt="Alpine">
  </button>
</div>


<script>
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      // marca só o botão clicado como ativo
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const team = btn.dataset.team; // pode ser "All" ou nome da equipe
      document.querySelectorAll('.product-card').forEach(card => {
        if (team === 'All' || card.dataset.team === team) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
</script>


  <?php include 'php/listar_produtos.php'; ?>

  
  <br><br>
  

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
