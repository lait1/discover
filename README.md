## Installation
Clone the repository and run the following commands to install all the dependencies and build frontend scripts and styles:
```bash
git clone git clone https://github.com/lait1/discover.git
cd discover
cp .env.test .env
```

Building a project for production with Nginx setup
```bash
docker-compose up --build
docker exec -it discover-cli bash
composer install

bin/console doctrine:migrations:migrate
bin/console lexik:jwt:generate-keypair
bin/console doctrine:fixtures:load
```

Installing frontend dependencies
```bash
docker exec -it discover-npm bash
npm install
npm run build
```

Create certs

```bash
docker-compose run --rm  certbot certonly --webroot --webroot-path /var/www/certbot/ -d domain.com
```