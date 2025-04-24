async function carregarClientes() {
    try {
        const response = await fetch('api/clientes.php');
        const clientes = await response.json();
        
        const tabela = document.querySelector("#tabelaClientes tbody");
        tabela.innerHTML = '';
        
        clientes.forEach(cliente => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${cliente.id}</td>
                <td>${cliente.nome}</td>
                <td>${cliente.telefone || '-'}</td>
                <td>${cliente.cpf || '-'}</td>
                <td>${cliente.email || '-'}</td>
                <td>
                    <button onclick="editarCliente(${cliente.id})">Editar</button>
                    <button onclick="excluirCliente(${cliente.id})">Excluir</button>
                </td>
            `;
            tabela.appendChild(row);
        });
    } catch (error) {
        console.error("Erro ao carregar clientes:", error);
        alert("Erro ao carregar clientes. Verifique o console para mais detalhes.");
    }
}

document.getElementById('formCliente').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const cliente = {
        nome: document.getElementById('nomeCliente').value,
        telefone: document.getElementById('telefone').value,
        cpf: document.getElementById('cpf').value,
        email: document.getElementById('email').value
    };
    
    const clienteId = document.getElementById('clienteId').value;
    const url = clienteId ? `api/clientes.php?id=${clienteId}` : 'api/clientes.php';
    const method = clienteId ? 'PUT' : 'POST';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(cliente)
        });
        
        if (response.ok) {
            alert(clienteId ? 'Cliente atualizado com sucesso!' : 'Cliente cadastrado com sucesso!');
            limparFormCliente();
            carregarClientes();
        } else {
            throw new Error('Erro na requisição');
        }
    } catch (error) {
        console.error("Erro ao salvar cliente:", error);
        alert("Erro ao salvar cliente. Verifique o console para mais detalhes.");
    }
});

async function editarCliente(id) {
    try {
        const response = await fetch(`api/clientes.php?id=${id}`);
        const cliente = await response.json();
        
        if (cliente.length > 0) {
            const c = cliente[0];
            document.getElementById('clienteId').value = c.id;
            document.getElementById('nomeCliente').value = c.nome;
            document.getElementById('telefone').value = c.telefone || '';
            document.getElementById('cpf').value = c.cpf || '';
            document.getElementById('email').value = c.email || '';
            
            
            document.getElementById('formCliente').scrollIntoView({ behavior: 'smooth' });
        }
    } catch (error) {
        console.error("Erro ao editar cliente:", error);
        alert("Erro ao editar cliente. Verifique o console para mais detalhes.");
    }
}

async function excluirCliente(id) {
    if (confirm('Tem certeza que deseja excluir este cliente?')) {
        try {
            const response = await fetch(`api/clientes.php?id=${id}`, {
                method: 'DELETE'
            });
            
            if (response.ok) {
                alert('Cliente excluído com sucesso!');
                carregarClientes();
            } else {
                throw new Error('Erro na requisição');
            }
        } catch (error) {
            console.error("Erro ao excluir cliente:", error);
            alert("Erro ao excluir cliente. Verifique o console para mais detalhes.");
        }
    }
}

function limparFormCliente() {
    document.getElementById('formCliente').reset();
    document.getElementById('clienteId').value = '';
}