**Test Plan V1**

1. **Introduction**

The following document outlines the course of action to be taken for testing the minimum viable product (MVP) iteration of the Level Crossing Prediction application. We are defining MVP in this "zeroth" iteration as the ability to determine in real time, or as accurate as possible, the status (up or down) of a level crossing. And also to determine the predicted future times for that level crossing to be down. This data will be accessed through a REST API, and a user friendly UI will be built on top of this.

2. **Test Strategy**

**Overview**

The overall strategy will be to make sure each component is individually well unit tested, with automated integration testing to be done regularly to avoid build ups of integration conflicts. Manual testing should also be carried out during each iteration to help provide feedback for the next iteration, rather than allow bugs and usability issues to remain in the software all through it’s development.

**2.1 Unit Testing**

**Definition**

The strict use of unit testing  across all areas of the software will be the core in ensuring a high quality deliverable. As well as developers running the tests during development build tools will be used wherever possible to ensure all unit tests are run, and that they pass, when code is ready to be deployed. Static analysis tools will be used to maintain a 100% unit test coverage for as far as is conceivable among back end, DB access, and API code. Front end and UI code due to its visual nature will not be required to maintain the 100% coverage but any and all unit testing that can be done, should be. Business and application logic should be kept separate from UI code to increase its unit testability.

**Participants**

Each developer will be responsible for making sure their code is well unit tested, and to help make sure these strict standard are kept to a code review rota will be put in place, whereby each member of the team will review the code of another member of the team in rotation. The code review will be used to catch mistakes and to ensure testing and code quality, but will also provide a means for each of us to understand the workings of  other parts of the system we are not directly working on. 

**Methodology**

In order to keep unit test coverage high, and to keep code clean, the red/green refactor method of test driven development should be used during development. Specifically tests should be written in order from most degenerate to most specific to help cover for outlying data and to prevent most bugs caused by unexpected input. The individual tests, where possible, should be names in the "Given, When, Then" format so that they can closely resemble the use cases of the class/entity they are testing. This will in turn provide the basis for technical documentation as the tests should in theory detail exactly what the unit is doing in a human readable format.

	**2.2 Manual and Automated User Acceptance Testing**

**Definition**

Planned deliverables should all come with pre written user acceptance criteria, these will likely take the form of the "Given, When, Then" statements that will be seen in the unit tests. This way we can at first, for the sake of simplicity, manually test code awaiting deployment against the user acceptance criteria so that we can confirm the software does what was required of it. Failures to meet the acceptance criteria will result in delays, so steps should be taken to manually test code during development, and during the code review process, as well as for a final time at the point of pre deployment. Issues, usability problems, and bugs (depending on severity) that affect the software at this stage will, for the sake of agility, not block deployment but will be added to our issue tracker. The testing at this point is not used to ensure the software is “perfect” but to make sure that it fulfils its pre defined function, and to allow us to discover any defects early so that they can be fixed quickly and effectively. The use of the “Given, When, Then” phrasing allows us the potential to convert the user acceptance criteria into Cucumber/Gherkin Acceptance Criteria language that we can then use to automate manual testing as part of the integration test suit.

**Participants**

The team will define the User acceptance criteria together, or at least seek appraisal from another or all of the developers, for any criteria written to ensure all team members agree on the direction and wording of the software’s functionality. Each developer will be responsible for manually testing their own work against the acceptance criteria, followed by at least some attempt to manually test the functionality at the code review level by the developer’s reviewer. As QA I will periodically conduct manual testing pre deployment and assign requirements for automated testing where I feel it is necessary.

**Methodology**

The general methodology of user acceptance testing will be one of repeated testing throughout the various stages of development and deployment. Integration and deployment tools can be used to run automated UA testing and manual testing should be conducted by the team throughout the development and into the release stages. The purpose of the continual testing is to ensure the functionality matches the planned acceptance criteria, to ensure our work remains focused to limit distractions and scope change. The main issue with such extensive testing at times is the way that it slows down the development by piling on more work as tests find new issues and changes that need to be made before it can be considered "done". To circumvent this the only time manual testing should ever bounce a feature back to development is when the software critically fails to achieve its goals. More trivial improvements or fixes, visual or functional, that do not stop the software completing any acceptance criteria should be treated like any other and added to the issue tracker and dealt with separately to the feature release to prevent a delay. Essentially the concept is that finding a non critical bug during QA testing does not mean the release should be halted until the software is made perfect, as this will essentially never happen and result in huge big bang releases filled with new features and improvements that will be difficult to fully test in one go.  

	**2.3 Integration Testing**

**Overview**

Project assembly and Integration testing will be set up as part of the first iteration and will be used in conjunction with build tools to ensure that all code deployed is run through the integration testing suit. Details of the technologies used and a more complete integration testing plan will be drawn up when the code is in a state that integration testing can feasibly be applied.

	**2.4 Performance/Stress Testing**

**Overview**

As the focus for the foreseeable future will primarily be on making the software work, performance, stress, and load testing will be delayed until speed and high request numbers become and issue. We will be following Kent Beck’s idea on software development of: "Make it Work, Make It Right, Make it Fast", essentially deferring the decision to optimise our code for speed and high usage until speed and high useage become issues affecting how the software works. 

