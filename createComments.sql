CREATE TABLE comments (
	cid int(11) NOT null AUTO_INCREMENT PRIMARY KEY,
    uid varchar(128) NOT null,
    date datetime NOT null,
    message TEXT NOT null
);

CREATE TABLE users (
	id int(11) NOT null AUTO_INCREMENT PRIMARY KEY,
	first varchar(128) NOT null,
	last varchar(128) NOT null,
    uid varchar(128) NOT null,
    pwd varchar(128) NOT null
);
