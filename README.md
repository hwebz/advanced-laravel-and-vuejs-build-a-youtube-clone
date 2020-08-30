## Advanced Laravel and Vue.js: Build a Youtube Clone
### Author: Kati Frantz
### Publisher: Packt

## How to setup Laralvel + PHP + MySQL + Nginx on Docker
Clone  laravel repo to your local env
1. > git clone https://github.com/laravel/laravel.git my-laravel-app
2. > cd ~/laravel-app

Fetching all composer packages by temporarily running it inside a container (container will be removed immediately once done)

3. > docker run --rm -v $(pwd):/app composer install

Grant non-root user permission

4. > sudo chown -R $USER:$USER ~/my-laravel-app

5. Creating the docker compose file

<pre>
version: '3'
services:

  #PHP Service
  app:
    build:
      context: .
      dockerfile: Dockerfile
    image: digitalocean.com/php
    container_name: app
    restart: unless-stopped
    tty: true
    environment:
      SERVICE_NAME: app
      SERVICE_TAGS: dev
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - app-network

  #Nginx Service
  webserver:
    image: nginx:alpine
    container_name: webserver
    restart: unless-stopped
    tty: true
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www
      - ./nginx/conf.d/:/etc/nginx/conf.d/
    networks:
      - app-network

  #MySQL Service
  db:
    image: mysql:5.7.22
    container_name: db
    restart: unless-stopped
    tty: true
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_ROOT_PASSWORD: your_mysql_root_password
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql
    volumes:
      - dbdata:/var/lib/mysql/
      - ./mysql/my.cnf:/etc/mysql/my.cnf
    networks:
      - app-network

#Docker Networks
networks:
  app-network:
    driver: bridge
#Volumes
volumes:
  dbdata:
    driver: local
</pre>

6. Creating docker file

<pre>
FROM php:7.2-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
</pre>

7. Configuring PHP, create php/local.ini
<pre>
upload_max_filesize=40M
post_max_size=40M
</pre>

8. Configuring Nginx, create nginx/conf.d/app.conf
<pre>
server {
    listen 80;
    index index.php index.html;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /var/www/public;
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }
}
</pre>

9. Configuring MySQL, create mysql/my.cnf
<pre>
[mysqld]
general_log = 1
general_log_file = /var/lib/mysql/general.log
</pre>

10. Modifying evn settings and running containers

> cp .env.example .env

11. Replace db settings inside .env
<pre>
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laraveluser
DB_PASSWORD=your_laravel_db_password
</pre>

12. > docker-compose up -d

Generate laravel key

13. > docker-compose exec app php artisan key:generate

Configuring cache for laravel

14. > docker-compose exec app php artisan config:cache

15. Creating a User for MySQL (prevent root user)
> docker-compose exec db bash

> root@c213cwef3f3:/# mysql -u root -p

> mysql> show databases;

> mysql> GRANT ALL ON laravel.* TO 'laraveluser'@'%' IDENTIFIED BY 'your_laravel_db_password';

> mysql> FLUSH PRIVILEGES;

> mysql> exit

16. Migrate data and working with the Tinker Console

> docker-compose exec app php artisan migrate

> docker-compose exec app php artisan tinker

> \>>> \DB::table('migrations')->get();

## 17. Accessing to http://localhost or http://your_ip_address

# Frontend Scaffolding with Vue
> docker run --rm -v $(pwd):/app composer require laravel/ui

Scaffolding bootstrap and vue with login / registration

> docker-compose exec app php artisan ui bootstrap --auth

> docker-compose exec app php artisan vue --auth

Migrade auth database

> alias art='docker-compose exec app php artisan'

> art migrate

### Media Library

> docker run --rm -v $(pwd):/app composer require "spatie/laravel-medialibrary:^7.0.0"

> docker-compose exec app php artisan vendor:publish

> Choose Provider:  Spatie\MediaLibrary\MediaLibraryServiceProvider


### Link image inside storage/app/public -> public/storage for viewers
> docker-compose exec app php artisan storage:link
