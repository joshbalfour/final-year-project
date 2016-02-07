**V 1.1.1**
# Database Software

## Preface
This document outlines what database software we researched the possibility of using and our conclusion.

## MySQL
MySQL will be the primary database that will hold all of our data and do the analysis of the train times. Although many feel that Postgres is a better tool for the job, MySQL has a rich set of features, a geospatial library, and a very powerful query engine. The key reason for going for MySQL is that the development team has better knowlegde of this then Postgres. Although they are both traditional RDBMS, the team's more advanced knowlegde of MySQL will allow them to tackle and fix bugs more effectively then if postgres was used. These issues have a relatively higher probaility of occuring as this project will heavily use the more advanced data analysis features of SQL.

## Alternatives
There are several other databases that could be used to store and query the data. We have gone for a traditional RDBMS although others could provide thier own unique set of benefits:

### Postgres
Postgres is also an RDBMS, similar to MySQL. It also has a geospatial addon known as Postgis. The sole reason for no tchoosing this was the development team's existing knowlegde of MySQL.

### MongoDB
MongoDB provides powerful, scalable document object storage which allows the user to pass in javascript and link multiple processes into chains, which allows easy production of custom map reduce setups. Mongo scales very well and comes natively with a geospatial library.

### Elasticsearch
A very unconventional method would be to use Elasticsearch or an eqivalent such as Solr. These systems are built for high speed searching over flat, unstructured data. Although they can't handle complex data, they can easily query terabytes of data in milliseconds and come with a reasonable set of mathematical functions that can be ran over filtered datasets. If we were processing a larger transit system with more realtime data, such as the road network or the US train network, this may prove to be a more effective and resource efficient system although would certainly require more development time.