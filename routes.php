<?php
require_once 'app/controllers/ClienteController.php';
require_once 'app/controllers/ImportacaoController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($page === 'importar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    (new ImportacaoController())->importarClientesEPedidos();
} elseif ($page === 'clientes') {
    $clientes = Cliente::listar();
    require 'app/views/clientes.php';
} elseif ($page === 'importar') {
    require 'app/views/importacao.php';
} elseif ($page === 'pedidos') {
    $pedidos = Pedido::listar();
    require 'app/views/pedidos.php';
} elseif ($page === 'home') {
    require 'app/views/home.php';
} else {
    echo "Página não encontrada!";
}

