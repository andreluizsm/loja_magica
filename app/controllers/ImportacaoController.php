<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Cliente.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportacaoController {
    public function importarClientes() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Método inválido!";
            return;
        }

        if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
            echo "Erro no envio do arquivo!";
            return;
        }

        $file = $_FILES['arquivo']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();

            $success = 0;
            $duplicados = 0;
            foreach ($worksheet->getRowIterator(2) as $row) {
                $cells = [];
                foreach ($row->getCellIterator() as $cell) {
                    $cells[] = $cell->getValue();
                }

                if (count($cells) >= 4) {
                    $nome = $cells[1] ?? null;
                    $email = $cells[2] ?? null;
                    $data_ultimo_pedido = $cells[5] ?? null;
                    $valor_ultimo_pedido = $cells[6] ?? null;

                    if (Cliente::inserir($nome, $email, $data_ultimo_pedido, $valor_ultimo_pedido)) {
                        $success++;
                    } else {
                        $duplicados++;
                    }
                }
            }

            echo "Importação concluída! $success clientes adicionados. $duplicados já existiam.";
        } catch (Exception $e) {
            echo "Erro ao processar o arquivo: " . $e->getMessage();
        }
    }
}
?>
