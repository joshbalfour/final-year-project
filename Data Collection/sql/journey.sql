drop table if exists journey;

create table journey (
	rid varchar(255),
	uid varchar(255),
	trainid varchar(255),
	std varchar(255),
	sdd varchar(255),
	operator varchar(255),
	operatorCode varchar(255),
	sta varchar(255),
	eta varchar(255),
	etd varchar(255),
	arrivalType varchar(255),
	platform varchar(255),
	platformIsUnreliable varchar(255),
	arrivalSource varchar(255),
	originCRS varchar(255),
	destinationCRS varchar(255),
	departureType varchar(255),
	departureSource varchar(255)
);

create unique index pk on journey (rid, uid, trainid);