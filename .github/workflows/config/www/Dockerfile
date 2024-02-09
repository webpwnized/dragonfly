#webpwnized/dragonfly:www

# Start with recent version of PHP with Apache 
# https://hub.docker.com/_/php?tab=tags&page=1&ordering=last_updated&name=apache
FROM php:apache

# ######################### #
# Update the image          #
# ######################### #

# Update software packages
# Install PHP requirements: if any
# Patch the container
# Remove the apt-get lists after installation
RUN apt-get update && \
    apt-get -y upgrade && \
    apt-get -y autoremove && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# ############################  #
# Install application software  #
# ############################  #

# Copy the application project to Apache web files directory
WORKDIR ${{ GitHub.GITHUB_WORKSPACE }}
ADD dragonfly /var/www/dragonfly

# ######################## #
# Configure the web server #
# ######################## #

# Change the document root
ENV APACHE_DOCUMENT_ROOT /var/www/dragonfly/

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Health check to verify web server is running
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost/ || exit 1

# Open ports 80 in the container firewall
# This exposes HTTP
EXPOSE 80

# USER command not used in GitHub Actions
# USER www-data