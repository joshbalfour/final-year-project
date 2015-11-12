**V 1.1.0**
# Database Software
This document outlines what database software we looked into using and what we finally went with.

## MySQL
MySQL will be the primary database that will hold all of our data and do the anaylsis of the train times. Although many feel that postgres is a better tool for the job, MySQL has a rich set of features, a geosptail library, and very powerful query engine. The key choice for going for MySQL is that the development team has better knowlegde of this then Postgres. Although on the broad view they are both RDBMS', the teams knowlegde of MySQL will allow them to tackle and fix any bugs more effiecntly then if it was build in postgres. These issues are more likely to occour because of our heavily analyises of data with SQL.

## Alternatives
There are several other optional databases that could be used to store and query the data. We have gone for a tradictional RDBMS although others could provide thier own unique set of beinifts:

### Postgres
Postgress is another RDBSM similar to MySQL. It also has an geostatail addon known as Postgis. The sole reason for no choosing this was the development teams existing knowlegde with MySQL

### MongoDB
MongoDB provides a powerful scalable document object storage which allows the user to pass in javascript and link multiple processes into chains easily producing custom map reduce setups. Mongo scales very well and comes natively with a geospatail library.

### Elasticsearch
A very unconvetional method would be to use Elasticsearch or an eqivalent such as Solr. These systems are build for high speed search searching over flat denromalize data structures. Athlough they cant handle complex data, they can easily query terabytes in milliseconds and come with a resonable set of mathmatical functions that can be run over filtered datasets. If we was processing a larger transit system with more real time data, such as the road network, or the US train network, this my prove to be a more effect and resource effeicnt system although would certainly require more development time.  