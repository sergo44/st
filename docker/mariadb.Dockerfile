FROM mariadb:10.5

RUN apt update && apt upgrade -y && apt install curl -y \
    && curl "https://raw.githubusercontent.com/major/MySQLTuner-perl/master/mysqltuner.pl" -o /usr/local/bin/mysqltuner.pl \
    && chmod +x /usr/local/bin/mysqltuner.pl /usr/local/bin/mysqltuner.pl

