Requirements :
php7.3
mariadb 10
node.js (on local)
yarn

Install the app :
> git clone https://github.com/malacarnea/TutoOffice.git
> composer install

Install JS and styles files:
> npm install
> npm install bootstrap jquery @popperjs/core utils.js fontawesome select2

Build css and JS with webpack encore :
> composer require symfony/webpack-encore-bundle
> yarn install
> yarn encore dev --watch




Prepare for production environement :
* Webpack
> yarn encore production

* Symfony
> composer require symfony/apache-pack
> composer remove symfony/dotenv
> composer require symfony/dotenv

*** Prod server ***
Create a .env file for environment variables
> composer dump-env prod

Install dependencies in prod with SSH and composer :
> composer install --no-dev --optimize-autoloader

Automaticaly filter folders
> rsync -av ./ myuser@myserver:~/folder --include=public/build --include=public/.htaccess --exclude-from=.gitignore --exclude=".*"

Install database :
> php bin/console doctrine:migrations:migrate