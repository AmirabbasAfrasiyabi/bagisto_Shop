# استفاده از تصویر پایه PHP با Apache
FROM php:8.0-apache

# تنظیمات محیطی
ENV DEBIAN_FRONTEND=noninteractive

# نصب افزونه‌های مورد نیاز PHP و ابزارهای ضروری
RUN apt-get update && \
    apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تنظیم دایرکتوری کاری
WORKDIR /var/www/html

# کپی کردن فایل‌های پروژه به کانتینر
COPY . .

# تنظیم مجوزها
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# اجرای دستورات نصب
RUN composer install \
    && cp .env.example .env \
    && php artisan key:generate

# تنظیمات نهایی
EXPOSE 80
CMD ["apache2-foreground"]
