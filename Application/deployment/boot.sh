if [[ ! -e "$MYSQL_DIR" ]]; then
	mkdir "$MYSQL_DIR"
fi
chown -R mysql:staff "$MYSQL_DIR"
mysqld --initialize-insecure=on --datadir="$MYSQL_DIR"
# cd /data && mkdir osm
# cd osm
# curl $OSM_URL.html | grep -o '"england/.*\latest.osm\.pbf"' | sed 's/"//g' | xargs -P 4 -I % wget -N $OSM_URL/../%
# ls -1 | head -n 1 | xargs -I % osm2pgsql --create --database gis --username postgres "%"
# ls | xargs -I % osm2pgsql --append --database gis --username postgres "%"