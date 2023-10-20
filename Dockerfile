#Usando abordagem de multistage para otimizar a geração de imagem
FROM composer AS vendor-base
WORKDIR /var/www/app
COPY ./composer.* ./

#Gerando a pasta Vendor para otimizado para produção
FROM vendor-base AS vendor-prod
RUN composer install --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --no-autoloader \ 
    --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize --no-dev --ignore-platform-reqs --classmap-authoritative

FROM vendor-base AS vendor-dev
RUN composer install \
    --ignore-platform-reqs \
    --no-autoloader \
    --no-interaction 
COPY . .
RUN composer dump-autoload

#Gera imagem otimizada development
FROM php:7.4-fpm-alpine as backend-development
RUN set -ex \
	&& apk --no-cache add postgresql-libs postgresql-dev \
	&& docker-php-ext-install pgsql pdo_pgsql \
	&& apk del postgresql-dev
COPY . /var/www/app
COPY --from=vendor-dev /var/www/app/vendor /var/www/app/vendor
RUN chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache

#Gera imagem otimizada para produção
FROM php:7.4-fpm-alpine as backend-production
RUN set -ex \
	&& apk --no-cache add postgresql-libs postgresql-dev \
	&& docker-php-ext-install pgsql pdo_pgsql \
	&& apk del postgresql-dev
COPY . /var/www/app
COPY --from=vendor-prod /var/www/app/vendor /var/www/app/vendor
RUN chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache

#Gera o nginx para ficar como proxy para o php-fpm que oferece melhor performance
FROM nginx:alpine as backend-nginx
COPY . /var/www/app
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/
RUN ln -s /var/www/app/storage/app/public /var/www/app/public/storage