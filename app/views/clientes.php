<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <h1>Lista de Clientes</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Endereço</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= $cliente['id'] ?></td>
                <td><?= $cliente['nome'] ?></td>
                <td><?= $cliente['email'] ?></td>
                <td><?= $cliente['telefone'] ?></td>
                <td><?= $cliente['endereco'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
