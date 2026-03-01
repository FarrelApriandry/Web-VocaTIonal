FROM php:8.2-apache

# Install PDO MySQL untuk koneksi database
RUN docker-php-ext-install pdo pdo_mysql

# Aktifkan mod_rewrite buat .htaccess (Routing MVC)
RUN a2enmod rewrite

# Memastikan folder public dapat dibaca Apache
RUN chown -R www-data:www-data /var/www/html