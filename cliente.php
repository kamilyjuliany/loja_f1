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

<style>
  .notificacao {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #28a745;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 0 8px rgba(0,0,0,0.2);
    z-index: 9999;
    font-weight: bold;
    animation: fadein 0.3s ease, fadeout 0.5s ease 1.5s;
  }

  @keyframes fadein {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes fadeout {
    from { opacity: 1; }
    to { opacity: 0; transform: translateY(-10px); }
  }
</style>

  <header>
    <img src="img/logo_loja_f1.png" alt="Logo" class="logo">
    <a href="carrinho.html" id="carrinho-btn">🛒 Ver Carrinho</a>
    <div style="text-align: center; margin-top: 20px;">

  <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
  <a href="php/login_cliente.php">
    <button style="
      padding: 10px 25px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    " onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
      Login Cliente
    </button>
  </a>

  <a href="php/cadastrar_cliente.php">
    <button style="
      padding: 10px 25px;
      background-color: green;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    " onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
      Cadastrar Cliente
    </button>
  </a>
</div>


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
  

  <div id="modal" class="modal">
  <div class="modal-content fade-in">
    <span class="close-btn" onclick="fecharModal()">&times;</span>

    <img id="modal-img" src="" alt="" class="modal-img">

    <h2 id="modal-nome" class="modal-title"></h2>
    <p id="modal-equipe" class="modal-info"></p>
    <p id="modal-tamanho" class="modal-info"></p>
    <p id="modal-preco" class="modal-price"></p>

    <label for="quantidade" class="modal-label">Quantidade:</label>
    <div class="quantidade-container">
      <input type="number" id="modal-quantidade" min="1" value="1" class="quantidade-input">
    </div>

    <button onclick="adicionarAoCarrinho()" class="btn-add">Adicionar ao Carrinho</button>
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
  document.getElementById('modal-quantidade').value = 1;

  document.getElementById('modal').style.display = "flex";
}

function fecharModal() {
  document.getElementById('modal').style.display = "none";
}

function adicionarAoCarrinho() {
  let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

  const quantidade = parseInt(document.getElementById("modal-quantidade").value);
  if (quantidade <= 0) {
    alert("Quantidade inválida");
    return;
  }

  carrinho.push({
    ...produtoSelecionado,
    quantidade: quantidade
  });

  localStorage.setItem("carrinho", JSON.stringify(carrinho));
  mostrarNotificacao("Produto adicionado ao carrinho!");
  fecharModal();
}

function mostrarNotificacao(mensagem) {
  const notif = document.createElement("div");
  notif.className = "notificacao";
  notif.innerText = mensagem;
  document.body.appendChild(notif);

  setTimeout(() => {
    notif.remove();
  }, 2000);
}


</script>