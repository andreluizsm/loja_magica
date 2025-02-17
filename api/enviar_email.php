<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once '../app/models/Cliente.php';

// Define o cabeçalho de resposta
header("Content-Type: text/html; charset=UTF-8");

// Captura os dados enviados pelo formulário
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');
$clientesSelecionados = $_POST['clientes'] ?? []; // Array de IDs

// Validação básica
if (empty($subject) || empty($message) || empty($clientesSelecionados)) {
    echo "Assunto, mensagem e clientes são obrigatórios.";
    exit;
}

// Personalize a mensagem se necessário
$fullMessage = "<h2>E-mail Encantado</h2><p>{$message}</p>";

// Configuração SMTP (exemplo com Gmail - ajuste conforme necessário)
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'seu_email@gmail.com';    // Substitua pelo seu e-mail
$smtpPassword = 'sua_app_password';         // Substitua pela sua senha ou app password

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
    $mail->setFrom($smtpUsername, 'Loja Mágica');
    $mail->isHTML(true);

    // Envia e-mail para cada cliente selecionado
    foreach ($clientesSelecionados as $clienteId) {
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
    
    echo "E-mails enviados com sucesso para {$sentCount} clientes.";
} catch (Exception $e) {
    echo "Falta configurar o seridor smtp\n";
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
?>
