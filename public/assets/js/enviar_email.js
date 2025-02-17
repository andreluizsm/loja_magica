const API_CLIENTES = "http://localhost/loja_magica/api/clientes.php";

$(document).ready(function(){
  carregarClientesSelect();
  
  $("#emailForm").submit(function(e){
    e.preventDefault(); // Impede o envio padrão

    var formData = new FormData(this);

    $.ajax({
      url: $(this).attr("action"),
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        // Se a resposta for uma string, tenta convertê-la para objeto
        if (typeof response === "string") {
          try {
            response = JSON.parse(response);
          } catch(err) {
            response = { error: "Erro ao processar resposta" };
          }
        }
        
        // Verifica se há erro relacionado ao SMTP
        if(response.error && response.error.toLowerCase().includes("smtp")) {
          $("#resultado").html('<div class="alert alert-danger" role="alert">Erro: Falta a configuração do servidor SMTP.</div>');
        } else if(response.success) {
          $("#resultado").html('<div class="alert alert-success" role="alert">E-mails enviados com sucesso!</div>');
        } else {
          $("#resultado").html('<div class="alert alert-danger" role="alert">Erro: ' + (response.error || "Erro desconhecido") + '</div>');
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#resultado").html('<div class="alert alert-danger" role="alert">Erro ao enviar arquivo: ' + errorThrown + '</div>');
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
