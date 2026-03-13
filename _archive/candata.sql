-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2016 at 05:47 PM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rsts`
--

-- --------------------------------------------------------

--
-- Table structure for table `candata`
--

CREATE TABLE IF NOT EXISTS `candata` (
`ID` int(10) unsigned NOT NULL,
  `token` int(6) NOT NULL,
  `date` date NOT NULL,
  `ent_time` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `fwdname` varchar(30) NOT NULL,
  `address` varchar(150) NOT NULL,
  `city` varchar(30) NOT NULL,
  `cnic` varchar(15) NOT NULL,
  `bgroup` varchar(4) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `lpno` varchar(15) NOT NULL,
  `lpdate` date NOT NULL,
  `liccat` varchar(50) NOT NULL,
  `tktcost` int(4) NOT NULL,
  `sgntst` varchar(4) NOT NULL,
  `sgn_time` varchar(10) NOT NULL,
  `stnres` varchar(10) NOT NULL,
  `rdtest` varchar(4) NOT NULL,
  `rd_time` varchar(10) NOT NULL,
  `42days` date NOT NULL,
  `fnlres` varchar(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `candata`
--

INSERT INTO `candata` (`ID`, `token`, `date`, `ent_time`, `name`, `fwdname`, `address`, `city`, `cnic`, `bgroup`, `phone`, `email`, `lpno`, `lpdate`, `liccat`, `tktcost`, `sgntst`, `sgn_time`, `stnres`, `rdtest`, `rd_time`, `42days`, `fnlres`) VALUES
(1, 1, '2016-09-07', '08:30:55', 'SHAN ALI', 'ABDUL JABBAR', 'P-61MAIN BAZAR CHOOTI ONASI FAISALABAD', 'Faisalabad', '3310212039827', 'B+', '03126479279', '', '45053/4505', '1970-01-01', 'Moter Cycle,Motor Car,', 950, 'Pass', '10:40:49', '', 'Pass', '10:56:49', '0000-00-00', ''),
(2, 2, '2016-09-07', '08:42:45', 'UMAIR SAJID', 'SYED SAJID HUSSIAN', 'P-80 ST 08 FAROOQ ABAD ', 'Faisalabad', '3310079452811', 'AB-', '03217806547', '', '28337-2833', '2016-03-14', 'Moter Cycle,Motor Car,', 950, '2', '07:59:00', '2', 'Pass', '08:34:00', '2016-11-02', ''),
(3, 3, '2016-09-07', '08:44:46', 'M.NADEEM ASVID', 'M.SHAFIQUE', 'MANSOORABAD P-3303 ST 16/20 FAROOQABAD', 'Faisalabad', '3310293695113', 'O+', '3366662347', '', '53672-5367', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Fail', '11:02:35', '2016-10-19', ''),
(4, 4, '2016-09-07', '08:46:35', 'UMAIR ARSHAD', 'MUHAMMAD ARSHAD', 'MAIN BAZAR H 1382 ST 16 MANSOOR ABAD ', 'Faisalabad', '3310263694351', 'B+', '3032263751', '', '53687-5368', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Fail', '11:11:52', '2016-10-19', ''),
(5, 5, '2016-09-07', '08:48:41', 'FAHAD AMIN', 'MUHAMMAD AMIN', 'P-3200 ST 16/20 FAROOQ ABAD', 'Faisalabad', '3310077489131', 'B+', '3316898150', '', '53663-5366', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Fail', '08:09:44', '2016-11-02', ''),
(6, 6, '2016-09-07', '08:50:49', 'IMRAN SOHAIL', 'MUHAMMAD SIDDIQUE', 'NAQVI PARK P-25/B SHADAF COLONY ', 'Faisalabad', '3310059302935', 'O+', '3009669628', '', '54037-5403', '2016-07-26', 'Moter Cycle,Motor Car,', 950, '6', '06:16:31', '6', 'Fail', '08:12:52', '2016-11-02', ''),
(7, 7, '2016-09-07', '08:53:50', 'MUHAMMAD BILAL RAZA', 'MUHAMMAD YASIN', 'CHAK NO 007 JB PO KHAS ', 'Faisalabad', '3310299758645', 'A+', '03452603002', '', '52016-5201', '2016-07-20', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(8, 8, '2016-09-07', '08:55:15', 'MOHSIN HASSAN', 'MUHAMMAD AKRAM', 'H 443-A MOH. NAZIM ABAD', 'Faisalabad', '3310007230819', 'O-', '03006619354', '', '30365-3036', '2016-03-26', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(9, 9, '2016-09-07', '08:57:01', ' QADEER AHMAD', 'BASHIR AHMAD', '107/GB PATHAN KOT JARANWALA', 'Faisalabad', '3310438708655', 'O+', '03466566470', '', '40120-4011', '2016-05-24', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(10, 10, '2016-09-07', '08:58:50', 'ZAEEM BUKARI', 'MUBARIK ALI SHAH', 'P-27 GULSHAN E IQBAL B BLOCK ', 'Faisalabad', '3310047388795', 'O+', '03144920934', '', '51663-5166', '2016-07-19', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(11, 11, '2016-09-07', '09:00:53', 'MUHAMMAD IMRAN', 'SARDAR MUHAMMAD', 'PO SAE CHAK NIO 257 RB JEHANGIR KHURD PO SAME', 'Faisalabad', '3310035502937', 'B+', '03366576953', '', '50069-5006', '2016-07-13', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Fail', '08:11:21', '2016-11-02', ''),
(12, 12, '2016-09-07', '09:02:10', 'RAJAB ALI', 'NOOR MUHAMMAD', 'CHAK 497 MAMUKANJAN TEH TENDLINA WALA', 'Faisalabad', '3310635236713', 'B+', '03318778431', '', '53478-5347', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Fail', '11:27:06', '2016-10-19', ''),
(13, 13, '2016-09-07', '09:03:43', 'ABDUL WAHEED KHAN', 'ABDUL HAMEED KHAN', 'P-136, MOH LASANI TOWN', 'Faisalabad', '3310010147043', 'B+', '03236022202', '', '51015-5101', '2016-07-16', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Fail', '11:26:48', '2016-10-19', ''),
(14, 14, '2016-09-07', '09:05:20', 'AZIZ UR REHMAN', 'GUL REHMAN', 'TEZAB MIL ROAD MOH FEROZ COLONY', 'Faisalabad', '3310455498637', 'A+', '03063320115', '', '43338/L', '2016-06-04', 'Moter Cycle,', 550, '', '', '', 'Fail', '11:26:29', '2016-10-19', ''),
(15, 15, '2016-09-07', '09:10:09', 'MIAN ZAHOOR SABIR', 'SABIR MOHAMMAD', 'CHAK 251/RB BANDALA ', 'Faisalabad', '3310061047795', 'A+', '3007612032', '', '23109/L', '2016-08-30', 'Motor Car,', 900, '', '', '', 'Fail', '11:26:08', '2016-10-19', ''),
(16, 16, '2016-09-07', '09:12:27', 'MUHAMMAD FAIZAN', 'KHALID AHMAD RASHEED', 'PEOPLES COLONY NO 2 H # B-162 MUSLIM PARK', 'Faisalabad', '3310266557937', 'O+', '03038822422', '', '52933/L', '2016-07-22', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Fail', '11:28:44', '2016-10-19', ''),
(17, 17, '2016-09-07', '09:20:44', 'SHEHROZ AHMAD', 'MUHAMMAD MUMTAZ', 'CHAK NO. 210 R PO SAME JARANWALA', 'Faisalabad', '3310486588795', 'B+', '03438199353', '', '52387/L', '2016-07-21', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(18, 18, '2016-09-07', '09:22:14', 'MUHAMMAD ARSLAN SHAHID', 'SHAHID PERVEZ', 'CHAK NO. 482/GB PO SAME SAMUNDARI', 'Faisalabad', '3310502145447', 'AB+', '03074824500', '', '52334/L', '2016-07-21', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(19, 19, '2016-09-07', '09:30:26', 'JAVAED IQBAL', 'MUHAMMAD IQBAL', 'CHAK NO. 432/GB PO 230/GB JARANWALA ', 'Faisalabad', '3310442959147', 'B+', '03421752432', '', '46370/L', '2016-06-18', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(20, 20, '2016-09-07', '09:31:58', 'TABASSUM HUSSAIN', 'JAVED IQBAL BAJWA', 'CHAK NO.126/RB PO SAME CHAK JHUMRA', 'Faisalabad', '3310140942293', 'O+', '03336597551', '', '39886/L', '2016-05-23', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(21, 21, '2016-09-07', '09:34:01', 'ANWAR ALI', 'BASHIR AHMAD', 'H-328 BLOCK -G GULISTAN COLONY', 'Faisalabad', '3310081925787', 'B+', '03226854566', '', '34883/L', '2016-04-20', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(22, 22, '2016-09-07', '09:35:53', 'ABDUL REHMAN', 'IFTIKHAR HUSSAIN SIDDIQUEI', 'P-428 GULSHAN COLONY', 'Faisalabad', '3310286293033', 'O+', '0323693303', '', '42902/L', '2016-06-03', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(23, 23, '2016-09-07', '09:37:19', 'MUBASHAR HUSSAIN ARIF', 'MUHAMMAD ARIF', 'CHAK NO.280/RB PO SAME', 'Faisalabad', '3310068066955', 'O+', '03456742886', '', '2002/L', '2016-06-13', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(24, 24, '2016-09-07', '09:39:18', 'AWAIS ASGHAR', 'ASGHAR ALI', 'EAST CENALROAD SHAKAR STREET H NO 211 RAZA TOWN', 'Faisalabad', '3420291087939', 'AB+', '03466881129', '', '31374/L', '2016-03-31', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(25, 25, '2016-09-07', '09:41:12', 'MUHAMMAD AHMAD', 'ANJAM SHAHZADA', 'P-185/1 ST 2 MUSTAFA ABAD', 'Faisalabad', '3310003181113', 'O+', '03478999150', '', '43810', '2016-06-06', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(26, 26, '2016-09-07', '09:42:53', 'MUHAMMAD SHOAIB AMMAR', 'ABDUL RAUF', 'H NO P-211 ABDULLAH PARK JARAN WALA ', 'Faisalabad', '3310453031649', 'A+', '03069809205', '', '53904/L', '2016-07-26', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(27, 27, '2016-09-07', '09:44:30', 'AHTASHAM UL HAQ', 'SHABIR AHAMAD', 'CHAK 220 RB JHANG ROAD PATHAN WALA', 'Faisalabad', '3310231218253', 'A+', '03067106492', '', '49654/L', '2016-07-12', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(28, 28, '2016-09-07', '09:47:28', 'QAISAR ABBAS', 'QASIM ALI', 'H 167-B GHULAM MUHAMMAD ABAD IQBAL CHOWK SADAR BAZAR PO GM ABAD', 'Faisalabad', '3310009786891', 'A+', '03236665050', '', '28157/L', '2016-09-03', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(29, 29, '2016-09-07', '09:48:53', 'SOHAIB AHSAN', 'MAIN MUHAMMAD SHAKEEL', 'PTHAN WALA PO KHAS CHAK NO 220 RB ', 'Faisalabad', '3310252279589', 'B+', '03025619320', '', '33860/L', '2016-04-14', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(30, 30, '2016-09-07', '09:50:14', 'MUHAMMAD ADIL', 'IFKHTAR ALI', 'CHAK NO 233 RB HAREE SINGH WALA', 'Faisalabad', '3310354270597', 'A+', '03437738366', '', '28379/L', '2016-03-14', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(31, 31, '2016-09-07', '09:51:38', 'USAMA NAWAZ', 'MUHAMMAD NAWAZ', 'CHACK NO 220 RB JHANG ROAD FAREED TOWN', 'Faisalabad', '3310005239725', 'A+', '03143101096', '', '51797/L', '1970-01-01', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(32, 32, '2016-09-07', '09:53:22', 'MUHAMMAD TAQI ZAIDI', 'SYED IZHAR HAIDER ZAIDI', 'P-280 A BLOCK GULBERG COLONY', 'Faisalabad', '3310049981079', 'A+', ' 03213232311', '', '53988/L', '2016-07-26', 'Motor Car,', 900, '', '', '', '', '', '0000-00-00', ''),
(33, 33, '2016-09-07', '09:55:20', 'MUHAMMAD USMAN', 'AZMAT ALI', 'P-70 ST2 GOBIND PURA', 'Faisalabad', '3540187462769', 'B+', '03040469575', '', '53458/L', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(34, 34, '2016-09-07', '09:56:52', 'MUHAMMAD MOHSIN', 'ABDUL LATIF', 'STIANA ROAD ST 40 11 AHMAD NAGAR', 'Faisalabad', '3310003284939', 'B+', '03027135121', '', '43922/L', '2016-06-07', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(35, 35, '2016-09-07', '09:58:10', 'RASHID NAEEM', 'NAIK MUHMMAD', 'H# P-1029 GM ABAD NO.1', 'Faisalabad', '3310012022733', 'B+', '03213636000', '', '53279/L', '2016-07-23', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(36, 36, '2016-09-07', '09:59:30', 'MUHAMMAD ATEEQ', 'MUHAMMAD SHAFIQUE', 'CHAK 115 GB GOBIND PURA', 'Faisalabad', '3310472783601', 'O+', '03027082515', '', '53550/L', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(37, 37, '2016-09-07', '10:00:51', 'MUHAMMAD ASHRAF', 'MUHAMMAD ISHAQ', 'CHAK NO 68 GB TEH JARANWALA', 'Faisalabad', '4200004292469', 'A+', '03018436210', '', '53360/L', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(38, 38, '2016-09-07', '10:02:20', 'ALI RAZA ', 'MUHAMMAD SIDDIQUE', 'H NO 98 ST NO 4 HAJWERI TOWN ', 'Faisalabad', '331026145289', 'B+', '03451032655', '', '35076/L', '2016-04-21', 'Moter Cycle,', 550, '', '', '', '', '', '0000-00-00', ''),
(39, 39, '2016-09-07', '10:04:01', 'TASWAR ABBAS', 'ZAHOOR AHMAD', '421/GB JHOK DARA TANDLINWALA', 'Faisalabad', '3310646399139', 'O+', '03424587785', '', '37985/L', '2016-05-11', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(40, 40, '2016-09-07', '10:05:56', 'MUHAMMAD SARWAR SALEEM SHAD', 'MUHAMMAD DIN SHAD', 'P G-5 POSTAL COLONY 1 RAILWAY ROAD ', 'Faisalabad', '3310005497837', 'A+', '03009654743', '', '53389/L', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(41, 41, '2016-09-07', '10:08:22', 'ABUBAKAR SIIDDQUE', 'QUTAB ALI', 'CHAK 616 KOT GHAHLA TANDLIAN WALA ', 'Faisalabad', '3310688318587', 'A+', '03452505618', '', '53481/L', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(42, 42, '2016-09-07', '10:10:31', 'IQRA SHAHEEN', 'PERVAZ AKHTAR', 'CHAK NO. 28/JB ', 'Faisalabad', '3310271509318', 'B+', '03026241337', '', '53561/L', '2016-07-25', 'Motor Car,', 900, '', '', '', 'Pass', '10:51:21', '0000-00-00', ''),
(43, 43, '2016-09-07', '10:12:53', 'AHSAN UR RAHMAN', 'MUHAMMAD RAFIQ', '36-P JAMIL TOWN', 'Faisalabad', '3310247333665', 'B+', '0307-6007869', '', '64249/L', '2016-07-12', 'Motor Car,', 900, '', '', '', '', '', '0000-00-00', ''),
(44, 44, '2016-09-07', '10:15:03', 'MUHAMMAD MAJID SAEED', 'MUHAMMAD SAEED', 'P-131 ST 13 GURUNANAK PURA', 'Faisalabad', '3310270950573', 'O-', '03226227572', '', '48794/L', '2016-07-01', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(45, 45, '2016-09-07', '10:16:28', 'HAMZA MUDASSAR', 'MUDASSAR NAWAZ', 'H NO 40-C SAMAN ABAD', 'Faisalabad', '3310021568727', 'A+', '03015905399', '', '53392/L', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(46, 46, '2016-09-07', '10:18:39', 'MUHAMMAD IDREES', 'IMAM DEEN', 'P-1017 BLOCK D GM ABAD DILDAR CHOWK ', 'Faisalabad', '3310007201047', 'O+', '03007616452', '', '40306/L', '2016-05-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(47, 47, '2016-09-07', '10:20:23', 'ANEES AHMAD', 'ALTAF HUSSAIN', '786 TAILOR H 9-05 JINNAH COLONY', 'Faisalabad', '3310050650267', 'B+', '03024998786', '', '54125/L', '2016-07-26', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(48, 48, '2016-09-07', '10:22:23', 'ALI AHMAD', 'MATLOOB AHMAD', 'ST NO 1 SETLIT TOWN', 'Faisalabad', '3310295528523', 'B+', '03023431257', '', '53531/L', '2016-07-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(49, 49, '2016-09-07', '10:23:56', 'ALLAH TAWAKAL', 'MUHAMMAD ZAHOOR', '494 GB PO KHAS TEH TANDLIAN WALA', 'Faisalabad', '3310681945327', 'B+', '03320768073', '', '33306/L', '2016-04-12', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(50, 50, '2016-09-07', '10:25:34', 'MUHAMMAD SAEED AKHTAR', 'MUHAMMAD BASHIR', 'H NO P 192 LIAQAT TOWN A ', 'Faisalabad', '3310009649801', 'B+', '03036225889', '', '28761/L', '2016-03-16', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(51, 51, '2016-09-07', '10:27:11', 'MUHAMMAD AWAIS FAROOQ', 'FAROOQ SHOUKAT', 'CHAK 186 RB P-16 ST 1 RASOOL PURA', 'Faisalabad', '3310115466175', 'B+', '03458879021', '', '53877/L', '2016-07-26', 'Moter Cycle,', 550, '', '', '', 'Pass', '10:49:05', '0000-00-00', ''),
(52, 52, '2016-09-07', '10:29:19', 'ADNAN ALI', 'ASGHAR ALI', 'P-955 ST 2 REHMAN SHARIF ', 'Faisalabad', '3310202122457', 'A+', '03137797090', '', '49470/L', '2016-11-07', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(53, 53, '2016-09-07', '10:31:28', 'RIZWAN MAHMOOD ', 'MAHMOOD ALI', 'B-648 PEOPLES COLONY', 'Faisalabad', '3310270010721`', 'A-', '03076060648', '`', '1612/L', '2015-09-09', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(54, 54, '2016-09-07', '10:33:28', 'MUHAMMAD YAQOOB', 'AHMAD ALI', 'CHAK NO 150 RB MADOOANA PO KHAS TEH JARAN WALA', 'Faisalabad', '3310487224117', 'B+', '03441861340', '', '44592/L', '2016-06-10', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(55, 55, '2016-09-07', '10:35:14', 'SAAD HUSSAIN', 'TAJJMAL HUSSAIN', 'SARGODHA ROAD H NO P-2121/1 ST 17/A CIVIL LINE', 'Faisalabad', '3310008789799', 'O+', '03236644590', '', '30112/L', '2016-03-24', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(56, 56, '2016-09-07', '10:36:58', 'MUHAMMAD SAMI ULLAH', 'SHAHID JAVED', 'H NO B-45 GULISTAN COLONY NO 2', 'Faisalabad', '3310035289513', 'A+', '03044111191', '', '52889/L', '2016-07-22', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(57, 57, '2016-09-07', '10:38:46', 'AMMAD HUSSAIN', 'TAJAMMAL HUSSAIN', 'SARGODHA ROAD H P-2121/1 NEW CIVIL LINE', 'Faisalabad', '3310009835749', 'O+', '0336-8220229', '', '28011/L', '2016-03-11', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(58, 58, '2016-09-07', '10:40:43', 'SYED FARHAT HUSSAIN', 'SYED EJAZ HUSSAIN', 'UMAR BLOCK H NO P-79 ST 3 MUSLIM TOWN NO 1', 'Faisalabad', '3310077459541', 'B+', '03336533293', '', '53804/L', '2016-07-26', 'Moter Cycle,', 550, '', '', '', 'Pass', '10:47:19', '0000-00-00', ''),
(59, 59, '2016-09-07', '10:43:20', 'ZOHAIB WAQAS ASLAM', 'MUHAMMAD ASLAM', 'P-1380 KALEEM SHAHEED COLONY # 1', 'Faisalabad', '3310087921053', 'B+', '03346369681', '', '49440/L', '2016-07-11', 'Motor Car,', 900, '', '', '', '', '', '0000-00-00', ''),
(60, 60, '2016-09-07', '10:45:57', 'SULTAN MAHMOOD', 'ABDUL REHMAN', 'P-29/11 ST 2 HAJVERI TOWN', 'Faisalabad', '3310009192047', 'B+', '03217851469', '', '43736/L', '2016-06-06', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(61, 61, '2016-09-07', '10:51:00', 'MUHAMMAD SHAZAM', 'SAJID NAEEM', 'H NO P-26 ST 4 RABBANI COLONY', 'Faisalabad', '3310248523959', 'B+', '031677476307', '', '43901/L', '2016-06-07', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(62, 62, '2016-09-07', '10:54:37', 'MUHAMMAD TALHA MAHBOOB', 'MAHBOOB ELAHI', 'H NO P-946 ST 5 NEGHBAN PURA ', 'Faisalabad', '3310007382371', 'A+', '03157055814', '', '48924/L', '2016-07-02', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(63, 63, '2016-09-07', '10:56:07', 'MUHAMMAD RAZA ASLAM', 'MUHAMMAD ASLAM RANA', 'P-1/5DW EDEN GARDEN ', 'Faisalabad', '3310237228329', 'B-', '03032650616', '', '53207/L', '2016-07-23', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(64, 64, '2016-09-07', '10:59:24', 'HAFIZ MUHAMMAD ARSLAN YOUSAF', 'MUHAMMAD YOUSAF', 'P-4097 ST 8 MANSOOR ABAD ', 'Faisalabad', '3310262125493', 'B+', '03067133306', '', '46424/L', '2016-06-18', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Pass', '11:03:17', '0000-00-00', ''),
(65, 65, '2016-09-07', '11:00:57', 'MUHAMMAD RIZWAN', 'MUHAMMAD ZAFAR', 'CHAK NO 99 GB PO KHAS TEH JARAN WALA ', 'Faisalabad', '3310406815239', 'B+', '03004501380', '', '43911/L', '2016-06-07', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(66, 66, '2016-09-07', '11:05:38', 'ALI ZAID NAZIR', 'NAZIR AHMAD', 'SARGODHA ROAD ST 1 MUSTAFA ABAD', 'Faisalabad', '3310425091967', 'O+', '03327432076', '', '52943/L', '2016-07-22', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(67, 67, '2016-09-07', '11:07:43', 'WALEED AHMAD', 'NASIR MAHMOOD', 'GHAZI CHOWK H124 GM ABAD BLOCK D ', 'Faisalabad', '3310043577787', 'B+', '03217337299', '', '52923/L', '2016-07-22', 'Moter Cycle,', 550, '', '', '', '', '', '0000-00-00', ''),
(68, 68, '2016-09-07', '11:11:12', 'LUQMAN ALI', 'MUHAMAMD HUSSAIN', 'CHAK NO.229/RB TEH JARAWALA ', 'Faisalabad', '331044418043', 'A+', '03402236603', '', '54014/L', '2016-07-26', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(69, 69, '2016-09-07', '11:50:15', 'ABDULLAH ASHRAF', 'MUHAMMAD ASRAF', '262 RB', 'Faisalabad', '3310348848823', 'O+', '03087271622', '', '47212/L', '2016-06-23', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(70, 70, '2016-09-07', '07:28:11', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '', 'panah786@gmail.com', '200-98', '2016-08-25', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Pass', '07:35:56', '2016-10-19', ''),
(71, 71, '2016-09-07', '07:45:20', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-08-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(72, 72, '2016-09-07', '07:49:18', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-08-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(73, 73, '2016-09-07', '07:49:23', '', '', '', '', '', '', '', '', '', '1970-01-01', '', 0, '', '', '', '', '', '0000-00-00', ''),
(74, 74, '2016-09-07', '07:49:30', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-08-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(75, 75, '2016-09-07', '07:50:54', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-08-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(76, 76, '2016-09-07', '07:51:16', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-08-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(77, 77, '2016-09-07', '07:58:25', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-08-25', 'Moter Cycle,Motor Car,', 950, '', '', '', 'Fail', '10:51:16', '2016-10-20', ''),
(78, 78, '2016-09-07', '07:59:47', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-08-25', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(79, 79, '2016-09-08', '07:19:46', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-09-02', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(80, 80, '2016-09-08', '07:21:17', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-09-08', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(81, 81, '2016-09-17', '10:50:30', 'Iftikhar Ahmad', 'Muhammad Ramzan', 'P-75 Liaqat Road Faisalabad', 'Faisalabad', '33100-84037678-', 'A+', '0321-6681663', 'panah786@gmail.com', '200-98', '2016-09-15', 'Moter Cycle,Motor Car,', 950, '', '', '', '', '', '0000-00-00', ''),
(82, 82, '2016-09-17', '10:52:05', '', '', '', '', '', '', '', '', '200-98', '1970-01-01', 'Moter Cycle,Motor Car,', 0, '', '', '', '', '', '0000-00-00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candata`
--
ALTER TABLE `candata`
 ADD UNIQUE KEY `id` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candata`
--
ALTER TABLE `candata`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=83;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
