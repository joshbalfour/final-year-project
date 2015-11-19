set -e

export TERM=xterm

if [ ! -d "$MYSQL_DIR/mysql" ]; then

	if [ -z "$MYSQL_ROOT_PASSWORD" -a -z "$MYSQL_ALLOW_EMPTY_PASSWORD" ]; then
		echo >&2 'error: database is uninitialized and MYSQL_ROOT_PASSWORD not set'
		echo >&2 '  Did you forget to add -e MYSQL_ROOT_PASSWORD=... ?'
		exit 1
	fi

	mkdir -p "$MYSQL_DIR"
	chown -R mysql:mysql "$MYSQL_DIR"

	echo 'Initializing database FS'
	mysqld --initialize-insecure=on --datadir="$MYSQL_DIR"
	echo 'Database FS initialized'
	
	mysqld --skip-networking --datadir="$MYSQL_DIR" &
	pid="$!"

	mysql=( mysql --protocol=socket -uroot )


	for i in {30..0}; do
		if echo 'SELECT 1' | "${mysql[@]}" &> /dev/null; then
			echo 'MySQL booted in skip networking mode.'
			break
		fi
		echo 'MySQL init process in progress...'
		sleep 1
	done
	if [ "$i" = 0 ]; then
		echo >&2 'MySQL init process failed.'
		exit 1
	fi


	"${mysql[@]}" <<-EOSQL
		-- What's done in this file shouldn't be replicated
		--  or products like mysql-fabric won't work
		SET @@SESSION.SQL_LOG_BIN=0;

		DELETE FROM mysql.user ;
		CREATE USER 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}' ;
		GRANT ALL ON *.* TO 'root'@'%' WITH GRANT OPTION ;
		DROP DATABASE IF EXISTS test ;
		FLUSH PRIVILEGES ;
	EOSQL

	if [ ! -z "$MYSQL_ROOT_PASSWORD" ]; then
		mysql+=( -p"${MYSQL_ROOT_PASSWORD}" )
	fi

	if [ "$MYSQL_DATABASE" ]; then
		echo "CREATE DATABASE IF NOT EXISTS \`$MYSQL_DATABASE\` ;" | "${mysql[@]}"
		mysql+=( "$MYSQL_DATABASE" )
	fi

	if [ "$MYSQL_USER" -a "$MYSQL_PASSWORD" ]; then
		echo "CREATE USER '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD' ;" | "${mysql[@]}"

		if [ "$MYSQL_DATABASE" ]; then
			echo "GRANT ALL ON \`$MYSQL_DATABASE\`.* TO '$MYSQL_USER'@'%' ;" | "${mysql[@]}"
			echo "CREATE USER '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD' ; GRANT ALL ON \`$MYSQL_DATABASE\`.* TO '$MYSQL_USER'@'%' ;"
		fi
		
		echo 'FLUSH PRIVILEGES ;' | "${mysql[@]}"
	fi
	
	if ! kill -s TERM "$pid" || ! wait "$pid"; then
		echo >&2 'MySQL init process failed.'
		exit 1
	fi

	echo
	echo 'MySQL init process done. Ready for start up.'
	echo

fi

sed -i "s/bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf
sed -i "s|datadir.*|datadir = $MYSQL_DIR|" /etc/mysql/my.cnf

rm /etc/apache2/sites-enabled/000-default.conf
ln -s /src/deployment/apache.conf /etc/apache2/sites-enabled/levelcrossingpredictor.conf
ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
service mysql start
service apache2 start

echo 'Composer install..'

cd /src && composer -v install --prefer-source

echo 'Composer install completed'

echo '🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨'
echo '🚂 💨 🚂 💨                                  🚂 💨 🚂 💨'
echo '🚂 💨 🚂 💨  Level Crossing Predictor Ready  🚂 💨 🚂 💨'
echo '🚂 💨 🚂 💨              Choo Choo           🚂 💨 🚂 💨'
echo '🚂 💨 🚂 💨                                  🚂 💨 🚂 💨'
echo '🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨 🚂 💨'

tail -f /var/log/apache2/error.log

# cd /data && mkdir osm
# cd osm
# curl $OSM_URL.html | grep -o '"england/.*\latest.osm\.pbf"' | sed 's/"//g' | xargs -P 4 -I % wget -N $OSM_URL/../%
# ls -1 | head -n 1 | xargs -I % osm2pgsql --create --database gis --username postgres "%"
# ls | xargs -I % osm2pgsql --append --database gis --username postgres "%"
