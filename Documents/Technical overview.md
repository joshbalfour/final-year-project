**V 1.0.2**
# Technical Overview
This document providers a more techincal in-depth view of the system and how each component works and interacts with its neighbouring components.


![image](images/System designs/Technical.jpg =700x)


### 1. Browser Interface
The primary access to the site and its data is through a website accessible by a user using any internet enabled device such as a laptop, smart phone or tablet. This works by providing a a web application from the application server which will then request data from the API server. We support the latest versions of the most popular 4 browsers: IE, Chrome, Safari and Firefox.

### 2. API Interface
This project also allows users to access the data via the API directly which is documented [here](API/Endpoints.md). Users are neither rate limited or required to posess an API key, and can rely on the same strong system architecture that copes with any level of demand from our own users. 
API access allows other developers to build on our work and screate more apps with our data, such as a a Navigiation app that factors in crossing locations and times.

### 3. Web App
The web app is the interface which allows human users to interact with the data. It uses several of the latest technologies which efficiently display to the user - in an intuitive manner - data about each level crossing. It is cross browser and cross device compatible so provides maximum accessibility for our users.  
[More technical details can be found here.](Web App/Technical overview.md)

### 4. API Server
The API server serves data from the database to the users and 3rd party services. It is responsible for reading and validating the requests, as well as caching the requests for performance.

### 5. Storage/Processing
The database serves 2 main purposes: Firstly it stores all the data for the level crossings, train tracks, along with the current and historical train times. 
It's second purpose is to perform all the the analysis on the data in order to calculate when each crossing will be up or down. We found that leaving this logic the in database provided a massive performance gain in calculation times of both repeat and new data requests.

### 6. Data Collection
The purpose of the data collection service is to peridically collect data from both National Rail and Network Rail, check that the data is correct and store it into the database.