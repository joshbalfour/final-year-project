# Technical Overview

### How it works
The site will use AngularJS to run the webpage. After loading the page and it resources it will connect to the API and periodically down the the data for the crossing passing this data into the angular scope. Angular will use the HTML markup to update the icons on the screen automatically. 

When a user clicks on a crossing icon this will bring up a popup that will pull more complex future data about when crossing will be closed as well as meta data about the crossing its self.

### Technologies
- AngularJS (Javascript framework)
	- AngularUI
	- ngRoute
- Google Maps (Mapping engine)
- SCSS (Stylesheet language)
- Grunt (Task management)
- Mocha (Testing framework)
- Karma (Test runner)