<?php
require_once 'Database.php';

class Cliente {
    public static function inserir($nome, $email, $data_ultimo_pedido, $valor_ultimo_pedido) {
        $conn = Database::getInstance();

        // Verifica se o e-mail já existe
        $stmt = $conn->prepare("SELECT id FROM clientes WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return false; // Cliente já existe
        }

        // Insere o cliente no banco
        $stmt = $conn->prepare("INSERT INTO clientes (nome, email, data_ultimo_pedido, valor_ultimo_pedido) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $data_ultimo_pedido, $valor_ultimo_pedido);
        return $stmt->execute();
    }

    public static function listar() {
        $conn = Database::getInstance();
        $result = $conn->query("SELECT * FROM clientes ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function buscarPorId($id) {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function atualizar($id, $nome, $email, $data_ultimo_pedido, $valor_ultimo_pedido) {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("UPDATE clientes SET nome = ?, email = ?, data_ultimo_pedido = ?, valor_ultimo_pedido = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $email, $data_ultimo_pedido, $valor_ultimo_pedido, $id);
        return $stmt->execute();
    }

    public static function excluir($id) {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

