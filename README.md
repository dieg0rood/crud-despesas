
# CRUD Despesas

Projeto consiste em um CRUD (CREATE, READ, UPDATE, DELETE) de despesas, tendo algumas regras:
- O sistema é acessivel somente para usuários registrados e autenticados.
- Qualquer usuário pode registrar uma despesa para qualquer outro usuario existente, enviando seu respectivo id.
- Um usuário só pode ler/atualizar/apagar uma despesa existente e referenciado ao seu id de usuário.

## Instalação

Faça o clone do projeto em uma pasta de sua preferência

```bash
  git clone git@github.com:dieg0rood/crud-despesas.git
```

Acessando o diretório raiz do projeto faça a instalação das dependências do projeto

```bash
  composer install
```    

Copie o arquivo env

```bash
  cp .env.example .env
```
Obs.:Nesse momento, é importante que você configure manualmente os dados de SMTP para que o envio de e-mail funcione corretamente!

Na raiz do projeto, gere o banco de dados com suas migrations, segue exemplo utilizando o sail

```bash
  alias sail="vendor/bin/sail"
  sail up -d 
  sail artisan migrate
```

Para utilizar o servidor do laravel

```bash
  sail artisan serve
```  

Após isso a API já estará disponível para consulta

*Obs.: Utilizando o sail, a porta para uso será a 80, mesmo que no terminal aponte a porta 8000.

```http
  http://localhost:80/
```
## Rodando os testes

Para rodar os testes, rode os seguintes comandos na raiz do projeto
*Comandos para usar somente se o sail ainda não estiver Up

```bash  
  *alias sail="vendor/bin/sail"
  *sail up -d 
  sail test
```
## Rodando a fila

Para rodar a fila, rode os seguintes comandos na raiz do projeto
*Comandos para usar somente se o sail ainda não estiver Up

```bash  
  *alias sail="vendor/bin/sail"
  *sail up -d 
  sail artisan queue:work
```

# Documentação da API

## Registro e Autenticação

### Cadastrar usuário
```http
  POST /api/auth/register
```

+ Request

            {
                "name": "Name For Test",
                "email": "emailfortest@gmail.com",
                "password": "12345678",
                "password_confirmation": "12345678"
            } 

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `name`      | `string` | **Obrigatório**. Nome do usuário - Maximo 255 caracteres |
| `email`      | `string` | **Obrigatório**. E-mail do usuário - Deve ser único no sistema|
| `password`      | `string` | **Obrigatório**. Senha do usuário - Minimo 8 caracteres |
| `password_confirmation`      | `string` | **Obrigatório**. Confirmação da senha - Minimo 8 caracteres |

+ Response 200 OK

            {
                "data": {
                    "user": {
                        "name": "Name For Test",
                        "email": "emailfortest@gmail.com",
                        "updated_at": "2023-04-23T20:23:33.000000Z",
                        "created_at": "2023-04-23T20:23:33.000000Z",
                        "id": 11
                    }
                }
            }

+ Response 500 Internal Server Error

            {
                "message": "Não foi possível cadastrar o usuário, tente novamente mais tarde!",
            } 

### Login (gerar token)
```http
  POST /api/auth/login
```

+ Request

            {
                "email": "emailfortest@gmail.com",
                "password": "12345678"
            } 

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `email`      | `string` | **Obrigatório**. E-mail do usuário |
| `password`      | `string` | **Obrigatório**. Senha do usuário |

+ Response 200 OK

            {
                "data": {
                    "token": "6|R3fmyQkw442NoHcAQycSxif44rTat5Ay3mSWDvjc"
                }
            }  

+ Response 401 Unauthorized

            {
                "message": "Credenciais inválidas!",
            } 

### Logout (expirar token)
```http
  POST /api/auth/logout
```

+ Headers

            Authorization: Bearer [access_token]


| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `authorization`      | `string` | **Obrigatório**. Access token gerado no login |

+ Response 204 No Content

            {
            } 

## Expenses[/expenses]

Para todas as requisições a seguir, deverá ser enviado um token válido:
+ Headers

            Authorization: Bearer [access_token]

### Listar despesa 

```http
  GET /api/expenses/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Opcional**. Id da despesa (Caso não informado serão buscados todas as despesas do usuário autenticado.) |

+ Response 200 OK

            {
                "id": 28,
                "description": "Teste 001",
                "expense_date": "2013-11-12",
                "user_id": 1,
                "amount": "1222.33",
                "created_at": "2023-04-23T19:31:01.000000Z",
                "updated_at": "2023-04-23T19:31:01.000000Z"
            }

+ Response 401 Unauthorized

            {
                "message": "Usuário não autorizado a realizar a ação!",
            } 

+ Response 404 Not Found

            {
                "message": "Nenhuma despesa encontrada para o usuário nº ${id}",
            }   

### Cadastrar uma despesa

```http
  POST /api/expenses/
```

+ Request

            {
                "user_id": 1,
                "description": "Teste 005",
                "expense_date": "2013-11-12",
                "amount": "1222.33",
            }

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `user_id`      | `int` | **Obrigatório**. Id de usuário registrado que terá a despesa vinculada |
| `description`      | `string` | **Obrigatório**. Descrição da despesa - Limite 191 caracteres |
| `expense_date`      | `date` | **Obrigatório**. Data da despesa - Formato YYYY-mm-dd (igual ou anterior a hoje) |
| `amount`      | `decimal` | **Obrigatório**. Valor da despesa - Formato: inteiro ou com duas casas decimais ex: 999.99|


+ Response 201 Created

            {
                "id": 28,
                "description": "Teste 005",
                "expense_date": "2013-11-12",
                "user_id": 1,
                "amount": "1222.33",
                "created_at": "2023-04-23T19:31:01.000000Z",
                "updated_at": "2023-04-23T19:31:01.000000Z"
            }

+ Response 401 Unauthorized

            {
                "message": "Usuário não autorizado a realizar a ação!",
            } 

+ Response 500 Internal Server Error

            {
                "message": "Não foi possível criar a despesa, tente novamente mais tarde!",
            } 
### Atualizar uma despesa

```http
  PUT /api/expenses/${id}
```

+ Request

            {
                "description": "Teste 066",
                "expense_date": "2013-10-12",
                "amount": "1555.33",
            }

+ Response 401 Unauthorized

            {
                "message": "Usuário não autorizado a realizar a ação!",
            } 

+ Response 500 Internal Server Error

            {
                "message": "Nenhuma despesa encontrada para o usuário nº 1",
            }              

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. Id da despesa |
| `description`      | `string` | **Opcional**. Descrição da despesa - Limite 191 caracteres |
| `expense_date`      | `date` | **Opcional**. Data da despesa - Formato YYYY-mm-dd (igual ou anterior a hoje) |
| `amount`      | `decimal` | **Opcional**. Valor da despesa - Formato: inteiro ou com duas casas decimais ex: 999.99|


+ Response

            {
                "id": 28,
                "description": "Teste 005",
                "expense_date": "2013-10-12",
                "user_id": 1,
                "amount": "1555.33",
                "created_at": "2023-04-23T19:31:01.000000Z",
                "updated_at": "2023-04-23T19:31:01.000000Z"
            }     

### Deletar uma despesa

```http
  DELETE /api/expenses/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. Id da despesa |


+ Response 204 No Content

            {
            }   
                              
+ Response 401 Unauthorized

            {
                "message": "Usuário não autorizado a realizar a ação!",
            } 

+ Response 500 Internal Server Error

            {
                "message": "A Despesa nº ${id} não pode ser excluída",
            }     
