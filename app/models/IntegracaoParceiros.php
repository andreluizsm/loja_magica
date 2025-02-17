<?php
require_once __DIR__ . '/../../config.php';

class IntegracaoParceiros {
    private static function conectar() {
        $config = require __DIR__ . '/../../config.php';
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }
        return $conn;
    }

    public static function inserirPedidoParceiro($id_loja, $nome_loja, $localizacao, $produto, $quantidade) {
        $conn = self::conectar();
        $stmt = $conn->prepare("INSERT INTO pedidos_parceiros (id_loja, nome_loja, localizacao, produto, quantidade) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $id_loja, $nome_loja, $localizacao, $produto, $quantidade);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
}
?>
