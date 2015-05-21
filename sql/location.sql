drop table if exists location;

create table location (
	locationName varchar(255),
	crs varchar(255), 
	tiploc  varchar(255),
	via  varchar(255)
);

create unique index pk on location (crs);