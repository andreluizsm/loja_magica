$(document).ready(function(){
    $("#xmlForm").submit(function(e){
        e.preventDefault(); // nao deixa envio padrao

        var formData = new FormData(this);

        $.ajax({
          url: $(this).attr("action"),
          type: $(this).attr("method"),
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
            var html = "";
            if(response.success) {
              html = '<div class="alert alert-success" role="alert">' +
                       'Integração concluída! Pedidos inseridos: ' + response.inseridos +
                     '</div>';
            } else {
              html = '<div class="alert alert-danger" role="alert">' +
                       'Erro: ' + (response.error || 'Erro desconhecido') +
                     '</div>';
            }
            $("#resultado").html(html);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#resultado").html('<div class="alert alert-danger" role="alert">Erro ao enviar arquivo: ' + errorThrown + '</div>');
          }
        });
    });
});
