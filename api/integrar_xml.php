<?php
require '../app/models/IntegracaoParceiros.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Trata requisição OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['xmlFile']) || $_FILES['xmlFile']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["error" => "Nenhum arquivo XML enviado ou ocorreu um erro no upload."]);
        exit;
    }

    $file = $_FILES['xmlFile']['tmp_name'];

    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($file);
    if ($xml === false) {
        $errors = libxml_get_errors();
        libxml_clear_errors();
        echo json_encode(["error" => "Erro ao processar o XML."]);
        exit;
    }

    $inseridos = 0;
    foreach ($xml->pedido as $pedido) {
        // Verifica se há dados mínimos
        if (!isset($pedido->id_loja) || !isset($pedido->nome_loja)) {
            continue;
        }
        $id_loja     = trim((string)$pedido->id_loja);
        $nome_loja   = trim((string)$pedido->nome_loja);
        $localizacao = trim((string)$pedido->localizacao);
        $produto     = trim((string)$pedido->produto);
        $quantidade  = (int)$pedido->quantidade;

        if (IntegracaoParceiros::inserirPedidoParceiro($id_loja, $nome_loja, $localizacao, $produto, $quantidade)) {
            $inseridos++;
        }
    }
    echo json_encode(["success" => true, "inseridos" => $inseridos]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Método não permitido"]);
?>
