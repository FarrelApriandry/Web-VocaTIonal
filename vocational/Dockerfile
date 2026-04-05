FROM php:8.2-apache

# 1. Install PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# 2. Aktifkan mod_rewrite (Penting buat routing lo)
RUN a2enmod rewrite

# 3. Copy konfigurasi vhost lo pas build (Biar sinkron)
COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# 4. Paksa Apache buat nonaktifin default lama dan pake yang baru
RUN a2dissite 000-default.conf && a2ensite 000-default.conf

# 5. Create Logs & Permissions
RUN mkdir -p /var/www/html/app/Logs && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 777 /var/www/html/app/Logs

# 6. Set working directory
WORKDIR /var/www/html