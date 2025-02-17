<?php
require_once __DIR__ . '/../../config.php';

class PedidosParceiros {
    private static function conectar() {
        $config = require __DIR__ . '/../../config.php';
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }
        return $conn;
    }
    
    public static function listar() {
        $conn = self::conectar();
        $sql = "SELECT * FROM pedidos_parceiros ORDER BY nome_loja ASC";
        $result = $conn->query($sql);
        $pedidos = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $pedidos;
    }
    
    public static function inserir($id_loja, $nome_loja, $localizacao, $produto, $quantidade) {
        $conn = self::conectar();
        $stmt = $conn->prepare("INSERT INTO pedidos_parceiros (id_loja, nome_loja, localizacao, produto, quantidade) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $id_loja, $nome_loja, $localizacao, $produto, $quantidade);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
    
    public static function atualizar($id, $id_loja, $nome_loja, $localizacao, $produto, $quantidade) {
        $conn = self::conectar();
        $stmt = $conn->prepare("UPDATE pedidos_parceiros SET id_loja = ?, nome_loja = ?, localizacao = ?, produto = ?, quantidade = ? WHERE id = ?");
        $stmt->bind_param("sssiii", $id_loja, $nome_loja, $localizacao, $produto, $quantidade, $id);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
    
    public static function excluir($id) {
        $conn = self::conectar();
        $stmt = $conn->prepare("DELETE FROM pedidos_parceiros WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }
}
?>
