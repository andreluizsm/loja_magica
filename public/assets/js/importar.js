const API_IMPORTAR = "http://localhost/loja_magica/api/importar.php";

$(document).ready(() => {
    $("#importarForm").submit(event => {
        event.preventDefault();
        importarArquivo();
    });
});

function importarArquivo() {
    let formData = new FormData();
    let arquivo = $("#arquivo")[0].files[0];

    if (!arquivo) {
        alert("Selecione um arquivo para importar!");
        return;
    }

    formData.append("arquivo", arquivo);

    $.ajax({
        url: API_IMPORTAR,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {

            if (typeof response === 'string') {
                try {
                    response = JSON.parse(response);
                } catch(e) {
                    response = { error: "Erro ao processar resposta" };
                }
            }

            // <span> para exibir a mensagem
            let messageSpan = $('<span></span>');
            if (response.success) {
                messageSpan
                    .addClass('alert alert-success d-block')
                    .html(`Importação concluída!<br>
                           Clientes Importados: ${response.clientes_importados}<br>
                           Pedidos Importados: ${response.pedidos_importados}`);
            } else {
                messageSpan
                    .addClass('alert alert-danger d-block')
                    .text(response.error || "Erro desconhecido");
            }
            $("#mensagem").empty().append(messageSpan);
        },
        error: function() {
            $("#mensagem").empty().append(
                $('<span></span>')
                .addClass('alert alert-danger d-block')
                .text("Erro ao enviar arquivo!")
            );
        }
    });
}
