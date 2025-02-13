<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {
    public function listar() {
        $clientes = Cliente::listar();
        require __DIR__ . '/../views/clientes.php';
    }
}

