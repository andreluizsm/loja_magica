<?php
require_once __DIR__ . '/../../config.php';

class Pedido {
    private static function conectar() {
        $config = require __DIR__ . '/../../config.php';
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    
    public static function listar() {
        $conn = self::conectar();
        // Junta o pedido com o nome do cliente para exibição
        $result = $conn->query("
            SELECT pedidos.*, clientes.nome AS cliente_nome 
            FROM pedidos 
            JOIN clientes ON pedidos.cliente_id = clientes.id
            ORDER BY pedidos.data_pedido DESC
        ");
        $pedidos = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $pedidos;
    }
    
    public static function inserir($cliente_id, $produtos, $data_pedido = null, $valor) {
        $conn = self::conectar();
        $stmt = $conn->prepare("INSERT INTO pedidos (cliente_id, produtos, data_pedido, valor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $cliente_id, $produtos, $data_pedido, $valor);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
    
    public static function atualizar($id, $cliente_id, $produtos, $data_pedido = null, $valor) {
        $conn = self::conectar();
        $stmt = $conn->prepare("UPDATE pedidos SET cliente_id = ?, produtos = ?, data_pedido = ?, valor = ? WHERE id = ?");
        $stmt->bind_param("issdi", $cliente_id, $produtos, $data_pedido, $valor, $id);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
    
    public static function excluir($id) {
        $conn = self::conectar();
        $stmt = $conn->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
}
?>
