# On part de l'image officielle
FROM php:8.3-apache

# On installe l'extension PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# 1. Activer le module mod_rewrite d'Apache
RUN a2enmod rewrite

# 2. Autoriser les fichiers .htaccess dans le répertoire du projet
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf