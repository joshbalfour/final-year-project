**V 1.0.0**
# Data Sources

There are three pieces of data we have worked out we will need to make these predictions. The locations of the crossing, the train lines, and the locations of the trains. 

### Crossing Locations
Firstly we will need a list of all the crossings as well as the meta data to go with them. We have found that network rail contains this data. By going to their crossing homepage there is a link to a XLS file which contains the location and details about all UK level crossings. On top of this they also have a an image of every level crossing which can be accessed by using the unqiue id in the spreadsheet.

### Train Locations
The second key peice of information is the location of trains. This allows us to then work out if the train is going past the level crossing. Although the exact location of the trains can not be gotten their are data feeds from train stations which says when a train has gone past it as well as how long until it gets to the next station.

### Train Lines
The final peice of information we need that we didnt release until we started to think abotu the model was the actaul train lines them selves. Because track can often run close to each other their may be a crossing which effects one peice of track but not another. So knowing which lines there are, and where they are is key. There are two optional sources for this. Firstly the trainmaponline.com has a comprensive data set, secondly if that is not available then when can use the data from Open Street Maps although this contains alot more raw data then required.  

## Crossing Information
[Level Crossings: A guide for managers, designers and operators](http://orr.gov.uk/__data/assets/pdf_file/0016/2158/level_crossings_guidance.pdf)
