** V 1.1.0 **

# Sample Data

### Result Definitions 


| Classification | definition |
| ------ | ------ |
| Hit | |The prediction matches or overlaps the timespan of the recorded barrier times, i.e the barriers open and close within the predicted times.|
| Almost | The prediction correctly matches the opening or closing of the barriers, but not both i.e the barrier closes inside the predicted period but opens outside the period. |
| Miss | The prediction was wrong, the barrier either didn't open or close at that time, or the barrier did open or close but there was no prediction. |


### Feature Release Quality Definitions

### Release R3
A 90% degree of accuracy within 2 minutes

### Release R5
A 95% degree of accuracy within 30 seconds

## Results

### St. Dunstans Taken on 20/01/2016
 
| Down  | Up    |
| ----- | ----- |
| 15:22 | 15:25 |
| 15:46 | 15:50 |
| 16:05 | 16:10 |
| 16:22 | 16:26 |
| 16:39 | 16:41 |


#### Respective Predicitons from the application V1

| Real  | Real  | Predicition  | Predicition  |        | Error  |
| ----- | ----- | ------------ | ------------ | ------ | ------ |
| Down  | Up    | Down         | Up           | Result |           |
| 15:22 | 15:25 | 15:22        | 15:25        | Hit    | 0 minutes |
| 15:46 | 15:50 |              |              | Miss   | Missed    |
| 16:05 | 16:10 | 16:04        | 16:07        | Almost | 4 minutes |
| 16:22 | 16:26 | 16:22        | 16:26        | Hit    | 0 minutes |
| 16:39 | 16:41 |              |              | Miss   | Missed |

Misses seem to be due to a an issue in the train time data collection from national rail. Data needs to be flattened to match known tiploc locations.

Average error: 0.75 minutes, 60% of the time.

#### Respective Predicitons from the application V2

| Real  | Real  | Predicition  | Predicition  |        |  Error    |
| ----- | ----- | ------------ | ------------ | ------ | --------- |
| Down  | Up    | Down         | Up           | Result |           |
| 15:22 | 15:25 | 15:22        | 15:25        | Hit    | 0 minutes |
| 15:46 | 15:50 | 15:43        | 15:50        | Almost | 3 minutes |
| 16:05 | 16:10 | 16:04        | 16:07        | Almost | 4 mintues |
| 16:22 | 16:26 | 16:22        | 16:25        | Hit    | 1 minute  |
| 16:39 | 16:41 | 16:39        | 16:41        | Hit    | 0 minutes |


#### Prediction Error
Average error: 1.6 minutes, 100% of the time.

#### Respective Predicitons from the application V3

| Real  | Real  | Predicition  | Predicition  |        |  Error    |
| ----- | ----- | ------------ | ------------ | ------ | --------- |
| Down  | Up    | Down         | Up           | Result |           |
| 15:22 | 15:25 | 15:22        | 15:25        | Hit    | 0 minutes |
| 15:46 | 15:50 | 15:44        | 15:50        | Almost | 2 minutes |
| 16:05 | 16:10 | 16:05        | 16:09        | Almost | 1 mintue  |
| 16:22 | 16:26 | 16:22        | 16:26        | Hit    | 0 minute  |
| 16:39 | 16:41 | 16:39        | 16:41        | Hit    | 0 minutes |


#### Prediction Error
Average error: 30 seconds, 100% of the time.



### St Stephens - Taken on 03/02/2016

| Down  | Up    |
| ----- | ----- |
| 10:22 | 10:25 |
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

#### Respective Predicitons from the application V2

| Real  | Real  | Predicition  | Predicition  |        | Error |
| ----- | ----- | ------------ | ------------ | ------ |------ |
| Down  | Up    | Down         | Up           | Result | |
| 10:22 | 10:25 | 10:22        | 10:25        | Hit    | 0 Minutes | 
| 10:45 | 10:51 | 10:43        | 10:50        | Almost | 3 Minutes |
| 11:04 | 11:10 | 11:04        | 11:07        | Hit    | 0 Minutes |
| 11:22 | 11:25 | 11:22        | 11:25        | Hit    | 0 Minutes |
| 11:43 | 11:46 | 11:43        | 11:47        | Hit    | 0 Minutes |
| 12:05 | 12:07 | 12:04        | 12:07        | Hit    | 0 Minutes |
| 12:23 | 12:26 | 12:22        | 12:25        | Hit    | 0 Minutes |
| 12:47 | 12:51 | 12:43        | 12:47        | Almost | 7 Minutes |
| 13:05 | 13:07 | 13:04        | 13:07        | Hit    | 0 Minutes |
| 13:22 | 13:25 | 13:22        | 13:25        | Hit    | 0 Minutes |
| 13:43 | 13:47 | 13:43        | 13:47        | Hit    | 0 Minutes |
| 14:05 | 14:09 | 14:04        | 14:07        | Almost | 3 Minutes |

#### Prediction Error
Average error: 1.08 minutes, 100% of the time.
