<?php
require_once __DIR__ . '/../../config.php';

class Importar {
    private static function conectar() {
        $config = require __DIR__ . '/../../config.php';
        return new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    }

    /**
     * Importa ou localiza um cliente.
     * Se o cliente for novo, retorna ['id' => novo_id, 'novo' => true].
     * Se já existir, retorna ['id' => id_existente, 'novo' => false].
     */
    public static function importarCliente($nome, $email) {
        if (!$nome || !$email) {
            return ['id' => 0, 'novo' => false];
        }

        $conn = self::conectar();

        // Verifica se o cliente já existe pelo e-mail
        $stmt = $conn->prepare("SELECT id FROM clientes WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($idExistente);
            $stmt->fetch();
            return ['id' => $idExistente, 'novo' => false];
        }

        // Insere novo cliente
        $stmt = $conn->prepare("INSERT INTO clientes (nome, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $email);
        $stmt->execute();
        return ['id' => $stmt->insert_id, 'novo' => true];
    }

    /**
     * Insere um pedido,sem duplicar.
     * Se já existir um pedido com os mesmos dados (cliente_id, produto, data e valor), não insere.
     */
    public static function importarPedido($cliente_id, $produto, $data_pedido, $valor) {
        $conn = self::conectar();
        
        // Verifica duplicação do pedido
        $stmt = $conn->prepare("SELECT id FROM pedidos WHERE cliente_id = ? AND produtos = ? AND data_pedido = ? AND valor = ?");
        $stmt->bind_param("issd", $cliente_id, $produto, $data_pedido, $valor);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return false;
        }
        
        // Insere o novo pedido
        $stmt = $conn->prepare("INSERT INTO pedidos (cliente_id, produtos, data_pedido, valor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $cliente_id, $produto, $data_pedido, $valor);
        return $stmt->execute();
    }
}
?>
