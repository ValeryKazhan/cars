#clone repository from github
git clone https://github.com/ValeryKazhan/cars

# install dependencies
composer install


# create .env file and generate the application key
cp .env.example .env
php artisan key:generate

docker-compose up -d

# create database with following credentials
DB NAME = laravel
or
DB NAME = laravel_test(for testing)
DB HOST = 0.0.0.0
PORT = 3306
user = root
password = ""

# migrate database tables with artisan command
php artisan migrate


