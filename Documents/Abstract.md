# Level Crossing Predictor  Josh Balfour, Kieran Jones, Ryan Wood
Supervised by: Peter Rodgers
## Project description (150 words)
Level crossing closures are a cause of delay, have a negative impact on the environment due to fumes of stopped transport, and prevent vital emergency services from getting to their destination quickly. The problem is particularly noticeable in Canterbury, which has level crossings on main transport routes.
Can level crossing closures be predicted? Rail timetables plus real time train feeds might make journey planning through level crossings more reliable. Redirecting via longer, but quicker routes or delaying journeys would then be possible.
This project is to develop such a level crossing predictor, integrate with suitable mapping software on the web and/or mobile apps. Field testing for accuracy would be a key part of the final stages of the project.
The project is implemented in PHP and Node JS on the back end, using Angular JS on the front end and a MySQL Database, all managed in a docker container.
## Results (150 words)The project was able to, at the time of writing, produce reliable results 95% of the time, to within 30 seconds of accuracy.
This was achieved by importing a spreadsheet of level crossing locations, the train timetable, a map of the rail line and station locations.
The key challenges faced and overcome by the team who developed the project were:
* Data acquisition is easy, data processing and curation is a difficult process
* We overestimated the quality of relavent data available* Not having much computing power available so spending more time waiting than coding* PHP has no concept of performance
* The lack of premium tools was a big issue, especially for project management
* Setting our practices for project management from scratch as we hadn't been previously taught a project management procedures, system or tool
* PHP is UTF8MB4 compliant, however MySQL is not.

If we were to run this project again we

* would write it in Node JS
* would split out our docker containers as per industry best practices
* would've used Oracle DB for the data processing aspect of the project


Continuous integration and quality testing of the code base was a key player in the success of the project.

The web app part of it just worked, and was quick to develop, using purely open source software and free services.

The prediction aspect of the project was the easiest part, once the data was in a workable format.
