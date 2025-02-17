<?php
require '../app/models/PedidosParceiros.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    echo json_encode(PedidosParceiros::listar());
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(["success" => PedidosParceiros::inserir($data['id_loja'], $data['nome_loja'], $data['localizacao'], $data['produto'], $data['quantidade'])]);
    exit;
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(["success" => PedidosParceiros::atualizar($data['id'], $data['id_loja'], $data['nome_loja'], $data['localizacao'], $data['produto'], $data['quantidade'])]);
    exit;
}

if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;
    echo json_encode(["success" => PedidosParceiros::excluir($id)]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Método não permitido"]);
?>
