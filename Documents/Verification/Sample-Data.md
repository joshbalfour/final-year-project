** V 1.1.0 **

# Sample Data

### Result Definitions 

Hit: The prediction matches or overlaps the timespan of the recorded barrier times, i.e the barriers open and close within the predicted times.
Almost: The prediction correctly matches the opening or closing of the barriers, but not both i.e the barrier closes inside the predicted period but opens outside the period.
Miss: The prediction was wrong, the barrier either didn't open or close at that time, or the barrier did open or close but there was no prediction.

### Take on 20/01/2016
 
| Down  | Up    |
| ----- | ----- |
| 15:22 | 15:25 |
| 15:46 | 15:50 |
| 16:05 | 16:10 |
| 16:22 | 16:26 |
| 16:39 | 16:41 |


### Predicitons V1

| Real  | Real  | Predicition  | Predicition  |        |
| ----- | ----- | ------------ | ------------ | ------ |
| Down  | Up    | Down         | Up           | Result |
| 15:22 | 15:25 | 15:22        | 15:25        | Hit    |
| 15:46 | 15:50 |              |              | Miss   |
| 16:05 | 16:10 | 16:04        | 16:07        | Almost |
| 16:22 | 16:26 | 16:22        | 16:26        | Hit    |
| 16:39 | 16:41 |              |              | Miss   |

Misses seem to be due to a an issue in the train time data collection from national rail. Data needs to be faltended to match known tiploc locations.


### Predicitons V2

| Real  | Real  | Predicition  | Predicition  |        |
| ----- | ----- | ------------ | ------------ | ------ |
| Down  | Up    | Down         | Up           | Result |
| 15:22 | 15:25 | 15:22        | 15:25        | Hit    |
| 15:46 | 15:50 | 15:43        | 15:50        | Almost |
| 16:05 | 16:10 | 16:04        | 16:07        | Almost |
| 16:22 | 16:26 | 16:22        | 16:25        | Hit    |
| 16:39 | 16:41 | 16:39        | 16:41        | Hit    |

### Taken on 03/02/2016

| Down  | Up    |
| ----- | ----- |
| 10:22 | 10:26 |
| 10:45 | 10:51 |
| 11:05 | 11:10 |
| 11:22 | 11:25 |
| 11:39 | 11:41 |
| 12:05 | 12:10 |
| 12:23 | 12:26 |
| 12:47 | 12:51 |
| 13:06 | 13:10 |
| 13:22 | 13:25 |
| 13:40 | 13:41 |
| 14:05 | 14:10 |

### Predicitons
