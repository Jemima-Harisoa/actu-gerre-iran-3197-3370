# On part de l'image officielle
FROM php:8.3-apache

# On installe l'extension PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql