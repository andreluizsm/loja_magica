<?php
require_once __DIR__ . '/../../config.php';

class Cliente {
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
        $result = $conn->query("SELECT * FROM clientes ORDER BY nome ASC");
        $clientes = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $clientes;
    }
    
    public static function inserir($nome, $email, $data_ultimo_pedido = null, $valor_ultimo_pedido = null) {
        $conn = self::conectar();
        $stmt = $conn->prepare("INSERT INTO clientes (nome, email, data_ultimo_pedido, valor_ultimo_pedido) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $data_ultimo_pedido, $valor_ultimo_pedido);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
    
    public static function atualizar($id, $nome, $email, $data_ultimo_pedido = null, $valor_ultimo_pedido = null) {
        $conn = self::conectar();
        $stmt = $conn->prepare("UPDATE clientes SET nome = ?, email = ?, data_ultimo_pedido = ?, valor_ultimo_pedido = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $email, $data_ultimo_pedido, $valor_ultimo_pedido, $id);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
    
    public static function excluir($id) {
        $conn = self::conectar();
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }

    public static function buscarPorId($id) {
        $conn = self::conectar();
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cliente = $result->fetch_assoc();
        $conn->close();
        return $cliente;
    }
    
}
?>
