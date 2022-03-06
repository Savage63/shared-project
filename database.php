CREATE TABLE userinfo (
    	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    	username VARCHAR(50) NOT NULL UNIQUE,
    	password VARCHAR(255) NOT NULL,
	name VARCHAR(60) NOT NULL,
	address VARCHAR(255) NOT NULL, 
	dob DATE NOT NULL, 
	phone INT NOT NULL, 
	image longblob NOT NULL,
  	created datetime NOT NULL DEFAULT current_timestamp(),
    	created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE closecontacts( 
	name VARCHAR(60) NOT NULL , 
	phone INT NOT NULL , 
	PRIMARY KEY (`name`)
) ENGINE = InnoDB;