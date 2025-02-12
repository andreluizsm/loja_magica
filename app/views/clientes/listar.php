<?php require_once __DIR__ . '/../../controllers/ClienteController.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <a href="adicionar.php">Adicionar Cliente</a>
    <ul>
        <?php foreach ($clientes as $cliente): ?>
            <li><?= htmlspecialchars($cliente['nome']) ?> - <?= htmlspecialchars($cliente['email']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
