FROM php:8.2-apache

# Install PDO MySQL untuk koneksi database
RUN docker-php-ext-install pdo pdo_mysql

# Aktifkan mod_rewrite buat .htaccess (Routing MVC)
RUN a2enmod rewrite

# Create Logs directory dengan proper permissions
RUN mkdir -p /var/www/html/app/Logs && \
    chmod 777 /var/www/html/app/Logs

# Memastikan folder public dapat dibaca Apache
RUN chown -R www-data:www-data /var/www/html

# Set proper permissions for app directory
RUN chmod -R 755 /var/www/html/app && \
    chmod 777 /var/www/html/app/Logs
