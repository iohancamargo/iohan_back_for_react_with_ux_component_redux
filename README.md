# API products
This api was made from the example of this repository (https://github.com/1ma/Slim-Doctrine-Demo).

## Requirements

- PHP 7.3+
- [Composer]
- [MySQL]
- [XDebug]

## Overview
- After cloning this repository, the command: `composer install` must be run.

- You must create a database using mysql, with the default name for slimdb (you can change this name, in the settings.php file, you need to check all the configuration information in this file )

- With the installation done, the `composer server` command will go up on the localhost: 8000 port and you will be able to make the necessary requests described below:

- GET /products    -> Lists all products in the database
- GET /prices/:id  -> Lists the product specified in the id parameter
- PUT /create_data -> Route responsible for registering products in the database

## Running the tests

Similarly, typing `composer test` will take care of loading the testing environment and running PHPUnit. If the XDebug exension is enabled code coverage results will be available at `var/coverage/` after running the tests.