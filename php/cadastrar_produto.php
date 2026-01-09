<?php
include '../db/conexao.php';

// Dados do formulário
$nome = $_POST['nome'];
$valor = $_POST['valor'];
$tamanho = $_POST['tamanho'];
$equipe = $_POST['equipe'];

// Lida com a imagem
$imagem_nome = $_FILES['imagem']['name'];
$imagem_tmp = $_FILES['imagem']['tmp_name'];
$caminho_destino = '../img/produtos/' . $imagem_nome;

// Move o arquivo
move_uploaded_file($imagem_tmp, $caminho_destino);

// Salva no banco
$sql = "INSERT INTO produtos (nome, valor, tamanho, equipe, imagem) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsss", $nome, $valor, $tamanho, $equipe, $imagem_nome);

if ($stmt->execute()) {
    header("Location: painel_vendedor.php?sucesso=1");
    exit;
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$conn->close();
?>
