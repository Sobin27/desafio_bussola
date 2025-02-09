# Desafio Bússola Digital

Pequena aplicação que simula um carrinho de compras simples.

## Instalação
Para instalar o projeto você precisar clonar o repositório para o seu ambiente local e instalar as dependências do projeto.

```bash
git clone https://github.com/Sobin27/desafio_bussola.git
```
Após clonar o repositório, entre na pasta do projeto e instale as dependências do projeto.

```bash
cd desafio_bussola
```
```bash
composer install
```
Após a instalação das dependências, copie o arquivo .env.example para .env e gere uma chave para a aplicação.

```bash
cp .env.example .env
```
E crie uma chave para a aplicação.

```bash
php artisan key:generate
```
Pronto, ambiente configurado e pronto para uso.


## Formas de uso

Para rodar a aplicação, basta rodar o comando abaixo.

```bash
php artisan serve
```
E você precisará de algum app para testar as requisições, como o Postman ou Insomnia.

## Rotas
Você deve acessar a rota: http://localhost:8000/api/checkout utilizando do método HTTP Post para enviar um JSON com os produtos que deseja adicionar ao carrinho.

Exemplo de Json para pagamento via PIX:
```json
{
    "paymentmethod": "pix",
    "items": [
        {
            "name": "Produto C",
            "price": 100,
            "quantity": 2
        }
    ],
    "cardInformation": null
}
```
Exemplo de retorno:
```json
{
    "message": "Payment processed successfully",
    "totalToPay": 180
}
```
Exemplo de Json para pagamento via Cartão de crédito a vista:
```json
{
    "paymentmethod": "credit_card",
    "items": [
        {
            "name": "Produto A",
            "price": 50,
            "quantity": 2
        }
    ],
    "cardInformation": [
        {
            "cardNumber": "1234 5678 9012 3456",
            "cardHolder": "Fulano de Tal",
            "expirationDate": "12/25",
            "cvv": "123",
            "installments": 1
        }
    ]
}
```
Exemplo de retorno:
```json
{
    "message": "Payment processed successfully",
    "totalToPay": 180
}
```

Exemplo de Json para pagamento via Cartão de crédito parcelado:
```json
{
    "paymentmethod": "credit_card",
    "items": [
        {
            "name": "Produto B",
            "price": 75,
            "quantity": 2
        }
    ],
    "cardInformation": [
        {
            "cardNumber": "1234 5678 9012 3456",
            "cardHolder": "Fulano de Tal",
            "expirationDate": "12/25",
            "cvv": "123",
            "installments": 4
        }
    ]
}
```
Exemplo de retorno:
```json
{
    "message": "Payment processed successfully",
    "totalToPay": "208.12",
    "installments": {
        "amount": "52.03",
        "total": 4
    }
}
```
## Para rodar os testes
Para rodar os testes de feature, basta rodar o comando abaixo.

```bash
php artisan test --filter=CheckoutTest
```

E para rodar os teste de unidade, basta rodar o comando abaixo.

```bash
php artisan test --filter=CheckoutServiceTest
```
