<?php
require '../app/models/Cliente.php';

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
    echo json_encode(Cliente::listar());
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(["success" => Cliente::inserir($data['nome'], $data['email'], $data['data_ultimo_pedido'] ?? null, $data['valor_ultimo_pedido'] ?? null)]);
    exit;
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(["success" => Cliente::atualizar($data['id'], $data['nome'], $data['email'], $data['data_ultimo_pedido'] ?? null, $data['valor_ultimo_pedido'] ?? null)]);
    exit;
}

if ($method === 'DELETE') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    echo json_encode(["success" => Cliente::excluir($id)]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Método não permitido"]);
?>
