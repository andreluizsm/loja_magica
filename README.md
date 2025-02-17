# Loja Mágica

Este é um projeto para a Loja Mágica de Tecnologia, implementando um sistema completo de gestão com as seguintes funcionalidades:

- **Gerenciamento de Clientes:** CRUD completo com modal para inserção e edição.
- **Gerenciamento de Pedidos:** CRUD completo com dropdown para seleção de clientes e validação de campos.
- **E-mails Encantados:** Sistema de envio de e-mails usando PHPMailer. Em modo teste, exibe mensagem informando que falta configurar o servidor SMTP.
- **Integração com XML:** Importação de pedidos de lojas parceiras via arquivo XML, com processamento e inserção em tabela.
- **Gerenciamento de Lojas (Pedidos Parceiros):** Exibição dos dados únicos das lojas extraídos dos pedidos parceiros, com opções de edição, exclusão e um botão "Adicionar Tabela" para redirecionar à página de inserção XML.


---


## Arquitetura do Projeto

A arquitetura adotada é baseada em um padrão bastante comum que combina conceitos do padrão MVC (Model-View-Controller) com uma abordagem RESTful.

- **Camada de Modelos:** Responsável pelo acesso e manipulação dos dados (banco de dados).
- **Camada de API/Controladores:** Os endpoints (em arquivos PHP) atuam como controladores, recebendo requisições HTTP e interagindo com os modelos para realizar operações (CRUD).
- **Camada de Front-End:** A interface do usuário (HTML, CSS e JavaScript) consome os endpoints da API via AJAX, desacoplando a apresentação da lógica de negócio.

Essa separação de responsabilidades, também conhecida como arquitetura em camadas, é bastante comum em aplicações web modernas, pois facilita a manutenção, a escalabilidade e a segurança do sistema.



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

http://localhost/loja_magica/public/pages/
