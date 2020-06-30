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
> npm install bootstrap jquery @popperjs/core utils.js fontawesome

Build css and JS with webpack encore :
> composer require symfony/webpack-encore-bundle
> yarn install
> yarn encore dev --watch

Prepare for production environement :
> yarn encore production