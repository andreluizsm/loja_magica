const API_CLIENTES = "http://localhost/loja_magica/api/clientes.php";

$(document).ready(function(){
  carregarClientesSelect();
  
  $("#emailForm").submit(function(e){
    e.preventDefault(); // nao deixa envio padrao

    var formData = new FormData(this);

    $.ajax({
      url: $(this).attr("action"),
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (typeof response === "string") {
          try {
            response = JSON.parse(response);
          } catch(err) {
            response = { error: "Erro ao processar resposta" };
          }
        }
        if (response.error) {
          // Exibe mensagem de erro ou mensagem de teste
          $("#resultado").html(`
            <div class="alert alert-danger" role="alert">
              ${response.error}
            </div>
          `);
        } else if (response.success) {
          $("#resultado").html(`
            <div class="alert alert-success" role="alert">
              ${response.mensagem}
            </div>
          `);
        } else {
          // Caso inesperado
          $("#resultado").html(`
            <div class="alert alert-danger" role="alert">
              Erro desconhecido.
            </div>
          `);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#resultado").html(`
          <div class="alert alert-danger" role="alert">
            Erro ao enviar: ${errorThrown}
          </div>
        `);
      }
    });   
  });
});

function carregarClientesSelect() {
  $.get(API_CLIENTES, function(clientes) {
    let select = $("#clientesSelect").empty();
    clientes.forEach(function(cliente) {
      select.append(`<option value="${cliente.id}">${cliente.nome} (${cliente.email})</option>`);
    });
  });
}
