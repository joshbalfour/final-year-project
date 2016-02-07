**V 1.1.1**
# Data Sources

There are four pieces of data needed to make these predictions:

1. The locations of the crossing
2. The locations of the railway station
3. The locations of the railway lines
4. The locations of the trains. 

### Crossing Locations
Firstly we will need a list of all the crossings as well as the meta data to go with them. We have found that network rail contains this data. By going to their crossing homepage there is a link to a XLS file which contains the location and details about all UK level crossings. On top of this they also have a an image of every level crossing which can be accessed by using the unqiue id in the spreadsheet.

### Train Locations
The second key peice of information is the location of trains. This allows us to then work out if the train is going past the level crossing. Although the exact location of the trains can not be gotten their are data feeds from train stations which says when a train has gone past it as well as how long until it gets to the next station.

### Train Lines and Stations
The train line data will be provided by Nation Rail as part of the Governments Open Data Platform. This will need to be normalised, but provides a detailed map of all UK railway lines and the stations.

## Crossing Timings
- [Level Crossings: A guide for managers, designers and operators](http://orr.gov.uk/__data/assets/pdf_file/0016/2158/level_crossings_guidance.pdf)
- [SteveDD1's YouTube channel](https://www.youtube.com/channel/UCdj_ttCg5UZZtz5vgMeAOKQ)
- Manual data collection
