
<?php

session_start();
include('conexao.php');


if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];


    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->bindParam(':id', $id_produto);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        echo "Produto não encontrado.";
        exit;
    }
} else {
    echo "ID do produto não fornecido.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem']['name'];


    if (!empty($imagem)) {
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem_destino = "perifericos/".basename($imagem);
        move_uploaded_file($imagem_temp, $imagem_destino);
    } else {

        $imagem_destino = $produto['imagem'];
    }

    $stmt = $pdo->prepare("UPDATE produtos SET nome = :nome, preco = :preco, categoria = :categoria, descricao = :descricao, imagem = :imagem WHERE id = :id");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':imagem', $imagem_destino);
    $stmt->bindParam(':id', $id_produto);

    if ($stmt->execute()) {
        echo "Produto atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar produto.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Editar Produto</h2>
    <form action="editar_produto.php?id=<?php echo $id_produto; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">


        <div class="form-group">
            <label for="id">ID do Produto</label>
            <input type="text" id="id" name="id" value="<?php echo $produto['id']; ?>" disabled>
        </div>

        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" id="nome" name="nome" value="<?php echo $produto['nome']; ?>" required>
        </div>

        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="text" id="preco" name="preco" value="<?php echo $produto['preco']; ?>" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoria</label>
            <select id="categoria" name="categoria" required>
                <option value="teclado" <?php if ($produto['categoria'] == 'teclado') echo 'selected'; ?>>Teclado</option>
                <option value="mouse" <?php if ($produto['categoria'] == 'mouse') echo 'selected'; ?>>Mouse</option>
                <option value="headset" <?php if ($produto['categoria'] == 'headset') echo 'selected'; ?>>Headset</option>
                <option value="monitor" <?php if ($produto['categoria'] == 'monitor') echo 'selected'; ?>>Monitor</option>
                <option value="gabinete" <?php if ($produto['categoria'] == 'gabinete') echo 'selected'; ?>>Gabinete</option>
                <option value="processador" <?php if ($produto['categoria'] == 'processador') echo 'selected'; ?>>Processador</option>
                <option value="fonte" <?php if ($produto['categoria'] == 'fonte') echo 'selected'; ?>>Fonte</option>
                <option value="memoria ram" <?php if ($produto['categoria'] == 'memoria ram') echo 'selected'; ?>>Memória RAM</option>
                <option value="ssd" <?php if ($produto['categoria'] == 'ssd') echo 'selected'; ?>>SSD</option>
                <option value="hd" <?php if ($produto['categoria'] == 'hd') echo 'selected'; ?>>HD</option>
                <option value="placa de video" <?php if ($produto['categoria'] == 'placa de video') echo 'selected'; ?>>Placa de Vídeo</option>
                <option value="placa mae" <?php if ($produto['categoria'] == 'placa mae') echo 'selected'; ?>>Placa Mãe</option>
                <option value="mousepad" <?php if ($produto['categoria'] == 'mousepad') echo 'selected'; ?>>Mousepad</option>
                <option value="microfone" <?php if ($produto['categoria'] == 'microfone') echo 'selected'; ?>>Microfone</option>
                <option value="gift card" <?php if ($produto['categoria'] == 'gift card') echo 'selected'; ?>>Gift Card</option>
            </select>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" required><?php echo $produto['descricao']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="imagem">Imagem do Produto</label>
            <input type="file" id="imagem" name="imagem">
        </div>

        <div class="form-group">
            <button type="submit">Atualizar Produto</button>
        </div>
    </form>
</div>

</body>
</html>
