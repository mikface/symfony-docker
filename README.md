# Symfony 5.2 REST api running in Docker container (php 8.0, mysql 8, nginx) boilerplate

## install:

`git clone git@github.com:mikface/symfony-docker.git` / `git clone https://github.com/mikface/symfony-docker.git`

`cd symfony-docker`

`make`

Then access [symfony.localhost:8081](http://symfony.localhost:8081), you should see symfony welcome page.
(url can be changed in **docker-compose.yml**, line 32)

### stop docker:

`make down`

### remove database:

`make clean-database`

### add user for app

`make add-user`

### list all app users

`make list-users`

## Authorization

To authorize, first add user. Then send POST request to obtain the JWT token:

`curl -X POST -H "Content-Type: application/json" http://symfony.localhost:8081/login_check -d '{"email":"user@example.com","password":"test"}'`

You should now be able to visit page for logged users:

`curl --location --request GET 'http://symfony.localhost:8081/auth/hello-world/greet' --header 'Authorization: Bearer {token}'`

## Code quality

To run Codesniffer

`make cs`

Run cs autofix

`make fix`

Run phpstan:

`make phpstan`
