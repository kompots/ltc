---
title: My First Post
date: 2019-07-10
path: /my-first-post
menu: DevOps
---
This is my first Gatsby post written in Markdown!

# Project settup setp by step

1. Head to https://github.com/kompots/ltc and check out project with git clone https://github.com/kompots/ltc.git;
2. From project root directory enter image-builder folder and execute "docker build -t ltc ." 
3. "cd .."
4. Start docker container with: "docker-compose up -d";
5. Enter docker database container "docker exec -it ltc_db_1 bash";
	- mysql -u root -p  (password toor);
	- Execute "create database ltc; "
6. Exit container and enter webserver container via "docker exec -it ltc_webserver_1 bash"
7. Start webserver container "docker-compose up -d & enter it via docker exec -it ltc_webserver_1 bash
8. Execute following commands from symfony application console:
	- cd /var/www/html/ltc/
	- composer update
		- database host = db;
		- database name = ltc;
		- database password = toor;
	- php app/console doctrine:schema:update --force
	- php app/console assets:install --symlink --relative
	- php app/console assetic:dump
	- php app/console cache:clear 

9. Due to currently annoying BUG in Docker cron jobs tend to work only if you force them into existing image via touch command. Since its a hack, we'll stick to a classic web server settup methods
	- crontab -e and add "* * * * * php /var/www/html/ltc/app/console app:fetch-exchange-rates > /var/www/html/ltc/app/logs/cron.log"
### Exceptional case may occur when crons start to run if image is running on unix machine.

10. Head over to https://localhost:8080/ and you should be able to use the application

- Authorisation logfile available at: app/logs/authentications.log
