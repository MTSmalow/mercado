async function carregarProdutos() {
    try {
        const response = await fetch('api/produtos.php');
        const produtos = await response.json();
        
        const tabela = document.querySelector("#tabelaProdutos tbody");
        tabela.innerHTML = '';
        
        produtos.forEach(produto => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${produto.id}</td>
                <td>${produto.nome}</td>
                <td>R$ ${parseFloat(produto.preco).toFixed(2)}</td>
                <td>${produto.quantidade_estoque}</td>
                <td>${produto.categoria_nome || 'Sem categoria'}</td>
                <td>
                    <button onclick="editarProduto(${produto.id})">Editar</button>
                    <button onclick="excluirProduto(${produto.id})">Excluir</button>
                </td>
            `;
            tabela.appendChild(row);
        });
    } catch (error) {
        console.error("Erro ao carregar produtos:", error);
        alert("Erro ao carregar produtos. Verifique o console para mais detalhes.");
    }
}

async function carregarCategoriasSelect() {
    try {
        const response = await fetch('api/categorias.php');
        const categorias = await response.json();
        
        const select = document.getElementById('categoria');
        select.innerHTML = '<option value="">Selecione...</option>';
        
        categorias.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria.id;
            option.textContent = categoria.nome;
            select.appendChild(option);
        });
    } catch (error) {
        console.error("Erro ao carregar categorias:", error);
    }
}

document.getElementById('formProduto').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const produto = {
        nome: document.getElementById('nome').value,
        descricao: document.getElementById('descricao').value,
        preco: parseFloat(document.getElementById('preco').value),
        quantidade_estoque: parseInt(document.getElementById('quantidade').value),
        categoria_id: document.getElementById('categoria').value || null
    };
    
    const produtoId = document.getElementById('produtoId').value;
    const url = produtoId ? `api/produtos.php?id=${produtoId}` : 'api/produtos.php';
    const method = produtoId ? 'PUT' : 'POST';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(produto)
        });
        
        if (response.ok) {
            alert(produtoId ? 'Produto atualizado com sucesso!' : 'Produto cadastrado com sucesso!');
            limparFormProduto();
            carregarProdutos();
        } else {
            throw new Error('Erro na requisição');
        }
    } catch (error) {
        console.error("Erro ao salvar produto:", error);
        alert("Erro ao salvar produto. Verifique o console para mais detalhes.");
    }
});

async function editarProduto(id) {
    try {
        const response = await fetch(`api/produtos.php?id=${id}`);
        const produto = await response.json();
        
        if (produto.length > 0) {
            const p = produto[0];
            document.getElementById('produtoId').value = p.id;
            document.getElementById('nome').value = p.nome;
            document.getElementById('descricao').value = p.descricao;
            document.getElementById('preco').value = p.preco;
            document.getElementById('quantidade').value = p.quantidade_estoque;
            document.getElementById('categoria').value = p.categoria_id;
            
            document.getElementById('formProduto').scrollIntoView({ behavior: 'smooth' });
        }
    } catch (error) {
        console.error("Erro ao editar produto:", error);
        alert("Erro ao editar produto. Verifique o console para mais detalhes.");
    }
}

async function excluirProduto(id) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        try {
            const response = await fetch(`api/produtos.php?id=${id}`, {
                method: 'DELETE'
            });
            
            if (response.ok) {
                alert('Produto excluído com sucesso!');
                carregarProdutos();
            } else {
                throw new Error('Erro na requisição');
            }
        } catch (error) {
            console.error("Erro ao excluir produto:", error);
            alert("Erro ao excluir produto. Verifique o console para mais detalhes.");
        }
    }
}

function limparFormProduto() {
    document.getElementById('formProduto').reset();
    document.getElementById('produtoId').value = '';
}
