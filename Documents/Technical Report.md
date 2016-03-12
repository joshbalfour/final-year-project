## Title

```
Should be informative and not too long.
```

Enterprise-Ready Cloud-Based Containerised Algorithmic Big-Geospatial-Data Based Level Crossing Predictor.

## Author(s)

```
The members of the project group, listed in alphabetical order.
```
* Josh, Kieran, Ryan

## Abstract

Level crossing closures are a cause of delay, have a negative impact on the environment due to fumes of stopped transport, and prevent vital emergency services from getting to their destination quickly. The problem is particularly noticeable in Canterbury, which has level crossings on main transport routes.
Can level crossing closures be predicted? Rail timetables plus real time train feeds might make journey planning through level crossings more reliable. Redirecting via longer, but quicker routes or delaying journeys would then be possible.
The project was to develop such a level crossing predictor, integrate with suitable mapping software on the web and/or mobile apps. Field testing for accuracy would be a key part of the final stages of the project.
The project was implemented in PHP and Node JS on the back end, using Angular JS on the front end and a MySQL Database, all managed in a Docker container.

## Introduction
```
This should outline the motivation for the project and sketch the general background. It might also signpost significant features of the rest of the report. Ideally, the introduction will both orient the reader and capture his/her interest.
```


## Background

```
No project is undertaken in isolation; rather, it builds upon earlier work and published material. In this section, you should provide a detailed account of this material, linking it in with the bibliography at the end of your report. The purpose is twofold: as a formal acknowledgement of prior work in the field, and as guidance to your reader should he or she be unfamiliar with the field.
```

* unofficial NROD wiki

## Aims

```
A careful statement of what it is that you are setting out to achieve.

(Several technical content sections)

This is where you go into detail about what you have done. You will need to decide the titles for these sections yourself; they will depend on the content of the project. These sections should summarize the technical and scientific achievements of the project.

Depending on the nature of your project, these sections may include: a comparison of different approaches that you considered, accounts of experimental work, mathematical analyses, specifications, top-level architectural diagrams, results obtained, problems encountered, workarounds, user evaluations, performance measures, testing regimes and results, comparisons between different approaches adopted, comparisons with existing work on similar problems.

In particular you should give a mixture of general discussion of your work and particular examples. Too much general discussion and the reader cannot easily get a handle on what you are doing; too many specific examples and the document fails to "tell a story".
```

### Step One - Plan

The project's requirements were first broken down to into 6 key points and numbered, in order of priority:

* R1 - Be able to show current level crossing times

* R2 - Be able to display level crossing times in a nice way

* R3 - Predict level crossing times to a 90% degree of accuracy within 2 minutes

* R4 - Have an open API to allow other developers to add value

* R5 - Be able to predict level crossing times to 95% degree of accuracy within 30 seconds

* R6 - Show more data about the level crossing that could be of potential interest (pictures, names, general information such as: accessibility, train frequency, and more)

We then broke each requirement down to a functional level, and listed out the functions that the the system would have to fullfill in order to accomplish each respective requirement, numbered in the format `Requirement#.Function#` for example R1 was broken down to 5 functional requirements:

* R1.F1 - Download and Store Level Crossing Locations

* R1.F2 - Download and Store Train Times

* R1.F3 - Download and Store Rail Station Locations (links R1.F1 and R1.F2)

* R1.F4 - Download and Store Railway Route Locations (R1.F1, R1.F2, and R1.F3)

* R1.F5 - Write algorithm to show if level crossing is up or down based on the above data

We then started a Spike, within which each function was discussed in depth and broken down to a task level, making notes from our own knowledge and researching where there were gaps, bullet points of what needed to be done in order to accomplish the task. This then allowed us to put man hour time estimates against each task.

For Example R1.F1 was broken down into 3 tasks:

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
	
With these Man Hour estimates in hand we were then able to make estimates by aggregating the estimates and including 10% contingency, as to how long each requirement was going to take to fulfill.

Aside from providing us with time estimates this process was incredibly valuable as it also highlighted the project's risks, which is why some tasks have ranges against them instead of an absolute hour value, and it also gave us time to think through the approach we would take, lowering the number of assumptions we made.

Taking these time estimates we then established how we would share the load of the tasks. During the discussions surrounding the spike we had already established where the group member's strengths were and 


## Conclusions

```
A statement of what your project achieved. For example you might want to consider:

* how well did your end-product work?
* how does it compare with other, similar projects?
* how novel are your ideas?
* what guidance can you offer to others setting out with similar aims?
* what scope is there for further work on the topic?
```

Key pain points:

* Data processing and curation as we overestimated the quality of relavent data available.* Spending more time waiting than coding due to lack computing power.
* Setting our practices for project management from scratch due to not previously being taught project management procedures, systems or tools.
* Horrendous amount of Scope creep


Key success points:

* Automated continuous integration and code quality testing.
* The web app part of it just worked and was quick to develop.
* The prediction aspect of the project was easy.
* Data acquisition was relatively easy once found.

If we were to run this project again we would

* Write it entirely in Javascript.
* Split out our Docker containers as per industry best practices.
* Use Oracle DB for the data processing aspect of the project.



##Acknowledgements

```
Where you thank people who helped you or gave guidance (including your supervisor!).
```

## Bibliography

```
A list of work that you have referred to throughout the document, for example related projects and papers, reference documents, relevant textbooks, et cetera.

Some of the references may be of URLs to free-standing, electronically published reports but the majority are likely to be to textbooks or journal articles. Have a look at an academic paper such as the one below to see the style in which references to published work are presented. There are automated systems such as Endnote and BibTeX which can help you manage references automatically.
```

## Appendices

```
You might include items such as: test data, detailed results, significant portions of programs, statistical analyses, UML diagrams, etc. that, whilst not essential to understanding the main report, provide fine-grained info supporting conclusions reached or explaining methods adopted.

Appendices do not could towards the page limit. But do not use this as an excuse to "bulk up" the project in the mistaken belief that the heavier the project report the higher the mark! Indeed you will be marked down for excessive appendices which contain information which would be better included on the CD-ROM.

You should give careful thought to which items you want to include here, and which are better included on the accompanying CD-ROM. Written documents, detailed diagrams and tables are often better presented on paper. Items which will only be read briefly (like minutes of meetings) and items which contain large amounts of data (e.g. large sets of testing results) are better placed on the CD-ROM.
```