# Installation
- Clone
- `composer install`
- `cp .env.example .env && php artisan key:generate`
- Open `.env` and setup your database config
- `php artisan migrate`
- `php artisan db:seed`

# Test Account
Email: johndoe@example.com <br>
Password: secret

# Prerequisites
- PHP >=7.1.3
- PHPUnit 7.0
- SQLite 3 (for testing)

# Test
```shell
vendor\bin\phpunit
```
