ARG ALPINE_VERSION=3.15
FROM alpine:${ALPINE_VERSION}

# Install packages and remove default server definition
RUN apk --update add --virtual \
  build-dependencies \
  build-base \
  openssl-dev \
  autoconf \
  git \
  nginx \
  pcre-dev \
  php8 \
  php8-ctype \
  php8-dev \
  php8-dom \
  php8-fpm \
  php8-gd \
  php8-intl \
  php8-mbstring \
  php8-opcache \
  php8-openssl \
  php8-phar \
  php8-session \
  php8-xml \
  php8-xmlreader \
  php8-zlib \
  php8-redis \
  wget \
  supervisor

# Create symlink so programs depending on `php` still function
RUN ln -s /usr/bin/php-config8 /usr/bin/php-config
RUN ln -s /usr/bin/phpize8 /usr/bin/phpize
RUN ln -s /usr/bin/php8 /usr/bin/php

# install php mongo
RUN git clone https://github.com/mongodb/mongo-php-driver.git
RUN cd mongo-php-driver && \ 
    git submodule update --init && \
    phpize && \
    ./configure && \
    make all && \
    make install 

RUN sed -i s/\;extension=shmop/extension=mongodb/g '/etc/php8/php.ini'

# Configure nginx
COPY config/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php8/php-fpm.d/www.conf
COPY config/php.ini /etc/php8/conf.d/custom.ini

# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./src/php/composer.json .

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Run composer require for all requirements
RUN composer require laudis/neo4j-php-client 
RUN composer require mongodb/mongodb --ignore-platform-reqs
RUN composer require jenssegers/mongodb --ignore-platform-reqs

# Run composer install to install the dependencies
RUN composer install \
  --optimize-autoloader \
  --no-interaction \
  --no-progress

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /run 
RUN chown -R nobody.nobody /var/lib/nginx
RUN chown -R nobody.nobody /var/log/nginx

# Switch to use a non-root user from here on
USER nobody

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
# CMD ["/var/www/html/wait-for-mongo.sh", "/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
