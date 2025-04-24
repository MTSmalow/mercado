<?php
require_once 'conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conexao->prepare("SELECT * FROM clientes WHERE id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conexao->prepare("SELECT * FROM clientes");
        }
        
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        resposta(200, $clientes);
        break;
        
    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $conexao->prepare("INSERT INTO clientes (nome, telefone, cpf, email) VALUES (:nome, :telefone, :cpf, :email)");
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':telefone', $dados['telefone']);
        $stmt->bindParam(':cpf', $dados['cpf']);
        $stmt->bindParam(':email', $dados['email']);
        
        if ($stmt->execute()) {
            resposta(201, ["mensagem" => "Cliente cadastrado com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao cadastrar cliente"]);
        }
        break;
        
    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        
        $stmt = $conexao->prepare("UPDATE clientes SET nome = :nome, telefone = :telefone, cpf = :cpf, email = :email WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':telefone', $dados['telefone']);
        $stmt->bindParam(':cpf', $dados['cpf']);
        $stmt->bindParam(':email', $dados['email']);
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Cliente atualizado com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao atualizar cliente"]);
        }
        break;
        
    case 'DELETE':
        $id = $_GET['id'];
        
        $stmt = $conexao->prepare("DELETE FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Cliente removido com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao remover cliente"]);
        }
        break;
}
?>