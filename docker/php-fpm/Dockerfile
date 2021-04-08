FROM php:7.4-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it


RUN apt-get update && apt-get install -y \
        build-essential \
         curl \
         git \
         htop \
         ncdu \
         netcat \
         net-tools \
         telnet \
         unzip \
         vim \
         wget

RUN apt-get install -y librabbitmq-dev libssl-dev bash-completion
RUN pecl install amqp
RUN docker-php-ext-enable amqp
RUN docker-php-ext-install pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/dockler-backend

CMD composer install;  php-fpm


EXPOSE 9000



