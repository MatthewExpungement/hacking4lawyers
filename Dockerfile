FROM mattrayner/lamp:latest-1804-php7

COPY mysqld_innodb.cnf /etc/mysql/conf.d/mysqld_innodb.cnf

