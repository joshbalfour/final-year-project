# Level Crossing Predictor

## State of the code
This is (currently) ~~COMPLETELY SHIT~~ PoC code

I basically took some old code I had when I reversed the National Rail API

## Description

### Level Crossing Predictor

#### Brief

Level crossing closures are a cause of delay, have a negative impact on the environment due to fumes of stopped transport, and prevent vital emergency services from getting to their destination quickly. The problem is particularly noticeable in Canterbury, which has level crossings on main transport routes.

Can level crossing closures be predicted? Rail timetables plus real time train feeds might make journey planning through level crossings more reliable. Redirecting via longer, but quicker routes or delaying journeys would then be possible.

This project is to develop such a level crossing predictor, integrate with suitable mapping software on the web and/or mobile apps. Field testing for accuracy would be a key part of the final stages of the project.

### Proposal
Web app that integrates with Google Maps

User inputs their start point, destination and time

App routes them accordingly, adding an "Avoid This Road" flag if the user is likely to hit a road closure due to level crossing 

App informs user, if appropriate, if they're likely to hit a closure


### Implementation Ideas



#### Make Field Testing Easier
Make a simple app where you hit a button if the thing is closed

Backend records time, create DB and correllate with train times

#### Make Unit Testing Easier
Use [Mocha.js](http://mochajs.org/) to make our lives easier, and [Instanbul.js](https://github.com/gotwarlost/istanbul) to ensure our tests are comprehensive.


#### Make Design and Documentation Easier
Host our own [MediaWiki](https://www.mediawiki.org/wiki/MediaWiki) Wiki, use that to write documentation

#### Make Development Easier
Use [LoopBack](http://loopback.io/) to do the bulk of the work


### Tutor
[Peter Rodgers](http://www.cs.kent.ac.uk/people/staff/pjr/)


## Usage

### Prerequisites
Install [node.js](https://nodejs.org/) if you haven't already

Check you can run node by going `node --version`


### Clone Repo
`cd ~`

`git clone https://github.com/beakybal4/final-year-project.git`


###  Install Dependancies
`cd ~/final-year-project`

Run `npm install` 

### Run Example
 `node examples`