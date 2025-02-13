<?php
require_once 'app/controllers/ClienteController.php';
require_once 'app/controllers/ImportacaoController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'clientes';

if ($page === 'importar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    (new ImportacaoController())->importarClientes();
} elseif ($page === 'clientes') {
    (new ClienteController())->listar();
} elseif ($page === 'importar') {
    require 'app/views/importacao.php'; // Carrega a página de importação corretamente
} else {
    echo "Página não encontrada!";
}
?>
