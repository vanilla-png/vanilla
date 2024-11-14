

<?php

include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    

    $target_dir = "perifericos/";
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
    
    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {

        $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, imagem) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $preco, $target_file]);

        header("Location: admin_dashboard.php"); 
        exit;
    } else {
        echo "Desculpe, ocorreu um erro ao fazer o upload da imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="css/admin.css"> 
</head>
<body>
    <h2>Adicionar Novo Produto</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nome">Descrição do produto:</label>
        <input type="text" name="nome" required>

        <label for="preco">Preço:</label>
        <input type="number" name="preco" step="0.01" required>

        <label for="imagem">Imagem do Produto:</label>
        <input type="file" name="imagem" accept="image/*" required>

        <label for="categoria">Categoria:</label>
    <select name="categoria" id="categoria" required>
        <option value="teclado">Teclado</option>
        <option value="mouse">Mouse</option>
        <option value="headset">Headset</option>
        <option value="monitor">Monitor</option>
        <option value="gabinete">Gabinete</option>
        <option value="processador">Processador</option>
        <option value="fonte">Fonte</option>
        <option value="memoria ram">Memória RAM</option>
        <option value="ssd">SSD</option>
        <option value="hd">HD</option>
        <option value="placa de video">Placa de Vídeo</option>
        <option value="placa mae">Placa Mãe</option>
        <option value="mousepad">Mousepad</option>
        <option value="microfone">Microfone</option>
        <option value="gift card">Gift Card</option>
    </select><br>

        <button type="submit">Adicionar Produto</button>
    </form>
    <?php
// Inclui a conexão com o banco de dados
include 'conexao.php';

// Recupera todos os produtos do banco de dados
$sql = "SELECT * FROM produtos";
$stmt = $pdo->query($sql);

// Verifica se há produtos e exibe a tabela
?>
<h2>Lista de Produtos</h2>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Ações</th>
    </tr>

    <?php
    if ($stmt->rowCount() > 0) {
        // Itera pelos produtos
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>" . $row['categoria'] . "</td>";
            echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
            echo "<td>";
            echo "<a href='editar_produto.php?id=" . $row['id'] . "'>Editar</a> | ";
            echo "<a href='excluir_produto.php?id=" . $row['id'] . "' onclick=\"return confirm('Tem certeza que deseja excluir este produto?')\">Excluir</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Nenhum produto encontrado.</td></tr>";
    }
    ?>
</table>

    
</body>
</html>
