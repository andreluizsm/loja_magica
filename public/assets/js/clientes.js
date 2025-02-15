const API_URL = "http://localhost/loja_magica/api/clientes.php";

$(document).ready(function() {
    carregarClientes();

    // Evento para salvar cliente via modal
    $("#salvarClienteModalBtn").click(function() {
        salvarClienteModal();
    });

    // Delegated event for edit button
    $(document).on('click', '.editar-btn', function() {
        let id = $(this).data('id');
        let nome = $(this).data('nome');
        let email = $(this).data('email');
        editarCliente(id, nome, email);
    });

    // Delegated event for delete button
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
                        <button class="btn btn-sm btn-outline-warning editar-btn" data-id="${cliente.id}" data-nome="${cliente.nome}" data-email="${cliente.email}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger excluir-btn" data-id="${cliente.id}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
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
            // Fecha o modal
            let modalEl = document.getElementById('clienteModal');
            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();
            // Reseta o formulário do modal
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
