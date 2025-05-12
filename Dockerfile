FROM node:18 AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

FROM php:8.1-fpm

# Instala dependências básicas
RUN apt-get update && apt-get install -y \
    libzip-dev unzip curl git zip libpng-dev libonig-dev libxml2-dev \
    netcat-openbsd \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia os arquivos da aplicação
COPY . .

# Copia os arquivos compilados do Vite
COPY --from=node-builder /app/public/build /var/www/public/build
COPY --from=node-builder /app/public/mix-manifest.json /var/www/public/mix-manifest.json
COPY --from=node-builder /app/public/build/manifest.json /var/www/public/build/manifest.json

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Ajusta permissões
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

EXPOSE 8000

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

CMD ["/usr/local/bin/entrypoint.sh"]
