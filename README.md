# STS Technical task

## Notes from author

#### What's new?
- Used DDD approach.
- Used CQRS approach.
- Php 8.2, I like to keep things updated whenever it is possible. I also like features introduces in 8 like union types, named arguments, constructor property promotion, match expression, enum.
- Symfony 6.2. Consider updating to long term when it is possible.
- Used php-fpm alpine image
- Added basic docker environment.
- Added cs-fixer and code coverage packages.
- Used Sync and Async messages separately.
- Added example specification for wallet balance.
- Added example domain exceptions.
- Added example value objects.
- Added functional tests for Controllers.
- In Shared directory I added few pre-defined (by me) components that made my work easier.

#### What I would do differently? (if I had more time)
- Add symfony forms and validation.
- Add user authentication, authorization and roles. (configure symfony security)
- Add voters and specifications related to accessing objects.
- Add currency to wallet. Maybe similar solution to Revolut where you can have wallet per currency.
- Add more code coverage. I think that 100% code coverage is not necessary. I prefer to have 100% coverage for critical parts of application. In this case I would add more tests for services and repositories.
- Add fixtures or Generators (e.g. Generator::createWallet()). I would use this to generate data for tests.
- Add ci/cd.
- Add logging elk or similar.
- Add swagger documentation.
- Add performance monitoring (blackfire or similar).
- Add uuid to entities. 
- Add domain events e.g. WalletCreated, WalletBalanceChanged, WalletDeleted.
- For specification, you can use composite pattern and resolver. Depend on needs.
- Use value object for early validation and for better readability.
- Add postman collection if needed.
- Add more test coverage, current should be enough for this task.
- Use DTO to pass objects between layers.

## How to start project

These are following steps to set up project:

```
cp .env.dist .env
```
then prepare docker environment:
```
docker-compose build
docker-compose up -d
docker-compose run sts-php bash
or
docker-compose exec sts-php bash
```

final project steps inside of docker container:
```
composer install
bin/console doctrine:database:create
bin/console doctrine:schema:create
```

tests:
```
vendor/bin/phpunit
or
vendor/bin/phpunit --coverage-text
```

REST API:
- POST http://localhost/api/v1/account/{accountId}/wallet
- GET http://localhost/api/v1/account/{accountId}/wallet/{walletId}
- PUT http://localhost/api/v1/account/{accountId}/wallet/{walletId}/deposit
  - body: {"amount": integer}
- PUT http://localhost/api/v1/account/{accountId}/wallet/{walletId}/withdraw
  - body: {"amount": integer}

