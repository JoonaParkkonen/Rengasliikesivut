<?php

$conn = mysqli_connect("localhost","root","","rengasliikekanta");
 
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }



$sql = "CREATE TABLE IF NOT EXISTS `asiakastaulu` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `etunimi` varchar(10) NOT NULL,
  `sukunimi` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `osoite` varchar(30) NOT NULL,
  `postinumero` int(5) NOT NULL,
  `paikkakunta` varchar(15) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if(mysqli_query( $conn,$sql))
{  
echo "Table 1 Created successfully.<br>";  
}
else
{  
echo "Table Creation Failed; ".mysqli_error($conn);  
}  

  

$sql2 = "CREATE TABLE IF NOT EXISTS `tilaustaulu` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `asiakas_id` int(15) NOT NULL,
  `pvm` date NOT NULL,
  `toimitus` varchar(20) NOT NULL,
   PRIMARY KEY (`id`),
   CONSTRAINT FK_asiakas FOREIGN KEY (asiakas_id)
   REFERENCES asiakastaulu(id)ON DELETE CASCADE
   ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if(mysqli_query( $conn,$sql2))
{  
echo "Table 2 Created successfully.<br>";  
}
else
{  
echo "Table Creation Failed; ".mysqli_error($conn);  
}  

$sql3 = "CREATE TABLE IF NOT EXISTS `renkaat` (
    `RengasID` int(11) NOT NULL AUTO_INCREMENT,
    `Merkki` varchar(255) NOT NULL,
    `Malli` varchar(255) NOT NULL,
    `Tyyppi` varchar(255) NOT NULL,
    `Koko` varchar(20) NOT NULL,
    `Hinta` decimal(10,2) NOT NULL,
    `Saldo` int(11) NOT NULL,
    PRIMARY KEY (`RengasID`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=29 ";
  
 
  
  if(mysqli_query( $conn,$sql3))
  {  
  echo "Table 3 Created successfully.<br>";  
  mysqli_query($conn,"INSERT INTO `renkaat` (`RengasID`, `Merkki`, `Malli`, `Tyyppi`, `Koko`, `Hinta`, `Saldo`) VALUES
  (1, 'Nokian', 'Hakkapeliitta 8', 'Nasta', '165/55-14', 65.50, 15),
  (2, 'Nokian', 'Hakkapeliitta 8', 'Nasta', '165/65-14', 65.75, 15),
  (3, 'Nokian', 'Hakkapeliitta 9', 'Kitka', '165/55-15', 74.55, 50),
  (4, 'Nokian', 'Hakkapeliitta R3', 'Kitka', '175/65-15', 78.94, 3),
  (5, 'Kumho', 'Wi31+', 'Nasta', '185/65-15', 125.45, 80),
  (6, 'Kumho', 'Wi31+', 'Nasta', '205/65-16', 132.53, 14),
  (7, 'Kumho', 'WS71', 'Kitka', '175/65-15', 86.45, 23),
  (8, 'Kumho', 'WS71', 'Kitka', '165/55-14', 75.88, 3),
  (9, 'Hankook', 'RW11', 'Kitka', '165/65-14', 98.12, 2),
  (10, 'Hankook', 'RW11', 'Kitka', '175/65-15', 99.49, 12),
  (11, 'Hankook', 'RW11', 'Kitka', '205/65-16', 102.24, 50),
  (12, 'Nokian', 'Nordman RS2', 'Kitka', '185/65-15', 78.50, 60),
  (13, 'Nokian', 'Nordman RS2', 'Kitka', '175/65-14', 88.34, 16),
  (14, 'Nokian', 'Nordman RS2', 'Kitka', '185/65-14', 87.32, 5),
  (15, 'Kumho', 'WS71', 'Kitka', '235/65-17', 199.93, 7),
  (16, 'Kumho', 'WS71', 'Kitka', '235/60-18', 213.05, 8),
  (17, 'Nokian', 'Hakkapeliitta 9', 'Nasta', '185/65-15', 81.20, 16),
  (18, 'Nokian', 'Hakkapeliitta 9', 'Nasta', '195/65-15', 99.00, 20),
  (19, 'Nokian', 'Hakkapeliitta 8 SUV', 'Kitka', '225/55-18', 234.40, 7),
  (20, 'Kumho', 'WS71', 'Kitka', '235/60-17', 134.90, 30),
  (21, 'Kumho', 'WS71', 'Kitka', '255/50-19', 144.10, 8),
  (22, 'Hankook', 'K425', 'Kesä', '205/55-16', 55.00, 34),
  (23, 'Hankook', 'K125', 'Kesä', '205/55-16', 61.00, 12),
  (24, 'Nokian', '91H', 'Kesä', '205/55-16', 63.00, 1),
  (25, 'Hankook', 'Ventus Prime 3 K125', 'Kesä', '185/55-15', 75.00, 32),
  (26, 'Hankook', 'Ventus Prime 3 K125', 'Kesä', '195/55-15', 82.00, 12),
  (27, 'Kumho', 'Ecowing ES-31', 'Kesä', '195/55-15', 81.00, 16),
  (28, 'Nokian ', 'Hakka Blue 2', 'Kesä', '195/55-15', 91.00, 3)");
  }
  else
  {  
  echo "Table Creation Failed; ".mysqli_error($conn);  
  }  
  
   

$sql4 = "CREATE TABLE IF NOT EXISTS `tilausrivitaulu` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `tilaus_id` int(5) NOT NULL,
  `tuote_id` int(5) NOT NULL,
  `tilausmaara` int(5) NOT NULL,
   PRIMARY KEY (`id`),
   CONSTRAINT FK_tilaus FOREIGN KEY (tilaus_id)
   REFERENCES tilaustaulu(id)ON DELETE CASCADE
   ON UPDATE CASCADE,
   CONSTRAINT FK_tuote FOREIGN KEY (tuote_id)
   REFERENCES renkaat(RengasID)ON DELETE CASCADE
   ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if(mysqli_query( $conn,$sql4))
{  
echo "Table 4 Created successfully.<br>";  
}
else
{  
echo "Table Creation Failed; ".mysqli_error($conn);  
}  




mysqli_close($conn);
echo "Connection Closed"
    
?>