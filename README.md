# Csattos Zsolt - Árukereső teszt

## Setup application:

### Clone from GIT repository

```bash
> git clone git@github.com:PokiPlayer/arukereso.git . 
```

### Setup backend application

```bash
> cd backend-app
backend-app> composer install --ignore-platform-reqs
```

### Start docker containers

```bash
backend-app> cd ..
> docker-compose up -d
```

### Init database
```bash
# Login to php container
> docker exec -ti arukereso_php_1 bash
# Run database migrations
app> php artisan migrate
```

## Create test datas:

```bash
# Login to php container
> docker exec -ti arukereso_php_1 bash
# Run database seeders - this create users, products, product prices
app> php artisan db:seed
```

## OpenApi doc:

```bash
http://0.0.0.0/api/doc
```

## Available API endpoints - curl examples:

### Available users list
```bash
curl --location --request GET 'http://0.0.0.0/api/user/list' \
--header 'Accept: application/json'
```

### User login (every user password is: "password")
```bash
curl --location --request POST 'http://0.0.0.0/api/auth' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
"email": "esther.feeney@example.net",
"password": "password"
}'
```

### User logout
```bash
curl --location --request POST 'http://0.0.0.0/api/logout' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 7|qMtVr5RhEhAeo4UvmiGjmvK3HVtjsnvplvFYT5GD' \
--header 'Content-Type: application/json' \
--data-raw '{
}'
```

### Order store (without shipping)
```bash
curl --location --request POST 'http://0.0.0.0/api/order/store' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 7|qMtVr5RhEhAeo4UvmiGjmvK3HVtjsnvplvFYT5GD' \
--header 'Content-Type: application/json' \
--data-raw '{
    "customerName": "Csattos Zsolt",
    "customerEmail": "csattoszsolt@gmail.com",
    "billingAddress": {
        "city": "Budapest",
        "postcode": "1033",
        "address": "Hévízi út 5/A 1/4"
    },
    "deliveryMode": "personal",
    "items": [
        {
            "productId": 1,
            "quantity": 1
        },
        {
            "productId": 2,
            "quantity": 3
        }
    ]
}
'
```

### Order store (with shipping)
```bash
curl --location --request POST 'http://0.0.0.0/api/order/store' \
--header 'Accept: application/json' \
--data-raw '{
    "customerName": "Csattos Zsolt",
    "customerEmail": "csattoszsolt@gmail.com",
    "billingAddress": {
        "city": "Budapest",
        "postcode": "1033",
        "address": "Hévízi út 5/A 1/4"
    },
    "deliveryMode": "shipping",
    "shippingAddress": {
        "city": "Budapest",
        "postcode": "1033",
        "address": "Hévízi út 5/A 1/4"
    },
    "items": [
        {
            "productId": 3,
            "quantity": 5
        },
        {
            "productId": 8,
            "quantity": 1
        },
        {
            "productId": 6,
            "quantity": 4
        }
    ]
}
'
```

### Order status modify
```bash
curl --location --request POST 'http://0.0.0.0/api/order/modify/1' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 7|qMtVr5RhEhAeo4UvmiGjmvK3HVtjsnvplvFYT5GD' \
--header 'Content-Type: application/json' \
--data-raw '{
"orderStatus": "completed"
}
'
```

### Order list (each user can only see their own list...)
```bash
curl --location --request POST 'http://0.0.0.0/api/order/list' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 7|qMtVr5RhEhAeo4UvmiGjmvK3HVtjsnvplvFYT5GD' \
--header 'Content-Type: application/json' \
--data-raw '{
    "orderStatus": "completed",
    "from": "2021-09-09 00:00:00",
    "to": "2021-09-09 09:38:13",
    "id": 1
}
'
```
