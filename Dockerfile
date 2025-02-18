# Use official PHP image with Apache
FROM php:8.2-apache
# Enable mod_rewrite for Apache (needed for URL rewriting)
RUN a2enmod rewrite
# Install MySQL client and mysqli extension for PHP
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli \
    && rm -rf /var/lib/apt/lists/*  # Clean up unnecessary files
# Set the working directory inside the container
WORKDIR /var/www/html
# Copy the application files into the container
COPY . /var/www/html/
# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
# Expose Apache's default port
EXPOSE 80
# Start Apache
CMD ["apache2-foreground"]






