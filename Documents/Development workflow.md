**V 1.0.2**
# Development Workflow

This document defines the workflow for development. It uses **Feature Branches**, incorporates **Continuous Integration** and **Auto-Deployment** to provide an easy, safe, and seamless enviroment.

### 1. Branch from Master
All new features are created in a new branch created from master following the format of `feature/{feature name}`. All coding and testing will done in here.

### 2. Pull request to master
Once the feature is ready to go into the main branch. A pull request will be made from the feature branch into the main branch. It will then be reviewed and tested before merging. 
 
**All pull requests must be auto-mergable.**

### 3. Travis validates merge
When a pull request is made, this will automatically trigger a request to travis which will run the automated tests against the auto-merged code.


### 4. Merge into master
Once a merge has passed all tests and code has been reviewed by a second member of the team, then the branch will be merged into master.

### 5. Auto deployment
Finally when the merge is committed to the master branch the development server will automatically pull the lasted version of the code for demonstration.
