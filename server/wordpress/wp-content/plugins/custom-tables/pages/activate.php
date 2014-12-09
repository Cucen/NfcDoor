<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `secret` varchar(32) DEFAULT NULL,
  `t_setup` text DEFAULT NULL,
  `e_setup` text DEFAULT NULL,
  `o_setup` text DEFAULT NULL,
  `sheme` enum('0','1') NOT NULL DEFAULT '0',
  `overlay` enum('0','1') NOT NULL DEFAULT '0',
  `headerline` enum('0','1') NOT NULL DEFAULT '1',
  `header` text DEFAULT NULL,
  `headersort` text DEFAULT NULL,
  `vortext` text DEFAULT NULL,
  `nachtext` text DEFAULT NULL,
  `sort` varchar(32) NOT NULL DEFAULT 'id',
  `sortB` enum('ASC','DESC') NOT NULL DEFAULT 'ASC',
  `searchaddon` varchar(120) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_list` VALUES (0,'Archive','','<td>{date}</td><td>{title}</td><td>{comment_count}</td>','','<b>{date} » {title}</b><br/>\r\n{content}','0','1','1','Datum,Artikel,Kommentare','date,title,comment_count','','','post_date','DESC','');");
$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET `id`=0 WHERE `name`='Archive' LIMIT 1;");
$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_list` WHERE `name`='Archive' AND `id` != '0';");

$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_list` VALUES (1,'Demo DB','".md5('wcf'.time())."','<td>{Kategory}</td><td>{City}</td><td>{Companyname}</td>','<strong>Category:</strong> {Kategory}<br/><strong>Name:</strong> {Companyname}<br/><strong>Street:</strong> {Street}<br/><strong>City:</strong> {PoBox} {City}<br/><strong>ID:</strong> <em>{id}</em><br/>[BACK]','<em>Overlay Demo</em><br/><br/><strong>{Companyname}</strong><br/>{Street}<br/>{PoBox} {City}','0','1','1','[wctselect field=\"Kategory\" maintext=\"Category\"],City,Company Name','Kategory,City,Companyname','[wctsearch felder=\"*\"]\nPlease find here the list of all companies:','Note: This list is on the internet available for all with number and mail, I take only not so high private data from it.','id','ASC','');");

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `t_setup` text DEFAULT NULL,
  `e_setup` text DEFAULT NULL,
  `r_fields` text DEFAULT NULL,
  `r_table` text DEFAULT NULL,
  `r_filter` text DEFAULT NULL,
  `rights` int(4) DEFAULT NULL,
  `htmlview` enum('0','1') NOT NULL DEFAULT '0',
  `smail` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_cron` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule` enum('h','t','d') NOT NULL DEFAULT 'd',
  `command` text NOT NULL,
  `nextrun` int(11) NOT NULL DEFAULT 0,
  `error` text DEFAULT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `table_id` int(11) NOT NULL,
  `t_setup` text,
  `e_setup` text,
  `o_setup` text,
  `sheme` enum('0','1') NOT NULL DEFAULT '0',
  `overlay` enum('0','1') NOT NULL DEFAULT '0',
  `headerline` enum('0','1') NOT NULL DEFAULT '1',
  `header` text,
  `headersort` text,
  `vortext` text,
  `nachtext` text,
  `sort` varchar(32) NOT NULL DEFAULT 'id',
  `sortB` enum('ASC','DESC') NOT NULL DEFAULT 'ASC',
  `searchaddon` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('active','draft','passive') NOT NULL DEFAULT 'active',
  `Kategory` enum('Bar','Cantine','Company','Restaurant') DEFAULT NULL,
  `Companyname` varchar(32) DEFAULT NULL,
  `Street` varchar(32) DEFAULT NULL,
  `PoBox` int(11) DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  `Date` int(10) DEFAULT NULL,
  `picture` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=utf8;");

$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (1,'active','Company','web updates kmu','Morgenacherstr. 20',5452,'Oberrohrdorf',1325466061,'');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (2,'active','Restaurant','AAFES-EUR-EIA','Kirchheimerstr. 104',0,'Gr',1326416461,'');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (3,'active','Cantine','Abel & Schafer GmbH & Co. KG','Schloastr. 8-12',0,'V',1327626061,'');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (4,'active','Restaurant','AEG Hausgerate GmbH','Muggenhofer Str. 135',0,'N',1326243661,'');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (5,'active','Restaurant','Alb Gold Teigwaren','Im Grindel 1',0,'Trochtelfingen',1324515661,'');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (6,'active','Bar','Alfred Ritter GmbH & Co. KG Pers','Alfred Ritter-Str. 25',0,'Waldenbuch',1304174724,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (7,'active','Cantine','Alnatura Produktions- und Handel','Darmstadter Str. 3',0,'Bickenbach',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (8,'active','Restaurant','Alten-und Pflegeheim','Herzogenbuscher Str. 37',0,'Trier',1304174724,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (9,'active','Restaurant','Anastift Trier','Krahnenstr. 32',0,'Trier',1326243661,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (10,'active','Restaurant','Arbeitsamt Saarlouis','Ludwigstr. 10',0,'Saarlouis',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (11,'active','Restaurant','arotop food creation GmbH & Co K','Dekan-Laist-Str. 9',0,'Mainz',1325466061,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (12,'active','Restaurant','Backerei-Konditorei Manfred Jung','Kuchenbergstr. 50',0,'Neunkirchen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (13,'active','Restaurant','Badischer Winzerkeller eG','Zum Kaiserstuhl 6',32767,'Breisach am Rhein',1326243661,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (14,'active','Bar','BASF Aktiengesellschaft','Carl-Bosch-Str. 38',0,'Ludwigshafen',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (15,'active','Restaurant','Bayer AG','',0,'Leverkusen',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (16,'active','Restaurant','Bayer AG, Werk Leverkusen','',0,'Leverkusen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (17,'active','Bar','Beleuchtung & Technik','Kirchweg 11',0,'Farschweiler',1326243661,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (18,'active','Cantine','BIB-Ulmer Spatz','Mainzer Str. 152-160',0,'Bingen am Rhein',1094247411,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (19,'active','Restaurant','Binding-Brauerei AG','Darmstadter Landstr. 185',0,'Frankfurt',1094247411,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (20,'active','Restaurant','Biol. Bundesanst. far Land-und F','Messeweg 11/12',0,'Braunschweig',1325466061,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (21,'active','Restaurant','Bioland Bundesverband','Kaiserstr. 18',0,'Mainz',1326243661,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (22,'active','Restaurant','Birkenhof Milchprodukte GmbH','Birkenhof',0,'Osterbr',1094247411,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (23,'active','Restaurant','Bitburger Brauerei Th. Simon Gmb','Ramermauer 3',32767,'Bitburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (24,'active','Restaurant','Boehringer Backmittel GmbH & Co.','Mainzerstr. 152-160',0,'Bingen',1326243661,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (25,'active','Bar','Brauerei Ganter GmbH & Co. KG','Schwarzwaldstr.43',32767,'Freiburg i. Br.',1325466061,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (26,'active','Restaurant','Brauerei Schwelm','Neumarkt 1',32767,'Schwelm',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (27,'active','Restaurant','Breisgaumilch GmbH','Haslacher Str. 12',0,'Freiburg',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (28,'active','Bar','BSB Nahrungsmittel GmbH','Birkelstr.',0,'Weinstadt-Endersbach',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (29,'active','Cantine','BSH Bosch und Siemens Hausgerate','',32767,'Giengen/ Benz',1325466061,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (30,'active','Restaurant','Bundesanstalt far Landwirtschaft','',0,'Frankfurt/ Main',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (31,'active','Restaurant','Bundesanstalt far Milchforschung','Herrmann-Weigmann-Str. 1',24121,'Kiel',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (32,'active','Restaurant','Bundesforschungsanstalt far Erna','Haid-und-Neu-Str. 9',0,'Karlsruhe',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (33,'active','Restaurant','Bundesverband Naturkost Naturwar','Robert-Bosch-Str. 6',0,'H',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (34,'active','Restaurant','Campina GmbH, Zentrale Heilbronn','Wimpfener Str. 125',0,'Heilbronn ',1325466061,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (35,'active','Restaurant','Carl Kankele zur Schapfenmahle G','Franzenhauserweg 21',0,'Ulm-Jungingen',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (36,'active','Bar','CBA GmbH','Konrad-Zuse-Str. 10',0,'Kirkel-Limbach',1325466061,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (37,'active','Restaurant','CCS Clinic Catering Service GmbH','Lazarettgarten 18',0,'Landau',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (38,'active','Restaurant','Cerestar Deutschland GmbH','George-C.-Marshall-Str. 210',32767,'Krefeld',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (39,'active','Cantine','Chemisches Untersuchungsamt','Maximineracht 11a',0,'Trier',1325466061,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (40,'active','Restaurant','Chemisches Untersuchungsamt Kobl','Neverstr.4-6',32767,'Koblenz',1304174724,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (41,'active','Restaurant','Clemens & Co. GmbH','Rudolf-Diesel-Str. 8',32767,'Wittlich',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (42,'active','Bar','Danone GmbH','Heinrich-Wieland-Str. 170',0,'M',1304174724,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (43,'active','Cantine','Dauner Sprudel GmbH','Maria-Hilf-Str. 22',32767,'Daun',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (44,'active','Restaurant','Deutsches Institut far Lebensmit','Prof.-vonKlitzing-Str. 7',0,'Quakenbr',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (45,'active','Restaurant','Diamantquelle Klee & Jungblut Gm','Am Sauerbrunnen 33',0,'Schwollen',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (46,'active','Restaurant','Diosna Dierks & Sahne GmbH','Sandbachstr. 1',32767,'Osnabr',1248324875,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (47,'active','Restaurant','DiverseyLever','Morschheimer Str. 12',0,'Kirchheimbolanden',1325466061,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (48,'active','Restaurant','DahlerGrruppe','Riedstr.',0,'Darmstadt',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (49,'active','Restaurant','Dr. Marcus GmbH','Geesthachter Str. 103',0,'Geesthacht',1304174724,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (50,'active','Bar','Dr. Otto Suwelak Nachf. GmbH & C','Josef-Suwelack-Str.',0,'Billerbeck',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (51,'active','Restaurant','Dr.Oetker','Werkstr.',0,'Wittlich',1304174724,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (52,'active','Restaurant','DreiStern Konserven & Co. KG','Philipp-Oehmigke-Str. 4',0,'Neuruppin',1304174724,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (53,'active','Bar','E.G.O. Elektro-Geratebau GmbH','',1180,'Obererdingen',1304174724,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (54,'active','Cantine','Eckert\'s Wachholder Brennerei Gm','Trierer Str.59',32767,'Tholey',1145724574,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (55,'active','Restaurant','Eckes-GraniniGmbH & Co. KG','Ludwig-Eckes-Allee 6',32767,'Nieder-Olm',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (56,'active','Restaurant','Ecolab GmbH & Co. OHG','Reisholzerstr. 38-42',32767,'D',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (57,'active','Restaurant','EDNA International GmbH','Gollenhoferstr. 3',0,'Zusmarshausen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (58,'active','Restaurant','EDNA Tiefkahlkost GmbH','Fernstr. 49',0,'Neunkirchen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (59,'active','Restaurant','Eichbaum Brauerei AG','Kafertaler Straae 170',0,'Mannheim',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (60,'active','Restaurant','Eigenbetrieb Abfallwirtschaft Fr','Berliner Allee 29',0,'Freiburg i. Br.',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (61,'active','Bar','Eppers','Industriestr.1 b',32767,'Saarbr',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (62,'active','Restaurant','erlenbacher backwaren GmbH','Wasserweg 39',0,'Gro',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (63,'active','Restaurant','Ernst Backer GmbH & Co. KG','Ringstr. 55-57',0,'Minden',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (64,'active','Bar','ETO Nahrungsmittel','Marscher Str. 17-25',0,'Ettlingen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (65,'active','Cantine','Exquisa Karwendel-Werke Huber Gm','Karwendel Str. 6-16',0,'Buchloe',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (66,'active','Restaurant','Fabry\'s Fast Food e. K. ','Gewerbegebiet',0,'Dudeldorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (67,'active','Restaurant','Fissler GmbH','Harald-Fissler-Str. 1',0,'Idar-Oberstein',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (68,'active','Restaurant','Fokken & Maller GmbH','Am Eisenbahndock',26700,'Emden',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (69,'active','Restaurant','Francois Entsorgungsbetrieb','Nimsstr. 27',0,'Rittersdorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (70,'active','Restaurant','Franz Zentis GmbH & Co.','',32767,'Aachen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (71,'active','Restaurant','Fraunhofer Institut far Verfahre','Giggenhauser Str. 35',0,'Freising',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (72,'active','Bar','Fangers Feinkost GmbH & Co','Einsteinstr. 132-140',0,'Oranienbaum bei Dessau',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (73,'active','Restaurant','G. C. Hahn & Co.','Aegidienstr. 22',23503,'L',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (74,'active','Restaurant','Garley Spezialitaten Brauerei','Sandstr. 58-60',32767,'Gardelegen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (75,'active','Cantine','Gartenfrisch Jung GmbH','Bahnhofstr. 18',0,'Jagsthausen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (76,'active','Restaurant','Gebr. Jung GmbH','Homburger Landstr. 602',32767,'Frankfurt am Main',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (77,'active','Restaurant','Georg Breuer GmbH Food Ingredien','Limburgerstr. 42 A',0,'K',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (78,'active','Bar','Gerolsteiner Brunnen GmbH&Co','Vulkanring',0,'Gerolstein',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (79,'active','Cantine','Gewarzmaller GmbH','Klagenfurterstr. 1-3',0,'Stuttgart',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (80,'active','Restaurant','Girrbach Sachsen','August-Horch-Str. 68',0,'Reinsdorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (81,'active','Restaurant','Givaudan-Roure GmbH','Giselherstr. 11',32767,'Dortmund',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (82,'active','Restaurant','Gramss GmbH','Laubanger 10',32767,'Bamberg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (83,'active','Restaurant','Griesson - de Beukelaer GmbH & C','August-Horch-Str. 23',0,'Polch',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (84,'active','Restaurant','Grosswald Brauerei Bauer GmbH & ','',0,'Heusweiler',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (85,'active','Restaurant','H. Thanes Fleischwaren GmbH','Rudolf-Dieselstr. 11',32767,'Wittlich',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (86,'active','Bar','Haribo GmbH & Co. KG','Hans-Riegel-Str. 1',32767,'Bonn',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (87,'active','Restaurant','Hassia & Luisen Mineralquellen','Gieaener Str. 18-28',32767,'Bad Vilbel',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (88,'active','Restaurant','HC Catering Service GmbH','Wackenstr. 9',0,'Zweibr',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (89,'active','Bar','Heideblume Molkerei Elsdorf/Rote','Molkereistr. 6',0,'Elsdorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (90,'active','Cantine','Hengstenberg GmbH & Co.','Mettingerstr. 109',0,'Esslingen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (91,'active','Restaurant','Herbstreith & Fox KG Pektin Fabr','Turnstr. 37',0,'Neuenb',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (92,'active','Restaurant','Hiestand Backwaren GmbH','Kolpingstr. 1-3',0,'Gerolzhofen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (93,'active','Restaurant','Hipp GmbH & Co. Vertrieb KG','Georg-Hipp-Str. 7',0,'Pfaffenhofen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (94,'active','Restaurant','HOBART GmbH','Robert-Bosch-Str. 17',32767,'Offenburg/ Elgersweier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (95,'active','Restaurant','Hochland AG','Kemptener Str. 17',0,'Heimenkirch',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (96,'active','Restaurant','Hochwald Nahrungsmittel-Werke','Bahnhofstr. 37-43',32767,'Thalfang',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (97,'active','Bar','Holsten-Brauerei AG','Wolfenbatteler Str. 33',0,'Braunschweig',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (98,'active','Restaurant','IMO Institut far Marktakologie G','Obere Laube 51-53',0,'Konstanz',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (99,'active','Restaurant','Institut Fresenius','Im Maisel 14',32767,'Taunusstein',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (100,'active','Bar','J. Bauer KG Milchverarbeitung','',32767,'Wasserburg/Inn',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (101,'active','Cantine','JohnsonDiversey GmbH & Co.oHG','Mallaustr. 50-56',0,'Mannheim',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (102,'active','Restaurant','Juchem GmbH','Pramburgstr. 3',32767,'Eppelborn',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (103,'active','Restaurant','Kalfany Bonbon GmbH','Renkenrunsstr. 14',0,'M',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (104,'active','Restaurant','Kamps AG','Prinzenallee 11',0,'D',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (105,'active','Restaurant','Karl Kahne KG (GmbH)','Schatzenstr. 38',0,'Hamburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (106,'active','Restaurant','Karlsberg Brauerei  GmbH & Co KG','Karlsbergstr. 62',32767,'Homburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (107,'active','Restaurant','Kath. Alten- und Pflegeheim St.-','Apothekergasse 6',0,'Bretten',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (108,'active','Bar','Katjes FASSIN GmbH + Co. KG','Dechant-Spranken-Str. 53-57',0,'Emmerich',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (109,'active','Restaurant','KESSKO KESSLER & COMP. GMBH & CO','Kanigswinterer Str. 11-21',32767,'Bonn',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (110,'active','Restaurant','KEVAG','Schatzenstr. 80-82',0,'Koblenz',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (111,'active','Cantine','Konditorei-Caf','Jakobstr. 2-3',0,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (112,'active','Restaurant','Kanigsbacher Brauerei AG','An der Kanigsbach 8',32767,'Koblenz',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (113,'active','Restaurant','Koordination GLOBUS-Betriebe Gmb','Leipziger Str. 8',0,'St. Wendel',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (114,'active','Bar','Kraft Foods Deutschland GmbH & C','Langemarckstr. 4-20',0,'Bremen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (115,'active','Cantine','Krankenhaus der Barmherz. Brader','Nordallee 1',32767,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (116,'active','Restaurant','Kreisverwaltung Trier-Saarburg','Willy-BrandtPlatz 1',0,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (117,'active','Restaurant','Kreiswasserwerk Bitburg-Pram','Kalvarienbergstr. 4',32767,'Pr',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (118,'active','Restaurant','Krombacher Brauerei','Hagener Str. 261',0,'Kreuztal',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (119,'active','Restaurant','Langnese-Iglo GmbH','Luther Weg 50',31513,'Wunstorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (120,'active','Restaurant','Life Food GmbH','Bebelstr. 8',0,'Freiburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (121,'active','Restaurant','Lindemeyer GmbH & Co.','Neckarsulmer Str. 24',0,'Heilbronn a. N.',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (122,'active','Bar','Lindt & Sprangli GmbH','Sasterfeldstr. 130',32767,'Aachen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (123,'active','Restaurant','Lorenz Bahlsen Snack-World ','Siemensstr. 14',0,'Neu Isenburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (124,'active','Restaurant','LSG Hygiene Institute GmbH','Dornhofstr. 40',0,'Neu Isenburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (125,'active','Bar','Ludwig Scheid GmbH + Co.','',32767,'berherrn/ Saar',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (126,'active','Cantine','Ludwig Schokolade GmbH&Co.KG','Lebacherstr.1-3',0,'Saarlouis',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (127,'active','Restaurant','Lukullus Lukullus','Hauptstr. 47',0,'Wallerfangen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (128,'active','Restaurant','Madaus Ag, Abt. Aus- und Weiterb','Ostmerheimer Str.198',0,'K',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (129,'active','Restaurant','MAJA-Maschinenfabrik','Tullastr. 4',0,'Kehl-Goldscheuer',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (130,'active','Restaurant','Markant-Sadwest','Winzler-Str. 152-160',0,'Pirmasens',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (131,'active','Restaurant','Martin Braun Backmittel und Esse','Tillystr. 17',0,'Hannover',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (132,'active','Restaurant','Masterfoods GmbH','Industriering 17',32767,'Viersen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (133,'active','Bar','Medizinaluntersuchungsamt','Maximineracht 11 b',0,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (134,'active','Restaurant','Meistermarken GmbH','Theodor-Heuss-Allee 8',0,'Bremen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (135,'active','Restaurant','Merl Edmund Feinkost','Wesselinger Str. 18-20',0,'Br',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (136,'active','Bar','Merziger Fruchtgetranke GmbH & C','Gewerbegebiet Siebend',32767,'Merzig',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (137,'active','Cantine','Milch-Union Hocheifel eG','',0,'Pronsfeld',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (138,'active','Restaurant','Milupa GmbH & Co. KG','Bahnstr. 14-30',0,'Friedrichsdorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (139,'active','Restaurant','Miwe Michael Wenz GmbH','Michael-Wenz-Str. 2-10',0,'Arnstein',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (140,'active','Restaurant','Molkerei H. Strothmann GmbH','Hans-Boeckler-Str. 50',0,'G',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (141,'active','Restaurant','Molkerei Sabbeke GmbH & Co. KG','Amelandsbrackenweg 131',0,'Gronau-Epe',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (142,'active','Restaurant','Moselkellerei Weinbund GmbH & Co','Am arziger Bahnhof Gewerbegebiet',0,'Kinheim',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (143,'active','Restaurant','Mahlenchemie GmbH','Kornkamp 40',0,'Ahrensburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (144,'active','Bar','Maller-Brot Neufahrn GmbH & Co. ','Ludwig-Erhard-Str. 2-6',0,'Neufahrn bei M',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (145,'active','Restaurant','National Starch & Chemical GmbH ','Kalkarer Str. 81',0,'Kleve',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (146,'active','Restaurant','Naturmittel Begon GmbH','Am Tower 11',0,'Bitburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (147,'active','Cantine','Nestle Foodservice GmbH Schulung','Odenwaldstr. 5-7',0,'Heppenheim',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (148,'active','Restaurant','NGI-Niederrheinische Getranke-In','Marie-Bernays-Ring 37',0,'M',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (149,'active','Restaurant','Niehoffs Vaihinger Fruchtsafte G','',32767,'Lauterecken',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (150,'active','Bar','Nordwest Getranke','Oldenburger Landstr. 2',0,'Osnabr',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (151,'active','Cantine','Nutrinova GmbH','Industriepark Hachst',0,'Frankfurt',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (152,'active','Restaurant','Odenwald-Konserven GmbH','Bahnhofstr. 31',0,'Breuberg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (153,'active','Restaurant','Onken GmbH','Dr. Berns-Str.. 23',0,'Moers',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (154,'active','Restaurant','Parkbrauerei AG','Zweibrackerstr . 3-5',32767,'Pirmasens',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (155,'active','Restaurant','Peppino\'s Pizza','Niederkircherstr. 4',0,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (156,'active','Restaurant','Peter Mertes KG','Bornwiese 4',0,'Bernkastel-Kues',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (157,'active','Restaurant','Philipp Born GmbH - Schokoladenf','Industriestr. 29',0,'Friedrichsdorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (158,'active','Bar','PROFIL Gastronomie Planung und I','',0,'',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (159,'active','Restaurant','Quint GmbH&Co.KG','Gewerbegebiet',32767,'Kenn/ Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (160,'active','Restaurant','RANCH MASTER','Luther Weg 50',0,'Wunstorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (161,'active','Bar','Rasselstein Hoesch GmbH (RHG)','Koblenzerstr. 141',0,'Andernach',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (162,'active','Cantine','Rational AG','Iglinger Str. 62',0,'Landsberg a. Lech',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (163,'active','Restaurant','REGINARIS AG Mineral- und Heilbr','Reginarisbrunnen 1',32767,'Mendig',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (164,'active','Restaurant','Rhein-Main-Sieg Getranke GmbH&Co','Brauereistr. 42',0,'Bendorf',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (165,'active','Restaurant','Riegeler Brauerei','',0,'Riegel',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (166,'active','Restaurant','Rudolf Wild GmbH & Co.KG','Rudolf.Wild-Str. 4-6',0,'Heidelberg/ Eppelheim',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (167,'active','Restaurant','Sander Gourmet GmbH & Co. KG','Industriepark 12',0,'Wiesbaden',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (168,'active','Restaurant','Sanitas Alpenklinik Inzell','Schulstr. 4',0,'Inzell',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (169,'active','Bar','SATRO Milchwerk Lippstadt GmbH &','Wiedenbrackerstr. 80',32767,'Lippstadt',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (170,'active','Restaurant','Scheffel Backwaren GmbH','Hattenstr. 37',32767,'Raubach',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (171,'active','Restaurant','Scheffler Plant & Life','Am Sportplatz 3',0,'Leiningen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (172,'active','Bar','Scheibel Schwarzwald-Brennerei G','Graner Winkel 32',0,'Kappelrodeck',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (173,'active','Cantine','Schill-Malz GmbH & Co. KG','Ludwig-Schwamb-Str. 9-11',0,'Osthofen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (174,'active','Restaurant','Schloss Veldenz GmbH & Co. KG.','Burgstr. 14',0,'Lauterecken',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (175,'active','Restaurant','Sektkellerei Faber GmbH&Co.KG','Niederkircher Str. 27',32767,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (176,'active','Restaurant','Sektkellerei Henkell & Co.','Biebricher Allee 142',0,'Wiesbaden',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (177,'active','Restaurant','Sektkellerei Peter Herres GmbH','Rudolf-Diesel-Str. 7-9',32767,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (178,'active','Restaurant','Sektkellerei Schloss Wachenheim ','Niederkircher Str. 27',32767,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (179,'active','Restaurant','Silesia Gerhard Henke GmbH & Co.','Am alten Bach 20-24',0,'Neuss',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (180,'active','Bar','SMW Saar-Mosel-Winzersekt GmbH','Gilbertstr. 34',0,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (181,'active','Restaurant','Staatliche Molkerei Weihenstepha','Vattinger Str. 43',0,'Freising',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (182,'active','Restaurant','Staatliches Institut','Malstatter-Str.17',0,'Saarbr',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (183,'active','Cantine','Stadtwerke Trier GmbH','Ostallee 7-13',0,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (184,'active','Restaurant','Sadzucker AG','Maximilianstr. 10',0,'Mannheim',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (185,'active','Restaurant','T.I.P. Biehl & Wagner','Neustr.27',0,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (186,'active','Bar','Tartex + Dr. Ritter GmbH','Hans-Bunte-Str. 8a',0,'Freiburg',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (187,'active','Cantine','Teekanne GmbH','Kevelaerer Str. 21-23',0,'D',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (188,'active','Restaurant','Theresienkrankenhaus','',0,'Mannheim',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (189,'active','Restaurant','Tiefkahlprodukte-Frozen Food Hor','Gutenberdring 1-5',22825,'Norderstedt',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (190,'active','Restaurant','Tucher Brau Verwaltung','Schwabacherstr. 10',0,'F',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (191,'active','Restaurant','Uldo Backmittel','Dornierstr. 14',32767,'Neu-Ulm',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (192,'active','Restaurant','UNIFERM GmbH & Co. KG','Brede 4',0,'Werne',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (193,'active','Restaurant','Unilever Bestfoods DeutschlandGm','Knorrstr. 1',32767,'Heilbronn a. N.',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (194,'active','Bar','Urbacher Saamosterei','Puderbacherstr. 13',0,'Urbach',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (195,'active','Restaurant','Verbandsgemeindeverwaltung Konz','',32767,'Konz',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (196,'active','Restaurant','Verbraucher-Zentrale NRW e.V.','Mittelstr. 7',0,'Hagen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (197,'active','Bar','Verbraucherzentrale Rheinland-Pf','Johann-Philipp-Str. 3-4',0,'Trier',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (198,'active','Cantine','Vorwerk Elektrowerke Stiftung & ','Rauental 38',0,'Wuppertal',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (199,'active','Restaurant','Wagner Tiefkahlprodukte GmbH','Kurzer Weg 1',0,'Nonnweiler-Braunshausen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (200,'active','Restaurant','WALTER RAU Lebensmittelwerke Gmb','Mansterstr. 9-11',0,'Hilter',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (201,'active','Restaurant','Wiesheu GmbH','Daimlerstr. 10',0,'Affalterbach',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (202,'active','Restaurant','Wild Flavour/ Ingredient Divisio','Am Schlangengraben 3-5',0,'Berlin',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (203,'active','Restaurant','WMF Aktiengesellschaft','',0,'Geisslingen/ Steige',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (204,'active','Restaurant','Wolf Butterback GmbH & Co. KG','Magazinstr. 77',0,'F',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (205,'active','Bar','Zamek Nahrungs-mittelfabriken Gm','Kappeler Str. 147-167',0,'D',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (206,'active','Restaurant','Zentis GmbH & Co.','Jalicher Str. 177',32767,'Aachen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (207,'active','Restaurant','Zimmermann-Graeff GmbH&Co.KG.','Marientaler Au 23',0,'Zell/ Mosel',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (208,'active','Bar','Zitterwalder Brotfabrik','Trierer Str. 9-11',0,'Hallschlag',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (209,'active','Cantine','ZOTT GmbH & Co. KG','Dr. Steichele Str. 4',0,'Mertingen',NULL,NULL);");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct1` VALUES (210,'active','Restaurant','Aachener Printen- und Schokolade','Borchersstr. 18',0,'Aachen',NULL,NULL);");

$settings['dbversion'] = '2011121101';
update_option('wuk_custom_tables', $settings);

?>