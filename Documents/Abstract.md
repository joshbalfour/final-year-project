# Level Crossing Predictor  Josh Balfour, Kieran Jones, Ryan Wood
Supervised by: Peter Rodgers
## Project description (150 words)
Level crossing closures are a cause of delay, have a negative impact on the environment due to fumes of stopped transport, and prevent vital emergency services from getting to their destination quickly. The problem is particularly noticeable in Canterbury, which has level crossings on main transport routes.
Can level crossing closures be predicted? Rail timetables plus real time train feeds might make journey planning through level crossings more reliable. Redirecting via longer, but quicker routes or delaying journeys would then be possible.
This project is to develop such a level crossing predictor, integrate with suitable mapping software on the web and/or mobile apps. Field testing for accuracy would be a key part of the final stages of the project.
The project is implemented in PHP and Node JS on the back end, using Angular JS on the front end and a MySQL Database, all managed in a docker container.
## Results (150 words)The project is able to produce reliable results 95% of the time, to within 30 seconds of accuracy.Key challenges:
* Data processing and curation as we overestimated the quality of relavent data available.* Spending more time waiting than coding due to lack computing power.
* Setting our practices for project management from scratch due to not previously being taught project management procedures, systems or tools.

Key success points:

* Automated continuous integration and code quality testing.
* The web app part of it just worked and was quick to develop.
* The prediction aspect of the project was easy.
* Data acquisition was relatively easy.

If we were to run this project again we would

* Write it entirely in Javascript.
* Split out our Docker containers as per industry best practices.
* Use Oracle DB for the data processing aspect of the project.
