** V1.0.0 **
# Database Management
This document dicuses how we will manage the database schema and the data with it.

## Schema control
For controlling the databases schema we will be using Laravels schema control system which uses a method of time stamping files filled with SQL statements. This allows several developers to make edits to the schema, and then when pulling a new schema change file, their local database can quickly brought up to date using the `artisan db:migrate` command. This will play the database migrations in time order.  

This will overcome a common issue when building large applications with continuing changes to the schema. Simply reloading the schema for the whole table is ineffeicent and means loose of local data each time. Because the schema control files are written in PHP it means complex migration plans which could delete several columns and add new columns dynamicly based on the deleted data.

## Data storage
The plan for storing data is to import data from their sources and leave that data in tables in its raw state. From here views will be build that will alter that data turning it into a nicer format. Multiple views will be layered in order to slowly convert the source data into predictions about when a crossing will be up or down. This method of using layed views will produce a quick simple development path because we can edit source data and know that data in all other views will be automatically updated without the need for extra scripts or triggers to update other tables.

## Performance
Our articture relies heavily on views, which will intern read from other views should provide sped benifits because all processing is done directly on the data data. This may also cause a performance issue as MySQL has to calculate each view. We are relying on the advanced execution planner in MySQL and its abilty to cache heavily so that it can efficetly built the final data output which we will be reading from without a lot of unneeded intimidetry processing. If this comes an issue then views may be converted into memory tables that are peridoically updated using triggers from the source tables.