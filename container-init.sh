#!/bin/bash

# Ensure proper permissions
chown -R www-data:www-data /var/www/html

SAGE_THEME_DIR="./web/app/themes/sage"

# Install/update Composer dependencies if needed
if [ ! -d "/var/www/html/vendor" ] || [ "/var/www/html/composer.json" -nt "/var/www/html/vendor/autoload.php" ]; then
    composer install --no-dev --optimize-autoloader
fi

# Build Sage theme if needed
cd /var/www/html/web/app/themes/sage
if [ ! -d "node_modules" ] || [ "package.json" -nt "node_modules/.package-lock.json" ]; then
    bun install
fi

if [ ! -d "$SAGE_THEME_DIR/public" ] || find "$SAGE_THEME_DIR" -name "*.css" -o -name "*.js" -o -name "*.ts" | grep -q resources; then
    bun run build
fi

cd /var/www/html

# Start Apache
exec docker-entrypoint.sh apache2-foreground