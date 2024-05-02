* Setup a host (see etc/st.test.conf for example)
* Setup php-8.3 FPM and modules
```shell
apt-get install php8.3-fpm php8.3-pdo php8.3-mysql php8.3-mbstring php8.3-redis
```

* Setup redis-server
```shell
apt-get install redis-server
```

Some redis 

https://highload.today/optimizatsiya-nastroek-redis/
https://habr.com/ru/companies/manychat/articles/507136/


* Init composer
```shell
cd /var/www/st.test/www
sudo apt-get install composer
sudo -u www-data composer install
```