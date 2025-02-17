# Loja Mágica - Projeto de Desafio Técnico

Este é um projeto para a Loja Mágica de Tecnologia, implementando um sistema completo de gestão com as seguintes funcionalidades:

- **Gerenciamento de Clientes:** CRUD completo com modal para inserção e edição.
- **Gerenciamento de Pedidos:** CRUD completo com dropdown para seleção de clientes e validação de campos.
- **E-mails Encantados:** Sistema de envio de e-mails usando PHPMailer. Em modo teste, exibe mensagem informando que falta configurar o servidor SMTP.
- **Integração com XML:** Importação de pedidos de lojas parceiras via arquivo XML, com processamento e inserção em tabela.
- **Gerenciamento de Lojas (Pedidos Parceiros):** Exibição dos dados únicos das lojas extraídos dos pedidos parceiros, com opções de edição, exclusão e um botão "Adicionar Tabela" para redirecionar à página de inserção XML.

---


## Requisitos

- PHP 7.x ou superior  
- MySQL  
- XAMPP (ou outro servidor local)  
- Composer  
- Extensões PHP: ext-mysqli, ext-gd, ext-zip  
- PHPMailer (instalado via Composer)
- PhpSpreadsheet (instalado via Composer)


---



## Requisitos

- PHP 7.x ou superior  
- MySQL  
- XAMPP (ou outro servidor local)  
- Composer  
- Extensões PHP: ext-mysqli, ext-gd, ext-zip  
- PHPMailer (instalado via Composer)



---



## Instalação e Configuração

1. **Clone o Repositório:**

   git clone <URL_DO_REPOSITORIO>
   cd loja_magica

2. **Instale as Dependências:**

   composer install

3. **Configure o Banco de Dados:**

   Importe o arquivo loja_magica.sql no seu MySQL (via phpMyAdmin ou outro cliente).

   Edite o arquivo config.php com as credenciais corretas

4. **Acesse o Projeto:**

   http://localhost/loja_magica/public/
