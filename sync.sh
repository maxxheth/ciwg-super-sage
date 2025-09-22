#!/bin/bash

# Sync the web directory to the server
rsync -avz --delete web/ root@192.168.1.100:/var/www/html/

# Sync the database to the server
mysqldump -u root -p wordpress | ssh root@192.168.1.100 "mysql -u root -p wordpress"