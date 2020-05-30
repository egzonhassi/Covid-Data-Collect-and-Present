Go to CovidBackend, firstly run the command "composer install"

After that make a .env file, connect it to a database , run "php artisan migrate:fresh" than seed the DB with the command "php artisan db:seed". Afterwards make a cron job that runs the schedule which will collect covid data daily.

Open the frontend and change the url to your url and you are all set up.