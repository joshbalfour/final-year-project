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
| 15:22:15 | 15:25:43 |
| 15:46:43 | 15:50:21 |
| 16:06:24 | 16:10:59 |
| 16:22:32 | 16:26 |
| 16:38:30 | 16:41 |


#### Respective Predicitons from the application V1

| Real  | Real  | Predicition  | Predicition  |        | Error  |
| ----- | ----- | ------------ | ------------ | ------ | ------ |
| Down  | Up    | Down         | Up           | Result |           |
| 15:22:15 | 15:25:43 | 15:22        | 15:25        | Hit    | 0 minutes |
| 15:46:43 | 15:50:21 |              |              | Miss   | Missed    |
| 16:06:24 | 16:10:59 | 16:04        | 16:07        | Almost | 4 minutes |
| 16:22:32 | 16:26 | 16:22        | 16:26        | Hit    | 0 minutes |
| 16:38:30 | 16:41 |              |              | Miss   | Missed |

Misses seem to be due to a an issue in the train time data collection from national rail. Data needs to be flattened to match known tiploc locations.

Average error: 0.75 minutes, 60% of the time.

#### Respective Predicitons from the application V2

| Real  | Real  | Predicition  | Predicition  |        |  Error    |
| ----- | ----- | ------------ | ------------ | ------ | --------- |
| Down  | Up    | Down         | Up           | Result |           |
| 15:22:15 | 15:25:43 | 15:22        | 15:25        | Hit    | 0 minutes |
| 15:46:43 | 15:50:21 | 15:43        | 15:50        | Almost | 3 minutes |
| 16:06:24 | 16:10:59 | 16:04        | 16:07        | Almost | 4 mintues |
| 16:22:32 | 16:26 | 16:22        | 16:25        | Hit    | 1 minute  |
| 16:38:30 | 16:41 | 16:39        | 16:41        | Hit    | 0 minutes |


#### Prediction Error
Average error: 1.6 minutes, 100% of the time.

#### Respective Predicitons from the application V3

| Real  | Real  | Predicition  | Predicition  |        |  Error    |
| ----- | ----- | ------------ | ------------ | ------ | --------- |
| Down  | Up    | Down         | Up           | Result |           |
| 15:22:15 | 15:25:43 | 15:22        | 15:25        | Hit    | 0 minutes |
| 15:46:43 | 15:50:21 | 15:44        | 15:50        | Almost | 2 minutes |
| 16:06:24 | 16:10:59 | 16:05        | 16:09        | Almost | 1 mintue  |
| 16:22:32 | 16:26 | 16:22        | 16:26        | Hit    | 0 minute  |
| 16:38:30 | 16:41 | 16:39        | 16:41        | Hit    | 0 minutes |


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


#### Respective Predicitons from the application V3

| Real  | Real  | Predicition  | Predicition  |        | Error |
| ----- | ----- | ------------ | ------------ | ------ |------ |
| Down  | Up    | Down         | Up           | Result | |
| 10:22 | 10:25 | 10:22        | 10:25        | Hit    | 0 Minutes | 
| 10:45 | 10:51 | 10:45        | 10:50        | Almost | 1 Minutes |
| 11:04 | 11:10 | 11:04        | 11:07        | Hit    | 0 Minutes |
| 11:22 | 11:25 | 11:22        | 11:25        | Hit    | 0 Minutes |
| 11:43 | 11:46 | 11:43        | 11:47        | Hit    | 0 Minutes |
| 12:05 | 12:07 | 12:04        | 12:07        | Hit    | 0 Minutes |
| 12:23 | 12:26 | 12:22        | 12:25        | Hit    | 0 Minutes |
| 12:47 | 12:51 | 12:45        | 12:51        | Almost | 2 Minutes |
| 13:05 | 13:07 | 13:04        | 13:07        | Hit    | 0 Minutes |
| 13:22 | 13:25 | 13:22        | 13:25        | Hit    | 0 Minutes |
| 13:43 | 13:47 | 13:43        | 13:47        | Hit    | 0 Minutes |
| 14:05 | 14:09 | 14:05        | 14:08        | Almost | 1 Minutes |

#### Prediction Error
Average error: 20 seconds, 100% of the time.




### Chilham - Taken on 24/02/2016

| Down  | Up    |
| ----- | ----- |
| 15:29 | 15:31 |
| 15:42 | 15:44 |
| 15:49 | 15:51 |
| 15:59 | 16:05 |
| 16:12 | 16:15 |
| 16:29 | 16:31 |
| 16:42 | 16:45 |
| 16:45 | 16:47 |
| 16:59 | 17:01 |
| 17:12 | 17:15 |
| 17:29 | 17:31 |

#### Respective Predicitons from the application V3

| Real  | Real  | Predicition  | Predicition  |        | Error |
| ----- | ----- | ------------ | ------------ | ------ |------ |
| Down  | Up    | 
| 15:29 | 15:31 | 15:28 | 15:31 | Almost | 1 minute
| 15:42 | 15:44 | 15:42 | 15:44 | Hit 
| 15:49 | 15:51 | 15:49 | 15:51 | Hit
| 15:59 | 16:05 | 16:02 | 16:05 | Almost | 3 minutes
| 16:12 | 16:15 | 16:12 | 16:15 | Hit
| 16:29 | 16:31 | 16:29 | 16:31 | Hit
| 16:42 | 16:45 | 16:42 | 16:46 | Almost | 1 minute
| 16:45 | 16:47 | 16:45 | 16:47 | Hit
| 16:59 | 17:01 | 16:59 | 17:03 | Almost | 2 minutes
| 17:12 | 17:15 | 17:12 | 17:15 | Hit
| 17:29 | 17:31 | 17:29 | 17:31 | Hit

#### Prediction Error
Average error: 38 seconds, 100% of the time.






### Stone - Taken on Sunday 13/03/2016 

Near Faversham (ME13 0WG)

| Down  | Up    |
| ----- | ----- |
| 10:29 | 10:31 |
| 10:42 | 10:44 |
| 10:49 | 10:51 |
| 10:59 | 11:05 |
| 11:12 | 11:15 |
| 11:29 | 11:31 |
| 11:42 | 11:45 |
| 11:45 | 11:47 |
| 11:59 | 12:01 |
| 12:12 | 12:15 |
| 12:29 | 12:31 |

#### Respective Predicitons from the application V3


| Real  | Real  | Predicition  | Predicition  |        | Error |
| ----- | ----- | ------------ | ------------ | ------ |------ |
| Down  | Up    | 
| 10:29 | 10:31 | 10:24 | 10:30 | | 6 minutes
| 10:42 | 10:44 | 10:43 | 10:45 | | 2 minutes
| 10:49 | 10:51 | 10:51 | 10:52 | | 3 minutes
| 10:59 | 11:05 | 10:55 | 10:59 | | 6 minutes
| 11:12 | 11:15 | 11:10 | 11:17 | | 4 minutes
| 11:29 | 11:31 | 11:27 | 11:31 | | 2 minutes
| 11:42 | 11:45 | 11:42 | 11:45 | | 0 minutes
| 11:45 | 11:47 | 11:46 | 11:49 | | 3 minutes
| 11:59 | 12:01 | 11:55 | 12:00 | | 5 minutes
| 12:12 | 12:15 | 12:15 | 12:17 | | 3 minutes
| 12:29 | 12:31 | 12:32 | 12:35 | | 2 minutes

#### Prediction Error
Average error: 3 minutes, 100% of the time.


#### Respective Predicitons from the application V4


| Real  | Real  | Predicition  | Predicition  |        | Error |
| ----- | ----- | ------------ | ------------ | ------ |------ |
| Down  | Up    | 
| 10:29 | 10:31 | 10:29 | 10:32 | | 1 minute
| 10:42 | 10:44 | 10:42 | 10:44 | | 0 minutes
| 10:49 | 10:51 | 10:49 | 10:51 | | 0 minutes
| 10:59 | 11:05 | 10:58 | 11:05 | | 1 minute
| 11:12 | 11:15 | 11:12 | 11:15 | | 0 minutes
| 11:29 | 11:31 | 11:29 | 11:32 | | 1 minutes
| 11:42 | 11:45 | 11:42 | 11:45 | | 0 minutes
| 11:45 | 11:47 | 11:45 | 11:47 | | 0 minutes
| 11:59 | 12:01 | 11:59 | 12:01 | | 0 minutes
| 12:12 | 12:15 | 12:12 | 12:15 | | 0 minutes
| 12:29 | 12:31 | 12:29 | 12:31 | | 0 minutes

#### Prediction Error
Average error: 27 seconds, 100% of the time.







### Stone - Taken on Monday 14/03/2016

| Down  | Up    |
| ----- | ----- |
| 12:29 | 12:31 |
| 12:42 | 12:44 |
| 12:49 | 12:51 |
| 12:59 | 13:05 |
| 13:12 | 13:15 |
| 13:29 | 13:31 |
| 13:42 | 13:45 |
| 13:45 | 13:47 |
| 14:59 | 15:01 |
| 15:12 | 15:15 |
| 15:29 | 15:31 |

#### Respective Predicitons from the application V3


| Real  | Real  | Predicition  | Predicition  |        | Error |
| ----- | ----- | ------------ | ------------ | ------ |------ |
| Down  | Up    | 
| 12:29 | 12:31 | 12:31 | 12:32 | | 4 minutes
| 12:42 | 12:44 | 12:43 | 12:44 | | 1 minute
| 12:49 | 12:51 | 12:51 | 12:53 | | 5 minutes
| 12:59 | 13:05 | 12:59 | 13:07 | | 2 minutes
| 13:12 | 13:15 | 13:13 | 13:16 | | 2 minutes
| 13:29 | 13:31 | 13:31 | 13:32 | | 3 minutes
| 13:42 | 13:45 | 13:43 | 13:45 | | 1 minute
| 13:45 | 13:47 | 13:46 | 13:47 | | 1 minute
| 14:59 | 15:01 | 14:57 | 15:01 | | 2 minutes
| 15:12 | 15:15 | 15:14 | 15:16 | | 3 minutes
| 15:29 | 15:31 | 15:28 | 15:31 | | 1 minute

#### Prediction Error
Average error: 2.5 minutes, 100% of the time.


#### Respective Predicitons from the application V4


| Real  | Real  | Predicition  | Predicition  |        | Error |
| ----- | ----- | ------------ | ------------ | ------ |------ |
| Down  | Up    | 
| 12:29 | 12:31 | 12:28 | 12:31 | | 1 minute
| 12:42 | 12:44 | 12:42 | 12:44 | | 0 minutes
| 12:49 | 12:51 | 12:49 | 12:51 | | 0 minutes
| 12:59 | 13:05 | 12:59 | 13:05 | | 0 minutes
| 13:12 | 13:15 | 13:12 | 13:16 | | 1 minute
| 13:29 | 13:31 | 13:29 | 13:31 | | 0 minutes
| 13:42 | 13:45 | 13:42 | 13:45 | | 0 minutes
| 13:45 | 13:47 | 13:45 | 13:47 | | 0 minutes
| 14:59 | 15:01 | 14:59 | 15:01 | | 0 minutes
| 15:12 | 15:15 | 15:12 | 15:14 | | 1 minute
| 15:29 | 15:31 | 15:29 | 15:31 | | 0 minutes

#### Prediction Error
Average error: 26 seconds, 100% of the time.