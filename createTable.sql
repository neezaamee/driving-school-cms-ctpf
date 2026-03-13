USE `school_ctpfsd`;
            
CREATE TABLE IF NOT EXISTS `fee` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `idadmission` int(200) NOT NULL,
  `coursefee` int(200) NOT NULL,
  `misc` int(200) NOT NULL,
  `discount` int(200) NOT NULL,
  `totalpayable` int(200) NOT NULL,
  `received` int(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;