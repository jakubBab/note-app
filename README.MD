# Task app

Task app has been created for recruitment purposes only. It is by far not production ready. It aims to show
paradigm of OOP, DDD, CQS and Testing

## Installation

Copy .env.example to .env in ***dockler-backend*** and ***dockler-front*** and adjust values if necessary. Default
values work out of the box.

Later please run:

```bash
docker-compose up
```

When build is completed

Login to container:

```bash
docker exec -it dockler-note_php-fpm_1 bash
```

Execute commands:

```bash
sh ./commands
```

## Usage



```html
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