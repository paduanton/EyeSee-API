![](https://i.imgur.com/Ypv4mSz.png)

# Overview

EyeSee is an open source mobile app developed in partnership with [Natália](http://github.com/nataliaPintos/)
and it is built based in PHP with Laravel Framework. This project is the backend REST
API only. The frontend is written in React Native and can be found here:

[EyeSee Frontend](https://github.com/nataliaPintos/EyeSee)

## Project Setup

Install required packages:
```
composer install
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
* nome
* sobrenome
* email
* password
* deficiente

To login send a POST request to `/api/auth/login` with the data:
* email
* password

On success, user information and API token will be returned:
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
- [Facebook](https://www.facebook.com/TheNewBoston-464114846956315/)
- [Frontend (GitHub)](https://github.com/buckyroberts/Vataxia-Frontend)
- [Reddit](https://www.reddit.com/r/Vataxia/)
- [Slack](https://vataxia.slack.com/)
- [Support](https://www.patreon.com/thenewboston)
