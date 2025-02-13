<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Lista de Pedidos</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Produtos</th>
            <th>Data</th>
            <th>Valor</th>
        </tr>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?= $pedido['id'] ?></td>
                <td><?= $pedido['cliente_nome'] ?></td>
                <td><?= $pedido['produtos'] ?></td>
                <td><?= $pedido['data_pedido'] ?></td>
                <td>$<?= number_format($pedido['valor'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
