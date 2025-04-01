Gerex - Gerenciador de Contas e Senhas

📌 Sobre o Projeto

O Gerex é um sistema web para gerenciamento de contas e senhas de serviços utilizados pelos usuários. Ele permite armazenar e visualizar senhas de forma segura, além de manter um registro de mudanças.

🚀 Funcionalidades

Cadastro e login de usuários.

Adição de serviços com email, telefone e senha criptografada.

Opção para visualizar e editar as credenciais.

Registro da data de cadastro e última alteração.

Upload de imagens para auditoria (limite de 2MB por arquivo).

Recuperação de senha via e-mail.

🛠️ Tecnologias Utilizadas

Back-end: PHP (POO, padrão Singleton)

Banco de Dados: MySQL

Front-end: HTML, CSS, Bootstrap

Segurança: Hashing de senhas com password_hash() e criptografia AES-256 para senhas de serviços

📂 Estrutura de Pastas

projeto/
│-- src/
│   │-- controllers/
│   │-- models/
│   │-- views/
│-- public/
│-- config/
│-- database/
│-- README.md

src/ → Código principal do sistema.

controllers/ → Lógica de controle das ações do usuário.

models/ → Classes responsáveis pelo acesso ao banco de dados.

views/ → Páginas de interface com o usuário.

public/ → Arquivos públicos, como CSS e imagens.

config/ → Configuração do banco de dados.

database/ → Scripts SQL do projeto.

🎯 Como Executar o Projeto

1️⃣ Clonar o Repositório

git clone https://github.com/seu-usuario/gerex.git

2️⃣ Configurar o Banco de Dados

Importe o arquivo database/gerex.sql para seu MySQL.

Configure a conexão no arquivo config/database.php.

3️⃣ Rodar o Servidor Local

php -S localhost:8000 -t public/

Acesse http://localhost:8000 no navegador.

📝 Licença

Este projeto é de código aberto sob a licença MIT.

📌 Autor: Fernando de O. AlmeidaContato: 

LinkedIn https://www.linkedin.com/in/fernandooar/

E-mail: fernandooar@gmail.com