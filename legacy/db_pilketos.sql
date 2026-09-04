-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2019 at 06:37 PM
-- Server version: 10.2.24-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mahmudal_pilketos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `mail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `user`, `pass`, `mail`) VALUES
(1, 'Administrator', 'admin', '$2y$10$DebigZP2keqA7vrn.OtHke5xpM836B28RYlVqbAqXUPPZ5cuwBOP2', 'mail@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `calon`
--

CREATE TABLE `calon` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `organisasi` varchar(50) NOT NULL,
  `visi` varchar(5000) NOT NULL,
  `misi` varchar(5000) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `hasil` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calon`
--

INSERT INTO `calon` (`id`, `nama`, `kelas`, `organisasi`, `visi`, `misi`, `foto`, `hasil`) VALUES
(1, 'Ujang Saepul B - Fitri Nurajijah', 'XI TKJ - X TB', 'OSIS', '<p>\"Menciptakan lingkungan SMK Plus Al-Maftuh yang NYAMAN, HARMONIS, BERSIH, AKTIF, BERPRESTASI dengan berlandasan IMAN dan TAQWA\"</p>', '<p>-1). Menumbuhkan Keimanan dan Ketaqwaan.</p>\r\n<p>-2). Meningkatkan kesadaran mengenai kebersihan sekolah.</p>\r\n<p>-3). Memperkuat rasa kekeluargaan antar siswa.</p>\r\n<p>-4). Mengembangkan kegiatan Ekstrakurikuler yang menambah erat hubungan antar siswa.</p>\r\n<p>-5). Mengembangkaan bakat dan potensi yang di miliki siswa untuk lebih berprestasi.</p>\r\n<p>-6). Memunculkan kegiatan - kegiatan Agama untuk memperkokoh IMAN kepada Allah Swt;</p>\r\n<p>-7). Melanjutkan program Osis yang belum selesai di priode sebelumnya.</p>', '../Assets/img/calon/1.jpg', '47'),
(2, 'Siti Oktavia - Eva', 'XI TKJ - X TB', 'OSIS', '<p>- Menjadikan osis sebagai sarana penampung kreativitas, inspirasi,dan aspirasi. juga meningkatkan sekolah sebagai sekolah yg bermutu. berani tampil beda, berakhlak mulia, jujur, adil, dan disiplin</p>\r\n<p>- menjadi penghubung antar siswa/i dan guru.</p>', '<p>- Menjadikan smk plus al-maftuh sebagai wadah aspirasi siswa/i</p>\r\n<p>- Mengajak siswa/i untuk aktif di ekstrakulikuler</p>\r\n<p>- Meningkatkan kinerja serta kerja sama khususnya dalam berorganisasi&nbsp;</p>\r\n<p>- Melanjutkan dan melaksanakan program kerja yang belum terlaksana oleh osis sebelumnya.</p>', '../Assets/img/calon/2.jpg', '7'),
(3, 'Lusi Lawati - Ujang Yusup', 'XI TKJ - X TKJ', 'OSIS', '<p>- Meningkatkan kesadaran dan kualitas Siswa Siswi Smk Plus Al- Maftuh Menjadi Lebih Di Siplin Waktu, Disiplin Tenaga Dengan Menjadi Kan Contoh Teladan Bagi Sekolah Lain&nbsp;</p>\r\n<p>- Menjadi Pemimpin Yang Tegas Dan Dapat Di Percaya Dan Bisa Ber Tanggung Jawab Dalam Kinerja OSIS</p>', '<p>- Membantu Siswa Siswi Smk Plus Al- Maftuh Lebih Giat Dalam Melaksanakan Salat Duha dan Ber Jamaah Dzhur</p>', '../Assets/img/calon/3.jpg', '4'),
(4, 'Saepul Bahri - Rusmana', 'XI TB - X TB', 'Pramuka', '<p>Menjadi SMK (SMK PLUS AL-MAFTUH) berkualitas, aktif, berprestasi dengan berlandaskan iman dan takwa.</p>', '<p>1.menumbuhkan keimanan dan ketakwaan pada tuhan</p>\r\n<p>2.memperkuat rasa kekkeluargaan antar siswa</p>\r\n<p>3.menanamkan sikap di siplin pada semua siswa</p>\r\n<p>4.meningkat kan kesadaran siswa tentang kebersihan sekolah&nbsp;</p>\r\n<p>5.mengembangkan bakat dan potensi yang di miliki siswa</p>\r\n<p>6.melanjutkan program osis yang belum selesai di priode sebelum nya</p>\r\n<p>7.memajukn prestasi sekolah dalam segala bidang</p>', '../Assets/img/calon/4.jpg', '17');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `nis` char(10) NOT NULL,
  `nama2` varchar(25) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `jk` varchar(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `nis`, `nama2`, `nama`, `kelas`, `jk`, `status`) VALUES
(1, '34566', 'AGNAN AFTORI', '34566', 'XI-TKJ', 'L', 0),
(2, '11355', 'ANISA HIDAYANTI', '11355', 'XI-TKJ', 'P', 0),
(3, '11111', 'FITRI NS', '11111', 'XI-TKJ', 'P', 0),
(4, '24067', 'HERAWATI', '24067', 'XI-TKJ', 'P', 0),
(5, '76899', 'HILMANSYAH', '76899', 'XI-TKJ', 'L', 1),
(6, '22335', 'INE FEBRIYANTI', '22335', 'XI-TKJ', 'P', 0),
(7, '98799', 'KARINA S', '98799', 'XI-TKJ', 'P', 0),
(8, '34555', 'LUSI LAWATI', '34555', 'XI-TKJ', 'P', 0),
(9, '90087', 'MOH.ANWAR S', '90087', 'XI-TKJ', 'L', 0),
(10, '11119', 'MUIZ', '11119', 'XI-TKJ', 'L', 0),
(11, '67993', 'NENGSIH', '67993', 'XI-TKJ', 'P', 0),
(12, '70023', 'NURSUHAESTI', '70023', 'XI-TKJ', 'P', 0),
(13, '67452', 'RAHMAN HAKIM', '67452', 'XI-TKJ', 'L', 0),
(14, '23547', 'NYAI SANTI', '23547', 'XI-TKJ', 'P', 0),
(15, '66781', 'RINI ANGGRAENI', '66781', 'XI-TKJ', 'P', 0),
(16, '64538', 'SAEPUL MAKI', '64538', 'XI-TKJ', 'L', 0),
(17, '65909', 'SIFA DEWI', '65909', 'XI-TKJ', 'P', 0),
(18, '21253', 'SITI KARMILAH', '21253', 'XI-TKJ', 'P', 0),
(19, '67954', 'SITI OKTAVIA', '67954', 'XI-TKJ', 'P', 0),
(20, '76592', 'UDIN CEPRUDIN', '76592', 'XI-TKJ', 'L', 0),
(21, '67554', 'UJANG SB', '67554', 'XI-TKJ', 'L', 0),
(22, '45457', 'UJANG SUPRIADI', '45457', 'XI-TKJ', 'L', 0),
(23, '12788', 'YOGA SUPRIATIN', '12788', 'XI-TKJ', 'L', 0),
(24, '67569', 'YOGI PRAM', '67569', 'XI-TKJ', 'L', 0),
(25, '90981', 'AI AIDAH', '90981', 'XI-TB', 'P', 0),
(26, '25261', 'DEWI RAHMAWATI', '25261', 'XI-TB', 'P', 0),
(27, '70709', 'RAHMAWATI', '70709', 'XI-TB', 'P', 0),
(28, '23245', 'RANI KARISMA', '23245', 'XI-TB', 'P', 0),
(29, '12345', 'SAEPUL BAHRI', '12345', 'XI-TB', 'L', 0),
(30, '22652', 'SITI LASMINI A', '22652', 'XI-TB', 'P', 0),
(31, '18032', 'SITI LASMINI B', '18032', 'XI-TB', 'P', 0),
(32, '76765', 'SITI NURJANNAH', '76765', 'XI-TB', 'P', 0),
(33, '10011', 'SITI RJ', '10011', 'XI-TB', 'P', 0),
(34, '54543', 'SITI ZENAB', '54543', 'XI-TB', 'P', 0),
(35, '97978', 'ANI HANDAYANI', '97978', 'X-TKJ', 'P', 0),
(36, '97687', 'DEDE NURJAMAN', '97687', 'X-TB', 'L', 1),
(37, '34345', 'DERI ILHAM', '34345', 'X-TKJ', 'L', 0),
(38, '12123', 'ELI WULANSRI', '12123', 'X-TB', 'P', 0),
(39, '98765', 'EVA', '98765', 'X-TB', 'P', 0),
(40, '46467', 'EVI', '46467', 'X-TB', 'P', 0),
(41, '17106', 'FITI NURAJIJAH', '17106', 'X-TB', 'P', 0),
(42, '23231', 'HIDAYAH N', '23231', 'X-TB', 'P', 0),
(43, '89897', 'M RIAN RAHMADAN', '89897', 'X-TKJ', 'L', 1),
(44, '57567', 'M SIDIK', '57567', 'X-TKJ', 'L', 0),
(45, '24558', 'NENG YULI F', '24558', 'X-TKJ', 'P', 0),
(46, '78799', 'RINI ', '78799', 'X-TKJ', 'P', 0),
(47, '54459', 'RUSMANA', '54459', 'X-TB', 'L', 0),
(48, '66549', 'SITI NURAJIJAH', '66549', 'X-TB', 'P', 0),
(49, '87679', 'SITI NURHALIJAH', '87679', 'X-TB', 'P', 0),
(50, '22431', 'SRI RESTI H', '22431', 'X-TKJ', 'P', 0),
(51, '67634', 'SUSILAWATI', '67634', 'X-TB', 'P', 0),
(52, '14143', 'UJANG SAMSU', '14143', 'X-TB', 'L', 0),
(53, '17179', 'UJANG YUSUP', '17179', 'X-TKJ', 'L', 0),
(54, '61615', 'WAHYUDIN', '61615', 'X-TKJ', 'L', 0),
(55, '76762', 'YUSI SULISTIAWATI', '76762', 'X-TKJ', 'P', 0),
(56, '80938', 'SOPIAN SAURI', '80938', 'X-TKJ', 'L', 0),
(57, '78942', 'RANI FEBRIANTI', '78942', 'X-TKJ', 'P', 0),
(58, '54591', 'VITA JUARIAH', '54591', 'X-TB', 'P', 1),
(59, '13807', 'AGUS SUPANDI', '13807', 'X-TB', 'L', 0),
(60, '16756', 'CEP YUDI', '16756', 'X-TKJ', 'L', 0),
(61, 'mahmud', 'Mahmud Al Fauzi', 'mahmud', 'Guru 1', 'L', 0),
(62, 'kepsek', 'Asep Abdul Aziz', 'kepsek', 'Kepsek', 'L', 0),
(63, 'nurah', 'Nurah', 'nurah', 'Guru 2', 'P', 0),
(64, 'hasbi', 'Yusep Hasbi', 'hasbi', 'Guru 3', 'L', 0),
(65, 'ramli', 'Asep Ramli', 'ramli', 'Guru 4', 'L', 0),
(66, 'buya', 'Asep Romansyah', 'buya', 'Guru 5', 'L', 0),
(67, 'haris', 'M. Harisman', 'haris', 'Guru 6', 'L', 0),
(68, 'usman', 'Usman Pariz', 'usman', 'Guru 7', 'L', 0),
(69, 'mira', 'Mira', 'mira', 'Guru 8', 'P', 0),
(70, 'jaya', 'Jaya Ismail', 'jaya', 'Guru 9', 'L', 0),
(71, 'irma', 'Irma Damayanti', 'irma', 'Guru 10', 'P', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calon`
--
ALTER TABLE `calon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `calon`
--
ALTER TABLE `calon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
