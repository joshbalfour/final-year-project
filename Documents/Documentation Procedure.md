**V 1.1.0**
# Documentation Procedure

The following document is to outline the procedure for updating and introducing new documentation to the project. This is necessary to ensure all documentation is done to a consistent standard and the same high quality we expect from our code. Many parallels have been taken from the workflow we use for making changes to the software to try and keep the process familiar and simple.

### 1. Branch from Master
All documentation should be committed to a branch off of master. The naming of the branch should reflect the intent and subject matter of the document but there is no strict style for this. An example would be `subject\{document name}` e.g `QA\test-plan`. Documentation may also be included in a feature branch where appropriate, e.g an instruction document detailing a new feature/tool being added to the repo.

### 2. Pull request to master
When the author is happy the document is finished, a pull request will be made to merge the document branch with master. When the pull request is open the author's reviewer (same reviewer assigned for code review) will read the document and make comments about any changes that need to be made. Version numbering needs to be taken into account when making comments and adjustments. A full outline of version numbering will be outlined at the end of this document.

### 3. Reviewer validates merge
When all issues have been rectified, and the version numbers are correct, the reviewer will merge the pull request into master. A report will be generated from the closed pull requests giving us an accurtate version history of each document. 

# Document Version Numbering

The following briefly outlines the requirements for version numbering.

* Every document should have a version number at the top, in the format of "V x.x.x"
* WIP documents should have a "0.X" version number, although unfinished documentation should not be merged with master where possible
* An original, completed document should have the version number "V 1.0.0"
* Major changes (perhaps as suggested by a reviewer) to structure, meaning, or wording should increment the first level of the version number "V x.1.x"
* Minor changes to spelling, grammar, and visual layout (i.e those that do not affect meaning or intent) should increment the second level "V x.x.1"
* When a document is re written from scratch, but still exists under the same name for the same purpose, the main document version number increases and all sub versions revert to 0 "V 2.0.0"
