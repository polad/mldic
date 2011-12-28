DROP DATABASE IF EXISTS `test_mldic`;
CREATE DATABASE `test_mldic`
       DEFAULT CHARACTER SET = utf8
       DEFAULT COLLATE = utf8_unicode_ci;

USE `test_mldic`;

DROP TABLE IF EXISTS `entries`;
CREATE TABLE `entries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `phrase` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_id` int unsigned NOT NULL,
  `created_by` int unsigned NOT NULL,
  `created_date` timestamp DEFAULT 0,
  `modified_by` int unsigned DEFAULT NULL,
  `modified_date` timestamp DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `phrase` (`phrase`),
  UNIQUE `phrase_lang` (`phrase`, `language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `descriptions`;
CREATE TABLE `descriptions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int unsigned NOT NULL,
  `created_by` int unsigned NOT NULL,
  `created_date` timestamp DEFAULT 0,
  `modified_by` int unsigned DEFAULT NULL,
  `modified_date` timestamp DEFAULT 0,
  `description_text` text COLLATE utf8_unicode_ci NOT NULL,
  `rating_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `associations`;
CREATE TABLE `associations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rating_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `entries_associations`;
CREATE TABLE `entries_associations` (
  `association_id` int unsigned NOT NULL,
  `entry_id` int unsigned NOT NULL,
  PRIMARY KEY (`association_id`,`entry_id`),
  UNIQUE KEY `REV_PRIMARY` (`entry_id`,`association_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `num_of_votes` int unsigned NOT NULL DEFAULT '0',
  `total_rating` float(3,1) NOT NULL DEFAULT '0.0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `associations` VALUES (172,192),(173,194),(175,197),(178,201),(182,206),(187,212),(193,219),(200,227),(208,236),(217,246),(227,257),(238,269),(250,282),(263,296),(277,311),(292,327),(308,344),(325,362),(343,381),(362,401),(382,422),(403,444),(425,467),(448,491),(472,516),(497,542),(523,569),(550,597),(578,626),(607,656),(637,687),(668,719),(700,752),(733,786),(767,821),(802,857),(838,894);

INSERT INTO `descriptions` VALUES (16,20,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','the front part of the body,  middle section , below the chest and above the pelvic area; contains the stomach,  intestines , kidneys,  gallbladder,  liver,  spleen  pancreas and urinary bladder \r\n\r\n(L.  possibly from abdere to hide) that portion of the body which lies between the thorax and the pelvis; called also belly and venter. It contains a cavity (abdominal cavity) separated by the diaphragm from the thoracic cavity  above and by the plane of the pelvic inlet from the pelvic cavity below  and lined with a serous membrane  the peritoneum. This cavity contains the abdominal viscera and is enclosed by a wall (abdominal wall or parietes) formed by the abdominal muscles  vertebral column  and the ilia. It is divided into nine regions by four imaginary lines projected onto the anterior wall  of which two pass horizontally around the body (the upper at the level of the cartilages of the ninth ribs  the lower at the tops of the crests of the ilia)  and two extend vertically on each side of the body from the cartilage of the eighth rib to the centre of the inguinal ligament  as in A below. The regions are : three upper - right hypochondriac  epigastric  left hypochondriac; three middle - right lateral  umbilical  left lateral; and three lower - right inguinal  pubic  left inguinal)., \r\n\r\nThe part of the trunk that lies between the thorax and the pelvis. The abdomen does not include the vertebral region posteriorly but is considered by some anatomists to include the pelvis (abdominopelvic cavity). It includes the greater part of the abdominal cavity (cavitas abdominis [TA]) and is divided by arbitrary planes into nine regions',191),(17,21,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','the front part of the body,  middle section , below the chest and above the pelvic area; contains the stomach,  intestines , kidneys,  gallbladder,  liver,  spleen  pancreas and urinary bladder \r\n\r\n(L.  possibly from abdere to hide) that portion of the body which lies between the thorax and the pelvis; called also belly and venter. It contains a cavity (abdominal cavity) separated by the diaphragm from the thoracic cavity  above and by the plane of the pelvic inlet from the pelvic cavity below  and lined with a serous membrane  the peritoneum. This cavity contains the abdominal viscera and is enclosed by a wall (abdominal wall or parietes) formed by the abdominal muscles  vertebral column  and the ilia. It is divided into nine regions by four imaginary lines projected onto the anterior wall  of which two pass horizontally around the body (the upper at the level of the cartilages of the ninth ribs  the lower at the tops of the crests of the ilia)  and two extend vertically on each side of the body from the cartilage of the eighth rib to the centre of the inguinal ligament  as in A below. The regions are : three upper - right hypochondriac  epigastric  left hypochondriac; three middle - right lateral  umbilical  left lateral; and three lower - right inguinal  pubic  left inguinal)., \r\n\r\nThe part of the trunk that lies between the thorax and the pelvis. The abdomen does not include the vertebral region posteriorly but is considered by some anatomists to include the pelvis (abdominopelvic cavity). It includes the greater part of the abdominal cavity (cavitas abdominis [TA]) and is divided by arbitrary planes into nine regions',193),(18,22,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','the front part of the body,  middle section , below the chest and above the pelvic area; contains the stomach,  intestines , kidneys,  gallbladder,  liver,  spleen  pancreas and urinary bladder \r\n\r\n(L.  possibly from abdere to hide) that portion of the body which lies between the thorax and the pelvis; called also belly and venter. It contains a cavity (abdominal cavity) separated by the diaphragm from the thoracic cavity  above and by the plane of the pelvic inlet from the pelvic cavity below  and lined with a serous membrane  the peritoneum. This cavity contains the abdominal viscera and is enclosed by a wall (abdominal wall or parietes) formed by the abdominal muscles  vertebral column  and the ilia. It is divided into nine regions by four imaginary lines projected onto the anterior wall  of which two pass horizontally around the body (the upper at the level of the cartilages of the ninth ribs  the lower at the tops of the crests of the ilia)  and two extend vertically on each side of the body from the cartilage of the eighth rib to the centre of the inguinal ligament  as in A below. The regions are : three upper - right hypochondriac  epigastric  left hypochondriac; three middle - right lateral  umbilical  left lateral; and three lower - right inguinal  pubic  left inguinal)., \r\n\r\nThe part of the trunk that lies between the thorax and the pelvis. The abdomen does not include the vertebral region posteriorly but is considered by some anatomists to include the pelvis (abdominopelvic cavity). It includes the greater part of the abdominal cavity (cavitas abdominis [TA]) and is divided by arbitrary planes into nine regions',196),(19,29,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','Este partea frontală a mijlocului trunchiului situată sub cutia toracică şi deasupra bazinului, care cuprinde organele: stomacul, intestinele, rinichii, ficatul, vezica biliară, splina, pancreasul şi vezica urinară',245),(20,30,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','Este partea frontală a mijlocului trunchiului situată sub cutia toracică şi deasupra bazinului, care cuprinde organele: stomacul, intestinele, rinichii, ficatul, vezica biliară, splina, pancreasul şi vezica urinară',256),(21,35,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','La partie supérieure du corps, entre la poitrine et la région pelvienne. Il contient l\'estomac, les intestins, les reins, la vésicule biliaire, le foie, le pancréas de rate et la vessie urinaire',326),(22,36,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','La partie supérieure du corps, entre la poitrine et la région pelvienne. Il contient l\'estomac, les intestins, les reins, la vésicule biliaire, le foie, le pancréas de rate et la vessie urinaire',343),(23,37,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','parte del cuerpo que se extiende entre el tórax y la pelvis',361),(24,38,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','parte del cuerpo que se extiende entre el tórax y la pelvis',380),(25,39,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','parte del cuerpo que se extiende entre el tórax y la pelvis',400),(26,40,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','parte del cuerpo que se extiende entre el tórax y la pelvis',421),(27,41,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','parte del cuerpo que se extiende entre el tórax y la pelvis',443),(28,45,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','La regione del corpo fra il torace e le pelvi contenente l\'apparato digerente; la sezione inferiore del corpo dietro il torace. Parte del tronco posta tra torace in alto e bacino in basso. regione del tronco posta tra torace e bacino, più o meno prominente in ragione dell’accumulo di grasso. In alto è delimitato dall’arcata costale, in basso dalla regione pubica; per comodità di descrizione è suddiviso in nove regioni: epigastrio, regione ombelicale (mesogastrio), ipogastrio, ipocondrio destro e sinistro, regioni lombari (fianco destro e sinistro), fossa iliaca destra e sinistra. Internamente si ha la cavità addominale o addomino-pelvica, che contiene gran parte dell’apparato digerente, di quello urogenitale, l’aorta addominale, la vena cava inferiore, numerosi nervi e plessi nervosi. Tale cavità è delimitata in alto dal diaframma; dietro dalla colonna e dai muscoli dorsali; dietro e di lato dal quadrato dei lombi, dal piccolo e dal grande psoas; davanti dal grande retto, dal piramidale, dal grande e piccolo obliquo. Essa è inoltre tappezzata da una membrana sierosa, il foglietto parietale del peritoneo, che si ribatte su se stessa (peritoneo viscerale) per rivestire i vari organi contenuti nell’addome',541),(29,46,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','La regione del corpo fra il torace e le pelvi contenente l\'apparato digerente; la sezione inferiore del corpo dietro il torace. Parte del tronco posta tra torace in alto e bacino in basso. regione del tronco posta tra torace e bacino, più o meno prominente in ragione dell’accumulo di grasso. In alto è delimitato dall’arcata costale, in basso dalla regione pubica; per comodità di descrizione è suddiviso in nove regioni: epigastrio, regione ombelicale (mesogastrio), ipogastrio, ipocondrio destro e sinistro, regioni lombari (fianco destro e sinistro), fossa iliaca destra e sinistra. Internamente si ha la cavità addominale o addomino-pelvica, che contiene gran parte dell’apparato digerente, di quello urogenitale, l’aorta addominale, la vena cava inferiore, numerosi nervi e plessi nervosi. Tale cavità è delimitata in alto dal diaframma; dietro dalla colonna e dai muscoli dorsali; dietro e di lato dal quadrato dei lombi, dal piccolo e dal grande psoas; davanti dal grande retto, dal piramidale, dal grande e piccolo obliquo. Essa è inoltre tappezzata da una membrana sierosa, il foglietto parietale del peritoneo, che si ribatte su se stessa (peritoneo viscerale) per rivestire i vari organi contenuti nell’addome',568),(30,56,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18','المنطقة الأمامية من الجسم، القسم الاوسط، تحت الصدر و فوق منطقة الحوض؛ تحتوي المعدة، والأمعاء، والكِلى، والحويصلة المراريَّة، والكبد، والطحال، والبنكرياس،  والمثانة',893);

INSERT INTO `entries` VALUES (21,'belly',1,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(22,'abd',1,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(23,'has',2,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(24,'pocak',2,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(25,'altest',2,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(26,'vénter',3,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(27,'gáster',3,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(28,'abdómen',3,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(29,'abdomen',4,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(30,'pântece (pop)',4,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(31,'brucho',5,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(32,'Bauch',6,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(33,'der; Abdomen',6,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(34,'das;',6,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(35,'abdomen',7,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(36,'ventre',7,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(37,'panza',8,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(38,'estómago',8,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(39,'abdomen',8,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(40,'vientre',8,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(41,'barriga',8,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(42,'abdómen',9,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(43,'barriga',9,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(44,'ventre',9,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(45,'addome',10,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(46,'ventre',10,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(47,'brzuch',11,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(48,'břicho',12,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(49,'abdomen',12,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(50,'buk',13,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(51,'vatsa',14,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(52,'vatsaontelo',14,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(53,'полость брюшная',15,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(54,'живот',15,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(55,'брюшко',15,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(56,'بَطن',16,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(57,'腹',17,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18'),(20,'abdomen',1,1,'2007-05-01 08:32:22',1,'2010-03-01 18:01:18');

INSERT INTO `entries_associations` VALUES (172,20),(172,21),(173,20),(173,22),(175,20),(175,23),(178,20),(178,24),(182,20),(182,25),(187,20),(187,26),(193,20),(193,27),(200,20),(200,28),(208,20),(208,29),(217,20),(217,30),(227,20),(227,31),(238,20),(238,32),(250,20),(250,33),(263,20),(263,34),(277,20),(277,35),(292,20),(292,36),(308,20),(308,37),(325,20),(325,38),(343,20),(343,39),(362,20),(362,40),(382,20),(382,41),(403,20),(403,42),(425,20),(425,43),(448,20),(448,44),(472,20),(472,45),(497,20),(497,46),(523,20),(523,47),(550,20),(550,48),(578,20),(578,49),(607,20),(607,50),(637,20),(637,51),(668,20),(668,52),(700,20),(700,53),(733,20),(733,54),(767,20),(767,55),(802,20),(802,56),(838,20),(838,57);

INSERT INTO `languages` VALUES (1,'en','english'),(2,'hu','hungarian'),(3,'lg','latingreek'),(4,'ro','romanian'),(5,'sk','slovak'),(6,'de','german'),(7,'fr','french'),(8,'es','spanish'),(9,'pt','portuguese'),(10,'it','italian'),(11,'pl','polish'),(12,'cs','czech'),(13,'sv','swedish'),(14,'fi','finnish'),(15,'ru','russian'),(16,'ar','arabic'),(17,'zh','chinese');

INSERT INTO `ratings` VALUES (192,0,0.0),(194,0,0.0),(197,0,0.0),(201,0,0.0),(206,0,0.0),(212,0,0.0),(219,0,0.0),(227,0,0.0),(236,0,0.0),(246,0,0.0),(257,0,0.0),(269,0,0.0),(282,0,0.0),(296,0,0.0),(311,0,0.0),(327,0,0.0),(344,0,0.0),(362,0,0.0),(381,0,0.0),(401,0,0.0),(422,0,0.0),(444,0,0.0),(467,0,0.0),(491,0,0.0),(516,0,0.0),(542,0,0.0),(569,0,0.0),(597,0,0.0),(626,0,0.0),(656,0,0.0),(687,0,0.0),(719,0,0.0),(752,0,0.0),(786,0,0.0),(821,0,0.0),(857,0,0.0),(894,0,0.0),(191,0,0.0),(193,0,0.0),(196,0,0.0),(245,0,0.0),(256,0,0.0),(326,0,0.0),(343,0,0.0),(361,0,0.0),(380,0,0.0),(400,0,0.0),(421,0,0.0),(443,0,0.0),(541,0,0.0),(568,0,0.0),(893,0,0.0);

INSERT INTO `users` VALUES (1,'admin','Admin','User');
