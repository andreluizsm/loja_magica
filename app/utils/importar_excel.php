<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function importarClientes($arquivo) {
    global $pdo;
    $spreadsheet = IOFactory::load($arquivo);
    $sheet = $spreadsheet->getActiveSheet();
    foreach ($sheet->getRowIterator() as $row) {
        $nome = $row->getCellIterator()[0]->getValue();
        $email = $row->getCellIterator()[1]->getValue();
        $stmt = $pdo->prepare("INSERT INTO clientes (nome, email) VALUES (?, ?)");
        $stmt->execute([$nome, $email]);
    }
}
?>
