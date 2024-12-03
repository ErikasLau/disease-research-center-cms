# Build step for the frontend using Vite
FROM node:23-bullseye AS vite-builder

# The website itself
FROM php:8.3-apache-bullseye

COPY --from=vite-builder /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=vite-builder /usr/local/include/node /usr/local/include/node
COPY --from=vite-builder /usr/local/share/man/man1/node.1 /usr/local/share/man/man1/node.1
COPY --from=vite-builder /usr/local/share/doc/node /usr/local/share/doc/node
COPY --from=vite-builder /usr/local/bin/node /usr/local/bin/node
COPY --from=vite-builder /opt/ /opt/
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm
RUN ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx
RUN ln -s /opt/yarn-$(ls /opt/ | grep yarn | sed 's/yarn-//')/bin/yarn /usr/local/bin/yarn
RUN ln -s /opt/yarn-$(ls /opt/ | grep yarn | sed 's/yarn-//')/bin/yarnpkg /usr/local/bin/yarnpkg

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
COPY package.json /tmp/project/
COPY package-lock.json /tmp/project/
RUN npm install
RUN npm run build

# Run database seed
RUN php artisan

# Remove html directory by default and symlink the public one
# not needed if changing document root
#RUN rm -r html
#RUN ln -s public html

# Update permissions
RUN chown -R www-data:www-data /var/www/html

CMD ["apache2-foreground"]



WORKDIR /tmp/project
