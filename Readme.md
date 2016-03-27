**V 1.2**

CO600 Project Corpus Index
==

---


![image](Assets/logo-bg.png =700x)

[![Build Status](http://f.cl.ly/items/1C0b2q3L2q0X1m3a0Z3W/Image%202016-01-21%20at%2011.03.50%20pm.png)](https://travis-ci.com/joshbalfour/final-year-project)

## Project Details
|				|			 |
|---------------|-----------|
| Project title	| Level Crossing Predictor |
| Students		| Josh Balfour (jdb45), Kieran Jones (kj90), Ryan Wood (rsw24)
| Supervisor	| Peter Rodgers (P.J.Rodgers@kent.ac.uk)
| Date			| 27th March 2016 |

## Documentation Index

All documents are in the /Documents folder.

| Category 			| Document  | Contributors  |
|------------------|-----------|-----------|--------------------|
| Misc 				| [Abstract](Documents/Abstract.md)  |  Josh |   
| Misc				| [Project Plan](Documents/Project Plan.md)  | Josh  |   
| Misc				| [Meeting Minutes](Documents/meeting_minutes.md)  | Kieran  |   
| System  			| [Top level overview](Documents/Top level overview.md) | Kieran, Josh  |   
| System  			| [Technical overview](Documents/Technical overview.md) | Kieran, Josh  |   
| Development 		| [Environment](Documents/environment.md) | Kieran, Josh
| Development 		| [Workflow](Documents/Development workflow.md) | Josh, Kieran
| Data Collection 	| [Data Sources](Documents/Data Collection/Data Sources.md) | Josh, Kieran
| Data Collection 	| [Technical overview](Documents/Data Collection/Technical overview.md) | Kieran, Josh
| Data Collection 	| [Data Quality Verification](Documents/Verification/Sample-Data.md) | Josh, Kieran
| Database 			| [Software](Documents/Database/Database software.md) | Kieran, Josh
| Database 			| [Management](Documents/Database/Database management.md) | Kieran
| Database 			| [Algorithm](Documents/Database/Algorithm.md) | Kieran, Josh
| Deployment 		| [Docker](Documents/Deployment/Docker.md) | Josh, Kieran
| API 				| [Technical overview](Documents/API/Technical overview.md) | Kieran
| API 				| [Endpoints](Documents/API/Endpoints.md) | Kieran, Josh
| Web App 			| [Discovery](Documents/Web App/Discovery.md) | Kieran, Josh
| Web App 			| [UI Designs](Documents/Web App/UI Designs.md) | Kieran, Josh
| Web App 			| [Technical overview](Documents/Web App/Technical overview.md) | Kieran, Josh
| Testing 			| [Test Plan](Documents/Test Plan.md) | Ryan

## Main Code File Index

All code files are in the /Application folder. 
The table below describes the main code files, there are many more supporting files, but these are the most important ones.

| Name | Category 		| Purpose | Path  		| Main Contributor(s) (in order of amount)  | QA Approval Date  | 
|------|--------------	|-------- | -----------|---------------|-------------------|
| ImportCrossings.php | Data Importer	| Imports the Level Crossing Location Data from Network Rail | [/app/Console/Commands/ImportCrossings.php](Application/app/Console/Commands/ImportCrossings.php)  | Josh, Kieran  | 27th January 2016
|ImportDailyTrainData.php| Data Importer	| Imports the daily train schedule from National Rail | [/app/Console/Commands/ImportDailyTrainData.php](Application/app/Console/Commands/ImportDailyTrainData.php) | Josh, Kieran | 13th March 2016
|ImportExtendedCrossingData.php| Data Importer | Imports the extended Level Crossing data from Network Rail | [/app/Console/Commands/ImportExtendedCrossingData.php](Application/app/Console/Commands/ImportExtendedCrossingData.php) | Kieran, Josh | 27th January 2016
|ImportRailMapData.php| Data Importer | Imports the train stations and railway lines from INSPIRE | [/app/Console/Commands/ImportRailMapData.php](Application/app/Console/Commands/ImportRailMapData.php) | Josh | 24th November 2015
|ImportRTTrains.php| Data Importer | Imports real time schedule updates from National Rail | [/app/Console/Commands/ImportRTTrains.php](Application/app/Console/Commands/ImportRTTrains.php) | Josh | 13th March 2016
|ImportTIPLOCcrsMappings.php| Data Importer | Imports the TIPLOC to CRS mapping table | [/app/Console/Commands/ImportTIPLOCcrsMappings.php](Application/app/Console/Commands/ImportTIPLOCcrsMappings.php) | Kieran, Josh | 18th January 2016
|ImportTrainRoutes.php| Data Importer | Passes through to Node.JS to calculate train routes from the railway lines | [/app/Console/Commands/ImportTrainRoutes.php](Application/app/Console/Commands/ImportTrainRoutes.php) | Kieran | 28th January 2016
|ImportTrainRoutesToCrossingMap.php| Data Importer | Passes through to Node.JS to calculate which level crossings are on what train routes | [/app/Console/Commands/ImportTrainRoutesToCrossingMap.php](Application/app/Console/Commands/ImportTrainRoutesToCrossingMap.php) | Kieran | 28th January 2016
|train-routes.js| Data Importer | Calculates train routes from the railway lines | [/database/train-route-process/train-routes.js](Application/database/train-route-process/train-routes.js) | Kieran | 28th January 2016
|bind-to-crossings.js| Data Importer | Calculates which level crossings are on what train routes | [/database/train-route-process/bind-to-crossings.js](Application/database/train-route-process/bind-to-crossings.js) | Kieran  | 28th January 2016
|CrossingsController.php| API Controller | Responds to HTTP requests with a JSON response containing level crossing data, with calculated timing estimates | [/app/Http/Controllers/CrossingsController.php](Application/app/Http/Controllers/CrossingsController.php) | Kieran, Josh | 11th March 2016
|DebugController.php| API Controller | Responds to HTTP requests with a JSON response containing calculated real time train positions | [/app/Http/Controllers/DebugController.php](Application/app/Http/Controllers/DebugController.php) | Kieran, Josh | 11th March 2016
|TrainDataMysqlStorage.php| Storage Controller | Handles train data related interaction with the Database | [/app/Storage/TrainDataMysqlStorage.php](Application/app/Storage/TrainDataMysqlStorage.php) | Josh | 13th March 2016
|DailyTrainDataFtpGateway.php| Gateway Controller | Handles interaction with the daily train schedule FTP data source | [/app/Gateways/DailyTrainDataFtpGateway.php](Application/app/Gateways/DailyTrainDataFtpGateway.php) | Kieran | 15th March 2016
|RTTrainDataFtpGateway.php| Gateway Controller | Handles interaction with the real time train schedule corrections FTP data source | [/app/Gateways/RTTrainDataFtpGateway.php](Application/app/Gateways/RTTrainDataFtpGateway.php) | Josh | 15th March 2016
| Database Schema Migration PHP files | Database Schema Definitions | RDBMS engine agnostic satabase Schema definitions  | [/app/database/migrations](/app/database/migrations) | Josh, Kieran | 13th March 2016
| index.html | Web App Entrypoint |  Web app index HTML file | [/public/index.html](/public/index.html) | Kieran | 11th March 2016
| controller.js | Web App Controller |  Controller logic for the web app | [/public/app/modules/map/controller.js](/public/app/modules/map/controller.js) | Kieran | 25th February 2016
| debug.controller.js | Web App Controller |  Controller logic behind the debug button in the web app | [/public/app/modules/debug.controller.js](/app/public/app/modules/debug.controller.js) | Kieran | 17th March 2016
| Dockerfile | Runtime Environment Definition | Defines a Docker image containing Apache, PHP, HHVM, MySQL for the product to be ran in | [/app/deployment/Dockerfile](/deployment/Dockerfile) | Josh | 23rd March 2016
| boot.sh | Container Boot Bash Script | A Bash script ran when the Docker container starts | [/app/deployment/boot.sh](/deployment/boot.sh) | Josh | 23rd March 2016