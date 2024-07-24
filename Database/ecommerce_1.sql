-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 22 Jul 2024 pada 16.48
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_image` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_email`, `admin_image`, `admin_password`) VALUES
(1, 'bambang', 'bambangpamungkas@gmail.com', 'Screenshot 2024-01-14 234637.png', '$2y$10$5eUZzTHdZ4pcWBJUId61.eyXj9Aqak8PXhl5MoK3bb7E9kH8NX4Su');

-- --------------------------------------------------------

--
-- Struktur dari tabel `card_details`
--

CREATE TABLE `card_details` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'Air Conditioner'),
(2, 'Mesin Cuci'),
(3, 'Kipas Angin'),
(4, 'Blender'),
(5, 'Dispenser'),
(6, 'Kulkas'),
(7, 'Kompor'),
(8, 'Barang Lainnya'),
(9, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders_pending`
--

INSERT INTO `orders_pending` (`order_id`, `user_id`, `invoice_number`, `product_id`, `quantity`, `order_status`, `payment_status`) VALUES
(1, 1, 312346784, 1, 3, 'shipped', 'paid'),
(2, 1, 312346784, 2, 1, 'shipped', 'paid'),
(3, 1, 312346784, 4, 1, 'pending', 'unpaid'),
(4, 1, 1918753782, 3, 2, 'shipped', 'paid'),
(5, 1, 351837813, 1, 2, 'pending', 'unpaid'),
(6, 1, 1956894777, 3, 1, 'pending', 'unpaid'),
(7, 1, 925238006, 2, 3, 'pending', 'unpaid'),
(8, 1, 2110701984, 16, 1, 'Complete', 'paid'),
(9, 1, 2110701984, 18, 1, 'Complete', 'paid'),
(10, 1, 527646053, 4, 1, 'pending', 'unpaid'),
(11, 1, 1453008452, 12, 1, 'pending', 'unpaid'),
(12, 1, 614135190, 5, 1, 'Complete', 'paid'),
(13, 1, 1712862959, 12, 1, 'pending', 'unpaid'),
(14, 1, 1195320358, 3, 1, 'pending', 'unpaid'),
(15, 1, 1390098675, 18, 1, '0', 'unpaid'),
(16, 1, 1383536425, 18, 1, '0', 'unpaid'),
(17, 1, 200864925, 18, 1, '0', 'unpaid'),
(18, 1, 1852252016, 18, 1, '0', 'unpaid'),
(19, 1, 1467869411, 18, 1, '0', 'unpaid'),
(20, 1, 2054947705, 18, 1, '0', 'unpaid'),
(21, 1, 189429762, 18, 1, '0', 'unpaid'),
(22, 1, 1279647897, 18, 1, '0', 'unpaid'),
(23, 1, 399362416, 18, 1, '0', 'unpaid'),
(24, 1, 261406503, 18, 1, '0', 'unpaid'),
(25, 1, 2079606849, 18, 1, 'pending', 'unpaid'),
(26, 1, 698795857, 18, 1, 'pending', 'unpaid'),
(27, 1, 506104160, 18, 1, 'pending', 'unpaid'),
(28, 1, 828412881, 18, 1, 'pending', 'unpaid'),
(29, 1, 633673624, 18, 1, 'pending', 'unpaid'),
(30, 1, 889394914, 18, 1, 'pending', 'unpaid'),
(31, 1, 2062748953, 18, 1, 'pending', 'unpaid'),
(32, 1, 1572881218, 18, 1, 'pending', 'unpaid');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(120) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_image_one` varchar(255) NOT NULL,
  `product_image_two` varchar(255) NOT NULL,
  `product_image_three` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `brand_id`, `product_image_one`, `product_image_two`, `product_image_three`, `product_price`, `date`, `status`) VALUES
(1, 'AC SHARP Drain Selang Pembuangan Air slang 1/2', 'Selang Pembuangan Air slang 1/2 untuk merk sharp dijamin original', 'Selang, AC, Sharp', 1, 4, '3dc6e594-7ba6-4c38-88e0-b619e6d44a9a.jpg', '3dc6e594-7ba6-4c38-88e0-b619e6d44a9a.jpg', '3dc6e594-7ba6-4c38-88e0-b619e6d44a9a.jpg', 3000, '2024-07-11 20:44:15', 'true'),
(2, 'Bracket Ac Dudukan Outdoor Ac 12 - 15 Pk Bracket Siku Ac 1 Set', 'Bracket Siku Ac 1 Set dijamin kokoh dan tahan lama', 'Breket, AC', 1, 13, '85bd5c9f-dd11-4521-ae62-41040e6b648d.jpg', '85bd5c9f-dd11-4521-ae62-41040e6b648d.jpg', '85bd5c9f-dd11-4521-ae62-41040e6b648d.jpg', 43000, '2024-07-08 09:22:28', 'true'),
(3, 'Kapasitor kipas angin miyako 2.5 uf', 'Kapasitor untuk kipas angin miyako dijamin original', 'Kipas angin, Miyako, Kapasitor', 3, 13, 'bc254f27-01c5-423c-b6b9-62c1f4201e85.jpg', 'bc254f27-01c5-423c-b6b9-62c1f4201e85.jpg', 'bc254f27-01c5-423c-b6b9-62c1f4201e85.jpg', 12000, '2024-07-08 09:22:15', 'true'),
(4, 'SHARP ES-T70CL GEAR BOX Mesin Cuci 2 Dua Tabung', 'Gear Box mesin cuci untuk sharp dijamin ori', 'Sharp, Gear Box, Mesin Cuci', 2, 4, '917af642-787b-4068-8080-fb6bc62677c3.jpg', '917af642-787b-4068-8080-fb6bc62677c3.jpg', '917af642-787b-4068-8080-fb6bc62677c3.jpg', 150000, '2024-07-08 09:25:31', 'true'),
(5, 'TIMER MESIN CUCI LG 2 TABUNG', 'timer mesin cuci milik LG 2 tabung, Timer ganda atau double dijamin ori', 'Mesin Cuci, Timer, LG', 2, 5, 'S36b6476e04bf4d7ea587c2c2d012f7cbE.jpg_720x720q80.jpg', 'S36b6476e04bf4d7ea587c2c2d012f7cbE.jpg_720x720q80.jpg', 'S36b6476e04bf4d7ea587c2c2d012f7cbE.jpg_720x720q80.jpg', 80000, '2024-07-08 09:28:27', 'true'),
(6, 'Baling Kipas As Mesin Blender Miyako', 'BALING KIPAS AS MOTOR MESIN BLENDER MIYAKO ORIGINAL', 'Baling Kipas, Blender, Miyako', 4, 13, '5c1c0257-123e-4c47-ac8d-9188ee222d7f.jpg', '5c1c0257-123e-4c47-ac8d-9188ee222d7f.jpg', '5c1c0257-123e-4c47-ac8d-9188ee222d7f.jpg', 12000, '2024-07-08 09:30:47', 'true'),
(7, 'Kran Dispenser Cosmos Original Tanpa mur', 'Kran Dispenser untuk Cosmos Original Tanpa mur original', 'Dispenser, Cosmos,Kran', 5, 8, 'images.jpg', 'images.jpg', 'images.jpg', 29000, '2024-07-08 09:32:35', 'true'),
(8, 'Gelas Blender Plastik Philips HR 2115 / HR 2116 / HR 2061 / HR 2071', 'Gelas Blender Plastik Philips HR 2115 / HR 2116 / HR 2061 / HR 2071 original dan tahan lama', 'Blender, Philips, Gelas', 4, 13, 'data.jpeg.webp', 'data.jpeg.webp', 'data.jpeg.webp', 69000, '2024-07-08 09:36:27', 'true'),
(9, 'Filter Kulkas Sharp', 'Filter kulkas sharp kwalitas premium', 'Kulkas, Sharp, Filter', 6, 4, 'f79bc725a1a34094c3e0ad1ae380ef55.jpg', 'f79bc725a1a34094c3e0ad1ae380ef55.jpg', 'f79bc725a1a34094c3e0ad1ae380ef55.jpg', 12000, '2024-07-08 09:39:38', 'true'),
(10, 'Tatakan Kompor Bahan Besi Universal ', 'Tatakan Kompor Bahan Besi Universal Stovetop Trivet Tatakan Kompor gas Bahan Besi Tatakan', 'Kompor, Tatakan, Besi', 7, 13, 'data.jpeg (1).webp', 'data.jpeg (1).webp', 'data.jpeg (1).webp', 20000, '2024-07-08 09:45:29', 'true'),
(11, 'HUAYU Remote TV Universal Semua Merk', 'HUAYU Remote TV Universal Semua Merk TV LED/LCD Netflix Youtube - RM-L1130+X Plus - Black', 'TV, Remote, Universal', 8, 13, 'images (1).jpg', 'images (1).jpg', 'images (1).jpg', 34000, '2024-07-08 09:48:37', 'true'),
(12, 'Semua Jenis Steker ', 'sedia semua jenis steker', 'Sketer', 8, 13, 'jenis jenis steker.png', 'jenis jenis steker.png', 'jenis jenis steker.png', 15000, '2024-07-08 10:11:47', 'true'),
(13, 'ISKU Obeng Test with Indicator Dual LED Tespen Listrik', 'ISKU Obeng Test Pencil Tester TesPen Obeng Tes with Indicator Dual LED Tespen Listrik Multifungsi', 'Tespen, Obeng, Isku', 8, 13, 'images (2).jpg', 'images (2).jpg', 'images (2).jpg', 12000, '2024-07-08 09:54:58', 'true'),
(14, 'Lampu Plafon LED Panel', 'Lampu Plafon LED Panel 24W 36W 50W lampu plafon Bulat Outbow 3 Cahaya', 'Lampu LED', 8, 13, 'no-brand_no-brand_full06.webp', 'no-brand_no-brand_full06.webp', 'no-brand_no-brand_full06.webp', 360000, '2024-07-08 09:56:21', 'true'),
(15, 'LAMPU DOWNLIGHT LED 18W KOTAK INLITE IN-LITE ', 'LAMPU DOWNLIGHT LED PANEL 18 WATT 18W KOTAK INLITE IN-LITE - Putih', 'Lampu, LED, 18 WATT', 8, 13, '8c27ddde-f149-480e-89ac-8c4c0a09adae.jpg', '8c27ddde-f149-480e-89ac-8c4c0a09adae.jpg', '8c27ddde-f149-480e-89ac-8c4c0a09adae.jpg', 96000, '2024-07-08 09:58:45', 'true'),
(16, 'Duct tape Merk Saiki', 'Duct tape non adhesive Isolasi pipa ac non lem Lakban pipa ac non lengket Merk Saiki', 'Duct Tape', 8, 13, 'duct-tape.webp', 'duct-tape.webp', 'duct-tape.webp', 10000, '2024-07-08 10:00:54', 'true'),
(17, 'Mr.Safety Paku Beton 5 Cm', 'Mr.Safety Paku Beton Hitam 5 Cm', 'Paku, Beton', 8, 13, '239433_1.webp', '239433_1.webp', '239433_1.webp', 25000, '2024-07-08 10:04:16', 'true'),
(18, 'Dynabolt Dinabolt Berbagai Ukuran', 'Dynabolt untuk Pengencang ke Tembok dan Beton', 'Dynabolt', 8, 13, 'dynabolt.jpg', 'dynabolt.jpg', 'dynabolt.jpg', 2000, '2024-07-08 10:07:02', 'true'),
(19, 'Antena TV Digital', 'Antena TV Digital', 'TV, Antena', 8, 13, '2bb414b8d97b6c57c1f407455eeace53.jpg', '2bb414b8d97b6c57c1f407455eeace53.jpg', '2bb414b8d97b6c57c1f407455eeace53.jpg', 300000, '2024-07-08 10:08:54', 'true'),
(20, 'REMOT AC SHARP', 'REMOTE/REMOT AC SHARP CHINA YB1FA/AC SHARP AU-A5UCY/AU-A9UCY/AU-A12UCY/AU-A24UCY', 'Remot, AC, Sharp', 1, 4, '85bee4eb500f39b3f2ac5ed817e06e2f.jpg', '85bee4eb500f39b3f2ac5ed817e06e2f.jpg', '85bee4eb500f39b3f2ac5ed817e06e2f.jpg', 40000, '2024-07-08 10:10:51', 'true');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_price` int(255) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` enum('Belum Dibayar','Sudah Dibayar','Produk Dikirim','Produk Diterima','Menyiapkan Produk') DEFAULT 'Belum Dibayar',
  `amount_due` decimal(10,2) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `payment_receipt` varchar(255) NOT NULL,
  `payment_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `product_price`, `invoice_number`, `total_products`, `order_date`, `order_status`, `amount_due`, `payment_mode`, `payment_receipt`, `payment_status`) VALUES
(8, 1, 15000, 1453008452, 1, '2024-07-22 05:05:33', 'Sudah Dibayar', 10000.00, 'BTN', 'images (1).jpg', 'paid'),
(10, 1, 15000, 1712862959, 1, '2024-07-22 05:05:48', 'Produk Diterima', 100000.00, 'BRI', 'WhatsApp Image 2024-07-16 at 23.43.52.jpeg', NULL),
(11, 1, 12000, 1195320358, 1, '2024-07-22 04:12:48', 'Belum Dibayar', 0.00, '', '', NULL),
(12, 1, 2000, 1572881218, 1, '2024-07-22 04:26:09', 'Belum Dibayar', 0.00, '', '', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_payments`
--

CREATE TABLE `user_payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_receipt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_payments`
--

INSERT INTO `user_payments` (`payment_id`, `order_id`, `invoice_number`, `amount`, `payment_method`, `payment_date`, `payment_receipt`) VALUES
(8, 9, 614135190, 100000, 'Bank Mandiri', '2024-07-22 04:57:44', 'WhatsApp Image 2024-07-16 at 23.32.45.jpeg'),
(9, 10, 1712862959, 100000, 'BRI', '2024-07-22 04:59:18', 'WhatsApp Image 2024-07-16 at 23.43.52.jpeg'),
(10, 8, 1453008452, 10000, 'BTN', '2024-07-22 05:04:48', 'images (1).jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_mobile` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `user_email`, `user_password`, `user_image`, `user_ip`, `user_address`, `user_mobile`) VALUES
(1, 'bambang', 'bambangpamungkas@gmail.com', '$2y$10$l/G21riLGCefT0HbWEhS7OBSc5JQhQL2skBz3aAbZWZkTy32428N2', 'Nitro_Wallpaper_02_3840x2400.jpg', '::1', 'jalan jalan sama kamu', '088888546274');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeks untuk tabel `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indeks untuk tabel `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indeks untuk tabel `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indeks untuk tabel `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
