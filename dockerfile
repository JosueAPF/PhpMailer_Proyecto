# Usar una imagen base oficial de PHP
FROM php:8.1-apache

# Copiar los archivos de tu proyecto al contenedor
COPY . /var/www/html/


# Instalar las dependencias necesarias (si las tienes, como PHPMailer)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Exponer el puerto 80
EXPOSE 80

