# Build step for the frontend using Vite
FROM node:latest AS vite-builder

WORKDIR /tmp/project

# Copy over and install dependencies
COPY package.json /tmp/project/
COPY package-lock.json /tmp/project/
RUN npm install

# Copy the rest of the files over
COPY . /tmp/project

# Build it
RUN npm run build



# The website itself
FROM php:8.3-apache

# Install required zip development package
RUN apt-get update
RUN apt-get install libzip-dev -y

# Grab composer binary from a composer image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install mysqli extension
RUN docker-php-ext-install pdo_mysql zip

# Allow the use of .htaccess for rewrites
RUN a2enmod rewrite

# Change document root to /var/www/html/public as opposed to /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy all the files
COPY . /var/www/html

# Install dependencies
RUN composer install

# Copy built public content from vite-builder step
COPY --from=vite-builder /tmp/project/public/build public/build

# Run database seed
RUN php artisan

# Remove html directory by default and symlink the public one
# not needed if changing document root
#RUN rm -r html
#RUN ln -s public html

# Update permissions
RUN chown -R www-data:www-data /var/www/html

CMD ["apache2-foreground"]