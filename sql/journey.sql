drop table if exists journey;
create table journey (
	rid VARCHAR(255),
	uid VARCHAR(255),
	trainid VARCHAR(255),
	std VARCHAR(255),
	sdd VARCHAR(255),
	operator VARCHAR(255),
	operatorCode VARCHAR(255),
	sta VARCHAR(255),
	eta VARCHAR(255),
	arrivalType VARCHAR(255),
	platform VARCHAR(255),
	platformIsUnreliable VARCHAR(255),
	arrivalSource VARCHAR(255),
	originCRS VARCHAR(255),
	destinationCRS VARCHAR(255)
);