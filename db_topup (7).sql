-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jan 2026 pada 12.51
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
-- Database: `db_topup`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-config_apigames_merchant', 's:17:\"M220704FEUE9178NP\";', 1767450721),
('laravel-cache-config_apigames_secret', 's:64:\"bd6fbd73d36bfdb7aa818288c604fe5543f977f8ace024bdeccfbfec9185d7d6\";', 1767450721),
('laravel-cache-config_app_banner', 's:69:\"/storage/images/settings/MVKwmLuUA43ws9w0yh33e8UXC4RPgc3E7qV6k2qF.jpg\";', 1767614142),
('laravel-cache-config_app_logo', 'N;', 1767615263),
('laravel-cache-config_app_name', 's:11:\"Zoestore Id\";', 1767614146),
('laravel-cache-config_digiflazz_key', 's:36:\"ea5dc837-f75c-565f-b663-c272a9433cb4\";', 1767450719),
('laravel-cache-config_digiflazz_mode', 's:10:\"production\";', 1767450719),
('laravel-cache-config_digiflazz_username', 's:12:\"zeyumoD22vqD\";', 1767450719),
('laravel-cache-config_footer_description', 's:42:\"Website Topup Game Tercepat Dan Terpercaya\";', 1767614146),
('laravel-cache-config_gateway_midtrans_active', 's:1:\"0\";', 1767615316),
('laravel-cache-config_gateway_tripay_active', 's:1:\"1\";', 1767615316),
('laravel-cache-config_gateway_xendit_active', 's:1:\"0\";', 1767615316),
('laravel-cache-config_is_maintenance', 'N;', 1767615316),
('laravel-cache-config_midtrans_client_key', 's:30:\"SB-Mid-client-9FHjNP_lmvaXd6_F\";', 1767608151),
('laravel-cache-config_midtrans_mode', 's:7:\"sandbox\";', 1767608151),
('laravel-cache-config_midtrans_server_key', 's:38:\"SB-Mid-server-VHc_ltMQIJFnI9EE0KggMava\";', 1767608151),
('laravel-cache-config_page_about', 's:794:\"Zoestore ID adalah platform top up game terpercaya yang menyediakan berbagai kebutuhan game favorit Anda dengan proses cepat, aman, dan harga terjangkau. Kami hadir untuk memberikan pengalaman top up yang mudah tanpa ribet, sehingga Anda bisa lebih fokus menikmati permainan.\r\n\r\nDengan sistem otomatis dan metode pembayaran yang beragam, Zoestore ID memastikan setiap transaksi diproses secara instan dan aman. Kami melayani berbagai game populer dengan dukungan layanan pelanggan yang responsif dan siap membantu kapan saja.\r\n\r\nKomitmen kami adalah memberikan layanan terbaik, kecepatan transaksi, serta kepuasan pelanggan sebagai prioritas utama. Zoestore ID terus berinovasi untuk menjadi pilihan utama para gamer di Indonesia.\r\n\r\nTop up cepat, aman, dan terpercaya — hanya di Zoestore ID.\";', 1767614146),
('laravel-cache-config_page_faq', 's:834:\"1. Apa itu Zoestore ID?\r\nZoestore ID adalah website top up game online yang cepat dan terpercaya.\r\n\r\n2. Apakah Zoestore ID aman?\r\nYa, kami menggunakan sistem pembayaran yang aman.\r\n\r\n3. Bagaimana cara top up?\r\nPilih game, masukkan User ID, pilih pembayaran, lalu selesaikan transaksi.\r\n\r\n4. Berapa lama proses top up?\r\nSebagian besar diproses secara instan.\r\n\r\n5. Apakah perlu login?\r\nTidak, top up bisa dilakukan tanpa registrasi.\r\n\r\n6. Metode pembayaran apa saja?\r\nE-wallet, transfer bank, dan metode digital lainnya.\r\n\r\n7. Jika top up belum masuk?\r\nHubungi customer service dengan bukti transaksi.\r\n\r\n8. Apakah bisa refund?\r\nRefund hanya untuk kesalahan dari pihak Zoestore ID.\r\n\r\n9. Apakah harga bisa berubah?\r\nYa, harga dapat berubah sewaktu-waktu.\r\n\r\n10. Bagaimana menghubungi CS?\r\nMelalui kontak resmi yang tersedia di website.\";', 1767614146),
('laravel-cache-config_page_privacy', 's:1187:\"Zoestore ID menghargai dan melindungi privasi setiap pengguna. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi pengguna.\r\n\r\n1. Informasi yang Dikumpulkan\r\n- User ID dan Server ID game\r\n- Data transaksi dan metode pembayaran\r\n- Data teknis seperti alamat IP dan aktivitas website\r\n\r\n2. Penggunaan Informasi\r\nInformasi digunakan untuk memproses transaksi, meningkatkan layanan, serta keperluan keamanan dan dukungan pelanggan.\r\n\r\n3. Keamanan Data\r\nKami menerapkan sistem keamanan yang wajar untuk melindungi data pengguna dari akses yang tidak sah.\r\n\r\n4. Pembagian Informasi\r\nZoestore ID tidak menjual data pengguna kepada pihak ketiga, kecuali untuk proses pembayaran atau kewajiban hukum.\r\n\r\n5. Cookie\r\nWebsite dapat menggunakan cookie untuk meningkatkan pengalaman pengguna.\r\n\r\n6. Hak Pengguna\r\nPengguna berhak meminta informasi, perbaikan, atau penghapusan data sesuai hukum yang berlaku.\r\n\r\n7. Perubahan Kebijakan\r\nKebijakan Privasi dapat diperbarui sewaktu-waktu dan berlaku sejak tanggal diperbarui.\r\n\r\n8. Persetujuan\r\nDengan menggunakan layanan Zoestore ID, pengguna dianggap menyetujui Kebijakan Privasi ini.\";', 1767614146),
('laravel-cache-config_page_terms', 's:1096:\"Dengan menggunakan layanan Zoestore ID, pengguna dianggap menyetujui seluruh syarat dan ketentuan berikut:\r\n\r\n1. Ketentuan Umum\r\nZoestore ID menyediakan layanan top up game digital secara online.\r\n\r\n2. Data Pengguna\r\nPengguna wajib mengisi data dengan benar. Kesalahan input bukan tanggung jawab Zoestore ID.\r\n\r\n3. Transaksi dan Pembayaran\r\n- Semua transaksi bersifat final\r\n- Harga dapat berubah sewaktu-waktu\r\n- Pesanan diproses setelah pembayaran berhasil\r\n\r\n4. Proses Top Up\r\nTop up diproses secara otomatis, namun dapat terjadi keterlambatan akibat gangguan sistem.\r\n\r\n5. Refund\r\nRefund hanya berlaku jika terjadi kesalahan dari pihak Zoestore ID.\r\n\r\n6. Ketersediaan Layanan\r\nZoestore ID berhak mengubah atau menghentikan layanan tanpa pemberitahuan.\r\n\r\n7. Hak Kekayaan Intelektual\r\nSeluruh konten Zoestore ID dilindungi oleh hukum.\r\n\r\n8. Batasan Tanggung Jawab\r\nZoestore ID tidak bertanggung jawab atas kerugian akibat kelalaian pengguna.\r\n\r\n9. Perubahan Ketentuan\r\nSyarat dan Ketentuan dapat diperbarui sewaktu-waktu.\r\n\r\n10. Hukum yang Berlaku\r\nDiatur berdasarkan hukum Republik Indonesia.\";', 1767614146),
('laravel-cache-config_payment_logo_1', 's:69:\"/storage/images/settings/MAZ6RMibykIf1xSdU5tf3PzDMwDI7M2sFdOWtMv3.jpg\";', 1767614781),
('laravel-cache-config_payment_logo_2', 's:69:\"/storage/images/settings/A4WOOewXOuw5Oz4DlFsx9f4zkxYI2pV7U6MjkJKA.jpg\";', 1767614781),
('laravel-cache-config_payment_logo_3', 's:69:\"/storage/images/settings/KrLtL0qaHJcYnaTtJaBRZxSiBE66b4lYGhkXoILc.jpg\";', 1767614781),
('laravel-cache-config_payment_logo_4', 's:69:\"/storage/images/settings/IgvESx3f1P7nK1m4GbfNI6kYf5c0BtlC6prgDMkT.jpg\";', 1767614781),
('laravel-cache-config_tripay_api_key', 's:44:\"DEV-TN3p8mNH8ol7RGBAyQxktQ406lHU7NjG2ezimLEW\";', 1767612852),
('laravel-cache-config_tripay_merchant_code', 's:6:\"T13867\";', 1767450723),
('laravel-cache-config_tripay_mode', 's:7:\"sandbox\";', 1767612852),
('laravel-cache-config_tripay_private_key', 's:29:\"Ij23U-wKJTj-KrQ0v-WqU92-E4Dwr\";', 1767450723),
('laravel-cache-config_whatsapp_number', 's:12:\"087894692316\";', 1767614146),
('laravel-cache-config_xendit_callback_token', 's:48:\"z67iV99PdLPSq5nDI8x1PEE5nDde24ABHDRDrgHkRYR2rS2p\";', 1767609158),
('laravel-cache-config_xendit_mode', 's:10:\"production\";', 1767609158),
('laravel-cache-config_xendit_secret_key', 's:78:\"xnd_production_7lwOq3p4sTnCe2zRN2Bcl4zHvEgwZsQ6gJo121qNx0iO9oQnj9TQKWuUfrKXxFy\";', 1767609158);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-footer_payments', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:21:{i:0;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:103;s:4:\"code\";s:9:\"shopeepay\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:9:\"ShopeePay\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/d204uajhlS1655719774.png\";s:8:\"flat_fee\";s:4:\"0.00\";s:11:\"percent_fee\";s:4:\"3.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 10:47:34\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:103;s:4:\"code\";s:9:\"shopeepay\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:9:\"ShopeePay\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/d204uajhlS1655719774.png\";s:8:\"flat_fee\";s:4:\"0.00\";s:11:\"percent_fee\";s:4:\"3.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 10:47:34\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:104;s:4:\"code\";s:4:\"qris\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:17:\"QRIS by ShopeePay\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/BpE4BPVyIw1605597490.png\";s:8:\"flat_fee\";s:6:\"750.00\";s:11:\"percent_fee\";s:4:\"0.70\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 10:47:34\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:104;s:4:\"code\";s:4:\"qris\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:17:\"QRIS by ShopeePay\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/BpE4BPVyIw1605597490.png\";s:8:\"flat_fee\";s:6:\"750.00\";s:11:\"percent_fee\";s:4:\"0.70\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 10:47:34\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:111;s:4:\"code\";s:9:\"indomaret\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:9:\"Indomaret\";s:4:\"type\";s:6:\"retail\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/zNzuO5AuLw1583513974.png\";s:8:\"flat_fee\";s:7:\"3500.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 10:47:34\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:111;s:4:\"code\";s:9:\"indomaret\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:9:\"Indomaret\";s:4:\"type\";s:6:\"retail\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/zNzuO5AuLw1583513974.png\";s:8:\"flat_fee\";s:7:\"3500.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 10:47:34\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:112;s:4:\"code\";s:8:\"alfamart\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:8:\"Alfamart\";s:4:\"type\";s:6:\"retail\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/jiGZMKp2RD1583433506.png\";s:8:\"flat_fee\";s:7:\"3500.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 10:47:34\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:112;s:4:\"code\";s:8:\"alfamart\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:8:\"Alfamart\";s:4:\"type\";s:6:\"retail\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/jiGZMKp2RD1583433506.png\";s:8:\"flat_fee\";s:7:\"3500.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 10:47:34\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:114;s:4:\"code\";s:9:\"PERMATAVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:23:\"Permata Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/szezRhAALB1583408731.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:114;s:4:\"code\";s:9:\"PERMATAVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:23:\"Permata Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/szezRhAALB1583408731.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:115;s:4:\"code\";s:5:\"BNIVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"BNI Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/n22Qsh8jMa1583433577.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:115;s:4:\"code\";s:5:\"BNIVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"BNI Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/n22Qsh8jMa1583433577.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:116;s:4:\"code\";s:5:\"BRIVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"BRI Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/8WQ3APST5s1579461828.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:116;s:4:\"code\";s:5:\"BRIVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"BRI Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/8WQ3APST5s1579461828.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:117;s:4:\"code\";s:9:\"MANDIRIVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:23:\"Mandiri Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/T9Z012UE331583531536.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:117;s:4:\"code\";s:9:\"MANDIRIVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:23:\"Mandiri Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/T9Z012UE331583531536.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:118;s:4:\"code\";s:5:\"BCAVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"BCA Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/ytBKvaleGy1605201833.png\";s:8:\"flat_fee\";s:7:\"5500.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:118;s:4:\"code\";s:5:\"BCAVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"BCA Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/ytBKvaleGy1605201833.png\";s:8:\"flat_fee\";s:7:\"5500.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:9;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:119;s:4:\"code\";s:10:\"MUAMALATVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:24:\"Muamalat Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/GGwwcgdYaG1611929720.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:119;s:4:\"code\";s:10:\"MUAMALATVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:24:\"Muamalat Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/GGwwcgdYaG1611929720.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:10;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:120;s:4:\"code\";s:6:\"CIMBVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:26:\"CIMB Niaga Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/WtEJwfuphn1614003973.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:120;s:4:\"code\";s:6:\"CIMBVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:26:\"CIMB Niaga Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/WtEJwfuphn1614003973.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:11;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:121;s:4:\"code\";s:5:\"BSIVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"BSI Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/tEclz5Assb1643375216.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:121;s:4:\"code\";s:5:\"BSIVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"BSI Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/tEclz5Assb1643375216.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:12;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:122;s:4:\"code\";s:6:\"OCBCVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:25:\"OCBC NISP Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/ysiSToLvKl1644244798.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:122;s:4:\"code\";s:6:\"OCBCVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:25:\"OCBC NISP Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/ysiSToLvKl1644244798.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:13;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:123;s:4:\"code\";s:9:\"DANAMONVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:23:\"Danamon Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/F3pGzDOLUz1644245546.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:123;s:4:\"code\";s:9:\"DANAMONVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:23:\"Danamon Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/F3pGzDOLUz1644245546.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:14;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:124;s:4:\"code\";s:11:\"OTHERBANKVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:26:\"Other Bank Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/qQYo61sIDa1702995837.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:124;s:4:\"code\";s:11:\"OTHERBANKVA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:26:\"Other Bank Virtual Account\";s:4:\"type\";s:15:\"virtual_account\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/qQYo61sIDa1702995837.png\";s:8:\"flat_fee\";s:7:\"4250.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:15;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:125;s:4:\"code\";s:8:\"ALFAMIDI\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:8:\"Alfamidi\";s:4:\"type\";s:6:\"retail\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/aQTdaUC2GO1593660384.png\";s:8:\"flat_fee\";s:7:\"3500.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:125;s:4:\"code\";s:8:\"ALFAMIDI\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:8:\"Alfamidi\";s:4:\"type\";s:6:\"retail\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/aQTdaUC2GO1593660384.png\";s:8:\"flat_fee\";s:7:\"3500.00\";s:11:\"percent_fee\";s:4:\"0.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:16;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:126;s:4:\"code\";s:3:\"OVO\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:3:\"OVO\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/fH6Y7wDT171586199243.png\";s:8:\"flat_fee\";s:4:\"0.00\";s:11:\"percent_fee\";s:4:\"3.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:126;s:4:\"code\";s:3:\"OVO\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:3:\"OVO\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/fH6Y7wDT171586199243.png\";s:8:\"flat_fee\";s:4:\"0.00\";s:11:\"percent_fee\";s:4:\"3.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:17;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:127;s:4:\"code\";s:5:\"QRISC\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"QRIS (Customizable)\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/m9FtFwaBCg1623157494.png\";s:8:\"flat_fee\";s:6:\"750.00\";s:11:\"percent_fee\";s:4:\"0.70\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:127;s:4:\"code\";s:5:\"QRISC\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:19:\"QRIS (Customizable)\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/m9FtFwaBCg1623157494.png\";s:8:\"flat_fee\";s:6:\"750.00\";s:11:\"percent_fee\";s:4:\"0.70\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:18;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:128;s:4:\"code\";s:5:\"QRIS2\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:4:\"QRIS\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/8ewGzP6SWe1649667701.png\";s:8:\"flat_fee\";s:6:\"750.00\";s:11:\"percent_fee\";s:4:\"0.70\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:128;s:4:\"code\";s:5:\"QRIS2\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:4:\"QRIS\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/8ewGzP6SWe1649667701.png\";s:8:\"flat_fee\";s:6:\"750.00\";s:11:\"percent_fee\";s:4:\"0.70\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:19;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:129;s:4:\"code\";s:4:\"DANA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:4:\"DANA\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/sj3UHLu8Tu1655719621.png\";s:8:\"flat_fee\";s:4:\"0.00\";s:11:\"percent_fee\";s:4:\"3.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:129;s:4:\"code\";s:4:\"DANA\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:4:\"DANA\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/sj3UHLu8Tu1655719621.png\";s:8:\"flat_fee\";s:4:\"0.00\";s:11:\"percent_fee\";s:4:\"3.00\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:20;O:24:\"App\\Models\\PaymentMethod\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"payment_methods\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:13:{s:2:\"id\";i:130;s:4:\"code\";s:14:\"QRIS_SHOPEEPAY\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:24:\"QRIS Custom by ShopeePay\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/DM8sBd1i9y1681718593.png\";s:8:\"flat_fee\";s:6:\"750.00\";s:11:\"percent_fee\";s:4:\"0.70\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:11:\"\0*\0original\";a:13:{s:2:\"id\";i:130;s:4:\"code\";s:14:\"QRIS_SHOPEEPAY\";s:8:\"provider\";s:6:\"tripay\";s:4:\"name\";s:24:\"QRIS Custom by ShopeePay\";s:4:\"type\";s:8:\"e_wallet\";s:5:\"image\";s:72:\"https://assets.tripay.co.id/upload/payment-icon/DM8sBd1i9y1681718593.png\";s:8:\"flat_fee\";s:6:\"750.00\";s:11:\"percent_fee\";s:4:\"0.70\";s:14:\"admin_fee_flat\";s:4:\"0.00\";s:17:\"admin_fee_percent\";s:4:\"0.00\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-01-05 11:10:16\";s:10:\"updated_at\";s:19:\"2026-01-05 11:12:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"code\";i:1;s:4:\"name\";i:2;s:5:\"image\";i:3;s:8:\"provider\";i:4;s:8:\"flat_fee\";i:5;s:11:\"percent_fee\";i:6;s:9:\"is_active\";i:7;s:4:\"type\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1767614739);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-web_config_global', 'a:30:{s:18:\"digiflazz_username\";s:12:\"zeyumoD22vqD\";s:13:\"digiflazz_key\";s:36:\"ea5dc837-f75c-565f-b663-c272a9433cb4\";s:14:\"digiflazz_mode\";s:10:\"production\";s:14:\"tripay_api_key\";s:44:\"DEV-TN3p8mNH8ol7RGBAyQxktQ406lHU7NjG2ezimLEW\";s:18:\"tripay_private_key\";s:29:\"Ij23U-wKJTj-KrQ0v-WqU92-E4Dwr\";s:20:\"tripay_merchant_code\";s:6:\"T13867\";s:11:\"tripay_mode\";s:7:\"sandbox\";s:8:\"app_name\";s:11:\"Zoestore Id\";s:18:\"footer_description\";s:42:\"Website Topup Game Tercepat Dan Terpercaya\";s:15:\"whatsapp_number\";s:12:\"087894692316\";s:10:\"page_about\";s:794:\"Zoestore ID adalah platform top up game terpercaya yang menyediakan berbagai kebutuhan game favorit Anda dengan proses cepat, aman, dan harga terjangkau. Kami hadir untuk memberikan pengalaman top up yang mudah tanpa ribet, sehingga Anda bisa lebih fokus menikmati permainan.\r\n\r\nDengan sistem otomatis dan metode pembayaran yang beragam, Zoestore ID memastikan setiap transaksi diproses secara instan dan aman. Kami melayani berbagai game populer dengan dukungan layanan pelanggan yang responsif dan siap membantu kapan saja.\r\n\r\nKomitmen kami adalah memberikan layanan terbaik, kecepatan transaksi, serta kepuasan pelanggan sebagai prioritas utama. Zoestore ID terus berinovasi untuk menjadi pilihan utama para gamer di Indonesia.\r\n\r\nTop up cepat, aman, dan terpercaya — hanya di Zoestore ID.\";s:12:\"page_privacy\";s:1187:\"Zoestore ID menghargai dan melindungi privasi setiap pengguna. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi pengguna.\r\n\r\n1. Informasi yang Dikumpulkan\r\n- User ID dan Server ID game\r\n- Data transaksi dan metode pembayaran\r\n- Data teknis seperti alamat IP dan aktivitas website\r\n\r\n2. Penggunaan Informasi\r\nInformasi digunakan untuk memproses transaksi, meningkatkan layanan, serta keperluan keamanan dan dukungan pelanggan.\r\n\r\n3. Keamanan Data\r\nKami menerapkan sistem keamanan yang wajar untuk melindungi data pengguna dari akses yang tidak sah.\r\n\r\n4. Pembagian Informasi\r\nZoestore ID tidak menjual data pengguna kepada pihak ketiga, kecuali untuk proses pembayaran atau kewajiban hukum.\r\n\r\n5. Cookie\r\nWebsite dapat menggunakan cookie untuk meningkatkan pengalaman pengguna.\r\n\r\n6. Hak Pengguna\r\nPengguna berhak meminta informasi, perbaikan, atau penghapusan data sesuai hukum yang berlaku.\r\n\r\n7. Perubahan Kebijakan\r\nKebijakan Privasi dapat diperbarui sewaktu-waktu dan berlaku sejak tanggal diperbarui.\r\n\r\n8. Persetujuan\r\nDengan menggunakan layanan Zoestore ID, pengguna dianggap menyetujui Kebijakan Privasi ini.\";s:10:\"page_terms\";s:1096:\"Dengan menggunakan layanan Zoestore ID, pengguna dianggap menyetujui seluruh syarat dan ketentuan berikut:\r\n\r\n1. Ketentuan Umum\r\nZoestore ID menyediakan layanan top up game digital secara online.\r\n\r\n2. Data Pengguna\r\nPengguna wajib mengisi data dengan benar. Kesalahan input bukan tanggung jawab Zoestore ID.\r\n\r\n3. Transaksi dan Pembayaran\r\n- Semua transaksi bersifat final\r\n- Harga dapat berubah sewaktu-waktu\r\n- Pesanan diproses setelah pembayaran berhasil\r\n\r\n4. Proses Top Up\r\nTop up diproses secara otomatis, namun dapat terjadi keterlambatan akibat gangguan sistem.\r\n\r\n5. Refund\r\nRefund hanya berlaku jika terjadi kesalahan dari pihak Zoestore ID.\r\n\r\n6. Ketersediaan Layanan\r\nZoestore ID berhak mengubah atau menghentikan layanan tanpa pemberitahuan.\r\n\r\n7. Hak Kekayaan Intelektual\r\nSeluruh konten Zoestore ID dilindungi oleh hukum.\r\n\r\n8. Batasan Tanggung Jawab\r\nZoestore ID tidak bertanggung jawab atas kerugian akibat kelalaian pengguna.\r\n\r\n9. Perubahan Ketentuan\r\nSyarat dan Ketentuan dapat diperbarui sewaktu-waktu.\r\n\r\n10. Hukum yang Berlaku\r\nDiatur berdasarkan hukum Republik Indonesia.\";s:8:\"page_faq\";s:834:\"1. Apa itu Zoestore ID?\r\nZoestore ID adalah website top up game online yang cepat dan terpercaya.\r\n\r\n2. Apakah Zoestore ID aman?\r\nYa, kami menggunakan sistem pembayaran yang aman.\r\n\r\n3. Bagaimana cara top up?\r\nPilih game, masukkan User ID, pilih pembayaran, lalu selesaikan transaksi.\r\n\r\n4. Berapa lama proses top up?\r\nSebagian besar diproses secara instan.\r\n\r\n5. Apakah perlu login?\r\nTidak, top up bisa dilakukan tanpa registrasi.\r\n\r\n6. Metode pembayaran apa saja?\r\nE-wallet, transfer bank, dan metode digital lainnya.\r\n\r\n7. Jika top up belum masuk?\r\nHubungi customer service dengan bukti transaksi.\r\n\r\n8. Apakah bisa refund?\r\nRefund hanya untuk kesalahan dari pihak Zoestore ID.\r\n\r\n9. Apakah harga bisa berubah?\r\nYa, harga dapat berubah sewaktu-waktu.\r\n\r\n10. Bagaimana menghubungi CS?\r\nMelalui kontak resmi yang tersedia di website.\";s:10:\"app_banner\";s:69:\"/storage/images/settings/MVKwmLuUA43ws9w0yh33e8UXC4RPgc3E7qV6k2qF.jpg\";s:14:\"payment_logo_1\";s:69:\"/storage/images/settings/MAZ6RMibykIf1xSdU5tf3PzDMwDI7M2sFdOWtMv3.jpg\";s:14:\"payment_logo_2\";s:69:\"/storage/images/settings/A4WOOewXOuw5Oz4DlFsx9f4zkxYI2pV7U6MjkJKA.jpg\";s:14:\"payment_logo_3\";s:69:\"/storage/images/settings/KrLtL0qaHJcYnaTtJaBRZxSiBE66b4lYGhkXoILc.jpg\";s:14:\"payment_logo_4\";s:69:\"/storage/images/settings/IgvESx3f1P7nK1m4GbfNI6kYf5c0BtlC6prgDMkT.jpg\";s:17:\"apigames_merchant\";s:17:\"M220704FEUE9178NP\";s:15:\"apigames_secret\";s:64:\"bd6fbd73d36bfdb7aa818288c604fe5543f977f8ace024bdeccfbfec9185d7d6\";s:11:\"xendit_mode\";s:10:\"production\";s:17:\"xendit_secret_key\";s:78:\"xnd_production_7lwOq3p4sTnCe2zRN2Bcl4zHvEgwZsQ6gJo121qNx0iO9oQnj9TQKWuUfrKXxFy\";s:21:\"xendit_callback_token\";s:48:\"z67iV99PdLPSq5nDI8x1PEE5nDde24ABHDRDrgHkRYR2rS2p\";s:21:\"gateway_tripay_active\";s:1:\"1\";s:21:\"gateway_xendit_active\";s:1:\"0\";s:13:\"midtrans_mode\";s:7:\"sandbox\";s:19:\"midtrans_server_key\";s:38:\"SB-Mid-server-VHc_ltMQIJFnI9EE0KggMava\";s:19:\"midtrans_client_key\";s:30:\"SB-Mid-client-9FHjNP_lmvaXd6_F\";s:23:\"gateway_midtrans_active\";s:1:\"0\";}', 1767614739);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `configurations`
--

CREATE TABLE `configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `configurations`
--

INSERT INTO `configurations` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'digiflazz_username', 'zeyumoD22vqD', '2025-12-31 01:14:35', '2025-12-31 01:14:35'),
(2, 'digiflazz_key', 'ea5dc837-f75c-565f-b663-c272a9433cb4', '2025-12-31 01:14:35', '2025-12-31 01:14:35'),
(3, 'digiflazz_mode', 'production', '2025-12-31 01:14:35', '2025-12-31 01:14:35'),
(4, 'tripay_api_key', 'DEV-TN3p8mNH8ol7RGBAyQxktQ406lHU7NjG2ezimLEW', '2025-12-31 01:14:56', '2025-12-31 01:14:56'),
(5, 'tripay_private_key', 'Ij23U-wKJTj-KrQ0v-WqU92-E4Dwr', '2025-12-31 01:14:56', '2025-12-31 01:14:56'),
(6, 'tripay_merchant_code', 'T13867', '2025-12-31 01:14:56', '2025-12-31 01:14:56'),
(7, 'tripay_mode', 'sandbox', '2025-12-31 01:14:56', '2025-12-31 01:14:56'),
(8, 'app_name', 'Zoestore Id', '2025-12-31 02:09:05', '2025-12-31 02:09:30'),
(9, 'footer_description', 'Website Topup Game Tercepat Dan Terpercaya', '2025-12-31 02:09:05', '2025-12-31 02:09:05'),
(10, 'whatsapp_number', '087894692316', '2025-12-31 02:09:05', '2025-12-31 02:09:05'),
(11, 'page_about', 'Zoestore ID adalah platform top up game terpercaya yang menyediakan berbagai kebutuhan game favorit Anda dengan proses cepat, aman, dan harga terjangkau. Kami hadir untuk memberikan pengalaman top up yang mudah tanpa ribet, sehingga Anda bisa lebih fokus menikmati permainan.\r\n\r\nDengan sistem otomatis dan metode pembayaran yang beragam, Zoestore ID memastikan setiap transaksi diproses secara instan dan aman. Kami melayani berbagai game populer dengan dukungan layanan pelanggan yang responsif dan siap membantu kapan saja.\r\n\r\nKomitmen kami adalah memberikan layanan terbaik, kecepatan transaksi, serta kepuasan pelanggan sebagai prioritas utama. Zoestore ID terus berinovasi untuk menjadi pilihan utama para gamer di Indonesia.\r\n\r\nTop up cepat, aman, dan terpercaya — hanya di Zoestore ID.', '2025-12-31 03:04:40', '2025-12-31 03:04:40'),
(12, 'page_privacy', 'Zoestore ID menghargai dan melindungi privasi setiap pengguna. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi pengguna.\r\n\r\n1. Informasi yang Dikumpulkan\r\n- User ID dan Server ID game\r\n- Data transaksi dan metode pembayaran\r\n- Data teknis seperti alamat IP dan aktivitas website\r\n\r\n2. Penggunaan Informasi\r\nInformasi digunakan untuk memproses transaksi, meningkatkan layanan, serta keperluan keamanan dan dukungan pelanggan.\r\n\r\n3. Keamanan Data\r\nKami menerapkan sistem keamanan yang wajar untuk melindungi data pengguna dari akses yang tidak sah.\r\n\r\n4. Pembagian Informasi\r\nZoestore ID tidak menjual data pengguna kepada pihak ketiga, kecuali untuk proses pembayaran atau kewajiban hukum.\r\n\r\n5. Cookie\r\nWebsite dapat menggunakan cookie untuk meningkatkan pengalaman pengguna.\r\n\r\n6. Hak Pengguna\r\nPengguna berhak meminta informasi, perbaikan, atau penghapusan data sesuai hukum yang berlaku.\r\n\r\n7. Perubahan Kebijakan\r\nKebijakan Privasi dapat diperbarui sewaktu-waktu dan berlaku sejak tanggal diperbarui.\r\n\r\n8. Persetujuan\r\nDengan menggunakan layanan Zoestore ID, pengguna dianggap menyetujui Kebijakan Privasi ini.', '2025-12-31 03:04:40', '2025-12-31 03:04:40'),
(13, 'page_terms', 'Dengan menggunakan layanan Zoestore ID, pengguna dianggap menyetujui seluruh syarat dan ketentuan berikut:\r\n\r\n1. Ketentuan Umum\r\nZoestore ID menyediakan layanan top up game digital secara online.\r\n\r\n2. Data Pengguna\r\nPengguna wajib mengisi data dengan benar. Kesalahan input bukan tanggung jawab Zoestore ID.\r\n\r\n3. Transaksi dan Pembayaran\r\n- Semua transaksi bersifat final\r\n- Harga dapat berubah sewaktu-waktu\r\n- Pesanan diproses setelah pembayaran berhasil\r\n\r\n4. Proses Top Up\r\nTop up diproses secara otomatis, namun dapat terjadi keterlambatan akibat gangguan sistem.\r\n\r\n5. Refund\r\nRefund hanya berlaku jika terjadi kesalahan dari pihak Zoestore ID.\r\n\r\n6. Ketersediaan Layanan\r\nZoestore ID berhak mengubah atau menghentikan layanan tanpa pemberitahuan.\r\n\r\n7. Hak Kekayaan Intelektual\r\nSeluruh konten Zoestore ID dilindungi oleh hukum.\r\n\r\n8. Batasan Tanggung Jawab\r\nZoestore ID tidak bertanggung jawab atas kerugian akibat kelalaian pengguna.\r\n\r\n9. Perubahan Ketentuan\r\nSyarat dan Ketentuan dapat diperbarui sewaktu-waktu.\r\n\r\n10. Hukum yang Berlaku\r\nDiatur berdasarkan hukum Republik Indonesia.', '2025-12-31 03:04:40', '2025-12-31 03:04:40'),
(14, 'page_faq', '1. Apa itu Zoestore ID?\r\nZoestore ID adalah website top up game online yang cepat dan terpercaya.\r\n\r\n2. Apakah Zoestore ID aman?\r\nYa, kami menggunakan sistem pembayaran yang aman.\r\n\r\n3. Bagaimana cara top up?\r\nPilih game, masukkan User ID, pilih pembayaran, lalu selesaikan transaksi.\r\n\r\n4. Berapa lama proses top up?\r\nSebagian besar diproses secara instan.\r\n\r\n5. Apakah perlu login?\r\nTidak, top up bisa dilakukan tanpa registrasi.\r\n\r\n6. Metode pembayaran apa saja?\r\nE-wallet, transfer bank, dan metode digital lainnya.\r\n\r\n7. Jika top up belum masuk?\r\nHubungi customer service dengan bukti transaksi.\r\n\r\n8. Apakah bisa refund?\r\nRefund hanya untuk kesalahan dari pihak Zoestore ID.\r\n\r\n9. Apakah harga bisa berubah?\r\nYa, harga dapat berubah sewaktu-waktu.\r\n\r\n10. Bagaimana menghubungi CS?\r\nMelalui kontak resmi yang tersedia di website.', '2025-12-31 03:04:40', '2025-12-31 03:04:40'),
(15, 'app_banner', '/storage/images/settings/MVKwmLuUA43ws9w0yh33e8UXC4RPgc3E7qV6k2qF.jpg', '2025-12-31 06:10:40', '2025-12-31 06:23:44'),
(16, 'payment_logo_1', '/storage/images/settings/MAZ6RMibykIf1xSdU5tf3PzDMwDI7M2sFdOWtMv3.jpg', '2025-12-31 06:13:30', '2025-12-31 06:13:30'),
(17, 'payment_logo_2', '/storage/images/settings/A4WOOewXOuw5Oz4DlFsx9f4zkxYI2pV7U6MjkJKA.jpg', '2025-12-31 06:30:48', '2025-12-31 06:30:48'),
(18, 'payment_logo_3', '/storage/images/settings/KrLtL0qaHJcYnaTtJaBRZxSiBE66b4lYGhkXoILc.jpg', '2025-12-31 06:30:48', '2025-12-31 06:30:48'),
(19, 'payment_logo_4', '/storage/images/settings/IgvESx3f1P7nK1m4GbfNI6kYf5c0BtlC6prgDMkT.jpg', '2025-12-31 06:30:48', '2025-12-31 06:30:48'),
(20, 'apigames_merchant', 'M220704FEUE9178NP', '2025-12-31 13:04:11', '2025-12-31 13:04:11'),
(21, 'apigames_secret', 'bd6fbd73d36bfdb7aa818288c604fe5543f977f8ace024bdeccfbfec9185d7d6', '2025-12-31 13:04:11', '2025-12-31 13:07:20'),
(22, 'xendit_mode', 'production', '2026-01-02 10:53:01', '2026-01-02 10:53:01'),
(23, 'xendit_secret_key', 'xnd_production_7lwOq3p4sTnCe2zRN2Bcl4zHvEgwZsQ6gJo121qNx0iO9oQnj9TQKWuUfrKXxFy', '2026-01-02 10:53:01', '2026-01-02 10:53:01'),
(24, 'xendit_callback_token', 'z67iV99PdLPSq5nDI8x1PEE5nDde24ABHDRDrgHkRYR2rS2p', '2026-01-02 10:53:01', '2026-01-02 10:53:01'),
(25, 'gateway_tripay_active', '1', '2026-01-02 11:19:48', '2026-01-05 04:10:10'),
(26, 'gateway_xendit_active', '0', '2026-01-02 11:19:48', '2026-01-05 04:03:25'),
(27, 'midtrans_mode', 'sandbox', '2026-01-03 07:08:48', '2026-01-05 02:51:51'),
(28, 'midtrans_server_key', 'SB-Mid-server-VHc_ltMQIJFnI9EE0KggMava', '2026-01-03 07:08:48', '2026-01-05 02:51:51'),
(29, 'midtrans_client_key', 'SB-Mid-client-9FHjNP_lmvaXd6_F', '2026-01-03 07:08:48', '2026-01-05 02:51:51'),
(30, 'gateway_midtrans_active', '0', '2026-01-05 03:01:45', '2026-01-05 04:12:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `games`
--

CREATE TABLE `games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand_digiflazz` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `endpoint` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `publisher` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `target_endpoint` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `games`
--

INSERT INTO `games` (`id`, `name`, `brand_digiflazz`, `code`, `slug`, `endpoint`, `is_active`, `publisher`, `thumbnail`, `banner`, `target_endpoint`, `created_at`, `updated_at`) VALUES
(1, 'Mobile Legends', 'MOBILE LEGENDS', 'mobile-legends', 'mobile-legends', 'mobile-legends', 1, 'Moonton', '/images/logo/mobile-legends.png', '/images/banner/mobile-legends.jpg', 'ml', '2025-12-31 01:12:33', '2025-12-31 04:34:21'),
(2, 'Free Fire', 'FREE FIRE', 'free-fire', 'free-fire', 'free-fire', 1, 'Garena', '/images/logo/free-fire.png', '/images/banner/free-fire.jpg', 'ff', '2025-12-31 01:12:33', '2025-12-31 04:34:21'),
(3, 'League of Legends Wild Rift', 'League of Legends Wild Rift', 'league-of-legends-wild-rift', 'league-of-legends-wild-rift', NULL, 1, NULL, '/images/logo/league-of-legends-wild-rift.png', '/images/banner/league-of-legends-wild-rift.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(5, 'PUBG MOBILE', 'PUBG MOBILE', 'pubg-mobile', 'pubg-mobile', NULL, 1, NULL, '/images/logo/pubg-mobile.png', '/images/banner/pubg-mobile.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(8, 'Honkai Impact 3', 'Honkai Impact 3', 'honkai-impact-3', 'honkai-impact-3', NULL, 1, NULL, '/images/logo/honkai-impact-3.png', '/images/banner/honkai-impact-3.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(11, 'Eggy Party', 'Eggy Party', 'eggy-party', 'eggy-party', NULL, 1, NULL, '/images/logo/eggy-party.png', '/images/banner/eggy-party.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(12, 'Growtopia', 'Growtopia', 'growtopia', 'growtopia', NULL, 1, NULL, '/images/logo/growtopia.png', '/images/banner/growtopia.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(13, 'Genshin Impact', 'Genshin Impact', 'genshin-impact', 'genshin-impact', NULL, 1, NULL, '/images/logo/genshin-impact.png', '/images/banner/genshin-impact.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(14, 'Honor of Kings', 'Honor of Kings', 'honor-of-kings', 'honor-of-kings', NULL, 1, NULL, '/images/logo/honor-of-kings.png', '/images/banner/honor-of-kings.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(17, 'PUBG New State Mobile', 'PUBG New State Mobile', 'pubg-new-state-mobile', 'pubg-new-state-mobile', NULL, 1, NULL, '/images/logo/pubg-new-state-mobile.png', '/images/banner/pubg-new-state-mobile.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(24, 'Zepeto', 'Zepeto', 'zepeto', 'zepeto', NULL, 1, NULL, '/images/logo/zepeto.png', '/images/banner/zepeto.jpg', NULL, '2025-12-31 04:34:21', '2025-12-31 04:34:21'),
(32, 'AU2 MOBILE', 'AU2 MOBILE', 'au2-mobile', 'au2-mobile', NULL, 1, NULL, '/images/logo/au2-mobile.png', '/images/banner/au2-mobile.jpg', NULL, '2025-12-31 04:51:45', '2025-12-31 04:51:45'),
(33, 'Blood Strike', 'Blood Strike', 'blood-strike', 'blood-strike', NULL, 1, NULL, '/images/logo/blood-strike.png', '/images/banner/blood-strike.jpg', NULL, '2025-12-31 04:51:45', '2025-12-31 04:51:45'),
(36, 'ARENA OF VALOR', 'ARENA OF VALOR', 'arena-of-valor', 'arena-of-valor', NULL, 1, NULL, '/images/logo/arena-of-valor.png', '/images/banner/arena-of-valor.jpg', NULL, '2025-12-31 04:57:52', '2025-12-31 04:57:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(50, '0001_01_01_000000_create_users_table', 1),
(51, '0001_01_01_000001_create_cache_table', 1),
(52, '0001_01_01_000002_create_jobs_table', 1),
(53, '2025_12_26_140920_create_transactions_table', 1),
(54, '2025_12_26_143006_create_personal_access_tokens_table', 1),
(55, '2025_12_26_143559_create_products_table', 1),
(56, '2025_12_26_145118_add_nickname_to_transactions_table', 1),
(57, '2025_12_26_150310_create_games_table', 1),
(58, '2025_12_26_151442_add_role_to_users_table', 1),
(59, '2025_12_26_152351_create_configurations_table', 1),
(60, '2025_12_26_153056_add_details_to_products_table', 1),
(61, '2025_12_26_154630_create_promos_table', 1),
(62, '2025_12_26_155259_create_payment_methods_table', 1),
(63, '2025_12_31_102032_add_vip_price_to_products_table', 2),
(64, '2025_12_31_110106_add_brand_digiflazz_to_games_table', 3),
(65, '2025_12_31_113019_fix_games_table_structure', 4),
(66, '2025_12_31_113311_fix_games_table_structure', 5),
(67, '2026_01_02_164918_add_balance_to_users_table', 6),
(68, '2026_01_02_172448_add_provider_to_payment_methods', 7),
(69, '2026_01_02_185626_add_user_id_to_transactions_table', 8),
(70, '2026_01_02_190959_add_service_columns_to_transactions_table', 9),
(71, '2026_01_02_191437_fix_transactions_table_structure', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL DEFAULT 'tripay',
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `flat_fee` decimal(15,2) DEFAULT 0.00,
  `percent_fee` decimal(5,2) DEFAULT 0.00,
  `admin_fee_flat` decimal(10,2) NOT NULL DEFAULT 0.00,
  `admin_fee_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `code`, `provider`, `name`, `type`, `image`, `flat_fee`, `percent_fee`, `admin_fee_flat`, `admin_fee_percent`, `is_active`, `created_at`, `updated_at`) VALUES
(103, 'shopeepay', 'tripay', 'ShopeePay', 'e_wallet', 'https://assets.tripay.co.id/upload/payment-icon/d204uajhlS1655719774.png', 0.00, 3.00, 0.00, 0.00, 1, '2026-01-05 03:47:34', '2026-01-05 04:12:52'),
(104, 'qris', 'tripay', 'QRIS by ShopeePay', 'e_wallet', 'https://assets.tripay.co.id/upload/payment-icon/BpE4BPVyIw1605597490.png', 750.00, 0.70, 0.00, 0.00, 1, '2026-01-05 03:47:34', '2026-01-05 04:12:52'),
(111, 'indomaret', 'tripay', 'Indomaret', 'retail', 'https://assets.tripay.co.id/upload/payment-icon/zNzuO5AuLw1583513974.png', 3500.00, 0.00, 0.00, 0.00, 1, '2026-01-05 03:47:34', '2026-01-05 04:12:52'),
(112, 'alfamart', 'tripay', 'Alfamart', 'retail', 'https://assets.tripay.co.id/upload/payment-icon/jiGZMKp2RD1583433506.png', 3500.00, 0.00, 0.00, 0.00, 1, '2026-01-05 03:47:34', '2026-01-05 04:12:52'),
(114, 'PERMATAVA', 'tripay', 'Permata Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/szezRhAALB1583408731.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(115, 'BNIVA', 'tripay', 'BNI Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/n22Qsh8jMa1583433577.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(116, 'BRIVA', 'tripay', 'BRI Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/8WQ3APST5s1579461828.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(117, 'MANDIRIVA', 'tripay', 'Mandiri Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/T9Z012UE331583531536.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(118, 'BCAVA', 'tripay', 'BCA Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/ytBKvaleGy1605201833.png', 5500.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(119, 'MUAMALATVA', 'tripay', 'Muamalat Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/GGwwcgdYaG1611929720.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(120, 'CIMBVA', 'tripay', 'CIMB Niaga Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/WtEJwfuphn1614003973.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(121, 'BSIVA', 'tripay', 'BSI Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/tEclz5Assb1643375216.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(122, 'OCBCVA', 'tripay', 'OCBC NISP Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/ysiSToLvKl1644244798.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(123, 'DANAMONVA', 'tripay', 'Danamon Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/F3pGzDOLUz1644245546.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(124, 'OTHERBANKVA', 'tripay', 'Other Bank Virtual Account', 'virtual_account', 'https://assets.tripay.co.id/upload/payment-icon/qQYo61sIDa1702995837.png', 4250.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(125, 'ALFAMIDI', 'tripay', 'Alfamidi', 'retail', 'https://assets.tripay.co.id/upload/payment-icon/aQTdaUC2GO1593660384.png', 3500.00, 0.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(126, 'OVO', 'tripay', 'OVO', 'e_wallet', 'https://assets.tripay.co.id/upload/payment-icon/fH6Y7wDT171586199243.png', 0.00, 3.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(127, 'QRISC', 'tripay', 'QRIS (Customizable)', 'e_wallet', 'https://assets.tripay.co.id/upload/payment-icon/m9FtFwaBCg1623157494.png', 750.00, 0.70, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(128, 'QRIS2', 'tripay', 'QRIS', 'e_wallet', 'https://assets.tripay.co.id/upload/payment-icon/8ewGzP6SWe1649667701.png', 750.00, 0.70, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(129, 'DANA', 'tripay', 'DANA', 'e_wallet', 'https://assets.tripay.co.id/upload/payment-icon/sj3UHLu8Tu1655719621.png', 0.00, 3.00, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52'),
(130, 'QRIS_SHOPEEPAY', 'tripay', 'QRIS Custom by ShopeePay', 'e_wallet', 'https://assets.tripay.co.id/upload/payment-icon/DM8sBd1i9y1681718593.png', 750.00, 0.70, 0.00, 0.00, 1, '2026-01-05 04:10:16', '2026-01-05 04:12:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `sku_provider` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `price_vip` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cost_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `game_code`, `name`, `code`, `sku_provider`, `price`, `price_vip`, `cost_price`, `is_active`, `category`, `created_at`, `updated_at`) VALUES
(1, 'mobile-legends', 'MOBILE LEGENDS Startlight Member Plus', '4ncH41', '4ncH41', 198968.00, 195178.00, 189493.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(2, 'mobile-legends', 'MOBILELEGEND - 1000 Diamond', 'HML1000', 'HML1000', 254961.00, 250105.00, 242820.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(3, 'mobile-legends', 'MOBILELEGEND - 112 Diamond', 'HML112', 'HML112', 30373.00, 29794.00, 28926.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(4, 'mobile-legends', 'MOBILELEGEND - 1159 Diamond', 'HML1159', 'HML1159', 300339.00, 294619.00, 286037.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(5, 'mobile-legends', 'MOBILELEGEND - 1220 Diamond', 'HML1220', 'HML1220', 312811.00, 306853.00, 297915.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(6, 'mobile-legends', 'MOBILELEGEND - 128 Diamond', 'HML128-S2', 'HML128-S2', 35117.00, 34448.00, 33444.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(7, 'mobile-legends', 'MOBILELEGEND - 12976 Diamond', 'HML12976', 'HML12976', 3165327.00, 3105035.00, 3014597.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(8, 'mobile-legends', 'MOBILELEGEND - 140 Diamond', 'HML140', 'HML140', 38629.00, 37893.00, 36789.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(9, 'mobile-legends', 'MOBILELEGEND - 14412 Diamond', 'HML14412-S2', 'HML14412-S2', 3526771.00, 3459594.00, 3358829.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(10, 'mobile-legends', 'MOBILELEGEND - 1446 Diamond', 'HML1446', 'HML1446', 376995.00, 369814.00, 359042.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(11, 'mobile-legends', 'MOBILELEGEND - 14820 Diamond', 'HML14820', 'HML14820', 3616889.00, 3547996.00, 3444656.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(12, 'mobile-legends', 'MOBILELEGEND - 16080 Diamond', 'HML16080', 'HML16080', 3921003.00, 3846317.00, 3734288.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(13, 'mobile-legends', 'MOBILELEGEND - 16104 Diamond', 'HML16104', 'HML16104', 3931886.00, 3856993.00, 3744653.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(14, 'mobile-legends', 'MOBILELEGEND - 1669 Diamond', 'HML1669', 'HML1669', 429767.00, 421581.00, 409301.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(15, 'mobile-legends', 'MOBILELEGEND - 168 Diamond', 'HML168', 'HML168', 45197.00, 44336.00, 43044.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(16, 'mobile-legends', 'MOBILELEGEND - 1704 Diamond', 'HML1704-S2', 'HML1704-S2', 438829.00, 430470.00, 417932.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(17, 'mobile-legends', 'MOBILELEGEND - 172 Diamond', 'HML172-S1', 'HML172-S1', 47193.00, 46294.00, 44945.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(18, 'mobile-legends', 'MOBILELEGEND - 1830 Diamond', 'HML1830', 'HML1830', 471974.00, 462984.00, 449499.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(19, 'mobile-legends', 'MOBILELEGEND - 184 Diamond', 'HML184-S2', 'HML184-S2', 50617.00, 49653.00, 48206.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(20, 'mobile-legends', 'MOBILELEGEND - 18576 Diamond', 'HML18576', 'HML18576', 4557645.00, 4470833.00, 4340614.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(21, 'mobile-legends', 'MOBILELEGEND - 20100 Diamond', 'HML20100', 'HML20100', 4901245.00, 4807888.00, 4667852.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(22, 'mobile-legends', 'MOBILELEGEND - 21330 Diamond', 'HML21330', 'HML21330', 5229813.00, 5130198.00, 4980774.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(23, 'mobile-legends', 'MOBILELEGEND - 2195 Diamond', 'HML2195-S1', 'HML2195-S1', 544037.00, 533674.00, 518130.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(24, 'mobile-legends', 'MOBILELEGEND - 222 Diamond', 'HML222', 'HML222', 58840.00, 57720.00, 56038.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(25, 'mobile-legends', 'MOBILELEGEND - 2232 Diamond', 'HML2232-S2', 'HML2232-S2', 549501.00, 539035.00, 523334.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(26, 'mobile-legends', 'MOBILELEGEND - 2398 Diamond', 'HML2398', 'HML2398', 593717.00, 582408.00, 565444.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(27, 'mobile-legends', 'MOBILELEGEND - 2578 Diamond', 'HML2578-S2', 'HML2578-S2', 643470.00, 631213.00, 612828.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(28, 'mobile-legends', 'MOBILELEGEND - 277 Diamond', 'HML277-S2', 'HML277-S2', 73833.00, 72427.00, 70317.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(29, 'mobile-legends', 'MOBILELEGEND - 27864 Diamond', 'HML27864', 'HML27864', 6801479.00, 6671927.00, 6477599.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(30, 'mobile-legends', 'MOBILELEGEND - 2901 Diamond', 'HML2901', 'HML2901', 722418.00, 708658.00, 688017.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(31, 'mobile-legends', 'MOBILELEGEND - 300 Diamond', 'Hml300', 'Hml300', 79851.00, 78330.00, 76048.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(32, 'mobile-legends', 'MOBILELEGEND - 3073 Diamond', 'HML3073-S1', 'HML3073-S1', 767160.00, 752547.00, 730628.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(33, 'mobile-legends', 'MOBILELEGEND - 3638 Diamond', 'HML3638', 'HML3638', 909635.00, 892309.00, 866319.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(34, 'mobile-legends', 'MOBILELEGEND - 3688 Diamond', 'HML3688-S1', 'HML3688-S1', 921953.00, 904392.00, 878050.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(35, 'mobile-legends', 'MOBILELEGEND - 370 Diamond', 'HML370-S2', 'HML370-S2', 98148.00, 96279.00, 93474.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(36, 'mobile-legends', 'MOBILELEGEND - 4020 Diamond', 'HML4020', 'HML4020', 986817.00, 968020.00, 939825.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(37, 'mobile-legends', 'MOBILELEGEND - 42 Diamond', 'HML42-S1', 'HML42-S1', 12045.00, 11816.00, 11471.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(38, 'mobile-legends', 'MOBILELEGEND - 4394 Diamond', 'HML4394', 'HML4394', 1080856.00, 1060268.00, 1029386.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(39, 'mobile-legends', 'MOBILELEGEND - 4588 Diamond', 'HML4588-S2', 'HML4588-S2', 1136865.00, 1115210.00, 1082728.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(40, 'mobile-legends', 'MOBILELEGEND - 4830 Diamond', 'HML4830', 'HML4830', 1184125.00, 1161571.00, 1127738.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(41, 'mobile-legends', 'MOBILELEGEND - 500 Diamond', 'HML500', 'HML500', 132746.00, 130217.00, 126424.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(42, 'mobile-legends', 'MOBILELEGEND - 5532 Diamond', 'HML5532-S1', 'HML5532-S1', 1370771.00, 1344661.00, 1305496.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(43, 'mobile-legends', 'MOBILELEGEND - 6030 Diamond', 'HML6030-S2', 'HML6030-S2', 1471391.00, 1443364.00, 1401324.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(44, 'mobile-legends', 'MOBILELEGEND - 6050 Diamond', 'HML6050', 'HML6050', 1476308.00, 1448188.00, 1406007.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(45, 'mobile-legends', 'MOBILELEGEND - 6238 Diamond', 'HML6238-S1', 'HML6238-S1', 1526078.00, 1497010.00, 1453407.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(46, 'mobile-legends', 'MOBILELEGEND - 6840 Diamond', 'HML6338', 'HML6338', 1677520.00, 1645568.00, 1597638.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(47, 'mobile-legends', 'MOBILELEGEND - 716 Diamond', 'HML716-S2', 'HML716-S2', 186563.00, 183010.00, 177679.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(48, 'mobile-legends', 'MOBILELEGEND - 8040 Diamond', 'HML8040-S2', 'HML8040-S2', 1960513.00, 1923170.00, 1867155.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(49, 'mobile-legends', 'MOBILELEGEND - 845 Diamond', 'HML845-S2', 'HML845-S2', 219922.00, 215733.00, 209449.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(50, 'mobile-legends', 'MOBILELEGEND - 86 Diamond', 'HML86-S1', 'HML86-S1', 23074.00, 22635.00, 21975.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(51, 'mobile-legends', 'MOBILELEGEND - 878 Diamond', 'HML878-S1', 'HML878-S1', 231054.00, 226653.00, 220051.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(52, 'mobile-legends', 'MOBILELEGEND - 88 Diamond', 'HML88-S2', 'HML88-S2', 24116.00, 23657.00, 22967.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(53, 'mobile-legends', 'MOBILELEGEND - 9288 Diamond', 'HML9288-S1', 'HML9288-S1', 2273362.00, 2230060.00, 2165106.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(54, 'mobile-legends', 'MOBILELEGEND - 966 Diamond', 'HML966-S2', 'HML966-S2', 245327.00, 240654.00, 233644.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(55, 'mobile-legends', 'MOBILELEGEND - 9660 Diamond', 'HML9660', 'HML9660', 2368223.00, 2323114.00, 2255450.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(56, 'mobile-legends', 'Mobile Legends Coupon Pass', 'HMLCP', 'HMLCP', 72296.00, 70919.00, 68853.00, 0, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(57, 'mobile-legends', 'MOBILE LEGENDS Weekly Diamond Pass 2x', 'HMLWDP2-S3', 'HMLWDP2-S3', 57330.00, 56238.00, 54600.00, 0, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(58, 'mobile-legends', 'MOBILE LEGENDS Weekly Diamond Pass 3x', 'HMLWDP3-S3', 'HMLWDP3-S3', 85974.00, 84337.00, 81880.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(59, 'mobile-legends', 'MOBILE LEGENDS Weekly Diamond Pass 4x', 'HMLWDP4-S3', 'HMLWDP4-S3', 114624.00, 112440.00, 109165.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(60, 'mobile-legends', 'MOBILE LEGENDS Weekly Diamond Pass 5x', 'HMLWDP5-S3', 'HMLWDP5-S3', 143273.00, 140544.00, 136450.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(61, 'mobile-legends', 'MOBILELEGEND - 10 Diamond', 'ML10', 'ML10', 2967.00, 2910.00, 2825.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(62, 'mobile-legends', 'MOBILELEGEND - 1050 Diamond', 'ML1050', 'ML1050', 267643.00, 262545.00, 254898.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(63, 'mobile-legends', 'MOBILELEGEND - 113 Diamond', 'ML113', 'ML113', 30373.00, 29794.00, 28926.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(64, 'mobile-legends', 'MOBILELEGEND - 1412 Diamond', 'ML1412', 'ML1412', 363864.00, 356934.00, 346537.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(65, 'mobile-legends', 'MOBILELEGEND - 1500 Diamond', 'ML1500', 'ML1500', 403055.00, 395377.00, 383861.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(66, 'mobile-legends', 'MOBILELEGEND - 1558 Diamond', 'ML1558', 'ML1558', 400277.00, 392653.00, 381216.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(67, 'mobile-legends', 'MOBILELEGEND - 170 Diamond', 'ML170', 'ML170', 46144.00, 45265.00, 43946.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(68, 'mobile-legends', 'MOBILELEGEND - 20 Diamond', 'ML20', 'ML20', 5928.00, 5815.00, 5645.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(69, 'mobile-legends', 'MOBILELEGEND - 2010 Diamond', 'ML2010', 'ML2010', 493422.00, 484023.00, 469925.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(70, 'mobile-legends', 'MOBILELEGEND - 240 Diamond', 'ML240', 'ML240', 65076.00, 63837.00, 61977.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(71, 'mobile-legends', 'MOBILELEGEND - 257 Diamond', 'ML257', 'ML257', 70098.00, 68763.00, 66760.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(72, 'mobile-legends', 'MOBILELEGEND - 284 Diamond', 'ML284', 'ML284', 78549.00, 77053.00, 74808.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(73, 'mobile-legends', 'MOBILELEGEND - 296 Diamond', 'ML296', 'ML296', 77464.00, 75989.00, 73775.00, 0, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(74, 'mobile-legends', 'MOBILELEGEND - 344 Diamond', 'ML344', 'ML344', 91611.00, 89866.00, 87248.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(75, 'mobile-legends', 'MOBILELEGEND - 36 Diamond', 'ML36', 'ML36', 9918.00, 9729.00, 9445.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(76, 'mobile-legends', 'MOBILELEGEND - 408 Diamond', 'ML408', 'ML408', 107651.00, 105600.00, 102524.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(77, 'mobile-legends', 'MOBILELEGEND - 429 Diamond', 'ML429', 'ML429', 113867.00, 111698.00, 108444.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(78, 'mobile-legends', 'MOBILELEGEND - 5 Diamond', 'ML5', 'ML5', 1510.00, 1482.00, 1438.00, 0, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(79, 'mobile-legends', 'MOBILELEGEND - 514 Diamond', 'ML514', 'ML514', 136239.00, 133644.00, 129751.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(80, 'mobile-legends', 'MOBILELEGEND - 54 Diamond', 'ML54', 'ML54', 15033.00, 14747.00, 14317.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(81, 'mobile-legends', 'MOBILELEGEND - 568 Diamond', 'ML568', 'ML568', 150075.00, 147216.00, 142928.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(82, 'mobile-legends', 'MOBILELEGEND - 600 Diamond', 'ML600', 'ML600', 159605.00, 156565.00, 152004.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(83, 'mobile-legends', 'MOBILELEGEND - 706 Diamond', 'ML706', 'ML706', 184119.00, 180612.00, 175351.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(84, 'mobile-legends', 'MOBILELEGEND - 74 Diamond', 'ML74', 'ML74', 19604.00, 19231.00, 18670.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(85, 'mobile-legends', 'MOBILELEGEND - 85 Diamond', 'ML85', 'ML85', 21756.00, 21342.00, 20720.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(86, 'mobile-legends', 'MOBILELEGEND - 875 Diamond', 'ML875', 'ML875', 230006.00, 225625.00, 219053.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(87, 'mobile-legends', 'MOBILELEGEND - 963 Diamond', 'ML963', 'ML963', 247198.00, 242489.00, 235426.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(88, 'mobile-legends', 'MOBILE LEGENDS Startlight Member', 'MLSL', 'MLSL', 80250.00, 78721.00, 76428.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(89, 'mobile-legends', 'MOBILE LEGENDS Twilight Pass', 'MLTP', 'MLTP', 148680.00, 145848.00, 141600.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(90, 'mobile-legends', 'MOBILE LEGENDS Weekly Diamond Pass', 'MLWDP', 'MLWDP', 28088.00, 27553.00, 26750.00, 1, 'Games', '2025-12-31 01:15:18', '2025-12-31 04:10:18'),
(91, 'free-fire', 'Free Fire Membership Mingguan', '4qY109', '4qY109', 27709.00, 27181.00, 26389.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(92, 'free-fire', 'Free Fire Membership Bulanan', '4qY210', '4qY210', 83057.00, 81475.00, 79101.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(93, 'free-fire', 'Free Fire 10 Diamond', 'FF10-S1', 'FF10-S1', 1644.00, 1612.00, 1565.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(94, 'free-fire', 'Free Fire 100 Diamond', 'FF100-S1', 'FF100-S1', 13115.00, 12865.00, 12490.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(95, 'free-fire', 'Free Fire 1000 Diamond', 'FF1000-S1', 'FF1000-S1', 125469.00, 123079.00, 119494.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(96, 'free-fire', 'Free Fire 140 Diamond', 'FF140-S1', 'FF140-S1', 17808.00, 17469.00, 16960.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(97, 'free-fire', 'Free Fire 20 Diamond', 'FF20-S1', 'FF20-S1', 3282.00, 3219.00, 3125.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(98, 'free-fire', 'Free Fire 200 Diamond', 'FF200-S1', 'FF200-S1', 27681.00, 27153.00, 26362.00, 0, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(99, 'free-fire', 'Free Fire 2000 Diamond', 'FF2000-S1', 'FF2000-S1', 241835.00, 237229.00, 230319.00, 0, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(100, 'free-fire', 'Free Fire 355 Diamond', 'FF355-S1', 'FF355-S1', 44919.00, 44064.00, 42780.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(101, 'free-fire', 'Free Fire 5 Diamond', 'FF5-S1', 'FF5-S1', 825.00, 809.00, 785.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(102, 'free-fire', 'Free Fire 50 Diamond', 'FF50-S1', 'FF50-S1', 6558.00, 6433.00, 6245.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(103, 'free-fire', 'Free Fire 500 Diamond', 'FF500-S1', 'FF500-S1', 63614.00, 62402.00, 60584.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18'),
(104, 'free-fire', 'Free Fire 720 Diamond', 'FF720-S1', 'FF720-S1', 91587.00, 89842.00, 87225.00, 1, 'Games', '2025-12-31 02:44:41', '2025-12-31 04:10:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('percent','flat') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `max_usage` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('FCvNVmf6H110TcXqb5KWra9KXF2XcYRV1Ua2X7FL', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRlFub0tIYzJ6SkQ4Y2VKWGZVbFNyaHRJU0dhcUJOOHF3ZTRWTlk4TyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2ludGVncmF0aW9uL3BheW1lbnQiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2ludGVncmF0aW9uL3BheW1lbnQiO3M6NToicm91dGUiO3M6MjU6ImFkbWluLmludGVncmF0aW9uLnBheW1lbnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1767613876);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `user_id_game` varchar(255) DEFAULT NULL,
  `nickname_game` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `price` bigint(20) NOT NULL DEFAULT 0,
  `target` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_provider` varchar(50) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'UNPAID',
  `sn` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `service` varchar(50) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `tripay_reference` varchar(255) DEFAULT NULL,
  `processing_status` varchar(255) NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `reference`, `user_id_game`, `nickname_game`, `product_code`, `amount`, `price`, `target`, `payment_method`, `payment_provider`, `status`, `sn`, `note`, `service`, `service_name`, `tripay_reference`, `processing_status`, `created_at`, `updated_at`) VALUES
(2, 4, 'DEP-CDBSRNUCWM', NULL, NULL, NULL, 10000.00, 10000, '-', 'QRIS', 'xendit', 'PAID', NULL, NULL, 'DEPOSIT', 'Isi Saldo Akun', NULL, 'PENDING', '2026-01-02 12:24:55', '2026-01-02 12:25:36'),
(3, 4, 'DEP-64ZBW0YOXO', NULL, NULL, NULL, 25000.00, 25000, '-', 'QRIS', 'xendit', 'UNPAID', NULL, NULL, 'DEPOSIT', 'Isi Saldo Akun', NULL, 'PENDING', '2026-01-02 12:26:05', '2026-01-02 12:26:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `balance` bigint(20) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL DEFAULT 'member',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `balance`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@topup.com', 0, 'admin', NULL, '$2y$12$bZp5cjTnwp5QBzxd9QjDV.LXJak8V.yZyifQZVfdYSys2YSY9Pt0O', NULL, '2025-12-31 01:12:32', '2025-12-31 01:12:32'),
(2, 'Member Test', 'member@gmail.com', 0, 'member', NULL, '$2y$12$Fj4PPLa1iGnH2LD1j.CGKudRYtpjg8BGJ9AuvOvLnX.q5qWORAlde', NULL, '2025-12-31 01:12:32', '2025-12-31 01:12:32'),
(4, 'faat', 'zoezillo05@gmail.com', 5000, 'member', NULL, '$2y$12$M8dkHwlaJMyvsac6IkXD7uR78Ag6SsfwzeIMzRhKDQ39nFmqckzE2', NULL, '2025-12-31 01:47:33', '2026-01-02 10:00:18');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `configurations_key_unique` (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `games_code_unique` (`code`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_code_unique` (`code`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`);

--
-- Indeks untuk tabel `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promos_code_unique` (`code`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_reference_unique` (`reference`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT untuk tabel `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT untuk tabel `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
