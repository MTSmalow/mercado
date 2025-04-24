<?php
require_once 'conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conexao->prepare("SELECT id, nome, login FROM usuarios WHERE id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conexao->prepare("SELECT id, nome, login FROM usuarios");
        }
        
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        resposta(200, $usuarios);
        break;
        
    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        
        if (isset($dados['login']) && isset($dados['senha']) && !isset($dados['nome'])) {
            $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE login = :login");
            $stmt->bindParam(':login', $dados['login']);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario && password_verify($dados['senha'], $usuario['senha'])) {
                unset($usuario['senha']);
                resposta(200, ["mensagem" => "Login bem-sucedido", "usuario" => $usuario]);
            } else {
                resposta(401, ["mensagem" => "Login ou senha incorretos"]);
            }
        } else {
            if (!isset($dados['nome']) || !isset($dados['login']) || !isset($dados['senha'])) {
                resposta(400, ["mensagem" => "Dados incompletos para cadastro"]);
                exit();
            }
            
            $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome, login, senha) VALUES (:nome, :login, :senha)");
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':login', $dados['login']);
            $stmt->bindParam(':senha', $senhaHash);
            
            if ($stmt->execute()) {
                resposta(201, ["mensagem" => "Usuário cadastrado com sucesso!"]);
            } else {
                resposta(500, ["mensagem" => "Erro ao cadastrar usuário"]);
            }
        }
        break;
        
    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        
        $campos = [];
        $params = [':id' => $id];
        
        if (isset($dados['nome'])) {
            $campos[] = "nome = :nome";
            $params[':nome'] = $dados['nome'];
        }
        
        if (isset($dados['login'])) {
            $campos[] = "login = :login";
            $params[':login'] = $dados['login'];
        }
        
        if (isset($dados['senha'])) {
            $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);
            $campos[] = "senha = :senha";
            $params[':senha'] = $senhaHash;
        }
        
        if (empty($campos)) {
            resposta(400, ["mensagem" => "Nenhum dado fornecido para atualização"]);
            exit();
        }
        
        $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindParam($key, $value);
        }
        
        if ($stmt->execute()) {
            resposta(200, ["mensagem" => "Usuário atualizado com sucesso!"]);
        } else {
            resposta(500, ["mensagem" => "Erro ao atualizar usuário"]);
        }
        break;
        
    case 'DELETE':
        $id = $_GET['id'];
        
        if ($id == 1) {
            resposta(403, ["mensagem" => "Não é permitido excluir o usuário administrador padrão"]);
            exit();
        }
        
        $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
}