<?php
require_once 'conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conexao->prepare("SELECT v.*, c.nome as cliente_nome FROM vendas v LEFT JOIN clientes c ON v.cliente_id = c.id WHERE v.id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conexao->prepare("SELECT v.*, c.nome as cliente_nome FROM vendas v LEFT JOIN clientes c ON v.cliente_id = c.id ORDER BY v.data_venda DESC");
        }
        
        $stmt->execute();
        $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        resposta(200, $vendas);
        break;
        
    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($dados['cliente_id']) || !isset($dados['valor_total']) || $dados['valor_total'] <= 0) {
            resposta(400, ["mensagem" => "Dados inválidos para cadastro de venda"]);
            exit();
        }
        
        $stmt = $conexao->prepare("INSERT INTO vendas (cliente_id, valor_total) VALUES (:cliente_id, :valor_total)");
        $stmt->bindParam(':cliente_id', $dados['cliente_id']);
        $stmt->bindParam(':valor_total', $dados['valor_total']);
        
        if ($stmt->execute()) {
            resposta(201, ["mensagem" => "Venda registrada com sucesso!", "id" => $conexao->lastInsertId()]);
        } else {
            resposta(500, ["mensagem" => "Erro ao registrar venda"]);
        }
        break;
        
    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        
        $stmt = $conexao->prepare("UPDATE vendas SET cliente_id = :cliente_id, valor_total = :valor_total WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cliente_id', $dados['cliente_id']);
        $stmt->bindParam(':valor_total', $dados['valor_total']);
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Venda atualizada com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao atualizar venda"]);
        }
        break;
        
    case 'DELETE':
        $id = $_GET['id'];
        
        $stmt = $conexao->prepare("DELETE FROM vendas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Venda removida com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao remover venda"]);
        }
        break;
}
?>