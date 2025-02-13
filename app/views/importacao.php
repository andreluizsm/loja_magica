<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Importar Clientes</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <h1>Importar Clientes</h1>
    <form action="/importar" method="POST" enctype="multipart/form-data">
        <input type="file" name="arquivo" required>
        <button type="submit">Importar</button>
    </form>
</body>
</html>
