const API_PEDIDOS = "http://localhost/loja_magica/api/pedidos.php";
const API_CLIENTES = "http://localhost/loja_magica/api/clientes.php";

$(document).ready(function() {
    carregarPedidos();

    // Evento para salvar pedido via modal
    $("#salvarPedidoModalBtn").click(function() {
        salvarPedidoModal();
    });

    // Event delegation para os botões de editar e excluir
    $(document).on('click', '.editar-pedido-btn', function() {
        let id = $(this).data('id');
        let clienteId = $(this).data('cliente_id');
        let produtos = $(this).data('produtos');
        let dataPedido = $(this).data('data_pedido');
        let valor = $(this).data('valor');
        editarPedido(id, clienteId, produtos, dataPedido, valor);
    });

    $(document).on('click', '.excluir-pedido-btn', function() {
        let id = $(this).data('id');
        excluirPedido(id);
    });
    
    // Carrega o select de clientes sempre que o modal for aberto
    $('#pedidoModal').on('show.bs.modal', function () {
        carregarClientesSelect();
    });

    $('#pedidoModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $("#pedidoIdModal").val("");
        $("#modalClienteId").prop("disabled", false); // Reabilita o dropdown para novo pedido
        $("#pedidoModalLabel").text("Novo Pedido");
    });
});

function carregarPedidos() {
    $.get(API_PEDIDOS, function(pedidos) {
        let tabela = $("#pedidosTable").empty();
        pedidos.forEach(function(pedido) {
            tabela.append(`
                <tr>
                    <td>${pedido.id}</td>
                    <td>${pedido.cliente_nome}</td>
                    <td>${pedido.produtos}</td>
                    <td>${pedido.data_pedido ? pedido.data_pedido : '-'}</td>
                    <td>$${pedido.valor}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-sm btn-outline-warning editar-pedido-btn" 
                                data-id="${pedido.id}"
                                data-cliente_id="${pedido.cliente_id}"
                                data-produtos="${pedido.produtos}"
                                data-data_pedido="${pedido.data_pedido ? pedido.data_pedido : ''}"
                                data-valor="${pedido.valor}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger excluir-pedido-btn" data-id="${pedido.id}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });
    });
}

function salvarPedidoModal() {
    let id = $("#pedidoIdModal").val();

    // Temporariamente reabilita o select para obter o valor
    $("#modalClienteId").prop("disabled", false);
    let cliente_id = parseInt($("#modalClienteId").val(), 10);
    // Reabilita novamente o select se ele estava desabilitado (modo edição)
    $("#modalClienteId").prop("disabled", true);

    let pedido = {
        cliente_id: cliente_id,
        produtos: $("#modalProdutos").val(),
        data_pedido: $("#modalDataPedido").val() || null,
        valor: parseFloat($("#modalValor").val())
    };

    let metodo = id ? "PUT" : "POST";
    if (id) {
        pedido.id = id;
    }

    $.ajax({
        url: API_PEDIDOS,
        type: metodo,
        contentType: "application/json",
        data: JSON.stringify(pedido),
        success: function() {
            let modalEl = document.getElementById('pedidoModal');
            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();
            $("#pedidoFormModal")[0].reset();
            $("#pedidoIdModal").val("");
            carregarPedidos();
        },
        error: function() {
            alert("Erro ao salvar o pedido.");
        }
    });
}

function excluirPedido(id) {
    if (!confirm("Deseja excluir este pedido?")) return;
    $.ajax({
        url: API_PEDIDOS + "?id=" + id,
        type: "DELETE",
        success: carregarPedidos,
        error: function() {
            alert("Erro ao excluir o pedido.");
        }
    });
}

function editarPedido(id, cliente_id, produtos, data_pedido, valor) {
    $("#pedidoIdModal").val(id);
    $("#modalClienteId").val(cliente_id);
    $("#modalProdutos").val(produtos);
    $("#modalDataPedido").val(data_pedido);
    $("#modalValor").val(valor);
    $("#pedidoModalLabel").text("Editar Pedido");
    let modalEl = document.getElementById('pedidoModal');
    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}
function carregarClientesSelect() {
    $.get(API_CLIENTES, function(clientes) {
        let select = $("#modalClienteId").empty();
        select.append('<option value="">Selecione um cliente</option>');
        clientes.forEach(function(cliente) {
            select.append(`<option value="${cliente.id}">${cliente.nome} (${cliente.email})</option>`);
        });
    });
}
