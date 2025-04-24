# Projeto mercado
## 📘 Contexto<br>
Você foi contratado como desenvolvedor para criar o sistema de gerenciamento de um mercadinho de bairro,
que precisa informatizar suas operações básicas: cadastro de produtos, controle de estoque, vendas,
clientes e usuários do sistema. A solução deverá utilizar PHP com MySQL, uma API para comunicação entre o back-end e o front-end (HTML),
e exibir os dados de forma organizada na interface.
<br>
## 🎯 Objetivo

  Criar uma base de dados relacional com no mínimo 5 tabelas e desenvolver uma API em PHP que permita:<br>
  Inserir dados no banco<br>
  Listar registros<br>
  Atualizar informações<br>
  Deletar registros<br>
  Esses dados deverão ser consumidos por uma interface HTML simples, que represente visualmente os principais recursos do sistema.<br>

## 🗃️ Requisitos da Base de Dados
  A base de dados deve conter pelo menos as seguintes tabelas:<br>
  produtos – nome, descrição, preço, quantidade em estoque, id da categoria<br>
  categorias – nome da categoria (ex: alimentos, bebidas, limpeza, etc.)<br>
  clientes – nome, telefone, CPF, e-mail<br>
  vendas – id do cliente, data da venda, valor total<br>
  usuarios – nome do usuário, login, senha (criptografada - opcional)<br>
  As tabelas devem conter chaves primárias e estrangeiras, respeitando a integridade referencial.<br>
<br>
## 🧩 API (PHP) – Mínimo esperado
  A API deverá permitir:<br>
    -GET: listar dados de cada tabela<br>
    -POST: inserir novos registros<br>
    -PUT ou PATCH: atualizar registros existentes<br>
    -DELETE: remover registros<br>
    Use PHP procedural ou orientado a objetos, com organização mínima dos arquivos (ex: conexao.php, produtos.php, etc.)<br>
<br>
## 🖥️ Interface HTML<br>
  Crie uma página HTML com design simples, contendo:<br>
  -Formulários para cadastrar produtos, clientes e categorias<br>
  -Botões para listar e remover dados<br>
  -Exibição das vendas registradas (listagem)<br>
  -A comunicação com a API pode ser feita via JavaScript (Fetch ou AJAX).<br>
<br>
## 🧪 Entrega<br>
  Banco de dados (.sql)<br>
  Arquivos PHP da API<br>
  Interface HTML com integração funcionando<br>
  Instruções simples de uso (em um README.txt ou no próprio HTML)<br>

# utilização

## Instalação

1. Importe o arquivo `mercadinho.sql` para seu MySQL
2. Configure os dados de conexão no arquivo `api/conexao.php`
3. Coloque todos os arquivos em um servidor web com suporte a PHP

## Uso

1. Acesse o sistema através do arquivo `index.html`
2. Navegue entre as abas para acessar as diferentes funcionalidades
3. Utilize os formulários para cadastrar novos itens
4. Use os botões de editar e excluir para gerenciar os registros

## Credenciais padrão

- Login: admin
- Senha: 123456
