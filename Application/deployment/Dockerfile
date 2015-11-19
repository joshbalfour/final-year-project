FROM debian

RUN mkdir /data

# mysql
ENV MYSQL_MAJOR 5.7
ENV MYSQL_VERSION 5.7.9-1debian8
RUN apt-get update && apt-get install -y perl wget curl ca-certificates --no-install-recommends
RUN apt-key adv --keyserver ha.pool.sks-keyservers.net --recv-keys A4A9406876FCBD3C456770C88C718D3B5072E1F5
RUN echo "deb http://repo.mysql.com/apt/debian/ jessie mysql-${MYSQL_MAJOR}" > /etc/apt/sources.list.d/mysql.list

RUN useradd -g staff mysql && usermod -u 1000 mysql

# the "/var/lib/mysql" stuff here is because the mysql-server postinst doesn't have an explicit way to disable the mysql_install_db codepath besides having a database already "configured" (ie, stuff in /var/lib/mysql/mysql)
# also, we set debconf keys to make APT a little quieter
RUN { \
		echo mysql-community-server mysql-community-server/data-dir select ''; \
		echo mysql-community-server mysql-community-server/root-pass password ''; \
		echo mysql-community-server mysql-community-server/re-root-pass password ''; \
		echo mysql-community-server mysql-community-server/remove-test-db select false; \
	} | debconf-set-selections \
	&& apt-get update && apt-get install -y mysql-server="${MYSQL_VERSION}" && rm -rf /var/lib/apt/lists/* \
	&& rm -rf /var/lib/mysql

# comment out a few problematic configuration values
# don't reverse lookup hostnames, they are usually another container
RUN sed -Ei 's/^(bind-address|log)/&/' /etc/mysql/my.cnf \
	&& echo 'skip-host-cache\nskip-name-resolve' | awk '{ print } $1 == "[mysqld]" && c == 0 { c = 1; system("cat") }' /etc/mysql/my.cnf > /tmp/my.cnf \
	&& mv /tmp/my.cnf /etc/mysql/my.cnf

ENV MYSQL_DIR /data/mysql

EXPOSE 3306

VOLUME [ "/data" ]

ENV MYSQL_ROOT_PASSWORD "level_crossing_predictor"
ENV MYSQL_DATABASE "level_crossing_predictor"
ENV MYSQL_USER "level_crossing_predictor"
ENV MYSQL_PASSWORD "level_crossing_predictor"

# apache

RUN apt-get update && apt-get -y install apache2 php5 php5-mcrypt php5-pgsql php5-mysql
EXPOSE 80

# laravel

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer && composer -V

RUN mkdir /src && rm -rf /var/www/html

VOLUME ["/src"]
VOLUME ["/var/log/apache2"]

RUN service apache2 start && service apache2 stop

CMD ["/bin/bash","-C","/src/deployment/boot.sh"]
