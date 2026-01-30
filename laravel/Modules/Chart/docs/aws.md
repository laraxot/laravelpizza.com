ssh <nome progetto>
cd /var/www/html/base_<nome progetto>/laravel
php -d memory_limit=-1 composer.phar selfupdate
php -d memory_limit=-1 composer.phar update -W
rm -rf resources/views/vendor
php artisan vendor:publish --all
rm -rf database/migrations
php artisan migrate
lanciamo piu' volte php artinsa migrate finche' non esce
INFO  Nothing to migrate.


per vedere 
http://ec2-54-194-72-103.eu-west-1.compute.amazonaws.com/it
nuova macchina
http://ec2-54-217-13-148.eu-west-1.compute.amazonaws.com/it
terza
ec2-54-247-235-109.eu-west-1.compute.amazonaws.com
quarta
http://ec2-52-51-189-151.eu-west-1.compute.amazonaws.com/it
quinta
http://ec2-34-247-221-151.eu-west-1.compute.amazonaws.com/it


http://staging.<nome progetto>leingravidanza.it/


se si vedono dei |--35--
dalla cartella laravel
php artisan filament:upgrade
php artisan filament:optimize
php artisan optimize



mailtrap.io
m.sottana@exabytesrl.it
P_wkhD*Zri_7QU#


MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=3347c34800fc41
MAIL_PASSWORD=3b88a5ddd726a5

MAIL_FROM_ADDRESS="hello@<nome progetto>.com"
MAIL_FROM_NAME="${APP_NAME}"