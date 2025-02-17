const API_URL = "http://localhost/loja_magica/api/clientes.php";

$(document).ready(function() {
    carregarClientes();

    // salvar cliente pelo modal
    $("#salvarClienteModalBtn").click(function() {
        salvarClienteModal();
    });

    $(document).on('click', '.editar-btn', function() {
        let id = $(this).data('id');
        let nome = $(this).data('nome');
        let email = $(this).data('email');
        editarCliente(id, nome, email);
    });

    $(document).on('click', '.excluir-btn', function() {
        let id = $(this).data('id');
        excluirCliente(id);
    });
});

function carregarClientes() {
    $.get(API_URL, function(clientes) {
        let tabela = $("#clientesTable").empty();
        clientes.forEach(function(cliente) {
            tabela.append(`
                <tr>
                    <td>${cliente.id}</td>
                    <td>${cliente.nome}</td>
                    <td>${cliente.email}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-sm btn-outline-warning editar-btn" 
                                    data-id="${cliente.id}" 
                                    data-nome="${cliente.nome}" 
                                    data-email="${cliente.email}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger excluir-btn" data-id="${cliente.id}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });
    });
}


function salvarClienteModal() {
    let id = $("#clienteIdModal").val();
    let cliente = {
        nome: $("#modalNome").val(),
        email: $("#modalEmail").val()
    };

    let metodo = id ? "PUT" : "POST";
    if (id) {
        cliente.id = id;
    }

    $.ajax({
        url: API_URL,
        type: metodo,
        contentType: "application/json",
        data: JSON.stringify(cliente),
        success: function() { 
            
            let modalEl = document.getElementById('clienteModal');
            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();

            $("#clienteFormModal")[0].reset();
            $("#clienteIdModal").val("");
            carregarClientes();
        },
        error: function() {
            alert("Erro ao salvar o cliente.");
        }
    });
}

function excluirCliente(id) {
    if (!confirm("Deseja excluir este cliente?")) return;
    $.ajax({
        url: API_URL + "?id=" + id,
        type: "DELETE",
        success: carregarClientes,
        error: function() {
            alert("Erro ao excluir o cliente.");
        }
    });
}

function editarCliente(id, nome, email) {
    $("#clienteIdModal").val(id);
    $("#modalNome").val(nome);
    $("#modalEmail").val(email);
    $("#clienteModalLabel").text("Editar Cliente");
    let modalEl = document.getElementById('clienteModal');
    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}
