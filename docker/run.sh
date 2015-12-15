
docker run --name mariadb -p 3306:3306 -e MYSQL_ROOT_PASSWORD="123456" -d mariadb
docker run --name restfullp --link mariadb:dbserver -p 80:80 -v "$(pwd)/../":/var/www/html/ -d ubuntuphp /usr/sbin/apache2ctl -D FOREGROUND
