# Symfony 5 with Docker (php8, mysql 8, nginx) boilerplate

## install:

`git clone git@github.com:mikface/symfony-docker.git`

`cd symfony-docker`

`make`

Then access [symfony.localhost:8081](http://symfony.localhost:8081), you should see symfony welcome page.
(url can be changed in docker-compose.yml, line 32)

### stop docker:

`make down`

### remove database:

`make clean-database`

### add user for app

`make add-user`

### list all users

`make list-users`

## Authorization

To authorize, first add user. Then send POST request to obtain the JWT token:

`curl -X POST -H "Content-Type: application/json" http://symfony.localhost:8081/login_check -d '{"email":"user@example.com","password":"test"}'`

You should now be able to visit page for logged users:

`curl --location --request GET 'bakapot.localhost:8081/auth/hello-world/greet' --header 'Authorization: Bearer {token}'`
