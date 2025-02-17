<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once '../app/models/Cliente.php';


/**
 * flag para ativar/desativar o envio real
 * Em ambiente de teste (sem SMTP configurado), deixe como true
 */
$modo_teste = true;

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// Coleta os dados enviados pelo formulário
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');
$clientesSelecionados = $_POST['clientes'] ?? [];

// Validação básica
if (empty($subject) || empty($message) || empty($clientesSelecionados)) {
    echo json_encode(["error" => "Assunto, mensagem e clientes são obrigatórios."]);
    exit;
}

// Se estamos em modo teste, apenas retornamos a mensagem fixa:
if ($modo_teste) {
    echo json_encode([
        "success" => false,
        "error" => "Este é um teste e falta configurar o servidor SMTP para envio de e-mails."
    ]);
    exit;
}

// Se chegou aqui, significa que iremos tentar enviar de fato via PHPMailer
$fullMessage = "<h2>E-mail Encantado</h2><p>{$message}</p>";

// Configuração do SMTP (exemplo com Gmail)
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'seu_email@gmail.com';    // Seu e-mail
$smtpPassword = 'sua_senha_app';         // Sua senha ou App Password do Gmail

$sentCount = 0;

$mail = new PHPMailer(true);
try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUsername;
    $mail->Password   = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $smtpPort;

    // Remetente (From)
    $mail->setFrom($smtpUsername, 'Loja Mágica');
    $mail->isHTML(true);

    // Para cada cliente selecionado, envia um e-mail
    foreach ($clientesSelecionados as $clienteId) {
        // Exemplo de método buscarPorId($id) no modelo Cliente
        $cliente = Cliente::buscarPorId($clienteId);
        if ($cliente && !empty($cliente['email'])) {
            $mail->clearAddresses();
            $mail->addAddress($cliente['email'], $cliente['nome']);
            $mail->Subject = $subject;
            $mail->Body    = $fullMessage;
            
            if ($mail->send()) {
                $sentCount++;
            }
        }
    }
    
    echo json_encode([
        "success" => true,
        "mensagem" => "E-mails enviados com sucesso para {$sentCount} clientes."
    ]);
} catch (Exception $e) {
    echo json_encode(["error" => "Erro ao enviar e-mail: {$mail->ErrorInfo}"]);
}
?>
