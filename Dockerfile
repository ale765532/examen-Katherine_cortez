FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL PDO
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar todo el proyecto al contenedor
COPY . /var/www/html/

EXPOSE 80