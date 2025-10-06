# TrabalhoFinal
Esse github se trata de um projeto feito na aula de PROGRAMAÇÃO WEB da faculdade de ciências da computação durante a minha formação

# Projeto: Base para Wiki de Jogos (Sistema de Autenticação e Dashboard)

Este projeto serve como a fundação de segurança para uma futura Wiki de Jogos. Atualmente, ele implementa um sistema robusto de autenticação (Login/Logout) e uma área restrita, com foco em segurança (controle de tentativas de login, bloqueio temporal) e **restrição de acesso administrativo** para gerenciar os futuros dados da Wiki.

---

## Visão de Futuro (Futura Wiki)

O objetivo final deste sistema é evoluir para uma Wiki de Jogos onde os usuários poderão:
* **Acessar Páginas de Personagens:** Consultar guias detalhados sobre a construção ideal (builds) para diferentes personagens.
* **Visualizar Tier Lists:** Conferir as classificações de força e eficiência dos personagens.
* **Recomendações de Relíquias:** Achar sugestões de equipamentos e itens específicos para otimizar o desempenho no jogo.

O sistema de Login/Admin implementado agora é a base para o futuro gerenciamento e moderação desse conteúdo.

---

## Funcionalidades Implementadas (Fase Atual)

| Funcionalidade | Descrição |
| :--- | :--- |
| **Autenticação Segura** | Login de usuário com verificação de senha via `password_verify()` e proteção contra Session Fixation. |
| **Controle de Tentativas (Cooldown)** | Bloqueio temporário (configurado para **30 segundos** para testes) após 5 tentativas de login falhas. |
| **Restrição de Acesso Admin** | Exibição condicional da listagem de usuários e acesso à área administrativa, verificando o `nivel_acesso` via Cookie. |
| **Dashboard Restrito** | Área dedicada onde o administrador pode visualizar todos os usuários cadastrados. |
| **Cadastro de Usuários** | Criação de novos usuários com validação de campos e armazenamento seguro da senha. |
| **Interface Estilizada** | Layout adaptado ao tema escuro do dashboard (via `css/style.css`). |

---

## Estrutura do Projeto

A estrutura de arquivos segue o padrão de aplicações PHP simples:
Essa é uma excelente visão de futuro! Integrar a ideia de uma Wiki de Jogos (com foco em construção de personagens, tier lists e relíquias) torna o projeto muito mais interessante e justifica a necessidade de um sistema de login e permissões.

Vou reescrever o README.md novamente, garantindo que o título e a descrição reflitam o sistema de autenticação atual e, principalmente, o seu ambicioso objetivo final.

Aqui está o código completo e atualizado do arquivo README.md, pronto para ser copiado:

Markdown

# Projeto: Base para Wiki de Jogos (Sistema de Autenticação e Dashboard)

Este projeto serve como a fundação de segurança para uma futura Wiki de Jogos. Atualmente, ele implementa um sistema robusto de autenticação (Login/Logout) e uma área restrita, com foco em segurança (controle de tentativas de login, bloqueio temporal) e **restrição de acesso administrativo** para gerenciar os futuros dados da Wiki.

---

## Visão de Futuro (Futura Wiki)

O objetivo final deste sistema é evoluir para uma Wiki de Jogos onde os usuários poderão:
* **Acessar Páginas de Personagens:** Consultar guias detalhados sobre a construção ideal (builds) para diferentes personagens.
* **Visualizar Tier Lists:** Conferir as classificações de força e eficiência dos personagens.
* **Recomendações de Relíquias:** Achar sugestões de equipamentos e itens específicos para otimizar o desempenho no jogo.

O sistema de Login/Admin implementado agora é a base para o futuro gerenciamento e moderação desse conteúdo.

---

## Funcionalidades Implementadas (Fase Atual)

| Funcionalidade | Descrição |
| :--- | :--- |
| **Autenticação Segura** | Login de usuário com verificação de senha via `password_verify()` e proteção contra Session Fixation. |
| **Controle de Tentativas (Cooldown)** | Bloqueio temporário (configurado para **30 segundos** para testes) após 5 tentativas de login falhas. |
| **Restrição de Acesso Admin** | Exibição condicional da listagem de usuários e acesso à área administrativa, verificando o `nivel_acesso` via Cookie. |
| **Dashboard Restrito** | Área dedicada onde o administrador pode visualizar todos os usuários cadastrados. |
| **Cadastro de Usuários** | Criação de novos usuários com validação de campos e armazenamento seguro da senha. |
| **Interface Estilizada** | Layout adaptado ao tema escuro do dashboard (via `css/style.css`). |

---

## Estrutura do Projeto

A estrutura de arquivos segue o padrão de aplicações PHP simples:

TRABALHOFINAL/
├── css/
│   └── style.css           # Estilos para Dashboard e Formulários
├── js/
│   └── script.js           # Arquivo JavaScript (vazio ou para futuras interações)
├── autentica.php           # Processa o formulário de login e define a sessão/cookies.
├── banco_de_dados.php      # Conexão PDO com o MySQL.
├── cadastro_usuario.php    # Processa o formulário de cadastro de novos usuários.
├── dashboard.php           # Área restrita principal.
├── gera_hash.php           # Código que gera um hash baseado numa senha, utilizado para criar a sessão teste de admin.
├── index.php               # Página de Login.
├── logout.php              # Encerra a sessão e remove cookies.
├── sem_permissao.php       # Página de erro para acesso negado.
└── verifica_sessao.php     # Função para garantir que o usuário está logado.

---

## Requisitos

* **Servidor web** (ex.: Apache via XAMPP, WampServer, Laragon etc.)
* **PHP 7.4+** * **MySQL 5.7+** ou MariaDB
* **Extensão PDO (PHP Data Objects)** ativada.

---

## Instalação e Configuração

### 1. Preparação dos Arquivos

1.  Copie a pasta `TRABALHOFINAL` para dentro de `htdocs` (XAMPP) ou `www` (WampServer).

### 2. Configuração do Banco de Dados

Crie o banco de dados e a tabela de usuários com a coluna `nivel_acesso`. Execute o seguinte script no seu cliente MySQL:

```sql
-- 1. CRIA O NOVO BANCO DE DADOS
CREATE DATABASE banco_de_dados;
USE banco_de_dados;

-- 2. CRIA A TABELA 'usuarios' COM A COLUNA 'nivel_acesso'
CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso VARCHAR(50) NOT NULL DEFAULT 'user', 
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. INSERE UM USUÁRIO ADMINISTRADOR PADRÃO PARA TESTES
-- IMPORTANTE: A senha DEVE ser o hash gerado pela função password_hash() do PHP.
-- O hash abaixo (pode ser usado para testes) é da senha: '123456'
INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES (
    'Admin Teste',
    'admin@email.com',
    '$2y$10$.uUS04ZucAMdNUzcOF4FkOnW8Vrj4h.RBLs5mXZ6nr6ELQ0FEmE66',
    'admin'
);
```
## Fluxo de Teste
Login Admin: Use E-mail: admin@email.com e Senha: 123456.

Verifique a Função Admin: O botão "Mostrar Cadastros dos Usuários" deve aparecer no dashboard.

Teste o Bloqueio: Erre a senha 5 vezes para confirmar que o bloqueio de 30 segundos é ativado.

Teste o Usuário Comum: Cadastre um novo usuário pelo index.php e logue com ele. O painel administrativo e o botão de listagem não devem aparecer.

---

## Próximos Passos (Evolução para a Wiki)
Estrutura de Conteúdo: Criar tabelas específicas para personagens, relíquias, builds, e tier_lists.

CRUD Admin: Implementar o formulário completo (CRUD) na área administrativa (cadastro_usuario.php) para o administrador poder inserir e editar os dados da Wiki.

Interface da Wiki: Criar páginas públicas para visualização dos dados (sem necessidade de login).

Sessão de comentários: Criar uma sessão individual em cada página para que usuários opinem e discutam na comunidade.

Gerenciamento de usuários: Administradores terão permissão para banir usuários que acharem necessários ou que desrespeitam outros usuários na página.
