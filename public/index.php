<?php
require_once __DIR__ . '/../app/controllers/ClienteController.php';

$clienteController = new ClienteController();
$clientes = $clienteController->listarTodos();

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
</head>
<body>
    <h1>Clientes</h1>
    <ul>
        <?php foreach ($clientes as $cliente): ?>
            <li><?= htmlspecialchars($cliente['nome']) ?> - <?= htmlspecialchars($cliente['email']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
