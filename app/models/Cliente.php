<?php
require_once 'Database.php';

class Cliente {
    public static function inserir($nome, $email, $telefone, $endereco) {
        $conn = Database::getInstance();
        $stmt = $conn->prepare("INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $telefone, $endereco);
        return $stmt->execute();
    }

    public static function listar() {
        $conn = Database::getInstance();
        $result = $conn->query("SELECT * FROM clientes ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
