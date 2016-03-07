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