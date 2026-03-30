# On part de l'image officielle
FROM php:8.3-apache

# On installe l'extension PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# 1. Activer le module mod_rewrite d'Apache
RUN a2enmod rewrite

# 2. Autoriser explicitement les fichiers .htaccess dans le DocumentRoot
RUN printf '<Directory /var/www/html>\n    AllowOverride All\n    Require all granted\n</Directory>\n' > /etc/apache2/conf-available/allow-htaccess.conf \
	&& a2enconf allow-htaccess