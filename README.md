# API de Transferência de Dinheiro

Esta é uma API REST desenvolvida em **PHP**, inspirada em um desafio da [DevGym](https://devgym.com.br/).  
O objetivo é simular um sistema de **transferência bancária entre usuários**, com **validação de saldo**, **tratamento de concorrência** e **autenticação JWT**.

---

## Desafio original

> **Desafio (DevGym):**  
> Crie um endpoint que receba dois IDs de usuários e um valor monetário representando uma transferência entre eles.  
> Crie também um endpoint que receba o ID de um usuário e retorne o saldo atual.  
> 
> Valide se o usuário de origem possui saldo suficiente antes de realizar a transferência.  
> É necessário considerar a **concorrência**, onde duas pessoas podem transferir dinheiro simultaneamente para uma terceira.  
> Caso uma transferência falhe, o saldo do usuário de origem deve ser **restaurado**.  
> 
> Não é necessário criar endpoints para cadastro de usuários — basta popular o banco com dados iniciais.

---

## Expansão do desafio

Além do desafio original, este projeto foi **expandido** para incluir funcionalidades completas de CRUD, a fim de aperfeiçoar o aprendizado e a prática com desenvolvimento de APIs.

Foram implementados os seguintes recursos adicionais:

- **CRUD de Usuários** → criar, listar, atualizar e excluir usuários  
- **CRUD de Contas** → gerenciar contas bancárias vinculadas aos usuários  
- **CRUD de Bancos** → cadastro e manutenção de bancos disponíveis  
- **Autenticação JWT** → proteção dos endpoints com login e token  
- **Validação de saldo e concorrência** nas transferências  
- **Tratamento de erros e rollback** em caso de falhas  

---

## Tecnologias utilizadas

- **PHP 8+**
- **Composer** (autoloader e organização do projeto)
- **JWT (JSON Web Token)** para autenticação
- **PDO** para acesso ao banco de dados
- **MySQL** como banco de dados principal
- **Apache / Docker** (opcional, ambiente de desenvolvimento)

---

## Endpoints principais

### Autenticação
- `POST /login` → autentica um usuário e retorna o token JWT

### 👤 Usuários
- `POST /users` → cria um novo usuário  
- `GET /users` → lista todos os usuários  
- `GET /users/{id}` → retorna um usuário específico  
- `PUT /users/{id}` → atualiza os dados de um usuário  
- `DELETE /users/{id}` → remove um usuário  

### 🏦 Bancos
- `POST /banks` → cria um banco  
- `GET /banks` → lista bancos  
- `PUT /banks/{id}` → atualiza informações  
- `DELETE /banks/{id}` → remove um banco  

### 💰 Contas
- `POST /accounts` → cria uma conta bancária para um usuário  
- `GET /accounts/{id}` → exibe informações da conta  
- `PUT /accounts/{id}` → atualiza dados da conta  
- `DELETE /accounts/{id}` → remove uma conta  

### 🔄 Transferências
- `POST /transfers` → realiza a transferência entre dois usuários  
  **Body exemplo:**
  ```json
  {
    "from_user_id": 1,
    "to_user_id": 2,
    "amount": 150.00
  }
  ```
- `GET /balance/{user_id}` → retorna o saldo atual do usuário  

---

## ⚙️ Funcionalidades principais

- Verificação de saldo antes da transferência  
- Controle de concorrência (duas transferências simultâneas)  
- Rollback automático em caso de erro  
- Middleware de autenticação JWT  
- Estrutura organizada em **Controllers**, **Models**, **Routes** e **Middlewares**

---

## 🧠 Aprendizado

Este projeto foi criado com o objetivo de **aprofundar o conhecimento** em:
- Estruturação de APIs REST com PHP  
- Boas práticas de código e separação de responsabilidades  
- Implementação de autenticação com JWT  
- Manipulação segura de transações e concorrência em banco de dados  
- Uso do Composer para autoload e organização de namespaces  

---

## 🧪 Próximos passos

- Implementar logs de transações  
- Adicionar testes automatizados  
- Criar documentação com Swagger/OpenAPI  
- Melhorar o tratamento de exceções e respostas HTTP  

---

## 📄 Licença

Este projeto é de livre uso para fins de estudo e aprendizado.
