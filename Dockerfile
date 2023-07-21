# Use the official PHP 7.4 Apache image
FROM php:7.4-apache

# Enable Apache modules and configurations
RUN a2enmod rewrite
RUN a2enmod headers

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of your project into the container
COPY . /var/www/html