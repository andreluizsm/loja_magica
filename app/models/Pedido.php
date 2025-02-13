<?php
require_once 'Database.php';

class Pedido {
    public static function inserir($cliente_id, $produtos, $data_pedido, $valor) {
        $conn = Database::getInstance();

        $data_pedido = !empty($data_pedido) ? $data_pedido : null;

        $stmt = $conn->prepare("INSERT INTO pedidos (cliente_id, produtos, data_pedido, valor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $cliente_id, $produtos, $data_pedido, $valor);
        return $stmt->execute();
    }

    public static function listar() {
        $conn = Database::getInstance();
        $result = $conn->query("
            SELECT pedidos.*, clientes.nome AS cliente_nome 
            FROM pedidos 
            JOIN clientes ON pedidos.cliente_id = clientes.id
            ORDER BY pedidos.data_pedido DESC
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public static function buscarPorId($id) {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function atualizar($id, $cliente_id, $produtos, $data_pedido, $valor) {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("UPDATE pedidos SET cliente_id = ?, produtos = ?, data_pedido = ?, valor = ? WHERE id = ?");
        $stmt->bind_param("issdi", $cliente_id, $produtos, $data_pedido, $valor, $id);
        return $stmt->execute();
    }

    public static function excluir($id) {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

