# Task app

Task app has been created for recruitment purposes only. It is by far not production ready. It aims to show
paradigm of OOP, DDD, CQS and Testing

## Installation

Copy .env.example to .env in ***root dir***, ***dockler-backend*** and ***dockler-front***. Adjust values if necessary. Default
values work out of the box.

Later please run:

```bash
docker-compose up
```

When build is completed execute command below and follow instructions

```bash
docker exec -it dockler-note_php-fpm_1 sh ./commands
```

## Usage

```
http://127.0.0.1:8080
```

If previous steps have been fulfilled there should already be one task provided. You can

***create task***

***change task state***

## Tests

In the root dir of dockler-backed (host) please execute:

```bash
vendor/bin/behat 
```