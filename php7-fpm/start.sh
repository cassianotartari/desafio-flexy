usermod -u 1000 www-data
chmod 777 -R /var/www/symfony/app/logs
chmod 777 -R /var/www/symfony/app/cache
php /var/www/symfony/app/console assets:install web --symlink