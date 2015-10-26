FROM postgres

# osm2pgsql setup
RUN apt-get -y update
RUN apt-get -y install osm2pgsql

# postgres configuration
RUN echo "createdb gis --username postgres && psql -d gis -c 'CREATE EXTENSION postgis; CREATE EXTENSION hstore;' --username postgres \n" >> /docker-entrypoint-initdb.d/run.sh

RUN apt-get -y install wget curl
ENV OSM_URL "http://download.geofabrik.de/europe/great-britain/england"
ENV OSM_MIRROR "http://joshbalfour.co.uk/osm/"

RUN mkdir /data

EXPOSE 5432

# mysql

ENV MYSQL_MAJOR 5.7
ENV MYSQL_VERSION 5.7.9-1debian8
RUN apt-get update && apt-get install -y perl --no-install-recommends
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

ADD boot.sh boot.sh
ADD mysql_init.sh mysql_init.sh

RUN cat boot.sh >> /docker-entrypoint-initdb.d/run.sh