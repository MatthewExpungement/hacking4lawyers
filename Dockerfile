FROM mattrayner/lamp:latest-1804-php7

RUN apt-get update && apt-get install -y apt-transport-https
RUN apt-get install nano -y
RUN apt-get install software-properties-common -y
RUN apt-get install certbot python-certbot-apache -y

#COPY mysqld_innodb.cnf /etc/mysql/conf.d/mysqld_innodb.cnf

