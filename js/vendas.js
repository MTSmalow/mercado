async function carregarVendas() {
    try {
        const response = await fetch('api/vendas.php');
        const vendas = await response.json();
        
        const tabela = document.querySelector("#tabelaVendas tbody");
        tabela.innerHTML = '';
        
        vendas.forEach(venda => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${venda.id}</td>
                <td>${new Date(venda.data).toLocaleString()}</td>
                <td>${venda.cliente_nome || 'Consumidor'}</td>
                <td>R$ ${parseFloat(venda.valor_total).toFixed(2)}</td>
                <td>
                    <button onclick="detalhesVenda(${venda.id})">Detalhes</button>
                </td>
            `;
            tabela.appendChild(row);
        });
    } catch (error) {
        console.error("Erro ao carregar vendas:", error);
        alert("Erro ao carregar vendas. Verifique o console para mais detalhes.");
    }
}

async function detalhesVenda(id) {
    try {
        const response = await fetch(`api/vendas.php?id=${id}`);
        const venda = await response.json();
        
        if (venda.length > 0) {
            let detalhes = `Venda #${venda[0].id}\n`;
            detalhes += `Data: ${new Date(venda[0].data).toLocaleString()}\n`;
            detalhes += `Cliente: ${venda[0].cliente_nome || 'Consumidor'}\n`;
            detalhes += `Valor Total: R$ ${parseFloat(venda[0].valor_total).toFixed(2)}\n\n`;
            detalhes += `Itens:\n`;
            
            venda.forEach(item => {
                detalhes += `- ${item.produto_nome}: ${item.quantidade} x R$ ${parseFloat(item.preco_unitario).toFixed(2)} = R$ ${parseFloat(item.subtotal).toFixed(2)}\n`;
            });
            
            alert(detalhes);
        }
    } catch (error) {
        console.error("Erro ao obter detalhes da venda:", error);
        alert("Erro ao obter detalhes da venda. Verifique o console para mais detalhes.");
    }
}