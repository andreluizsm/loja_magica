<?php
require_once __DIR__ . '/../models/Cliente.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['email'])) {
        Cliente::adicionar($_POST['nome'], $_POST['email'], $_POST['telefone'] ?? '', $_POST['endereco'] ?? '');
        header("Location: /loja_magica/public/index.php");
        exit();
    }
}

class ClienteController {
    public function listarTodos() {
        return Cliente::listarTodos();
    }
}
?>
