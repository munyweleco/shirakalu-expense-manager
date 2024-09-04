# Use the Yii2 PHP-FPM with Nginx image
FROM yiisoftware/yii2-php:8.3-fpm-nginx

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the application files into the container
COPY . /var/www/html

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port for Nginx
EXPOSE 80

# Start PHP-FPM and Nginx server
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]