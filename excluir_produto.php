<?php
// Inclui a conexão com o banco de dados
include 'conexao.php';  // Inclua o arquivo de conexão corretamente

// Verifica se o ID foi passado pela URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_produto = $_GET['id'];

    try {
        // Prepara a consulta para excluir o produto
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Vincula o valor do ID na consulta
        $stmt->bindParam(':id', $id_produto, PDO::PARAM_INT);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "Produto excluído com sucesso!";
        } else {
            echo "Erro ao excluir o produto.";
        }
    } catch (PDOException $e) {
        echo "Erro ao excluir o produto: " . $e->getMessage();
    }
} else {
    echo "ID do produto não fornecido.";
}
?>
