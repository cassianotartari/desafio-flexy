#!/bin/bash
apt-get update
apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D
apt-add-repository 'deb https://apt.dockerproject.org/repo ubuntu-xenial main'
apt-get update
apt-cache policy docker-engine
apt-get install -y docker-engine
curl -L https://github.com/docker/compose/releases/download/1.15.0/docker-compose-`uname -s`-`uname -m` > ./docker-compose
mv ./docker-compose /usr/bin/docker-compose
chmod +x /usr/bin/docker-compose
apt-get install -y php7.0 php7.0-xml php7.0-zip
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
composer install -d symfony
docker-compose build
docker-compose up -d
docker exec -ti $(docker ps -f name=desafioflexy_php -q) chmod 777 -R app/logs
docker exec -ti $(docker ps -f name=desafioflexy_php -q) chmod 777 -R app/cache
docker exec -ti $(docker ps -f name=desafioflexy_php -q) php app/console assets:install web --symlink