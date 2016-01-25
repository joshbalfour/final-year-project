docker build -t level_crossing_predictor .
docker run -v "`pwd`/data":/data -v "`pwd`/../":/src -p 7000:80 -p 7001:3306 level_crossing_predictor

