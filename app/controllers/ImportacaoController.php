<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Pedido.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportacaoController {
    public function importarClientesEPedidos() {
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

            $successClientes = 0;
            $duplicados = 0;
            $successPedidos = 0;

            foreach ($worksheet->getRowIterator(2) as $row) {
                $cells = [];
                foreach ($row->getCellIterator() as $cell) {
                    $cells[] = $cell->getValue();
                }

                if (count($cells) >= 6) {
                    $nome = $cells[1] ?? null;
                    $email = $cells[2] ?? null;
                    $historico_pedidos = $cells[3] ?? null;  // Produtos comprados
                    $data_ultimo_pedido = $cells[4] ?? null;
                    $valor_ultimo_pedido = $cells[5] ?? 0;

                    if ($nome && $email) {
                        if (Cliente::inserir($nome, $email, $data_ultimo_pedido, $valor_ultimo_pedido)) {
                            $successClientes++;
                        } else {
                            $duplicados++;
                        }

                        // Obter o ID do cliente para associar pedidos
                        $conn = Database::getInstance();
                        $stmt = $conn->prepare("SELECT id FROM clientes WHERE email = ?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $cliente = $result->fetch_assoc();

                        if ($cliente && $historico_pedidos) {
                            if (Pedido::inserir($cliente['id'], $historico_pedidos, $data_ultimo_pedido, $valor_ultimo_pedido)) {
                                $successPedidos++;
                            }
                        }
                    }
                }
            }

            echo "Importação concluída! 
            $successClientes clientes adicionados, 
            $duplicados já existiam, 
            $successPedidos pedidos importados.";
        } catch (Exception $e) {
            echo "Erro ao processar o arquivo: " . $e->getMessage();
        }
    }
}
?>
