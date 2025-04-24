async function carregarCategorias() {
    try {
        const response = await fetch('api/categorias.php');
        const categorias = await response.json();
        
        const tabela = document.querySelector("#tabelaCategorias tbody");
        tabela.innerHTML = '';
        
        categorias.forEach(categoria => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${categoria.id}</td>
                <td>${categoria.nome}</td>
                <td>
                    <button onclick="editarCategoria(${categoria.id})">Editar</button>
                    <button onclick="excluirCategoria(${categoria.id})">Excluir</button>
                </td>
            `;
            tabela.appendChild(row);
        });
    } catch (error) {
        console.error("Erro ao carregar categorias:", error);
        alert("Erro ao carregar categorias. Verifique o console para mais detalhes.");
    }
}

document.getElementById('formCategoria').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const categoria = {
        nome: document.getElementById('nomeCategoria').value
    };
    
    const categoriaId = document.getElementById('categoriaId').value;
    const url = categoriaId ? `api/categorias.php?id=${categoriaId}` : 'api/categorias.php';
    const method = categoriaId ? 'PUT' : 'POST';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(categoria)
        });
        
        if (response.ok) {
            alert(categoriaId ? 'Categoria atualizada com sucesso!' : 'Categoria cadastrada com sucesso!');
            limparFormCategoria();
            carregarCategorias();
            carregarCategoriasSelect(); 
        } else {
            throw new Error('Erro na requisição');
        }
    } catch (error) {
        console.error("Erro ao salvar categoria:", error);
        alert("Erro ao salvar categoria. Verifique o console para mais detalhes.");
    }
});

async function editarCategoria(id) {
    try {
        const response = await fetch(`api/categorias.php?id=${id}`);
        const categoria = await response.json();
        
        if (categoria.length > 0) {
            const c = categoria[0];
            document.getElementById('categoriaId').value = c.id;
            document.getElementById('nomeCategoria').value = c.nome;
            
            document.getElementById('formCategoria').scrollIntoView({ behavior: 'smooth' });
        }
    } catch (error) {
        console.error("Erro ao editar categoria:", error);
        alert("Erro ao editar categoria. Verifique o console para mais detalhes.");
    }
}

async function excluirCategoria(id) {
    if (confirm('Tem certeza que deseja excluir esta categoria? Os produtos associados a ela ficarão sem categoria.')) {
        try {
            const response = await fetch(`api/categorias.php?id=${id}`, {
                method: 'DELETE'
            });
            
            if (response.ok) {
                alert('Categoria excluída com sucesso!');
                carregarCategorias();
                carregarCategoriasSelect(); 
            } else {
                throw new Error('Erro na requisição');
            }
        } catch (error) {
            console.error("Erro ao excluir categoria:", error);
            alert("Erro ao excluir categoria. Verifique o console para mais detalhes.");
        }
    }
}

function limparFormCategoria() {
    document.getElementById('formCategoria').reset();
    document.getElementById('categoriaId').value = '';
}