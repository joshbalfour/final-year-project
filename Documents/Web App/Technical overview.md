**V 1.0.1**
# Technical Overview

### Implementation
#### General
The site will use AngularJS to run the webpage. SCSS to build the style sheets. And grunt which will automatically build the style sheets and do any maniplucation on the resources.

#### Map
After loading the page and it resources it will connect to the API and periodically pull down down the latest data for the crossings and pass this data into the angular scope. Angular will use the HTML markup to update the icons on the screen automatically. This will provide a simple, maintinable but powerfull method of working.

##### Crossing Details
When a user clicks on a crossing icon this will bring up a popup that will pull more complex future data about when crossing will be closed as well as meta data about the crossing its self.

##### About
The the bottom left hand corner of the screen there will be a **?** icon. When a user clicks with it will open a modal that will have details about the projet and the data that went into it.

##### Testing
\#RyanFillThisInPlease (Something about mocha, karma and CI please)

### Technologies
- AngularJS (Javascript framework)
	- AngularUI
	- ngRoute
- Google Maps (Mapping engine)
- CSS (Stylesheet language)
- Mocha (Testing framework)
- Karma (Test runner)