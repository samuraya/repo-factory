# Repository Factory

## Demo app is here: https://repo-factory.herokuapp.com/

## Introduction
This is a solution to the web developer position test posted at EnvyBox company.
The application is based on PSR complient libraries and Vue Js frontend technology. The application follows Action Domain Responder pattern. The entire framework is build from scratch.

## Installation
1. "composer install" from the project root
2. provide local environmental variables in .env file for your local mysql database connection
3. create new database in your local host. Just import file "databases.sql" into your local mysql server
5. run "php -S localhost:8080 -t public/" in project root and visit "localhost:8080/all"

## Project structure
The main folder "src" contains core classes that build the logic and behavior of the app. 
There are separate controllers for each CRUD action. 
There are three Repository implementations of a MessageRepositoryInterface to demonstrate the overall behavior.
There is one core Middleware class that serves as a Repository Factory and builds necessary repositories according to incoming parameter.

## config/datasources.php 
There is only one place where new data source repository has to be provided in order to include it into application. Folder "config" -->> "datasources.php" .


## RepositoryFactoryMiddleware
This is an implementation of PSR MiddlewareInterface that contains the logic to decide which repository implementation should be used.
Next it instanciates every repository class needed, inject dependencies and releases the request to the next layer -> controllers.


## Front-end VueJs UI
An instance of Vue is created and provides UI for the front end 

## PHP -DI
DI container is used in order to autowire and maintain application-wide dependencies.