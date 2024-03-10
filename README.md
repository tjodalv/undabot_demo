# How to start this project

This project is using docker to run required containers. It will create PHP, nginx, postgres and pgadmin containers.

## 1. Clone this repository

```
git clone git@github.com:tjodalv/undabot_demo.git undabot_demo
```

## 2. Enter project directory

```
cd undabot_demo
```

## 3. Create .env file

The easiest way is just to copy .env.example file like this:

```
cp .env.example .env
```

## 4. Start the containers

```
docker compose up
```

You can optionally use `-d` flag to run the containers in background mode. like this:

```
docker compose up -d
```

## 5. Enter `app` container

Enter app container to install composer dependencies with command:

```
docker compose exec -it app bash
```

## 6. Install composer dependencies

```
composer install
```

## 7. Migrate the database

Create database tables with command:

```
php bin/console doctrine:migrations:migrate
```

## 8. Run the project in the browser

Now you can run the project in the browser with this URL:

```
http://localhost:11223/score?term=php
```

It should return JSON with term and it's score. The score is decimal number between 0-10 calculated as ratio of positive results and total results. If you do not provide the term to search for, service will return JSON error response with status code 400.

## 9. TESTING

To run the tests first create the test database with these commands from within app container:

```
php bin/console --env=test doctrine:database:create
```

And then with this command create schema and tables in the database:

```
php bin/console --env=test doctrine:schema:create
```

Now you are ready to run tests with command:

```
php bin/phpunit
```