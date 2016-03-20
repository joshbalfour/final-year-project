**V 1.2.0**
# Algorithm
### Station tracks
The first step will be to preprocess all of the train tracks and the stations so that we can produce a simple map which contains a table with a line.

#### Method
##### Techinical
All of the following process will be passed down to Node.Js because PHP will not provide the performance needed to chrunch the numbers in a timely manour.

##### Flatten
All of the rails will be flattened and join together to produce a continuous graph of connected nodes. This will group lines that run next to each other together and lines that join on junctions that aren't present in the shape file.

##### Attach stations and crossings
All of crossings and stations will be attached to their nearest node on the line. This will be based on distance but can be based on the shape and size of the station is using general area proves ineffective.

##### Mapping the result
We will start at each train station and begin walking along the nodes. If a node connects to two other nodes then we branch off the walker down each set of nodes. Once we reach a node that has a station attached we add the path and the station along with the from and to destinations into the database. We continue along into will covert 6 stations. This is a compromise between doing all station to all stations and having a 250GB data, and connnecting each station to the nearest neighbour which national rail may not provide.

##### End
The end result will be a table of the track that goes from station to stations. All location based columns will be stored in **Well Known Text**. The standard for storing locations.

#### Data flow

![image](../images/ERD.png =800x)

##### line
The line table contains a list of all of the train lines by national rail. This contains single end to end pieces of track and doesnt store where train joins or splits.

##### station
The station table contains a list of all the train stations in the UK.

| Station | Location |
| ------- | -------- |
| ABC     | 12 11.5  |
| DH1     | 10 12.8  |

##### crossing
The crossing table contians a list of all the crossings in the UK and meta meta about them.

| Crossing | Location |
| -------- | -------- |
| 4435     | 12 11.5  |
| 8865     | 10 12.8  |


##### train_routes
This train_routes table is statically produce when the system is first loaded and would need to be reran if nationa rail ever adds more track.

| From | To  | Route           |
| ---- | --- | --------------- |
| ABC  | DH1 | 1.0 13, 1.1 13  |
| DH1  | ABC | 1.1 13, 1.0 13  |
| DH1  | GGH | 9.3 1, 9.4 1.1  |


##### train_route_has_crossings
The train_route_has_crossings table stores the distance from each station how far along the train route the level crossing is.

##### toploc_to_crs
A table that maps the tiploc codes, the referance points provided by nationalrail data feeds with the crs codes, the ids given to each station.

##### train_times
The train_times table contains all of the train times prvoided by national rail. A train time says where a train will arrive and depart from each tiploc.

##### train_times_with_crs
The train_times_with_crs view contains the toploc_to_crs and train_times joined together. The table is complex to compute because not all tiplocs have matching cts codes so the query flatterns train time skipping out unknown tiplocs codes.

##### crossing_interaction_time
The final crossing_interaction_time view is a table that contains the predicted collisions between all trains and level crossings. This view is not expected to be read interaly, but to filter the results as needed, and the SQL engine will pull out the subset of results needed.




### Train Times
The data we get from national rail is times about when a train goes past each station. This data will be loaded into the database into the following schema.

| From tpl  | FromTime  | To tpl   | ToTime    | RID          |
| --------- | --------- | -------- | --------- | ------------ |
| ABC       | Sat 12:05 | DH1      | Sat 12:35 | 2015021222   |
| DH1       | Sat 23:54 | ABC      | Sun 01:12 | 2015021444   |

### Stats
##### Now
To compute the stats now we begin by selecting all the train times that have a start and end date that cover the current time. Then simulate the train running over that track at that time and calculate whether it's location at the current time is within the tolerance of the crossing going down.
 

##### Future
To compute the future stats we select all train times that will be between now and the prediction future. Then simulate the train running over that track at that those and calculate the times that the train will come within contact with a level crossing.

