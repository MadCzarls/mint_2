# Description

The exercise is to write a Symfony application.

<pre>
User Story 1:
As a user, I want to see an option to either sign in or sign up,so I can access
application with my account

Acceptance criteria:
-User should see sign in screen with input data fields for 1)Username 2) Password
-User should see an option to Sign-up if they don't have an account created
-clicking on this option will route user to the Sign-in screen
-User with disabled account should not sign in
-Signed in User should be redirect to restricted part ofapplication
-Signed in User should see logout option

User Story 2:
As a signed in User, I want to see paginated list of
allapplication users, where I can disable each application account.
</pre>

Symfony 4.4 (LTS) project running on Docker (utilizing docker-compose) with PHP 8.0 + nginx 1.19 + MySQL 8.0. By default includes xdebug extension and PHP_CodeSniffer for easy development and basic configuration for opcache for production. Includes instruction for setting it in PhpStorm.

- https://symfony.com/
- https://www.docker.com/
- https://docs.docker.com/compose/
- https://www.php.net/
- https://www.nginx.com/
- https://www.mysql.com/
- https://xdebug.org/
- https://github.com/squizlabs/PHP_CodeSniffer
- https://www.php.net/manual/en/intro.opcache.php
- https://www.jetbrains.com/phpstorm/

# Requirements:

1. Docker version 20.10.3, build 48d30b5
1. docker-compose version 1.28.4, build cabd5cfb
1. bash

# Usage

Clone repository, `cd` inside, create `docker-compose.yml` based on `docker-compose.yml.dist` with `cp docker-compose.yml.dist docker-compose.yml` command. If needed, change configuration according to the comments inside. Then define your `APP_SECRET` in the correct file based on your ENV (`docker/php/.env.app.[dev/prod]`) and run afterwards:

<pre>
docker-compose build
docker-compose up
</pre>

After that log into container with `docker exec -it mint_2.php bash`, where `mint_2.php` is the default container name from `docker-compose.yml.dist`. Then run:

<pre>
composer install
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
</pre>

And confirm last command's execution.
From this point forward, application should be available under `http://localhost:8050/`.

# Overview

All PHP extensions can be installed via `docker-php-ext-install` command in docker/php/Dockerfile. Examples and usage:
`https://gist.github.com/giansalex/2776a4206666d940d014792ab4700d80`.

## PhpStorm configuration

Open directory including cloned repository as directory in PhpStorm.

### Interpreter

1. `Settings` -> `Languages & Frameworks` -> `PHP` -> `Servers`: create server with name `docker` (the same as in ENV variable `PHP_IDE_CONFIG`), host `localhost`, port `8050` (default from docker-compose.yml.dist).
1. Tick `Use path mappings` -> set `File/Directory` <-> `Absolute path on the server` as: `</absolute/path>/mint_2/app` <-> `/var/www/app` (default from docker-compose.yml.dist).
1. `Settings` -> `Languages & Frameworks` -> `PHP`: three dots next to the field `CLI interpreter` -> `+` button -> `From Docker, Vagrant(...)` -> from `docker-compose`, from service `php`, server `Docker`, configuration files `./docker-compose`. After creating in `Lifecycle` section ensure to pick `Always start a new container (...)`, in `General` refresh interpreter data.

### xdebug

1. `Settings` -> `Languages & Frameworks` -> `PHP` -> `Debug: Xdebug` -> `Debug port`: `9003` (set by default) and check `Can accept external connections`.
1. Click `Start Listening for PHP Debug connections` -> `+` button, set breakpoints and refresh website.

### PHPCS

1. Copy `app/phpcs.xml.dist` and name it `phpcs.xml`. Tweak it to your needs.
1. `Settings` -> `Languages & Frameworks` -> `PHP` -> `Quality Tools` -> `PHP_CodeSniffer` -> `Configuration`: three dots, add interpreter with `+` and validate paths. By default, there should be correct path mappings and paths already set to `/var/www/app/vendor/bin/phpcs` and `/var/www/app/vendor/bin/phpcbf`.
1. `Settings` -> `Editor` -> `Inspections` -> `PHP` -> `Quality tools` -> tick `PHP_CodeSniffer validation` -> tick `Show sniff name` -> set coding standard to `Custom` -> three dots and type `/var/www/app/phpcs.xml` (path in container).

### MySQL

Open `Database` section on the right bar of IDE -> `Data Source` -> `MySQL` -> set host to `localhost`, port to `33306`, user to `app_user`, pass `app_pass` (defaults from docker-compose.yml.dist).

### PHPUnit

1. Copy `phpunit.xml.dist` into `phpunit.xml`.
1. Login into `mint_2.php` container and run `./bin/phpunit`.
1. `Settings` -> `Languages & Frameworks` -> `PHP` -> `Test frameworks`. Click `+` and `PHPUnit by Remote Intepreter` -> pick interpreter. In `PHPUnit library` tick `Path to phpunit.phar` and type `bin/phpunit`. Click refresh icon. In `Test runner` section set `Default configuration file` to `phpunit.xml` and `Default bootstrap file` to `tests/bootstrap.php`.

# Disclaimer

Although there are present different files for `prod` and `dev` environments these are only stubs and this repo is not suitable to run on `prod` environment. The idea was to create as much integral, self-contained and flexible environment for `development` as possible and these files are here merely to easily mimic `prod` env and point out differences in configuration.
