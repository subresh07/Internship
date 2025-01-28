# Use an official PHP image with Apache
FROM php:8.2-apache

# Copy your PHP files to the web server's root directory
COPY . /var/www/html/

# Set permissions for the web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for the web server
EXPOSE 80

# Start Apache when the container starts
CMD ["apache2-foreground"]
