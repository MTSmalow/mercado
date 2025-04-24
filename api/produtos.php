<?php
require_once 'conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conexao->prepare("SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id");
        }
        
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        resposta(200, $produtos);
        break;
        
    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $conexao->prepare("INSERT INTO produtos (nome, descricao, preco, quantidade_estoque, categoria_id) VALUES (:nome, :descricao, :preco, :quantidade, :categoria_id)");
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':descricao', $dados['descricao']);
        $stmt->bindParam(':preco', $dados['preco']);
        $stmt->bindParam(':quantidade', $dados['quantidade_estoque']);
        $stmt->bindParam(':categoria_id', $dados['categoria_id']);
        
        if ($stmt->execute()) {
            resposta(201, ["mensagem" => "Produto cadastrado com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao cadastrar produto"]);
        }
        break;
        
    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        
        $stmt = $conexao->prepare("UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, quantidade_estoque = :quantidade, categoria_id = :categoria_id WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':descricao', $dados['descricao']);
        $stmt->bindParam(':preco', $dados['preco']);
        $stmt->bindParam(':quantidade', $dados['quantidade_estoque']);
        $stmt->bindParam(':categoria_id', $dados['categoria_id']);
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Produto atualizado com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao atualizar produto"]);
        }
        break;
        
    case 'DELETE':
        $id = $_GET['id'];
        
        $stmt = $conexao->prepare("DELETE FROM produtos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Produto removido com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao remover produto"]);
        }
        break;
}
?>