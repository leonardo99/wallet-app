#!/bin/sh

# Espera o banco ficar disponível
echo "Aguardando banco de dados em $DB_HOST:$DB_PORT..."

# Tenta conexão com o banco antes de continuar
while ! nc -z $DB_HOST $DB_PORT; do
  sleep 2
done

echo "Banco de dados está acessível!"

# Executa as migrations
php artisan migrate --force

php artisan config:cache

# Inicia o servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000