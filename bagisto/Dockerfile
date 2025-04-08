
FROM php:8.2-apache

RUN if [ -f /etc/apt/sources.list ]; then \
      sed -i 's|deb.debian.org|debian.asis.ai|g' /etc/apt/sources.list && \
      sed -i 's|security.debian.org|debian.asis.ai|g' /etc/apt/sources.list; \
    else \
      echo "No /etc/apt/sources.list found, skipping mirror change."; \
    fi

RUN for i in $(seq 1 5); do \
        apt-get update -y && break || sleep 10; \
    done

RUN for i in $(seq 1 3); do \
        apt-get install -y \
        git \
        ffmpeg \
        libzip-dev \
        zlib1g-dev \
        unzip \
        libfreetype6-dev \
        libicu-dev \
        libgmp-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libxpm-dev \
        libmagickwand-dev && break || sleep 15; \
    done


RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd

RUN pecl install imagick && \
    docker-php-ext-enable imagick


RUN docker-php-ext-configure intl && \
    docker-php-ext-install intl


RUN docker-php-ext-install bcmath calendar exif gmp mysqli pdo pdo_mysql zip


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN curl -fsSL https://nodejs.org/dist/v18.17.0/node-v18.17.0-linux-x64.tar.gz -o /tmp/node.tar.gz && \
    mkdir -p /usr/local/lib/nodejs && \
    tar -xzf /tmp/node.tar.gz -C /usr/local/lib/nodejs && \
    ln -s /usr/local/lib/nodejs/node-v18.17.0-linux-x64/bin/node /usr/local/bin/node && \
    ln -s /usr/local/lib/nodejs/node-v18.17.0-linux-x64/bin/npm /usr/local/bin/npm && \
    ln -s /usr/local/lib/nodejs/node-v18.17.0-linux-x64/bin/npx /usr/local/bin/npx


ARG container_project_path=/var/www/html
ARG uid=1000
ARG user=myuser

RUN mkdir -p /home/$user && \
    useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


COPY ./.configs/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite


RUN mkdir -p $container_project_path && \
    chmod -R 775 $container_project_path && \
    chown -R $user:www-data $container_project_path


USER $user


WORKDIR $container_project_path
