**V 1.0.0**
# Algorithm
### Station tracks
The first step will be to preprocess all of the train tracks and the stations so that we can produce a simple map which contains a table with a line.

#### Method
##### Flattern
All of the rails will be falterned and join together to produce a continue join of nodes. This will group lines that run next to each other together and lines that join on juction that arent present in the shape file.

##### Attach stations and crossings
All of crossings and stations will be attached to their nearest node on the line. This will be based on distance but can be based on the shape and size of the station is using general area proves ineffective.

##### Mapping the result
We will start at each train station and begin walking alone the nodes. If a node connects to two other nodes then we branch of the walker down each set of nodes. Once we receach a node that has a station attached we stop the walker and add the path the station along with the from and to destinations into the database. 

##### End
The end result will be a table of the track that goes from station to stations.

| From | To  | LineString      |
| ---- | --- | --------------- |
| ABC  | DH1 | 1.0 13, 1.1 13  |
| DH1  | ABC | 1.1 13, 1.0 13  |
| DH1  | GGH | 9.3 1, 9.4 1.1  |

| Station | Location |
| ------- | -------- |
| ABC     | 12 11.5  |
| DH1     | 10 12.8  |

| Crossing | Location |
| -------- | -------- |
| 4435     | 12 11.5  |
| 8865     | 10 12.8  |

### Train Times
The data we get from national rail is times about when a train goes past each station. This data will be loaded into the database into the following schema.

| From tpl  | FromTime  | To tpl   | ToTime    | rid          |
| --------- | --------- | -------- | --------- | ------------ |
| ABC       | Sat 12:05 | DH1      | Sat 12:35 | 2015021222   |
| DH1       | Sat 23:54 | ABC      | Sun 01:12 | 2015021444   |

### Stats
##### Now
To compute the stats now we begin by selecting all the train times that have a start and end date that cover the current time. Grouping these values by service we then find the average running time for each service. Once we have the average running time for each service we model that service running over the track and see if the time it runs over a crossing is the current time minus the saftey bounds that determine how early the barrier goes down.   
Finally is the method of computing stats. it


