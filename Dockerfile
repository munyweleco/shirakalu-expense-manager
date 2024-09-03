# Build stage for Node.js dependencies
FROM node:18 as node-builder

# Install pnpm
RUN npm install -g pnpm

WORKDIR /app

# Copy package.json and pnpm-lock.yaml (if you have one)
COPY package.json pnpm-lock.yaml* ./

# Install dependencies
RUN pnpm install --frozen-lockfile

# Copy application files
COPY . .

# Build assets if needed (adjust this command based on your build script)
RUN pnpm install

# Production stage
FROM yiisoftware/yii2-php:8.3-fpm

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Copy built assets from node-builder stage
COPY --from=node-builder /app/web/assets /app/web/assets

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/web/assets \
    && chmod -R 755 /app/runtime

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]