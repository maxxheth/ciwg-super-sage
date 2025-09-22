FROM wordpress:latest


# Switch to root to install required packages
USER root



# Install necessary packages including Composer requirements
RUN apt-get update && apt-get install -y \
    curl \
    mariadb-client \
    cron \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    zip \
    unzip \
    zlib1g-dev \
    git \
    && pecl install redis \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install gd zip mbstring intl pdo pdo_mysql \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

# Install Bun (required for Sage theme development)
RUN curl -fsSL https://bun.sh/install | bash && \
    ln -s /root/.bun/bin/bun /usr/local/bin/bun

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Download WP-CLI, rename it, move it to /usr/local/bin, and make it executable
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp && \
    chmod +x /usr/local/bin/wp


# Create necessary directories
RUN mkdir /data && chown www-data:www-data /data


# Create log directory and ensure correct permissions
RUN mkdir -p /var/www/log && \
    touch /var/www/log/wordpress-website.log && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/log


# Copy cron scripts to the container
COPY ./crons /crons


# Ensure the cron jobs are executable
RUN chmod +x /crons/*


# Setup cron jobs
RUN echo "0 2 * * * root /crons/nightly.sh >> /var/log/nightly.log 2>&1" > /etc/cron.d/nightly && \
    echo "0 2 * * 0 root /crons/weekly.sh >> /var/log/weekly.log 2>&1" > /etc/cron.d/weekly && \
    echo "0 2 1 * * root /crons/monthly.sh >> /var/log/monthly.log 2>&1" > /etc/cron.d/monthly && \
    chmod 0644 /etc/cron.d/*


# Copy the container-init script and make it executable
COPY container-init.sh /usr/local/bin/container-init.sh
RUN chmod +x /usr/local/bin/container-init.sh


# Start cron service
RUN service cron start


# Switch to www-data for the rest
USER www-data


# Set the entrypoint script
ENTRYPOINT ["/usr/local/bin/container-init.sh"]
