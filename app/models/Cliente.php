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
}
?>
