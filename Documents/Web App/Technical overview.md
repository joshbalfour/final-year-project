**V 1.0.2**
# Technical Overview

## Implementation

### General
The site uses AngularJS to run the webpage, CSS to build the stylesheets, And Grunt which will automatically build the stylesheets and do any optimisation and dependancy resolution on the resources.

### Map
After loading the page and the resources it connects to the API and periodically fetches the latest data for the crossings and passes this data into the angular scope. Angular uses the HTML markup to update the icons on the screen automatically. This provides a simple, maintainable, and powerful method of working.

#### Crossing Details
When a user clicks on a crossing icon this brings up a popup that will pull more detailed future data including the crossing's closing times as well as metadata about the crossing itself.

#### Testing

This project uses a suite of testing frameworks in order to accomplish different tasks:

##### Mocha
Mocha is a testing framework which provides the standard components required in testing such as:

* (De)constructors
* Asserts
* Visual Reporter
* A programmatic way to define a hierarchy of tests

##### Karma
Karma allows you to run tests inside of a web browser using the Web Driver Protocol. We have it set up to use PhamtomJS, however it could be setup to use Selenium which would allow us to run tests on Chrome and IE. 

##### ngMock

ngMock is built into angular and provides a programmatic way to hijack system services and replace them with fixtures which allows us to test our code in an isolated environment, removing the need to rely on external services.

##### Travis

Travis watches the repository and runs all of the above tests in our testing environment (described in [/Deployment/Docker.md](Deployment/Docker.md)) after each commit and marks the commit as either Passed or Failed.


### Technologies
- AngularJS (Javascript framework)
	- AngularUI
	- ngRoute
- Google Maps (Mapping engine)
- Mocha (Testing framework)
- Karma (Testing framework)
- Travis (Continuous Integration tool)