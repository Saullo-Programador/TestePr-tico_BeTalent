# Payment Gateway API

API RESTful para processamento de compras utilizando múltiplos gateways de pagamento.
Projeto desenvolvido como teste técnico utilizando Laravel.

---

# 📌 Descrição

Este projeto implementa um sistema de compras que calcula o valor total da compra a partir de produtos armazenados no banco de dados e tenta processar o pagamento utilizando múltiplos gateways.

Caso o primeiro gateway falhe, o sistema automaticamente tenta o próximo gateway disponível. Se algum gateway retornar sucesso, a API retorna sucesso para o cliente.

O sistema também registra todas as transações e os produtos envolvidos em cada compra.

---

# 🚀 Tecnologias Utilizadas

* PHP 8+
* Laravel 10
* MySQL
* Eloquent ORM
* PHPUnit

---

# ⚙️ Requisitos

Antes de rodar o projeto você precisa ter instalado:

* PHP 8+
* Composer
* MySQL
* Docker (opcional, para rodar os gateways mock)

---

# 📥 Instalação

Clone o repositório:
```
git clone https://github.com/seu-usuario/payment-gateway-api.git

```
Entre na pasta do projeto:

```
cd payment-gateway-api
```

Instale as dependências:
```
composer install
```
Copie o arquivo de ambiente:
```
cp .env.example .env
```
Configure o banco de dados no arquivo `.env`.

Depois gere a chave da aplicação:

```
php artisan key:generate
```
---

# 🗄️ Banco de Dados

Execute as migrations:
```
php artisan migrate
```
As principais tabelas criadas são:

- users
- gateways
- clients
- products
- transactions
- transaction_products

---

# ▶️ Rodando a aplicação

Inicie o servidor:
```
php artisan serve
```
A API estará disponível em:
```
http://localhost:8000
```
---

# 💳 Rodando os Gateways Mock

Para simular os gateways de pagamento utilize o Docker:

Sem autenticação:
```
docker run -p 3001:3001 -p 3002:3002 -e REMOVE_AUTH='true' matheusprotzen/gateways-mock
```
Gateway 1 ficará disponível em:
```
http://localhost:3001
```
Gateway 2 ficará disponível em:
```
http://localhost:3002
```
---

# 📡 Endpoint Principal

## Realizar compra
```
POST /purchase
```
### Body
```
{
    "name": "Cliente Teste",
    "email": "[cliente@email.com](mailto:cliente@email.com)",
    "cardNumber": "5569000000006063",
    "cvv": "010",
    "products": [
        {
            "id": 1,
            "quantity": 2
        },
        {
            "id": 2,
            "quantity": 1
        }
    ]
}
```
### Funcionamento

1. A API recebe a requisição de compra.
2. O sistema calcula o valor total com base nos produtos e quantidades.
3. O sistema tenta realizar o pagamento no primeiro gateway.
4. Caso o primeiro gateway falhe, o segundo gateway é utilizado.
5. Se algum gateway retornar sucesso, a compra é considerada concluída.
6. A transação é salva no banco de dados.
7. Os produtos da transação são registrados na tabela `transaction_products`.

---

# 📄 Resposta da API

Sucesso:
```
{
"status": "success",
"amount": 3000
}
```
Falha:
```
{
"status": "failed",
"amount": 3000
}
```
---

# 🧪 Testes

Para rodar os testes automatizados execute:
```
php artisan test
```
---

# 📊 Estrutura das Principais Entidades

## Products

* id
* name
* amount

## Clients

* id
* name
* email

## Transactions

* id
* client_id
* gateway_id
* external_id
* status
* amount
* card_last_numbers

## Transaction Products

* transaction_id
* product_id
* quantity

---

# 📌 Observações

Este projeto implementa os requisitos do **Nível 2** do desafio:

* Valor da compra calculado no backend
* Compra com múltiplos produtos
* Integração com múltiplos gateways
* Fallback automático entre gateways
* Persistência das transações
* Persistência dos produtos de cada transação

---

# 👨‍💻 Autor

Saullo Paulo Dantas Felipe
