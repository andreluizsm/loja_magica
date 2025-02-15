<?php
require '../app/models/Pedido.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    echo json_encode(Pedido::listar());
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(["success" => Pedido::inserir($data['cliente_id'], $data['produtos'], $data['data_pedido'] ?? null, $data['valor'])]);
    exit;
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(["success" => Pedido::atualizar($data['id'], $data['cliente_id'], $data['produtos'], $data['data_pedido'] ?? null, $data['valor'])]);
    exit;
}

if ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    echo json_encode(["success" => Pedido::excluir($data['id'])]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Método não permitido"]);
?>
