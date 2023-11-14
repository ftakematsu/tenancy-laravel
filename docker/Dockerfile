FROM php:8.2-fpm

# Copie os arquivos do projeto para o contêiner
COPY . /var/www

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get install -y git
RUN apt-get install -y zip

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure as permissões dos arquivos (ajuste conforme necessário)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap

# Exponha as portas
EXPOSE 3306
EXPOSE 8001

# Configure o PHP-FPM para não rodar como daemon (permitindo que o contêiner continue em execução)
CMD ["php-fpm", "--nodaemonize"]
