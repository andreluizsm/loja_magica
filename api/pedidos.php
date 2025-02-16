<?php
require '../app/models/Pedido.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];


if ($method === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit;
}

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
    // Tenta obter o id via GET (já que a URL está sendo chamada com ?id=...)
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    echo json_encode(["success" => Pedido::excluir($id)]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Método não permitido"]);
?>
