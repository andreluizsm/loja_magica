<?php
require '../app/models/Importar.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["error" => "Nenhum arquivo válido foi enviado"]);
        exit;
    }

    $file = $_FILES['arquivo']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        $clientesImportados = 0;
        $pedidosImportados = 0;

        // Começa na linha 2, ignorando o cabeçalho
        foreach ($worksheet->getRowIterator(2) as $row) {
            $cells = [];
            foreach ($row->getCellIterator() as $cell) {
                $cells[] = $cell->getValue();
            }

            // Verifica se há pelo menos 6 colunas
            if (count($cells) >= 6) {
                // Ignora a primeira coluna (ID da planilha)
                $nome        = $cells[1] ?? null;
                $email       = $cells[2] ?? null;
                $produto     = $cells[3] ?? null;
                $data_pedido = $cells[4] ?? null;
                $valor       = $cells[5] ?? 0;

                // Importa ou localiza o cliente
                $resultado = Importar::importarCliente($nome, $email);
                $clienteId = $resultado['id'];
                if ($resultado['novo']) {
                    $clientesImportados++;
                }

                // Se houver produto e um cliente válido, tenta importar o pedido
                if ($produto && $clienteId > 0) {
                    $inseriuPedido = Importar::importarPedido($clienteId, $produto, $data_pedido, $valor);
                    if ($inseriuPedido) {
                        $pedidosImportados++;
                    }
                }
            }
        }

        echo json_encode([
            "success"             => true,
            "clientes_importados" => $clientesImportados,
            "pedidos_importados"  => $pedidosImportados
        ]);

    } catch (Exception $e) {
        echo json_encode(["error" => "Erro ao processar o arquivo: " . $e->getMessage()]);
    }
    exit;
}
?>
