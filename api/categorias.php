<?php
require_once 'conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conexao->prepare("SELECT * FROM categorias WHERE id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conexao->prepare("SELECT * FROM categorias");
        }
        
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        resposta(200, $categorias);
        break;
        
    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $conexao->prepare("INSERT INTO categorias (nome) VALUES (:nome)");
        $stmt->bindParam(':nome', $dados['nome']);
        
        if ($stmt->execute()) {
            resposta(201, ["mensagem" => "Categoria cadastrada com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao cadastrar categoria"]);
        }
        break;
        
    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        
        $stmt = $conexao->prepare("UPDATE categorias SET nome = :nome WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $dados['nome']);
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Categoria atualizada com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao atualizar categoria"]);
        }
        break;
        
    case 'DELETE':
        $id = $_GET['id'];
        
        $stmt = $conexao->prepare("SELECT COUNT(*) as total FROM produtos WHERE categoria_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado['total'] > 0) {
            resposta(400, ["mensagem" => "Não é possível excluir esta categoria pois existem produtos associados a ela"]);
            exit();
        }
        
        $stmt = $conexao->prepare("DELETE FROM categorias WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Categoria removida com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao remover categoria"]);
        }
        break;
}
?>