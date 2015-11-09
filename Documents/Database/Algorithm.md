**V 1.0.2**
# Algorithm
### Station tracks
The first step will be to preprocess all of the train tracks and the stations so that we can produce a simple map which contains a table with a line.

#### Method
##### Flatten
All of the rails will be flattened and join together to produce a continuous graph of connected nodes. This will group lines that run next to each other together and lines that join on junctions that aren't present in the shape file.

##### Attach stations and crossings
All of crossings and stations will be attached to their nearest node on the line. This will be based on distance but can be based on the shape and size of the station is using general area proves ineffective.

##### Mapping the result
We will start at each train station and begin walking along the nodes. If a node connects to two other nodes then we branch off the walker down each set of nodes. Once we reach a node that has a station attached we stop the walker and add the path and the station along with the from and to destinations into the database. 

##### End
The end result will be a table of the track that goes from station to stations. All location based columns will be stored in **Well Known Text**. The standard for storing locations.

| From | To  | Route           |
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

| From tpl  | FromTime  | To tpl   | ToTime    | RID          |
| --------- | --------- | -------- | --------- | ------------ |
| ABC       | Sat 12:05 | DH1      | Sat 12:35 | 2015021222   |
| DH1       | Sat 23:54 | ABC      | Sun 01:12 | 2015021444   |

### Stats
##### Now
To compute the stats now we begin by selecting all the train times that have a start and end date that cover the current time. Then simulate the train running over that track at that time and calculate whether it's location at the current time is within the tolerance of the crossing going down.
 

##### Future
To compute the future stats we select all train times that will be between now and the prediction future. Then simulate the train running over that track at that those and calculate the times that the train will come within contact with a level crossing.

