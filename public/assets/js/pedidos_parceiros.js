const API_PEDIDOS_PARCEIROS = "http://localhost/loja_magica/api/pedidos_parceiros.php";

$(document).ready(function() {
    carregarPedidosParceiros();

    // Evento para salvar pedido parceiro via modal
    $("#salvarPedidoParceiroModalBtn").click(function() {
        salvarPedidoParceiroModal();
    });

    // Event delegation para os botões de editar e excluir
    $(document).on('click', '.editar-pedido-parceiro-btn', function() {
        let id = $(this).data('id');
        let id_loja = $(this).data('id_loja');
        let nome_loja = $(this).data('nome_loja');
        let localizacao = $(this).data('localizacao');
        let produto = $(this).data('produto');
        let quantidade = $(this).data('quantidade');
        editarPedidoParceiro(id, id_loja, nome_loja, localizacao, produto, quantidade);
    });

    $(document).on('click', '.excluir-pedido-parceiro-btn', function() {
        let id = $(this).data('id');
        excluirPedidoParceiro(id);
    });
});

function carregarPedidosParceiros() {
    $.get(API_PEDIDOS_PARCEIROS, function(pedidos) {
        let tabela = $("#pedidosParceirosTable").empty();
        pedidos.forEach(function(pedido) {
            tabela.append(`
                <tr>
                    <td>${pedido.id}</td>
                    <td>${pedido.id_loja}</td>
                    <td>${pedido.nome_loja}</td>
                    <td>${pedido.localizacao}</td>
                    <td>${pedido.produto}</td>
                    <td>${pedido.quantidade}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-sm btn-outline-warning editar-pedido-parceiro-btn" 
                                data-id="${pedido.id}"
                                data-id_loja="${pedido.id_loja}"
                                data-nome_loja="${pedido.nome_loja}"
                                data-localizacao="${pedido.localizacao}"
                                data-produto="${pedido.produto}"
                                data-quantidade="${pedido.quantidade}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger excluir-pedido-parceiro-btn" data-id="${pedido.id}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });
    });
}

function salvarPedidoParceiroModal() {
    let id = $("#pedidoParceiroIdModal").val();
    let pedido = {
        id_loja: $("#modalIdLojaParceiro").val(),
        nome_loja: $("#modalNomeLojaParceiro").val(),
        localizacao: $("#modalLocalizacaoParceiro").val(),
        produto: $("#modalProdutoParceiro").val(),
        quantidade: parseInt($("#modalQuantidadeParceiro").val(), 10)
    };

    let metodo = id ? "PUT" : "POST";
    if (id) {
        pedido.id = id;
    }

    $.ajax({
        url: API_PEDIDOS_PARCEIROS,
        type: metodo,
        contentType: "application/json",
        data: JSON.stringify(pedido),
        success: function() {
            let modalEl = document.getElementById('pedidoParceiroModal');
            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();
            $("#pedidoParceiroFormModal")[0].reset();
            $("#pedidoParceiroIdModal").val("");
            carregarPedidosParceiros();
        },
        error: function() {
            alert("Erro ao salvar o pedido parceiro.");
        }
    });
}

function excluirPedidoParceiro(id) {
    if (!confirm("Deseja excluir este pedido parceiro?")) return;
    $.ajax({
        url: API_PEDIDOS_PARCEIROS + "?id=" + id,
        type: "DELETE",
        success: carregarPedidosParceiros,
        error: function() {
            alert("Erro ao excluir o pedido parceiro.");
        }
    });
}

function editarPedidoParceiro(id, id_loja, nome_loja, localizacao, produto, quantidade) {
    $("#pedidoParceiroIdModal").val(id);
    $("#modalIdLojaParceiro").val(id_loja);
    $("#modalNomeLojaParceiro").val(nome_loja);
    $("#modalLocalizacaoParceiro").val(localizacao);
    $("#modalProdutoParceiro").val(produto);
    $("#modalQuantidadeParceiro").val(quantidade);
    $("#pedidoParceiroModalLabel").text("Editar Pedido Parceiro");
    let modalEl = document.getElementById('pedidoParceiroModal');
    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}
