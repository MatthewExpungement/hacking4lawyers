#!/bin/bash
mysql -u root <<MY_QUERY
DROP DATABASE IF EXISTS websitedata;
CREATE DATABASE websitedata
MY_QUERY
mysql -u root websitedata < /app/mysql_tables/websitedata.sql