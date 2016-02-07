**V 1.0.2**
# Technical Overview

### Implementation

#### General
The site uses AngularJS to run the webpage, CSS to build the stylesheets, And Grunt which will automatically build the stylesheets and do any optimisation and dependancy resolution on the resources.

#### Map
After loading the page and the resources it connects to the API and periodically fetches the latest data for the crossings and passes this data into the angular scope. Angular uses the HTML markup to update the icons on the screen automatically. This provides a simple, maintainable, and powerful method of working.

##### Crossing Details
When a user clicks on a crossing icon this brings up a popup that will pull more detailed future data including the crossing's closing times as well as metadata about the crossing itself.

##### Testing
/#RyanFillThisInPlease (Something about mocha, karma and CI please)

### Technologies
- AngularJS (Javascript framework)
	- AngularUI
	- ngRoute
- Google Maps (Mapping engine)
- Mocha (Testing framework)
- Karma (Testing framework)