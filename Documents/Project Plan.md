**V 1.0.1**
# Project Plan

## Document Overview

The purpose of this document is to outline the project plan for the Level Crossing Predictor. It first defines the requirements of the product, then breaks the requirements down into functional requirements, then follows them through down to task-level items, with man hour time estimates, in the impact analysis.


## Contents

* Brief Project overview

* Requirements Definition

* Functional Specification

* Impact Analysis

## Brief Project Overview

The aim of the project is to provide a prediction to the user as to whether a Level Crossing is currently down or up.

## Requirements Definition

Each requirement that is defined falls into one of three categories: "Must", "Should", or "Could".

A **Must** requirement is defined as being essential to the project's success, the absolute bare minimum required to take the product to market – our MVP (Minimum Viable Product).

A **Should** requirement is a requirement that extends the product's functionality is a major way, allowing us to potentially enter new markets and strengthen our value proposition.

A **Could** requirement is essentially a nice to have, and is possible to extend our established position in the market.

Requirements are numbered to be referenced throughout the rest of the project process.

### Must

* R1 - Be able to show current level crossing times

### Should
* R2 - Be able to display level crossing times in a nice way

* R3 - Predict level crossing times to a 90% degree of accuracy within 2 minutes

### Could
* R4 - Have an open API to allow other developers to add value

* R5 - Be able to predict level crossing times to 95% degree of accuracy within 30 seconds

* R6 - Show more data about the level crossing (pictures, names, general information such as: accessibility, train frequency, and more)


# Functional Specification

Each function is based off of the numbered requirement and is also numbered in the format Requirement# (dot) Function#

### R1 - Be able to show current level crossing times
* R1.F1 - Download and Store Level Crossing Locations

* R1.F2 - Download and Store Train Times

* R1.F3 - Download and Store Rail Station Locations (links R1.F1 and R1.F2)

* R1.F4 - Download and Store Railway Route Locations (R1.F1, R1.F2, and R1.F3)

* R1.F5 - Write algorithm to show if level crossing is up or down based on the above data

### R2 - Be able to display level crossing times in a nice way

* R2.F1 - Easy to use interfac

* R2.F2 - Way to access level crossing time data

### R3 - Predict level crossing times to a 90% degree of accuracy within 2 minutes
* R3.F1 - Write Algorithm to predict crossing times within 2 minutes

### R4 - Have an open API to allow other developers to add value
* R4.F1 - Create API

* R4.F2 - Document API

### R5 - Be able to predict level crossing times to to 95% degree of accuracy within 30 seconds
* R5.F1 - Refine algorithm from R3.F1

### R6 - Show more data about the level crossing
* R6.F1 - Download and Store Extended Level Crossing Information

	* Picture

	* Name

	* Accessibility (public or private)

	* Train Frequency

	* Possibly More

* R6.F2 – Make Extended Level Crossing Information accessible via the API

* R6.F3 - Make Extended Level Crossing Information accessible from the user interface



# Spike

The Spike is a breakdown of the functional specification into task-level items to aid in the process of high level design and effort estimation.

Each task is numbered in line with the source function specified above, and the requirement that function stems from in the following format:

Requirement # (dot) Function # (dot) Task #

Each has a man hour time estimate against it in the format # MH, this is then summed into the function.

### R1.F1 - Download and Store Level Crossing Locations - 9 MH
* R1.F1.T1 Set up a Database - 4 MH

	* DockerFile from mysql  

* R1.F1.T2 Find and download the data - 4 MH

	* Needs to be able to be done regularly, so must write script

		* Scrape [http://www.networkrail.co.uk/transparency/level-crossings/](http://www.networkrail.co.uk/transparency/level-crossings/)

		* Find download link

		* Download contents

		* Parse XLS file

		* Grab second sheet

		* Import each row into database table

* R1.F1.T3 Write view to sanitise/convert/extract the data we need - 1 MH

	* ID

	* location

### R1.F2 - Download and Store Train Times - 20 MH
* R1.F2.T1 Find and download the data - 14 MH

	* National Rail - Darwin Data Feed

		* Username: joshbalfour

		* Email Address: jdb45@kent.ac.uk

		* API Token: c0812a6f-d0c4-45e4-98bf-a8830cd4fc41

		* Docs: [http://www.nationalrail.co.uk/100296.aspx](http://www.nationalrail.co.uk/100296.aspx)

	* National Rail FTP

		* URL: datafeeds.nationalrail.co.uk

		* FTP Username: ftpuser

		* FTP Password: A!t4398htw4ho4jy

		* docs: [http://wiki.openraildata.com/index.php/Darwin:Push\_Port](http://wiki.openraildata.com/index.php/Darwin:Push_Port)

	* National Rail STOMP Feed

		* Queue Name: D3e7f2670e-45c0-4f17-a022-fe33f54e707f

		* STOMP Username: d3user

		* STOMP Password: d3password

		* docs: [http://wiki.openraildata.com/index.php/Connecting\_with\_Stomp](http://wiki.openraildata.com/index.php/Connecting_with_Stomp)

	* Network Rail

		* url: [https://datafeeds.networkrail.co.uk/ntrod/](https://datafeeds.networkrail.co.uk/ntrod/)

		* username: beakybal4@gmail.com

		* password: /Levelcrossing1

		* Security Token: 1eb9983c-a295-4b57-aa93-e34288b88fd6

* R1.F2.T2 Write view to sanitise/convert/extract the data we need - 6 MH

	* Previous Station

	* Next Station

	* Actual Departure Time at Previous Station

	* Estimated Arrival Time at Next Station


### R1.F3 - Download and Store Rail Station Locations (links R1.F1 and R1.F2) - 5 MH
* R1.F3.T1 Find and download the data - 4 MH

	* Docs: [https://data.gov.uk/dataset/naptan](https://data.gov.uk/dataset/naptan)

	* Download [http://www.dft.gov.uk/NaPTAN/snapshot/NaPTANcsv.zip](http://www.dft.gov.uk/NaPTAN/snapshot/NaPTANcsv.zip)

	* Extract ZIP file

	* Parse RailReferences.csv File

	* Import each row into database table



* R1.F3.T2 Write view to sanitise/convert/extract the data we need - 1 MH

	* TIPLOC

	* Latitude

	* Longitude



### R1.F4 - Download and Store Railway Route Locations (R1.F1, R1.F2, and R1.F3) - 10 MH or 32 MH
* R1.F4.T1 Find and download the data
	* Current option: 3
	
	* Option 1: Use the data from [http://railmaponline.com/UKIEMap.php](http://railmaponline.com/UKIEMap.php) with the permission of the owner [[https://twitter.com/battercake](https://twitter.com/battercake)] (preference) - 5 MH

		* Data Downloaded: [https://drive.google.com/a/joshbalfour.co.uk/folderview?id=0Bz0TVyu9wmaic2IzdWNhX0JoUjg&usp=sharing](https://drive.google.com/a/joshbalfour.co.uk/folderview?id=0Bz0TVyu9wmaic2IzdWNhX0JoUjg&usp=sharing)

		* Data Owner emailed requesting permission on 7th October 2015: [https://drive.google.com/open?id=0Bz0TVyu9wmaiMkpCMjB2WXpDemM](https://drive.google.com/open?id=0Bz0TVyu9wmaiMkpCMjB2WXpDemM)

		* Extract the data into a database

		* Project Risk: We may not get permission to use this data, therefore we might have to use option 2 which we estimate to take longer

		* Project Risk: the process may not work
		
		* Request denied: [https://drive.google.com/open?id=0Bz0TVyu9wmaiMHoteVhSSmlhYWs](https://drive.google.com/open?id=0Bz0TVyu9wmaiMHoteVhSSmlhYWs) 

	* Option 2: Download the OpenStreetMap application along with the OpenStreetMap Railway data from [http://wiki.openstreetmap.org/wiki/OpenRailwayMap](http://wiki.openstreetmap.org/wiki/OpenRailwayMap), convert it to database format and extract the data from there - 16 MH

		* Install [https://github.com/rurseekatze/OpenRailwayMap](https://github.com/rurseekatze/OpenRailwayMap) (downloads a 30GB File, imports it into a postgres DB)

		* Project Risk: We may not have the resources required to achieve this
	* Option 3: Use Nation Rail Data
		* Download data from https://data.gov.uk/dataset/railway-network-inspire
		* Project risk: None.

* R1.F4.T2 Write view to sanitise/convert/extract the data we need - Option 1: 5 MH, Option 2: 16 MH

	* Rail track routes with Latitude + Longitudes

### R1.F5 - Write algorithm to show if level crossing is up or down based on the above data - 50 MH
* R1.F5.T1 Link the location of the level crossing to the railway - 1 MH

* R1.F5.T2 Get train journeys currently in progress on that line - 1 MH

* R1.F5.T3 Judge whether the train(s) are close enough to warrant the rail crossing barrier being closed - 48 MH

### R2.F1 - Easy to use interface - 9 MH
* R2.F1.T1 Design preliminary UI - 3 MH

	* Map + controls

	* Indicator for crossing status

	* About/Help page

* R2.F1.T2 Focus group to evaluate UI - 6 MH

	* Test interface with multiple users

	* Test interface with multiple devices

	* Evaluate results and refine UI

* R2.F1.T3 Write about page with usage instructions - 2MH
	
	* Write about page
	
	* Write usage instructions

### R2.F2 - Way to access level crossing time data - 8.5 MH
* R2.F2.T1 Fetch data from API server - 1 MH

	* Fetch data periodically to keep view up to date

* R2.F2.T2 Pass data into designed interface  - 0.5 MH

	* Pass data into angular's two way data binder

	* Two way data binder automagically updates the web page view

* R2.F2.T3 Build designed interface 3 MH

* R2.F2.T4 On click a crossing display future dates - 4 MH

	* When clicking the icon of a level crossing open a popup

	* Pull future predicted down times for the crossing

	* Display them on the page using two way data binding

### R3.F1 - Write Algorithm to predict crossing times to a 90% degree of accuracy within 2 minutes - 60 MH
* R3.F1.T1 Download historic time train data - 8 MH

	* Use Darwin Data Feed from R1.F2.T1

* R3.F1.T2 Write view to sanitise/convert/extract the data we need - 4 MH
* R3.F1.T3 Write algorithm to analyze future times and work out when the rail crossing barrier will be closed to within 2 minutes - 48 MH

### R4.F1 - Create API - 4 MH
* R4.F1.T1 Set up connection to database - 1 MH
* R4.F1.T2 Query the database and extract the required information - 2 MH

	* Level Crossing Locations

	* Level Crossing Statuses

* R4.F1.T3 Convert the data into an accessible format - 1 MH

	* JSON Objects

### R4.F2 - Document API - 6 MH
* R4.F2.T1 Agree documentation format - 2 MH
* R4.F2.T2 Copy existing internal-use API documentation to agreed format - 4 MH

### R5.F1 - Refine algorithm from F7 - 48 MH
* R5.F1.T1 Scope out steps needed for improvement

	* Project risk as currently unknown

* R5.F1.T2 Execute steps

### R6.F1 - Download and Store Extended Level Crossing Information (picture, name, accessibility, train frequency, possibly more) - 5 MH
* R6.F1.T1 Find data sources and Download data

	* Repeat R1.F1.T2

	* For images: [http://www.networkrail.co.uk/Custom/Images/LevelCrossings/$id/$id.jpg](http://www.networkrail.co.uk/Custom/Images/LevelCrossings/%3Cid%3E/%3Cid%3E.jpg) where $id is the unique identifier of the level crossing from the above step

* R6.F1.T2 Write database view to sanitise/convert/extract the data we need - 1 MH

	* Name

	* Accessibility

	* Train frequency

* R6.F1.T3 Write a script which downloads all the images from networkrail - 4 MH

	* Pull list of IDs

	* Convert into URL

	* Download contents of URL

### R6.F2 - Make Extended Level Crossing Information accessible via the API - 4 MH
* R6.F2.T1 Make extra metadata accessible via API - 1 MH

	* Add extra fields to requests

	* or add a separate detail endpoint

* R6.F2.T2 Make picture accessible via API - 3 MH

	* Send extra URL as a field in the above alteration

	* Or send image as base64 encoded along with the above alteration

### R6.F3 - Make Extended Level Crossing information accessible from the user interface - 3 MH
* R6.F3.T1 Add popup panel for when user clicks a crossing - 2 MH

	* Image

	* Name

	* Accessibility

	* Train frequency

	* Other

* R6.F3.T2 Fetch extra crossing data from server - 1 MH

	* Pull data from database
