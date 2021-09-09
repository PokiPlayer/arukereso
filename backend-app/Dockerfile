ARG DOCKER_IMAGE_PHP_FPM

FROM ${DOCKER_IMAGE_PHP_FPM} as php-base

ARG project_root=.

WORKDIR /app

COPY ${project_root}/composer.* ./
COPY ${project_root}/composer ./app/composer
COPY ${project_root}/artisan /app/
COPY ${project_root}/.env* /app/
COPY ${project_root}/app /app/app
COPY ${project_root}/bootstrap /app/bootstrap
COPY ${project_root}/config /app/config
COPY ${project_root}/database /app/database
COPY ${project_root}/public /app/public
COPY ${project_root}/resources /app/resources
COPY ${project_root}/routes /app/routes
COPY ${project_root}/vendor /app/vendor
COPY ${project_root}/storage /app/storage

RUN set -eux; \
    mkdir -p /app/storage/logs;  \
    mkdir -p /app/storage/public;  \
    mkdir -p /app/storage/framework/cache;  \
    mkdir -p /app/storage/framework/cache/data;  \
    mkdir -p /app/storage/framework/testing;  \
    mkdir -p /app/storage/framework/sessions;  \
    mkdir -p /app/storage/framework/views;  \
    chmod 775 -R /app/storage; \
    chmod 777 -R /app/storage/framework/cache; \
    chmod 777 -R /app/storage/framework/sessions; \
    chmod 777 -R /app/storage/framework/views; \
    chmod 777 -R /app/storage/logs; \
	sync





