<?php
require_once __DIR__ . '/../config/database.php';

class Cliente {
    public static function listarTodos() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM clientes ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function adicionar($nome, $email, $telefone, $endereco) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nome, $email, $telefone, $endereco]);
    }
}
?>
