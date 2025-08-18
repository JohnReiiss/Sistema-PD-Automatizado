# PDA System V 0.2.0 🚀

Bem-vindo à nova versão do PDA System! O que começou como um sistema web monolítico evoluiu para uma aplicação **full-stack moderna e desacoplada**, com uma API RESTful robusta no back-end e uma interface de usuário dinâmica e reativa no front-end.

Este projeto gerencia os parâmetros de pesagem de produtos industriais, garantindo a segurança e a integridade dos dados através de um sistema de autenticação e autorização baseado em papéis.

<div align="center">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
  <img src="https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript ES6+">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/API-RESTful-orange?style=for-the-badge" alt="API RESTful">
  <img src="https://img.shields.io/badge/Arquitetura-MVC-blueviolet?style=for-the-badge" alt="Arquitetura MVC">
</div>

## ✨ Sobre a Refatoração: De Monolito a API

A versão `0.2.0` não é apenas uma atualização, é uma reconstrução completa. O objetivo foi aplicar as melhores práticas de desenvolvimento de software para criar uma base de código mais segura, escalável e de fácil manutenção.

O sistema monolítico original foi dividido em duas partes independentes:

- **Back-end:** Uma API RESTful `stateless` (sem estado) responsável por toda a lógica de negócios, segurança e comunicação com o banco de dados.
- **Front-end:** Uma interface de usuário dinâmica que consome a API, proporcionando uma experiência fluida e sem recarregamentos de página, construída com JavaScript puro e moderno.

## 🌟 Funcionalidades Principais

- ✅ **Autenticação Segura via Token JWT:** Sistema de login que gera um token JWT para autenticação `stateless`.
- ✅ **Controle de Acesso Baseado em Papéis (RBAC):** Três níveis de permissão (`OPERADOR`, `ADMINISTRADOR`, `HOKAGE`) que restringem o acesso a funcionalidades críticas.
- ✅ **Gerenciamento de Produtos (CRUD):** Funcionalidades completas para criar, buscar, editar e excluir produtos, com ações restritas por nível de acesso.
- ✅ **Painel de Super-Administrador ("Hokage"):** Uma área exclusiva para o nível de acesso mais alto, permitindo o gerenciamento completo de usuários (criar, editar perfis e excluir).
- ✅ **Hashing Progressivo:** Um mecanismo de segurança que atualiza senhas antigas (em texto plano) para o formato de hash moderno de forma automática e transparente no primeiro login bem-sucedido do usuário.
- ✅ **Interface de Usuário Reativa:** Construída com JavaScript moderno (`async/await`, `fetch`), com componentes reutilizáveis, animações e feedback visual através de alertas modernos (SweetAlert2).

## 🛠️ Pilha de Tecnologias (Tech Stack)

#### Back-end

- **PHP 8+:** Utilizado de forma orientada a objetos para construir toda a lógica da API.
- **MySQL:** Banco de dados relacional para persistência dos dados.
- **Composer:** Gerenciador de dependências PHP.
- **Bibliotecas:**
  - `firebase/php-jwt`: Para geração e validação de JSON Web Tokens.
  - `vlucas/phpdotenv`: Para gerenciamento seguro de variáveis de ambiente.

#### Front-end

- **HTML5:** Estrutura semântica e moderna.
- **CSS3:** Estilização com Flexbox, Grid Layout e animações para uma interface responsiva.
- **JavaScript (ES6+):** O cérebro da interface, responsável pela interatividade, chamadas de API (`fetch`) e manipulação do DOM.
- **Bibliotecas (via CDN):** SweetAlert2, Font Awesome, Google Fonts (Poppins), Hamburgers.css.

## 🏛️ Arquitetura e Destaques Técnicos

- **API RESTful:** O back-end expõe endpoints claros e bem definidos para cada ação, comunicando-se exclusivamente via JSON.
- **MVC (Model-View-Controller):** A lógica do back-end é organizada no padrão MVC, separando o acesso a dados (Model), o processamento da requisição (Controller) e a resposta (View/JSON).
- **Componentização no Front-end:** O código front-end foi dividido em componentes reutilizáveis (`header.php`, `footer.php`) e arquivos CSS/JS modulares por funcionalidade, facilitando a manutenção.

## 🚀 Como Executar o Projeto

**Pré-requisitos:** PHP 8+, Composer, MySQL.

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/JohnReiiss/Sistema-PD-Automatizado.git](https://github.com/JohnReiiss/Sistema-PD-Automatizado.git)
    cd Sistema-PD-Automatizado
    ```
2.  **Configure o Back-end:**
    - Navegue até a pasta do back-end: `cd back-end`.
    - Instale as dependências: `composer install`.
    - Crie um arquivo `.env` a partir do exemplo (se houver, ou crie um novo) e preencha com as suas credenciais do banco de dados e uma `JWT_SECRET` segura.
3.  **Configure o Banco de Dados:**
    - Crie um banco de dados MySQL chamado `sistemadepesos`.
    - Importe o SQL da estrutura da tabela `PD_usuario` e `PD_peso`.
    - **Importante:** Para testar o painel do Hokage, altere manualmente o `TIPO_ACESSO` do seu usuário para `HOKAGE` no banco de dados.
4.  **Inicie o Servidor:**
    - Volte para a **pasta raiz** do projeto (`cd ..`).
    - Inicie o servidor embutido do PHP:
      ```bash
      php -S localhost:8000
      ```
5.  **Acesse a Aplicação:**
    - Abra seu navegador e acesse: `http://localhost:8000/front-end/login.php`

## 📌 Demonstração em Vídeo

<div align="center"> 
  <p>Acesse aqui o vídeo de demonstração <a href="https://drive.google.com/file/d/17aH50djg6J-NaBjsKa8ifBT-_UGXnuoY/view?usp=sharing">🎥 Clique aqui para assistir ao vídeo</a></p> 
</div>

## ✉️ Contato

- **Desenvolvedor**: Johnatan dos Santos Reis
- **E-mail:** johnatan.reiiss@icloud.com
- **LinkedIn:** [linkedin.com/in/johnatan-Reis](https://www.linkedin.com/in/johnatan-dos-santos-reis-945092b7/)
- **GitHub:** [github.com/JohnReiiss](https://github.com/JohnReiiss)

---

_Este projeto foi uma incrível jornada de aprendizado e aplicação de conceitos modernos de desenvolvimento web. Agradeço a visita!_
