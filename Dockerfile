# Dockerfile

# Use uma imagem base oficial do PHP com FPM (FastCGI Process Manager), que é ótimo para produção e desenvolvimento com Nginx.
FROM php:8.2-fpm

# Defina o diretório de trabalho dentro do contêiner.
WORKDIR /var/www/html

# Instale as dependências do sistema necessárias para as extensões comuns do Laravel.
# - libpq-dev: para a extensão pdo_pgsql
# - git, zip, unzip: para o Composer
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instale as extensões PHP necessárias para o Laravel e PostgreSQL.
RUN docker-php-ext-install pdo pdo_pgsql

# Instale o Composer (gerenciador de dependências do PHP).
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Altere o proprietário dos arquivos para o usuário que o FPM executa (www-data),
# isso ajuda a evitar problemas de permissão com logs e cache.
RUN chown -R www-data:www-data /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

# Exponha a porta 9000 para comunicação com o Nginx.
EXPOSE 9000

# O comando padrão para iniciar o PHP-FPM.
CMD ["php-fpm"]