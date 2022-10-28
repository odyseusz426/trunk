FROM  phpstorm/php-cli:8.1-xdebug3.1 as os
RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl
ENV APP_DIR /app
RUN mkdir -p $APP_DIR

FROM os as build
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN apt-get update && apt-get --yes install git
COPY . $APP_DIR
WORKDIR $APP_DIR
RUN composer -n install

FROM os as app
COPY --from=build $APP_DIR/public $APP_DIR/public
COPY --from=build $APP_DIR/src $APP_DIR/src
COPY --from=build $APP_DIR/vendor $APP_DIR/vendor
WORKDIR $APP_DIR/public
CMD ["php", "index.php"]