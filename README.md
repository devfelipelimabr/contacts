
# Gestão de Usuários e Contatos

Este projeto é uma aplicação web para gestão de usuários e contatos, construída com **Laravel** e utilizando ferramentas modernas para autenticação, autorização e gerenciamento de dados.

## 🛠️ Funcionalidades

### 👤 Gestão de Usuários

- **CRUD completo** de usuários.
- Usuários possuem os papéis de **Administrador** ou **Usuário comum**.
- **Administradores**:
  - Gerenciam todos os usuários.
  - Podem alternar o status dos usuários (ativo/inativo).
- **Usuários comuns**:
  - Podem editar apenas seus próprios dados (nome).
  
### 📇 Gestão de Contatos

- **CRUD completo** de contatos.
- Cada contato pertence a um usuário específico.
- Usuários só podem gerenciar os contatos que criaram.
- **Campos do contato**:
  - Nome, Telefone, Email, Notas.

### 🔒 Autenticação e Autorização

- Login seguro com middleware **auth**.
- Permissões baseadas em **Gates**:
  - Acesso administrativo protegido por `can:admin`.

### 🌐 Responsividade

- Layout responsivo utilizando **Bootstrap**:
  - Formulários e tabelas ajustados para dispositivos móveis.
  - Integração com **DataTables** para paginação e busca avançada.

---

## 🚀 Tecnologias Utilizadas

- **Laravel**: Framework PHP para backend.
- **Bootstrap**: Para estilização e responsividade.
- **jQuery**: Para manipulação de eventos e AJAX.
- **DataTables**: Para tabelas dinâmicas com busca e paginação.
- **MySQL**: Banco de dados relacional.
- **Faker**: Para geração de dados fictícios em testes e desenvolvimento.

---

## 🔧 Instalação e Configuração

### Pré-requisitos

- PHP >= 8.2
- Composer
- MySQL
- Node.js (para gerenciar dependências do frontend)

### Passos para Instalação

1. Clone o repositório:

   ```bash
   git clone https://github.com/devfelipelimabr/contacts.git
   cd seu-repositorio



2. Instale as dependências do PHP:

    ```bash
    composer install
    
    ```

3. Configure o arquivo `.env`:

    - Copie o exemplo:

        ```bash
        cp .env.example .env
        
        ```

    - Atualize as credenciais do banco de dados e outras configurações no arquivo `.env`.
4. Gere a chave da aplicação:

    ```bash
    php artisan key:generate
    
    ```

5. Execute as migrações e os seeders:

    ```bash
    php artisan migrate --seed
    
    ```

6. Inicie o servidor de desenvolvimento:

    ```bash
    php artisan serve
    
    ```

----------

## 📋 Testes

Para executar os testes:

```bash
php artisan test

```

##### Observação: O teste apaga os dados no BD. Crie um banco de dados para teste

----------

## 📚 Documentação das APIs

### Endpoints Principais

#### Usuários

- `GET /users`: Lista todos os usuários (somente administradores).
- `POST /users`: Cria um novo usuário (somente administradores).
- `PUT /users/{id}`: Atualiza dados de um usuário (administrador ou próprio usuário).
- `DELETE /users/{id}`: Exclui um usuário (somente administradores).

#### Contatos

- `GET /contacts`: Lista os contatos do usuário autenticado.
- `POST /contacts`: Cria um novo contato.
- `PUT /contacts/{id}`: Atualiza um contato do usuário autenticado.
- `DELETE /contacts/{id}`: Exclui um contato do usuário autenticado.
