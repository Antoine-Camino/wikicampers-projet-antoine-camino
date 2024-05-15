# wikicampers-projet-antoine-camino

Commande pour pouvoir lancer le projet

php -S localhost:8000 -t public | 
php bin/console doctrine:database:create  |
php bin/console make:migration |
php bin/console doctrine:migrations:migrate|
php bin/console doctrine:fixtures:load   
