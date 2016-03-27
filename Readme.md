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

| Category 			| Document  | Contributors  | QA Approval Date  | 
|------------------|-----------|-----------|--------------------|-------------------|
| Misc 				| [Abstract](Documents/Abstract.md)  |   |   |
| Misc				| [Project Plan](Documents/Project Plan.md)  |   |   |
| System  			| [Top level overview](Documents/Top level overview.md) |   |   |
| System  			| [Technical overview](Documents/Technical overview.md) |   |   |
| Development 		| [Environment](Documents/environment.md)
| Development 		| [Workflow](Documents/Development workflow.md)
| Data Collection 	| [Data Sources](Documents/Data Collection/Data Sources.md)
| Data Collection 	| [Technical overview](Documents/Data Collection/Technical overview.md)
| Data Collection 	| [Data Quality Verification](Documents/Verification/Sample-Data.md)
| Database 			| [Software](Documents/Database/Database software.md)
| Database 			| [Management](Documents/Database/Database management.md)
| Database 			| [Algorithm](Documents/Database/Algorithm.md)
| Deployment 		| [Docker](Documents/Deployment/Docker.md)
| API 				| [Technical overview](Documents/API/Technical overview.md)
| API 				| [Endpoints](Documents/API/Endpoints.md)
| Web App 			| [Discovery](Documents/Web App/Discovery.md)
| Web App 			| [UI Designs](Documents/Web App/UI Designs.md)
| Web App 			| [Technical overview](Documents/Web App/Technical overview.md)
| Testing 			| [Test Plan](Documents/Test Plan.md)

## Main Code File Index

All code files are in the /Application folder.

| Category 		| Purpose | File  | Contributors  | QA Approval Date  | 
|--------------	|-------- | -----------|-----------|--------------------|-------------------|
| Data Importer	| Imports the Level Crossing Location Data from Network Rail | [/app/Console/Commands/ImportCrossings.php](Application/app/Console/Commands/ImportCrossings.php)  |   
| Data Importer	| Imports the daily train schedule from National Rail | [/app/Console/Commands/ImportDailyTrainData.php](Application/app/Console/Commands/ImportDailyTrainData.php) | 
| Data Importer | Imports the extended Level Crossing data from Network Rail | [/app/Console/Commands/ImportExtendedCrossingData.php](Application/app/Console/Commands/ImportExtendedCrossingData.php) |
| Data Importer | Imports the train stations and railway lines from INSPIRE | [/app/Console/Commands/ImportRailMapData.php](Application/app/Console/Commands/ImportRailMapData.php) |
| Data Importer | Imports real time schedule updates from National Rail | [/app/Console/Commands/ImportRTTrains.php](Application/app/Console/Commands/ImportRTTrains.php) | 
| Data Importer | Imports the TIPLOC to CRS mapping table | [/app/Console/Commands/ImportTIPLOCcrsMappings.php](Application/app/Console/Commands/ImportTIPLOCcrsMappings.php) | 
| Data Importer | Passes through to Node.JS to calculate train routes from the railway lines | [/app/Console/Commands/ImportTrainRoutes.php](Application/app/Console/Commands/ImportTrainRoutes.php) |
| Data Importer | Passes through to Node.JS to calculate which level crossings are on what train routes | [/app/Console/Commands/ImportTrainRoutesToCrossingMap.php](Application/app/Console/Commands/ImportTrainRoutesToCrossingMap.php) |
