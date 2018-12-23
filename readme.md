![](https://github.com/paduanton/EyeSee-API/blob/master/public/png/eyesee.png?raw=true)

# Overview

EyeSee is an open source mobile app developed by [Natália](http://github.com/nataliaPintos/)
and [Antonio](http://github.com/paduanton/). It is built based in PHP with Laravel Framework. This project is the backend REST
API only. The frontend is written in React Native and can be found here:

[EyeSee Frontend](https://github.com/nataliaPintos/EyeSee)


## Scheme
![](https://raw.githubusercontent.com/paduanton/EyeSee-API/master/public/png/system.png)

## System requirements
* PHP >= 7.1.3
* Laravel: 5.7.*
* Composer: 1.6.5


## Project Setup

Install required packages:
```
composer install
```

Create unique key for the application:
```
php artisan key:generate
```

#### Database:
Create a file named .env with the same content that is in a sample file 
named .env.example and just set the informations from your MySQL database. After, run the command bellow:
```
php artisan migrate
```
#### Setup OAuth2 Authentication:
This will generate two encryption keys those are a Password grant client and a Personal access client that allows to use the OAuth2 attributes through the Laravel Passport API:
```
php artisan passport:install
```
#### Fixtures

To run development server:
```
php artisan serve
```

As you have the frontend all setup up, run development server like:
```
php artisan serve --host 192.168.0.24
```
The IP address above is local IP which you can find by running:

Linux:
```
ifconfig
```
Windows:
```
ipconfig
```

## Authentication

To signup, send a POST request to `/api/auth/signup` with the data:
* nome      | String 
* sobrenome | String
* email     | String (email format)
* password - String
* deficiente boolean

To login send a POST request to `/api/auth/login` with the data:
* email
* password

On success, an API access token will be returned with the type of it and its timing to expire:
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ic4ZDAwNG",
    "token_type": "Bearer",
    "expires_at": "2019-12-22 20:50:42"
}
```

All subsequent API requests must include this token in the HTTP header for user identification.
Header key will be `Authorization` with value of 'Bearer' followed by a single space and then token string:
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ic4ZDAwNG
```


## API Documentation
Coming soon...
<!--
To view API documentation, run development server and visit [http://127.0.0.1:8000/docs/](http://127.0.0.1:8000/docs/)
-->
## Links

<!-- - [API Docs](http://127.0.0.1:8000/docs/) -->
- [Frontend (GitHub)](https://github.com/nataliaPintos/EyeSee)
- [Natália (GitHub)](https://github.com/nataliaPintos)
- [Antonio (GitHub)](https://github.com/paduanton)
