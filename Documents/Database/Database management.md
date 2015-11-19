**V 1.1.0**
# Database Management
This document dicuses how we will manage the database schema and the data with it.

## Schema control
For controlling the databases schema we will be using Laravels schema control system which uses a method of time stamping files filled with SQL statements. This allows several developers to make edits to the schema, and then when pulling a new schema change file, their local database can quickly brought up to date using the `artisan db:migrate` command. This will play the database migrations in time order.  

This will overcome a common issue when building large applications with continuing changes to the schema. Simply reloading the schema for the whole table is ineffeicent and means loose of local data each time. Because the schema control files are written in PHP it means complex migration plans which could delete several columns and add new columns dynamicly based on the deleted data.

## Data storage
The data will be pre processed and normalized before being stored in the database. The format of the data is defined in algorithm.md. Geo data will be stored in Well Known Text which should allow optermizations via the geo library.

## Performance
A lot of the raw data will be heavily preprocessed, this means the only calculations that will have to be done is simulating the train driving down the tracks when computing its locatin. We are expecting MySQL to cache these simulations so it will provide quick results, when train times are updated MySQL will automatically know to recompute these times. 