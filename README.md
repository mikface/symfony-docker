# Symfony 5.3 REST api running in Docker container (php 8.0, mysql 8, nginx) boilerplate

## install:

1) `git clone git@github.com:mikface/symfony-docker.git your-folder-name` 

    or

    `git clone https://github.com/mikface/symfony-docker.git your-folder-name`

2) `cd your-folder-name`

3) `make`

Then access [symfony.localhost:8081](http://symfony.localhost:8081), you should see symfony welcome page.

(**url** / **port** can be changed in **docker-compose.yml::32** / **docker-compose.yml::36**)

### stop docker:

`make down`

### remove database:

`make clean-database`

### add user for app

`make add-user`

### list all app users

`make list-users`

---

## Authentication

To authorize, first add user. Then send POST request to obtain the JWT token:

`curl -X POST -H "Content-Type: application/json" http://symfony.localhost:8081/login_check -d '{"email":"user@example.com","password":"test"}'`

You should now be able to visit page for logged users:

`curl --location --request GET 'http://symfony.localhost:8081/auth/hello-world/greet' --header 'Authorization: Bearer {token}'`

---

## Code quality

To run Codesniffer

`make cs`

Run cs autofix

`make fix`

Run phpstan:

`make phpstan`

Reinit git repo:

`make init-git`
