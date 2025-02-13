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
            foreach ($worksheet->getRowIterator(2) as $row) {
                $cells = [];
                foreach ($row->getCellIterator() as $cell) {
                    $cells[] = $cell->getValue();
                }

                if (count($cells) >= 4) {
                    if (Cliente::inserir($cells[0], $cells[1], $cells[2], $cells[3])) {
                        $success++;
                    }
                }
            }

            // Redireciona corretamente para a página de clientes
            header("Location: /loja_magica/public/index.php?page=clientes&importados=$success");
            exit;
        } catch (Exception $e) {
            echo "Erro ao processar o arquivo: " . $e->getMessage();
        }
    }
}
?>
