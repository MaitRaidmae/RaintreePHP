-- Create patient table.
CREATE TABLE `patient` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key for  the table',
  `pn` varchar(11) DEFAULT NULL COMMENT 'Patient number',
  `first` varchar(15) DEFAULT NULL COMMENT 'First name of the patient',
  `last` varchar(25) DEFAULT NULL COMMENT 'Last name of the patient',
  `dob` date DEFAULT NULL COMMENT 'Date of Birth',
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Create insurance table.
CREATE TABLE `insurance` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key for the table',
  `patient_id` int(10) unsigned DEFAULT NULL,
  `iname` varchar(40) DEFAULT NULL COMMENT 'Name of the insurance',
  `from_date` date DEFAULT NULL COMMENT 'Insurance valid from',
  `to_date` date DEFAULT NULL COMMENT 'Insurance valit to',
  PRIMARY KEY (`_id`),
  KEY `fk_insurance_1_idx` (`patient_id`),
  CONSTRAINT `fk_insurance_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Insert dummy values into the patient table
insert into patient (pn,first,last,dob) values ('A1','John','Doe','1984-01-24');
insert into patient (pn,first,last,dob) values ('A2','Jane','Doe','1982-05-14');
insert into patient (pn,first,last,dob) values ('A3','James','Bond','1974-12-30');
insert into patient (pn,first,last,dob) values ('A4','Julie','Winters','1995-01-15');
insert into patient (pn,first,last,dob) values ('A5','Jackie','Stewart','1536-02-12');
-- Insert dummy values into insurance table
insert into insurance (patient_id, iname, from_date, to_date) values (3, 'Insurance 1','2015-05-13','2016-05-13');
insert into insurance (patient_id, iname, from_date, to_date) values (2, 'Insurance 2','2015-09-12','2016-09-12');
insert into insurance (patient_id, iname, from_date, to_date) values (2, 'Insurance 2','2013-09-12','2012-09-12');
insert into insurance (patient_id, iname, from_date, to_date) values (4, 'Insurance 2','2015-09-12','2016-09-12');
