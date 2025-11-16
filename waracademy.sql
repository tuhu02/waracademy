-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Nov 2025 pada 17.55
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
-- Database: `waracademy`
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
-- Struktur dari tabel `kisi_kisi`
--

CREATE TABLE `kisi_kisi` (
  `id_kisi` bigint(20) UNSIGNED NOT NULL,
  `id_level` int(11) NOT NULL,
  `topik` text NOT NULL,
  `jumlah_soal` int(11) NOT NULL,
  `waktu_menit` int(11) NOT NULL,
  `jenis_soal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kisi_kisi`
--

INSERT INTO `kisi_kisi` (`id_kisi`, `id_level`, `topik`, `jumlah_soal`, `waktu_menit`, `jenis_soal`) VALUES
(1, 1, '[\n  {\n    \"nama\": \"Fotosintesis dan Organ Tumbuhan\",\n    \"submateri\": [\"Fungsi daun dalam fotosintesis\", \"Struktur organ tumbuhan\", \"Proses fotosintesis\"]\n  },\n  {\n    \"nama\": \"Peta dan Geografi Dasar\",\n    \"submateri\": [\"Pengertian peta\", \"Skala peta\", \"Simbol dan unsur peta\"]\n  },\n  {\n    \"nama\": \"Ide Pokok Teks Nonfiksi\",\n    \"submateri\": [\"Menentukan ide pokok paragraf\", \"Makna kalimat utama\", \"Isi teks informatif\"]\n  },\n  {\n    \"nama\": \"Operasi Hitung dan Sifat Distributif\",\n    \"submateri\": [\"Sifat distributif perkalian terhadap penjumlahan\", \"Operasi bilangan bulat\", \"Penyederhanaan bentuk aljabar sederhana\"]\n  },\n  {\n    \"nama\": \"Metode Ilmiah\",\n    \"submateri\": [\"Langkah-langkah metode ilmiah\", \"Observasi dan perumusan masalah\", \"Hipotesis dan eksperimen\"]\n  },\n  {\n    \"nama\": \"Letak Geografis dan Astronomis Indonesia\",\n    \"submateri\": [\"Letak astronomis\", \"Letak geografis\", \"Pengaruh letak terhadap iklim\"]\n  },\n  {\n    \"nama\": \"Perubahan Wujud Zat\",\n    \"submateri\": [\"Melepaskan dan menyerap kalor\", \"Menguap, mengembun, membeku, menyublim\", \"Perubahan fisika zat\"]\n  },\n  {\n    \"nama\": \"Iklim dan Musim di Indonesia\",\n    \"submateri\": [\"Penyebab dua musim\", \"Pengaruh angin monsun\", \"Letak geografis terhadap iklim\"]\n  },\n  {\n    \"nama\": \"Tumbuhan Dikotil\",\n    \"submateri\": [\"Ciri-ciri tumbuhan dikotil\", \"Perbedaan monokotil dan dikotil\", \"Struktur akar dan daun\"]\n  },\n  {\n    \"nama\": \"Perubahan Suhu dan Satuan Suhu\",\n    \"submateri\": [\"Kenaikan suhu per waktu\", \"Operasi bilangan positif\", \"Konsep perubahan suhu dalam derajat Celcius\"]\n  },\n  {\n    \"nama\": \"Klasifikasi Hewan\",\n    \"submateri\": [\"Hewan berdarah panas dan dingin\", \"Ciri poikiloterm\", \"Contoh hewan poikiloterm\"]\n  },\n  {\n    \"nama\": \"Persamaan Linear Satu Variabel\",\n    \"submateri\": [\"Konsep PLDV\", \"Langkah menyelesaikan persamaan sederhana\", \"Nilai variabel\"]\n  },\n  {\n    \"nama\": \"Proklamasi Kemerdekaan Indonesia\",\n    \"submateri\": [\"Tokoh proklamasi\", \"Peristiwa proklamasi 17 Agustus 1945\", \"Isi teks proklamasi\"]\n  },\n  {\n    \"nama\": \"Kata Hubung (Konjungsi) Temporal\",\n    \"submateri\": [\"Fungsi konjungsi waktu\", \"Contoh kalimat dengan konjungsi temporal\", \"Makna hubungan waktu\"]\n  },\n  {\n    \"nama\": \"Besaran dan Satuan Listrik\",\n    \"submateri\": [\"Satuan kuat arus listrik (ampere)\", \"Simbol dan alat ukur listrik\", \"Besaran pokok dalam SI\"]\n  },\n  {\n    \"nama\": \"ASEAN dan Negara Anggotanya\",\n    \"submateri\": [\"Negara pendiri ASEAN\", \"Tujuan ASEAN\", \"Kerja sama antarnegara ASEAN\"]\n  },\n  {\n    \"nama\": \"Bangun Datar Persegi\",\n    \"submateri\": [\"Ciri persegi\", \"Rumus keliling dan luas persegi\", \"Satuan panjang dalam cm\"]\n  },\n  {\n    \"nama\": \"Teks Informasi tentang Lingkungan\",\n    \"submateri\": [\"Isi teks deskriptif\", \"Informasi utama dalam teks\", \"Pelestarian lingkungan dan fauna endemik\"]\n  },\n  {\n    \"nama\": \"Interaksi Antar Makhluk Hidup\",\n    \"submateri\": [\"Simbiosis mutualisme, komensalisme, parasitisme\", \"Hubungan antar makhluk hidup\", \"Contoh hubungan saling menguntungkan\"]\n  },\n  {\n    \"nama\": \"Kebutuhan Pokok Manusia\",\n    \"submateri\": [\"Jenis kebutuhan (primer, sekunder, tersier)\", \"Contoh kebutuhan primer\", \"Faktor pemenuhan kebutuhan\"]\n  }\n]\n', 10, 3, 'pilihan_ganda'),
(2, 2, '[\n  {\n    \"nama\": \"Bilangan Bulat dan Eksponen\",\n    \"submateri\": [\"Operasi Hitung Bilangan Bulat\", \"Sifat-Sifat Operasi Bilangan\", \"Perpangkatan Bilangan Bulat\"]\n  },\n  {\n    \"nama\": \"Himpunan\",\n    \"submateri\": [\"Pengertian Himpunan\", \"Komplemen Himpunan\", \"Diagram Venn\"]\n  },\n  {\n    \"nama\": \"Perbandingan\",\n    \"submateri\": [\"Skala\", \"Perbandingan Senilai\", \"Satuan Ukuran (Lusin, Kodi, dll)\"]\n  },\n  {\n    \"nama\": \"Besaran dan Satuan\",\n    \"submateri\": [\"Besaran Pokok dan Turunan\", \"Satuan Internasional\", \"Alat Ukur Fisika\"]\n  },\n  {\n    \"nama\": \"Sistem Pernapasan Manusia\",\n    \"submateri\": [\"Organ Pernapasan\", \"Proses Respirasi\", \"Zat Sisa Metabolisme\"]\n  },\n  {\n    \"nama\": \"Geografi Indonesia\",\n    \"submateri\": [\"Kepadatan Penduduk\", \"Kondisi Geografis Pulau Jawa\", \"Organisasi Regional (ASEAN)\"]\n  },\n  {\n    \"nama\": \"Keanekaragaman Hayati\",\n    \"submateri\": [\"Fauna Tipe Asiatis, Australis, dan Peralihan\", \"Ciri-ciri Hewan Endemik\"]\n  },\n  {\n    \"nama\": \"Bahasa Indonesia – Makna Kata & Ungkapan\",\n    \"submateri\": [\"Kata Bermakna Konotatif\", \"Ungkapan Idiomatik\", \"Pemahaman Teks Naratif\"]\n  },\n  {\n    \"nama\": \"Iklan dan Teks Nonfiksi\",\n    \"submateri\": [\"Ciri-ciri Iklan\", \"Penafsiran Kalimat dalam Iklan\", \"Struktur Teks\"]\n  },\n  {\n    \"nama\": \"Tokoh dan Nilai Keteladanan\",\n    \"submateri\": [\"Biografi Tokoh Nasional\", \"Nilai Karakter dari Perjuangan Tokoh\"]\n  },\n  {\n    \"nama\": \"Rumah Adat dan Budaya Nusantara\",\n    \"submateri\": [\"Rumah Adat Sumatera Barat\", \"Kearifan Lokal\"]\n  },\n  {\n    \"nama\": \"Perubahan Wujud Zat\",\n    \"submateri\": [\"Menguap\", \"Mengembun\", \"Menyublim\", \"Membeku\"]\n  }\n]', 10, 5, 'pilihan_ganda'),
(3, 3, '[\n  {\n    \"nama\": \"Operasi Hitung Campuran dan Pecahan\",\n    \"submateri\": [\"Operasi campuran bilangan bulat dan pecahan\", \"Penerapan sifat distributif\", \"Penyelesaian soal cerita aritmetika\"]\n  },\n  {\n    \"nama\": \"Getaran dan Frekuensi\",\n    \"submateri\": [\"Pengertian frekuensi dan periode\", \"Hubungan jumlah getaran dan waktu\", \"Satuan hertz (Hz)\"]\n  },\n  {\n    \"nama\": \"Interaksi Antarwilayah\",\n    \"submateri\": [\"Faktor saling melengkapi antarwilayah\", \"Pola distribusi sumber daya\", \"Keterkaitan ekonomi antar daerah\"]\n  },\n  {\n    \"nama\": \"Ide Pokok dan Kalimat Utama Teks\",\n    \"submateri\": [\"Menentukan ide pokok paragraf\", \"Kalimat utama dalam teks nonfiksi\", \"Ciri-ciri paragraf deduktif dan induktif\"]\n  },\n  {\n    \"nama\": \"Skala dan Perhitungan Jarak pada Peta\",\n    \"submateri\": [\"Pengertian skala peta\", \"Menghitung jarak sebenarnya\", \"Konversi satuan dari cm ke km\"]\n  },\n  {\n    \"nama\": \"Gelombang Bunyi\",\n    \"submateri\": [\"Jenis gelombang longitudinal dan transversal\", \"Arah rambat dan getar gelombang\", \"Contoh gelombang bunyi dalam kehidupan sehari-hari\"]\n  },\n  {\n    \"nama\": \"Fungsi Linear Satu Variabel\",\n    \"submateri\": [\"Bentuk umum f(x) = ax + b\", \"Menentukan nilai a dan b\", \"Menghitung nilai fungsi untuk x tertentu\"]\n  },\n  {\n    \"nama\": \"Perubahan Sosial Budaya\",\n    \"submateri\": [\"Jenis perubahan sosial\", \"Perbedaan evolusi dan revolusi\", \"Contoh perubahan sosial cepat dalam masyarakat\"]\n  },\n  {\n    \"nama\": \"Gelombang dan Panjang Gelombang\",\n    \"submateri\": [\"Hubungan antara kecepatan, frekuensi, dan panjang gelombang\", \"Rumus λ = v/f\", \"Satuan panjang gelombang\"]\n  },\n  {\n    \"nama\": \"Produktivitas dan Perbandingan Kerja\",\n    \"submateri\": [\"Hubungan antara jumlah pekerja, waktu, dan hasil\", \"Konsep perbandingan terbalik\", \"Penyelesaian masalah efisiensi kerja\"]\n  },\n  {\n    \"nama\": \"Interaksi Sosial dalam Masyarakat\",\n    \"submateri\": [\"Bentuk interaksi sosial asosiatif dan disosiatif\", \"Contoh interaksi berupa konflik\", \"Dampak sosial dari interaksi negatif\"]\n  },\n  {\n    \"nama\": \"Teks Biografi Tokoh\",\n    \"submateri\": [\"Ciri-ciri teks biografi\", \"Keistimewaan tokoh dalam teks\", \"Informasi penting dalam biografi\"]\n  },\n  {\n    \"nama\": \"Indera Penglihatan dan Proses Pembentukan Bayangan\",\n    \"submateri\": [\"Bagian-bagian mata dan fungsinya\", \"Urutan perjalanan cahaya dalam mata\", \"Peran retina dalam pembentukan bayangan\"]\n  },\n  {\n    \"nama\": \"Bunga Tabungan dan Persentase\",\n    \"submateri\": [\"Rumus bunga tunggal\", \"Menghitung bunga berdasarkan waktu (bulan/tahun)\", \"Hubungan antara suku bunga, modal, dan waktu\"]\n  },\n  {\n    \"nama\": \"Ekosistem Hutan Mangrove\",\n    \"submateri\": [\"Fungsi ekologis mangrove\", \"Habitat dan perlindungan biota laut\", \"Peranan hutan mangrove terhadap lingkungan pantai\"]\n  },\n  {\n    \"nama\": \"Gradien dan Hubungan Antar Garis\",\n    \"submateri\": [\"Menentukan gradien garis dari persamaan\", \"Konsep garis sejajar dan tegak lurus\", \"Hubungan m1 × m2 = -1\"]\n  },\n  {\n    \"nama\": \"Cermin Cembung dan Sifat Bayangan\",\n    \"submateri\": [\"Jenis cermin dan sifat bayangan\", \"Menggunakan rumus cermin (1/f = 1/s + 1/s’)\", \"Ciri bayangan maya, tegak, dan diperkecil\"]\n  },\n  {\n    \"nama\": \"Konsep Lokasi Geografis\",\n    \"submateri\": [\"Perbedaan lokasi absolut dan relatif\", \"Faktor yang memengaruhi lokasi\", \"Contoh penerapan lokasi relatif dalam kehidupan sehari-hari\"]\n  },\n  {\n    \"nama\": \"Konjungsi dan Hubungan Antar Kalimat\",\n    \"submateri\": [\"Jenis hubungan kalimat (pertentangan, sebab-akibat, waktu)\", \"Identifikasi kata penghubung pertentangan\", \"Makna hubungan antar kalimat\"]\n  },\n  {\n    \"nama\": \"Bangun Datar Belah Ketupat\",\n    \"submateri\": [\"Rumus keliling dan luas belah ketupat\", \"Hubungan antara sisi dan diagonal\", \"Penerapan teorema Pythagoras dalam belah ketupat\"]\n  }\n]', 10, 5, 'pilihan_ganda');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nomor_level` int(11) NOT NULL,
  `tingkat_kesulitan` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id_level`, `nomor_level`, `tingkat_kesulitan`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_11_062527_add_google_id_to_users_table', 2),
(5, '2025_11_09_000001_create_tournaments_table', 3);

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
-- Struktur dari tabel `pencapaian`
--

CREATE TABLE `pencapaian` (
  `id_pencapaian` int(11) NOT NULL,
  `nama_pencapaian` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pencapaian`
--

INSERT INTO `pencapaian` (`id_pencapaian`, `nama_pencapaian`, `deskripsi`) VALUES
(1, 'Langkah Pertama', 'Berhasil menyelesaikan level 1.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pencapaianpengguna`
--

CREATE TABLE `pencapaianpengguna` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_pencapaian` int(11) NOT NULL,
  `tanggal_didapat` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pencapaianpengguna`
--

INSERT INTO `pencapaianpengguna` (`id`, `id_pengguna`, `id_pencapaian`, `tanggal_didapat`) VALUES
(1, 1, 1, '2025-10-09 09:28:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('student','teacher') NOT NULL DEFAULT 'student',
  `password_hash` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `total_exp` int(11) DEFAULT 0,
  `deskripsi_profil` text DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `tanggal_registrasi` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `email`, `role`, `password_hash`, `google_id`, `total_exp`, `deskripsi_profil`, `avatar_url`, `tanggal_registrasi`) VALUES
(1, 'budisantoso', 'budi@email.com', 'student', 'hash12345', NULL, 100, NULL, NULL, '2025-10-09 09:28:07'),
(2, 'Ibu Retno', 'retno@guru.id', 'teacher', 'hash67890', NULL, 0, NULL, NULL, '2025-10-09 09:28:07'),
(3, 'paijo', 'paijo@gmail.com', 'student', '$2y$12$ZuFzC4YCkB.YxgOrWGF6A..DNuL96xOTshM79gvWivKMRLpA27BO6', NULL, 0, NULL, NULL, '2025-10-10 23:17:19'),
(4, 'Fajar Ali Hamzah_ MVP', 'pajarali15@gmail.com', 'student', '$2y$12$WEyJytynopwe.rC.rzku0uB0K24QA8ntaDJuBxUOoBCl/OGxYiRHi', '115700289121580866720', 0, NULL, NULL, '2025-10-10 23:34:02'),
(5, 'pa jarrr', 'pajarrr880@gmail.com', 'student', '$2y$12$bRXfQIbXN6pXoFq2lUOBOuWDGzHysgpfgLBwTXq9dUOj4V1ZBOHiu', '100178159551451873969', 0, NULL, NULL, '2025-10-11 07:21:54'),
(6, '23-040_ M. ALDI RAHMANDIKA', 'aldirahmandika2@gmail.com', 'student', '$2y$12$ok0IMF0Mz6bLs0Ea3c1c9ekiaiG5CsoDw4vpXGL73TQuP/xFtOaSi', '116026049394161582648', 0, NULL, NULL, '2025-10-25 06:40:34'),
(7, 'toyib', 'toyib@gmail.com', 'student', '$2y$12$w7sJaFQ4Egr6phGXnxBlV.p402U7j3ZRLYUY2GxS/N5L5cQydiVoW', NULL, 0, NULL, NULL, '2025-10-26 05:33:48'),
(8, 'brian', 'brian@gmail.com', 'student', '$2y$12$wRr5s9MFTKdYo7FTwhWFxOvhfq.HZO1UEru1q5Fkq6nbAu2MkcSMy', NULL, 0, NULL, NULL, '2025-10-26 05:40:50'),
(9, 'tuhu01', 'tuhuwkwk@gmail.com', 'teacher', '$2y$12$d.ox8qeq.5KHHBc701RLku.gZ.qzBtGv6ALmKNw8..sQECX4jJA1W', NULL, 0, NULL, NULL, '2025-11-06 10:15:54'),
(10, 'cherie', 'esotreic@gmail.com', 'student', '$2y$12$D3m/j32jNQ8iKiFLy0x3EutbUrwlpQMbTt226I0yTBRhAxUH0vls.', '112429940452917586185', 0, NULL, NULL, '2025-11-14 14:17:39'),
(11, 'ainun', 'abscour297@gmail.com', 'student', '$2y$12$tYD0lE.ej6O4C/vVy/vqVOx3M2v0rF1f4asmPV0euqeH7QG1nIZ.6', '116773823339407239061', 0, NULL, NULL, '2025-11-14 14:18:51'),
(12, 'wiwik', 'wiwik@gmail.com', 'teacher', '$2y$12$nj5BHomBYjpGdIh/EDVO/OHXY1KBMY9laBstjfJox5q.gLUyGXq5O', NULL, 0, NULL, NULL, '2025-11-14 14:30:12'),
(13, 'dyzael', 'dyzael2@gmail.com', 'student', '$2y$12$6eCaKy5n4qGEkJjgAOzgm.zWhoL1l8Nytre/M02WAKT3M49EiyBPa', '113970458710093350463', 0, NULL, NULL, '2025-11-14 23:46:26'),
(14, 'man', 'man@gmail.com', 'student', '$2y$12$SL5sUFuXTigFlrLpV3234OsHQRAMVy4YkD8lKYMBvGHx3hLj.fI7u', NULL, 0, NULL, 'avataranime.jpg', '2025-11-15 07:10:05'),
(16, 'anjay', 'mana@gmail.com', 'student', '$2y$12$SL5sUFuXTigFlrLpV3234OsHQRAMVy4YkD8lKYMBvGHx3hLj.fI7u', NULL, 0, NULL, 'avataranime.jpg', '2025-11-15 07:10:05'),
(17, 'Anomali', 'anomali@gmail.com', 'student', '$2y$12$6B1/D3gJrzsazCVQq2oY3ehANK6MV.5LY2IHsy4IlD7WzXrEHMqty', NULL, 0, NULL, NULL, '2025-11-15 15:59:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` int(11) NOT NULL,
  `id_level` int(11) DEFAULT NULL,
  `teks_pertanyaan` text NOT NULL,
  `untuk_turnamen` tinyint(1) DEFAULT 0,
  `dibuat_oleh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pertanyaan`
--

INSERT INTO `pertanyaan` (`id_pertanyaan`, `id_level`, `teks_pertanyaan`, `untuk_turnamen`, `dibuat_oleh`) VALUES
(1, 1, 'Organ tumbuhan yang berfungsi sebagai tempat terjadinya fotosintesis adalah...', 0, NULL),
(2, 1, 'Gambaran permukaan bumi pada suatu bidang datar dengan skala tertentu disebut...', 0, NULL),
(3, 1, 'Wortel sangat bermanfaat bagi kesehatan tubuh. Beberapa manfaat wortel antara lain menjaga kesehatan mata, mencegah rabun senja, dan menghilangkan racun dalam tubuh. Ide pokok kutipan teks tersebut adalah....', 0, NULL),
(4, 1, 'Hasil dari 32 × (8+7) dengan menggunakan sifat distributif adalah...', 0, NULL),
(5, 1, 'Langkah awal yang harus dilakukan dalam metode ilmiah adalah...', 0, NULL),
(6, 1, 'Letak suatu wilayah berdasarkan garis lintang dan garis bujur disebut letak...', 0, NULL),
(7, 1, 'Berikut ini yang merupakan contoh dari perubahan wujud zat yang melepaskan kalor adalah...', 0, NULL),
(8, 1, 'Negara Indonesia memiliki dua musim, yaitu musim hujan dan musim kemarau. Hal ini disebabkan oleh pengaruh...', 0, NULL),
(9, 1, 'Tumbuhan dikotil adalah tumbuhan berbiji berkeping dua. Tumbuhan ini memiliki sepasang daun lembaga yang sudah terbentuk sejak dalam biji. Tumbuhan dikotil memiliki beberapa ciri khusus, seperti bentuk akar tunggang dan pola tulang daun yang menyirip atau menjari. Gagasan utama paragraf tersebut adalah…', 0, NULL),
(10, 1, 'Suhu di sebuah kota pada pagi hari adalah 14°C. Setiap jam, suhu naik sebesar 3°C. Suhu kota tersebut setelah 4 jam adalah...', 0, NULL),
(11, 1, 'Berikut ini yang termasuk kelompok hewan berdarah dingin (poikiloterm) adalah...', 0, NULL),
(12, 1, 'Jika 2x + 5 = 17, maka nilai x adalah...', 0, NULL),
(13, 1, 'Dua tokoh sentral yang menandatangani naskah proklamasi kemerdekaan Indonesia atas nama bangsa Indonesia adalah...', 0, NULL),
(14, 1, 'Kalimat berikut yang menggunakan kata hubung (konjungsi) temporal (waktu) adalah...', 0, NULL),
(15, 1, 'Dalam Sistem Internasional (SI), satuan untuk mengukur kuat arus listrik adalah...', 0, NULL),
(16, 1, 'Berikut ini yang bukan merupakan negara pendiri ASEAN (Association of Southeast Asian Nations) adalah...', 0, NULL),
(17, 1, 'Sebuah persegi memiliki panjang sisi 12 cm. Keliling persegi tersebut adalah...', 0, NULL),
(18, 1, 'Taman Nasional Komodo terletak di antara Pulau Sumbawa dan Pulau Flores. Taman nasional ini menjadi habitat asli hewan komodo, kadal terbesar di dunia. Selain komodo, di kawasan ini juga hidup kuda liar, rusa, dan berbagai jenis burung. Keindahan bawah lautnya juga terkenal dengan terumbu karang yang beragam. Informasi yang sesuai dengan isi teks tersebut adalah...', 0, NULL),
(19, 1, 'Hubungan timbal balik antara dua makhluk hidup yang saling menguntungkan disebut...', 0, NULL),
(20, 1, 'Kebutuhan manusia yang harus dipenuhi untuk kelangsungan hidup, seperti makanan, pakaian, dan tempat tinggal, disebut kebutuhan...', 0, NULL),
(21, 2, 'Hasil dari 25 - (-15) + 10 adalah...', 0, NULL),
(22, 2, 'Kelompok besaran di bawah ini yang seluruhnya merupakan besaran pokok adalah...', 0, NULL),
(23, 2, 'Interaksi sosial yang mengarah pada perpecahan atau konflik disebut...', 0, NULL),
(24, 2, 'Alat yang digunakan untuk mengukur volume sebuah batu yang bentuknya tidak beraturan adalah...', 0, NULL),
(25, 2, 'Di pantai Sanur, Bali, terdapat wisata selam yang digemari para penyelam. Pantai Sanur juga dikenal dengan matahari terbitnya yang sangat indah dan memiliki pasir putih yang sangat \"eksotis\".\n\nMakna kata eksotis dalam teks tersebut adalah...', 0, NULL),
(26, 2, 'Hasil dari 3^-2 × 3^5 adalah...', 0, NULL),
(27, 2, 'Oksigen yang kita hirup saat bernapas akan digunakan oleh tubuh untuk proses...', 0, NULL),
(28, 2, 'Organisasi negara-negara di kawasan Asia Tenggara adalah...', 0, NULL),
(29, 2, 'Beberapa warga berdatangan. Mereka merangsek ke depan, tidak sabar ingin melihat apa yang terjadi. Suasana menjadi sesak dan banyak di antara mereka yang naik pitam karena saling dorong.\n\nMakna ungkapan naik pitam pada kutipan teks tersebut adalah…', 0, NULL),
(30, 2, 'Sebuah kapal selam berada 20 m di bawah permukaan laut. Kemudian, kapal tersebut turun lagi sejauh 15 m. Posisi kapal selam sekarang adalah...', 0, NULL),
(31, 2, 'Zat sisa metabolisme yang dikeluarkan melalui paru-paru adalah...', 0, NULL),
(32, 2, 'Rumah adat dari daerah Sumatera Barat dikenal dengan sebutan...', 0, NULL),
(33, 2, 'Perubahan wujud dari gas menjadi cair disebut...', 0, NULL),
(34, 2, 'Bentuk sederhana dari perbandingan 2 lusin : 3 kodi adalah...', 0, NULL),
(35, 2, 'Penjelasan kalimat pada iklan “Madu Green Organik: Makanan bebas pencemaran.” adalah…', 0, NULL),
(36, 2, 'Salah satu faktor yang menyebabkan Pulau Jawa lebih padat penduduknya dibandingkan pulau lainnya adalah...', 0, NULL),
(37, 2, 'Organ pernapasan yang strukturnya tersusun dari cincin-cincin tulang rawan dan epitelium bersilia adalah...', 0, NULL),
(38, 2, 'Jika S = {1,2,3,4,5,6,7,8,9,10} dan A = {2,4,6,8}, maka komplemen dari himpunan A adalah...', 0, NULL),
(39, 2, 'Hewan seperti beruang, walabi, dan kuskus termasuk ke dalam jenis fauna Indonesia tipe...', 0, NULL),
(40, 2, 'Hal yang dapat diteladani dari tokoh B.J. Habibie adalah…', 0, NULL),
(41, 3, 'Hasil dari (24 × 3) + (15 : (3/4)) - 7 adalah...', 0, NULL),
(42, 3, 'Jika sebuah benda bergetar sebanyak 60 kali dalam waktu 15 detik, maka frekuensi getaran benda tersebut adalah...', 0, NULL),
(43, 3, 'Wilayah A surplus sayuran tetapi minus ikan. Wilayah B surplus ikan tetapi minus sayuran. Interaksi antara kedua wilayah ini terjadi karena adanya...', 0, NULL),
(44, 3, 'Bacalah teks berikut! (1) Masyarakat Jawa memiliki dua model adaptasi ketika bermigrasi. (2) Model pertama adalah adaptasi total dengan meninggalkan budaya asal. (3) Model kedua adalah adaptasi dengan tetap mempertahankan sebagian budaya asal. (4) Kedua model ini terlihat pada komunitas Jawa di berbagai daerah. Kalimat utama paragraf tersebut adalah nomor…', 0, NULL),
(45, 3, 'Sebuah peta memiliki skala 1 : 1.500.000. Jika jarak antara kota A dan B pada peta adalah 4 cm, maka jarak sebenarnya adalah...', 0, NULL),
(46, 3, 'Bunyi termasuk gelombang longitudinal karena arah rambatnya...', 0, NULL),
(47, 3, 'Suatu fungsi dirumuskan dengan f(x) = ax + b. Jika f(5) = 7 dan f(-4) = -11, maka nilai f(3) adalah...', 0, NULL),
(48, 3, 'Proses perubahan sosial budaya yang berlangsung secara cepat dan menyangkut dasar-dasar kehidupan masyarakat disebut...', 0, NULL),
(49, 3, 'Sebuah gelombang merambat dengan kecepatan 340 m/s. Jika frekuensi gelombang adalah 40 Hz, panjang gelombang dari gelombang tersebut adalah...', 0, NULL),
(50, 3, 'Seorang pemborong memperkirakan dapat menyelesaikan proyek selama 60 hari dengan 20 pekerja. Jika proyek tersebut ingin diselesaikan dalam 50 hari, jumlah pekerja yang harus ditambahkan adalah...', 0, NULL),
(51, 3, 'Tawuran antarsuporter sepak bola yang menimbulkan korban luka adalah salah satu contoh interaksi sosial yang berbentuk...', 0, NULL),
(52, 3, 'Bacalah kutipan berikut! Andrea Hirata adalah penulis novel Laskar Pelangi yang sangat populer. Selain menjadi penulis, ia juga merupakan lulusan Master Ekonomi Mikro dari Universitas Sorbonne, Prancis. Keistimewaan tokoh berdasarkan kutipan tersebut adalah…', 0, NULL),
(53, 3, 'Berikut ini proses perjalanan cahaya pada mata hingga terbentuk bayangan benda adalah…', 0, NULL),
(54, 3, 'Andi menabung di bank sebesar Rp 1.500.000,00 dengan bunga 10% per tahun. Jumlah bunga yang diterima Andi setelah menabung selama 8 bulan adalah...', 0, NULL),
(55, 3, 'Fungsi ekologis dari hutan mangrove adalah sebagai...', 0, NULL),
(56, 3, 'Gradien garis yang tegak lurus dengan garis 3x + 2y - 5 = 0 adalah...', 0, NULL),
(57, 3, 'Sebuah benda yang tingginya 12 cm diletakkan 10 cm di depan cermin cembung yang jari-jari kelengkungannya 30 cm. Sifat bayangan yang terbentuk adalah...', 0, NULL),
(58, 3, 'Yono melakukan perjalanan dari Tasikmalaya menuju Pacitan. Ia memilih jalur selatan karena waktu tempuhnya lebih singkat. Konsep lokasi yang digunakan dalam informasi ini adalah...', 0, NULL),
(59, 3, 'Bacalah teks berikut! (1) Kesibukan membuatnya kerap meminta dispensasi pada sekolah. (2) Ia harus berlatih keras setiap hari. (3) Namun, prestasinya di bidang olahraga sangat membanggakan. (4) Sekolah pun mendukung penuh kegiatannya. Kalimat yang menyatakan hubungan pertentangan ditandai nomor…', 0, NULL),
(60, 3, 'Luas sebuah belah ketupat yang kelilingnya 40 cm dan panjang salah satu diagonalnya 16 cm adalah...', 0, NULL),
(61, 4, 'Sebuah mikroskop memiliki perbesaran lensa objektif 40x dan perbesaran lensa okuler 10x. Perbesaran total bayangan objek yang dilihat adalah...', 0, NULL),
(62, 4, 'Upaya pemerintah yang paling tepat untuk mengatasi masalah persebaran penduduk yang tidak merata di Indonesia adalah...', 0, NULL),
(63, 4, 'Sebuah tongkat tingginya 1,5 m mempunyai bayangan 1 m. Pada saat yang sama, bayangan sebuah tiang bendera adalah 2,5 m. Tinggi tiang bendera tersebut adalah...', 0, NULL),
(64, 4, 'Partikel tak bermuatan yang menyusun inti atom disebut...', 0, NULL),
(65, 4, 'Kegiatan perkemahan ini mengangkat tema \"Pramuka Indonesia Bersama Masyarakat Membangun Tanah Papua\". Kegiatan ini dikombinasikan dengan pesta budaya Festival Danau Sentani.\n\n\nMakna kata kombinasi pada teks tersebut adalah...', 0, NULL),
(66, 4, 'Perhatikan pernyataan berikut!\n(1) $4x^2-9=(2x+3)(2x-3)$\n(2) $2x^2+x-3=(2x+3)(x-1)$\n(3) $x^2+x-6=(x+3)(x-2)$\n(4) $x^2+4x-5=(x-5)(x+1)$\n\nPernyataan yang benar adalah...', 0, NULL),
(67, 4, 'Proses pembentukan individu baru dari sel telur yang tidak dibuahi oleh sperma, seperti pada lebah, disebut...', 0, NULL),
(68, 4, 'Faktor geografis yang dapat memengaruhi penyebaran dan kepadatan penduduk adalah...', 0, NULL),
(69, 4, 'Sebuah tanah berbentuk setengah lingkaran dengan diameter 42 m. Di sekeliling tanah tersebut akan ditanami pohon dengan jarak antar pohon 3 m. Banyak pohon yang dibutuhkan adalah...', 0, NULL),
(70, 4, 'Bacalah teks berikut!\nUntuk mewujudkan lingkungan sehat, diperlukan upaya persuasif untuk memberikan pemahaman kepada masyarakat. Selain itu, perlu ditunjukkan contoh nyata dan masyarakat perlu dilibatkan dalam setiap kegiatan\n\nMakna kata persuasif pada teks tersebut adalah…', 0, NULL),
(71, 4, 'Di sebuah tempat parkir terdapat 75 kendaraan yang terdiri dari sepeda motor (2 roda) dan mobil (4 roda). Jika jumlah seluruh roda adalah 210, maka banyaknya mobil di tempat parkir tersebut adalah...', 0, NULL),
(72, 4, 'Golongan bahan yang dapat ditarik kuat oleh magnet disebut...', 0, NULL),
(73, 4, 'Salah satu pengaruh masuknya kebudayaan Hindu-Buddha di bidang sosial adalah...', 0, NULL),
(74, 4, 'Bacalah paragraf berikut!\n(1) Terkena serangan jantung adalah pembunuh utama di dunia. (2) Banyak faktor yang membuat seseorang terkena serangan jantung. (3) Salah satu di antaranya adalah tingginya kolesterol dalam tubuh. (4) Jumlah lemak yang dikonsumsi juga menjadi salah satu pemicu kolesterol.\nKalimat utama paragraf tersebut ditandai dengan nomor…', 0, NULL),
(75, 4, 'Suku ketiga dan suku keenam suatu barisan aritmetika berturut-turut adalah 3 dan 18. Jumlah 10 suku pertama barisan tersebut adalah...', 0, NULL),
(76, 4, 'Perhatikan gambar pembuatan magnet berikut!\nSebuah paku dililiti kawat yang dialiri arus listrik dari baterai.\n\nMetode pembuatan magnet tersebut adalah...', 0, NULL),
(77, 4, 'Perhatikan kegiatan ekonomi berikut!\n(1) David memakan roti di warung.\n(2) Ahmad membuat roti untuk dijual.\n(3) Fernandes mengirim roti pesanan konsumen.\n\nUrutan kegiatan produksi, distribusi, dan konsumsi yang benar adalah...', 0, NULL),
(78, 4, 'Sebuah kerucut mempunyai volume 20 cm^3. Jika diameter kerucut tersebut diperbesar 3 kali dan tingginya diperbesar 2 kali, maka volume kerucut yang baru adalah...', 0, NULL),
(79, 4, 'Garis-garis lengkung yang keluar dari kutub utara menuju kutub selatan sebuah magnet disebut...', 0, NULL),
(80, 4, 'Peristiwa menyerahnya Jepang kepada Sekutu pada tanggal 15 Agustus 1945 menyebabkan terjadinya... di Indonesia.', 0, NULL),
(81, 5, 'Bacalah kedua kutipan berita berikut!\nTeks 1: Pemerintah akan menambah jumlah puskesmas yang ramah bagi para lansia untuk meningkatkan kualitas hidup mereka.\nTeks 2: Para lansia sebaiknya tidak dibiarkan tanpa aktivitas. Kegiatan ringan seperti berkebun atau senam dapat menjaga kebugaran fisik dan mental mereka.\nPersamaan isi kedua kutipan berita tersebut adalah…', 0, NULL),
(82, 5, 'Diketahui rumus fungsi f(x) = x^2 + 3x - 4. Titik potong grafik fungsi tersebut terhadap sumbu X adalah...', 0, NULL),
(83, 5, 'Bioteknologi konvensional memanfaatkan mikroorganisme secara langsung untuk menghasilkan produk. Contoh produk bioteknologi konvensional adalah...', 0, NULL),
(84, 5, 'Seorang tukang parkir mendapat uang Rp 17.000,00 dari 3 mobil dan 5 motor. Sedangkan dari 4 mobil dan 2 motor, ia mendapat Rp 18.000,00. Jika terdapat 20 mobil dan 30 motor, pendapatan parkir yang ia peroleh adalah...', 0, NULL),
(85, 5, 'Bacalah puisi berikut!\nSepi di luar, sepi menekan mendesak\nlurus kaku pepohonan tak bergerak\nsampai ke puncak.\nSuasana yang tergambar dalam puisi tersebut adalah…', 0, NULL),
(86, 5, 'Dua buah dadu dilempar bersamaan. Peluang munculnya mata dadu berjumlah 8 adalah...', 0, NULL),
(87, 5, 'Tanah yang subur dan kaya akan bahan organik hasil dari pelapukan dedaunan dan sisa-sisa makhluk hidup disebut tanah...', 0, NULL),
(88, 5, 'Sifat bayangan yang dibentuk oleh lensa okuler pada mikroskop adalah...', 0, NULL),
(89, 5, 'Sebuah tabung dengan jari-jari 10 cm dan tinggi 20 cm akan diisi air hingga penuh. Volume air yang dibutuhkan adalah... (π = 3,14)', 0, NULL),
(90, 5, 'Organisasi pergerakan nasional pertama di Indonesia yang berfokus pada bidang pendidikan dan kebudayaan adalah...', 0, NULL),
(91, 5, 'Bacalah kutipan tajuk rencana berikut!\nTampaknya, kepekaan kita pelan-pelan menyusut setelah tragedi demi tragedi itu kini hampir menjadi rutin. Kita khawatir, lama-lama semua menjadi biasa dan tidak ada lagi rasa sedih. Sesuatu yang menjadi rutin, tidak lagi mengusik kita.\nPihak yang dikritik dalam kutipan tajuk tersebut adalah…', 0, NULL),
(92, 5, 'Sifat paling mencolok yang muncul pada keturunan dan menutupi sifat pasangannya disebut...', 0, NULL),
(93, 5, 'Rata-rata nilai ulangan matematika dari 8 siswa adalah 75. Jika digabung dengan nilai 2 siswa lainnya, rata-ratanya menjadi 78. Berapakah rata-rata nilai kedua siswa tersebut?', 0, NULL),
(94, 5, 'Perubahan iklim global yang ditandai dengan meningkatnya suhu rata-rata bumi disebabkan oleh...', 0, NULL),
(95, 5, 'Kromosom yang berfungsi untuk menentukan jenis kelamin suatu individu disebut...', 0, NULL),
(96, 5, 'Sebuah kotak berisi 5 bola merah dan 3 bola biru. Jika diambil satu bola secara acak, peluang terambilnya bola biru adalah...', 0, NULL),
(97, 5, 'Bacalah paragraf berikut!\nSeseorang akan diuji dengan apa yang ia miliki. Ketika memiliki ilmu, ia akan diuji dengan kemampuannya memanfaatkan ilmu. Ketika mempunyai harta, ia akan diuji dengan keikhlasannya mendistribusikan hartanya.\nIde pokok paragraf tersebut adalah…', 0, NULL),
(98, 5, 'Perhatikan diagram transformator berikut!\nJumlah lilitan primer (Np) = 1200, jumlah lilitan sekunder (Ns) = 300. Jika tegangan primer (Vp) = 220 volt, maka tegangan sekunder (Vs) adalah...', 0, NULL),
(99, 5, 'Dalam sistem tanam paksa (Cultuurstelsel) yang diterapkan Belanda, rakyat Indonesia diwajibkan menanam tanaman ekspor seperti...', 0, NULL),
(100, 5, 'Dua buah lingkaran memiliki jari-jari masing-masing 10 cm dan 6 cm. Jika jarak kedua pusatnya 20 cm, panjang garis singgung persekutuan dalamnya adalah...', 0, NULL),
(101, 6, 'Sebuah benda diletakkan di depan lensa cembung yang memiliki jarak fokus 15 cm. Jika bayangan yang terbentuk bersifat nyata dan berada pada jarak 30 cm dari lensa, maka jarak benda dari lensa adalah...', 0, NULL),
(102, 6, 'Globalisasi di bidang ekonomi ditandai dengan adanya...', 0, NULL),
(103, 6, 'Modus dari data: 7, 8, 9, 6, 7, 8, 9, 8, 10, 8 adalah...', 0, NULL),
(104, 6, 'Bacalah kutipan berikut!\nJika banjir Jakarta yang akan datang ternyata lebih besar, berarti itu menjadi kado terburuk pada awal tahun jabatan gubernur. Masalahnya, perbaikan saluran air di permukiman kumuh belum sempat dilakukan karena terhambat administrasi anggaran.\nKalimat yang berupa opini pada kutipan tersebut adalah...', 0, NULL),
(105, 6, 'Sebuah benda bermassa 5 kg bergerak dengan percepatan 4 m/s^2. Gaya yang bekerja pada benda tersebut adalah...', 0, NULL),
(106, 6, 'Perhatikan ciri-ciri berikut!\n(1) Mengumpulkan makanan dari hutan (food gathering)\n(2) Mulai hidup menetap\n(3) Tinggal di gua-gua (abris sous roche)\n(4) Mengenal sistem barter\nCiri kehidupan masyarakat pada masa berburu dan meramu tingkat lanjut ditunjukkan oleh nomor...', 0, NULL),
(107, 6, 'Median dari data: 7, 9, 5, 6, 8, 7, 8, 9, 10 adalah...', 0, NULL),
(108, 6, 'Pemanfaatan bioteknologi modern dalam bidang kedokteran adalah untuk memproduksi...', 0, NULL),
(109, 6, 'Peran utama Perserikatan Bangsa-Bangsa (PBB) dalam menyelesaikan konflik antara Indonesia dan Belanda adalah...', 0, NULL),
(110, 6, 'Bacalah dua teks berikut!\nTeks 1: Peneliti menemukan bahwa tidur yang cukup dapat meningkatkan daya ingat dan konsentrasi pada remaja.\nTeks 2: Kurang tidur pada remaja terbukti berhubungan dengan peningkatan risiko obesitas dan masalah kesehatan mental.\nPerbedaan utama isi kedua teks tersebut adalah...', 0, NULL),
(111, 6, 'Sebuah bandul sederhana berayun dari A-B-C dalam waktu 0,5 detik. Jika jarak A ke C adalah 10 cm, maka frekuensi dan amplitudo getaran bandul tersebut adalah...', 0, NULL),
(112, 6, 'Sebuah bangun terdiri dari tabung dan kerucut yang berimpit pada alasnya. Diameter tabung 14 cm dan tingginya 15 cm. Jika tinggi kerucut 12 cm, maka luas permukaan bangun tersebut adalah... (π = 22/7)', 0, NULL),
(113, 6, 'Perubahan sosial yang tidak direncanakan seringkali menimbulkan dampak negatif bagi masyarakat, contohnya adalah...', 0, NULL),
(114, 6, 'Perhatikan pernyataan berikut!\n(1) Pemilik perusahaan mebel bekerja sama dengan toko mebel.\n(2) Debat calon ketua OSIS berlangsung secara kompetitif.\n(3) Pihak yang terlibat sengketa lahan menyelesaikan konflik dengan cara arbitrase.\n(4) Suporter kesebelasan sepak bola terlibat konflik fisik.\nProses sosial asosiatif ditunjukkan oleh angka...', 0, NULL),
(115, 6, 'Sebuah bola dijatuhkan dari ketinggian 10 meter dan memantul kembali dengan ketinggian 3/4 dari tinggi sebelumnya. Panjang lintasan bola sampai berhenti adalah...', 0, NULL),
(116, 6, 'Kelainan pada mata yang menyebabkan bayangan benda jatuh di depan retina sehingga tidak dapat melihat benda jauh dengan jelas disebut...', 0, NULL),
(117, 6, 'Bacalah kutipan cerpen berikut!\nKini giliranku memegang senter, menaklukkan semak-semak. Sebelumnya, dua kawanku bergantian membuka jalan. Ya, ini kesempatan kami; yang terdepan membuka jalan, di tengah membawa ransel, sedang yang paling belakang membawa matras. Ini dilakukan secara bergantian.\nSudut pandang yang digunakan dalam kutipan cerpen tersebut adalah...', 0, NULL),
(118, 6, 'Salah satu dampak negatif dari pembangunan industri yang tidak memperhatikan analisis mengenai dampak lingkungan (AMDAL) adalah...', 0, NULL),
(119, 6, 'Sebuah kapal berlayar sejauh 100 km ke arah timur, kemudian berbelok ke arah utara sejauh 75 km. Jarak terpendek kapal tersebut dari titik awal adalah...', 0, NULL),
(120, 6, 'Teknologi yang memanfaatkan bakteri Thiobacillus ferrooxidans untuk memisahkan logam dari bijihnya disebut...', 0, NULL),
(121, 7, 'Perhatikan data nilai ulangan berikut: 8, 7, 9, 8, 6, 10, 7, 8, 9. Jangkauan interkuartil dari data tersebut adalah...', 0, NULL),
(122, 7, 'Ada beberapa cara menghemat pengeluaran. Pertama, beralih dari mobil ke sepeda motor. Kedua, memangkas keperluan berdasarkan prioritas. Ketiga, belanja sesuai daftar rencana. Keempat, harus pandai mengendalikan keinginan belanja. Teks tersebut termasuk jenis teks...', 0, NULL),
(123, 7, 'Perdagangan antarnegara dapat terjadi karena adanya perbedaan...', 0, NULL),
(124, 7, 'Sebuah transformator step-down digunakan untuk mengubah tegangan 220 V menjadi 110 V. Jika arus pada kumparan primer adalah 0,5 A, maka arus pada kumparan sekunder (efisiensi 100%) adalah...', 0, NULL),
(125, 7, 'Diketahui segitiga ABC sebangun dengan $\\triangle PQR$. Sisi $AB$ bersesuaian dengan sisi $PQ$, dan sisi BC bersesuaian dengan sisi QR.Jika diketahui panjang sisi AB = 6 cm, PQ = 8 cm, dan QR = 12 cm, maka panjang sisi BC adalah.', 0, NULL),
(126, 7, 'Terjadi pergaulan intensif dalam waktu lama, kebudayaan berubah dan saling menyesuaikan, menghasilkan kebudayaan baru tanpa menghilangkan kepribadian asli. Proses interaksi sosial tersebut disebut...', 0, NULL),
(127, 7, 'Dalam sebuah kantong terdapat 4 kelereng merah, 5 kelereng biru, dan 1 kelereng hijau. Jika diambil satu kelereng, kemudian diambil satu lagi tanpa pengembalian, peluang terambilnya kelereng merah pertama dan biru kedua adalah...', 0, NULL),
(128, 7, 'Tugas meresensi Novel perahu kertas dikumpulkan hari ini. Penggunaan ejaan yang tidak tepat pada kalimat tersebut adalah...', 0, NULL),
(129, 7, 'Organisme yang berperan sebagai produsen dalam ekosistem air tawar adalah...', 0, NULL),
(130, 7, 'Politik Etis atau Politik Balas Budi terdiri dari tiga program yaitu...', 0, NULL),
(131, 7, 'Persamaan kuadrat 2x² - 5x - 3 = 0 memiliki akar-akar x₁ dan x₂. Nilai dari x₁ + x₂ adalah...', 0, NULL),
(132, 7, 'Peristiwa perubahan arah rambat cahaya saat melewati dua medium berbeda kerapatannya disebut...', 0, NULL),
(133, 7, 'Salah satu faktor pendorong terjadinya mobilitas sosial vertikal naik adalah...', 0, NULL),
(134, 7, 'Ajakan Pemerintah DKI untuk bermain gim di Balai Kota menimbulkan perdebatan. Maksud kalimat tersebut adalah…', 0, NULL),
(135, 7, 'Sebuah benda bermassa 2 kg jatuh bebas dari ketinggian 10 m. Jika g = 10 m/s², energi kinetik benda saat menyentuh tanah adalah...', 0, NULL),
(136, 7, 'Jika titik P(3, -5) dicerminkan terhadap sumbu Y, maka bayangan titik P adalah...', 0, NULL),
(137, 7, 'Perjanjian Linggarjati berisi antara lain...', 0, NULL),
(138, 7, 'Sebuah bandul menghasilkan 40 getaran selama 1 menit. Periode getaran bandul tersebut adalah...', 0, NULL),
(139, 7, 'Prestasi olahraga kontingen Indonesia di SEA Games 2017 terburuk sepanjang sejarah. Simpulan paragraf tersebut adalah…', 0, NULL),
(140, 7, 'Titik A(2,5) didilatasikan dengan pusat O(0,0) dan faktor skala 3. Koordinat bayangan titik A adalah...', 0, NULL),
(141, 8, 'Dalam sebuah ekosistem sawah, jika populasi ular menurun drastis akibat perburuan, maka yang akan terjadi adalah...', 0, NULL),
(142, 8, 'Perlawanan rakyat Indonesia terhadap Jepang salah satunya terjadi di Singaparna, Jawa Barat, yang dipimpin oleh...', 0, NULL),
(143, 8, 'Volume bola terbesar yang dapat dimasukkan ke dalam kubus dengan panjang rusuk 21 cm adalah... (π = 22/7)', 0, NULL),
(144, 8, 'Pada persilangan antara tanaman ercis berbiji bulat (BB) dengan tanaman ercis berbiji keriput (bb), dihasilkan keturunan F1 yang semuanya berbiji bulat. Jika F1 disilangkan dengan sesamanya, perbandingan fenotipe pada F2 adalah...', 0, NULL),
(145, 8, 'Bacalah kalimat berikut! \"Para siswa-siswi sedang mengerjakan tugas dari guru.\" Kalimat tersebut tidak efektif karena...', 0, NULL),
(146, 8, 'Lembaga negara yang bertugas mengawasi jalannya pemerintahan dan keuangan negara setelah era Reformasi adalah...', 0, NULL),
(147, 8, 'Sebuah roket diluncurkan vertikal ke atas. Ketinggian roket setelah t detik dinyatakan dengan rumus h(t) = 30t - 5t² meter. Tinggi maksimum yang dapat dicapai roket adalah...', 0, NULL),
(148, 8, 'Proses pemisahan campuran berdasarkan perbedaan titik didih komponen-komponennya disebut...', 0, NULL),
(149, 8, 'Perhatikan gambar sel saraf berikut! Bagian yang berfungsi untuk mempercepat jalannya impuls saraf ditunjukkan oleh nomor...', 0, NULL),
(150, 8, 'Perhatikan data berikut: 5, 6, 7, 7, 8, 9, 9, 10. Simpangan kuartil dari data tersebut adalah...', 0, NULL),
(151, 8, 'Tujuan utama Jepang membentuk BPUPKI (Badan Penyelidik Usaha-usaha Persiapan Kemerdekaan Indonesia) adalah...', 0, NULL),
(152, 8, 'Bacalah kutipan berikut! \"Pendidikan karakter sangat penting untuk membangun generasi muda yang tangguh. Namun, implementasinya di sekolah masih menghadapi banyak kendala, mulai dari kurikulum hingga kompetensi guru.\" Kalimat tanggapan yang logis berdasarkan kutipan tersebut adalah...', 0, NULL),
(153, 8, 'Unsur kimia yang paling melimpah di kerak bumi adalah...', 0, NULL),
(154, 8, 'Jika log 2 = a dan log 3 = b, maka nilai dari log 12 adalah...', 0, NULL),
(155, 8, 'Salah satu ciri dari negara maju adalah...', 0, NULL),
(156, 8, 'Sebuah partikel bergerak dengan kecepatan awal 10 m/s. Jika partikel tersebut mengalami perlambatan konstan sebesar 2 m/s², waktu yang dibutuhkan hingga partikel berhenti adalah...', 0, NULL),
(157, 8, 'Sebuah foto berukuran 12 cm x 18 cm diletakkan pada selembar karton. Di sebelah kiri, kanan, dan atas foto masih tersisa karton selebar 3 cm. Jika foto dan karton sebangun, lebar karton di bagian bawah foto adalah...', 0, NULL),
(158, 8, 'Bacalah kutipan pidato berikut! \"Hadirin yang saya hormati, marilah kita tingkatkan kepedulian terhadap lingkungan dengan tidak membuang sampah sembarangan. Sebuah langkah kecil dari kita akan berdampak besar bagi bumi kita.\" Isi kutipan pidato tersebut adalah...', 0, NULL),
(159, 8, 'Peristiwa Rengasdengklok terjadi karena adanya perbedaan pendapat antara...', 0, NULL),
(160, 8, 'Suatu barisan geometri memiliki suku pertama 3 dan suku keempat 24. Suku keenam barisan tersebut adalah...', 0, NULL),
(161, 9, 'Sebuah bola basket dijatuhkan dari ketinggian 6 meter. Setiap kali memantul, bola mencapai ketinggian (2/3) dari tinggi pantulan sebelumnya. Total panjang lintasan yang ditempuh bola tersebut sampai berhenti adalah...', 0, NULL),
(162, 9, 'Benda A bermassa 2 kg jatuh bebas dari ketinggian 20 m, sementara benda B bermassa 4 kg jatuh bebas dari ketinggian 10 m. Jika g = 10 m/s^2, perbandingan Energi Kinetik benda A dan B sesaat sebelum menyentuh tanah adalah...', 0, NULL),
(163, 9, 'Cermati silogisme berikut! (1) Premis Umum: Semua mamalia bernapas dengan paru-paru. (2) Premis Khusus: Ikan paus bernapas dengan paru-paru. (3) Kesimpulan: Ikan paus adalah mamalia. Penalaran silogisme di atas...', 0, NULL),
(164, 9, 'Suatu negara memiliki piramida penduduk berbentuk kerucut (ekspansif) dengan alas yang sangat lebar. Masalah kependudukan utama yang akan dihadapi negara tersebut dalam 20 tahun ke depan adalah...', 0, NULL),
(165, 9, 'Pada tanaman ercis, biji bulat (B) dominan terhadap keriput (b) dan warna kuning (K) dominan terhadap hijau (k). Jika tanaman F1 (BbKk) disilangkan dengan sesamanya (BbKk), persentase fenotipe untuk mendapatkan tanaman berbiji keriput kuning (bbK_) adalah...', 0, NULL),
(166, 9, 'Jika diketahui ^2log 3 = a dan ^3log 5 = b, maka nilai dari ^6log 15 adalah...', 0, NULL),
(167, 9, 'Kebijakan \"Gunting Syafruddin\" yang diterapkan oleh Menteri Keuangan Syafruddin Prawiranegara pada masa Demokrasi Liberal bertujuan utama untuk...', 0, NULL),
(168, 9, 'Cermati kutipan puisi berikut! Aku ingin mencintaimu dengan sederhana / Seperti awan yang tak pernah berjanji / Tuk turunkan hujan di atas bumi / Makna lambang \"awan\" dalam kutipan puisi karya Sapardi Djoko Damono tersebut adalah...', 0, NULL),
(169, 9, 'Untuk menyetarakan reaksi pembakaran gas propana berikut: aC3H8(g) + bO2(g) → cCO2(g) + dH2O(g). Nilai koefisien a, b, c, d yang tepat berturut-turut adalah...', 0, NULL),
(170, 9, 'Rata-rata nilai ulangan matematika 39 siswa di kelas A adalah 75. Jika nilai Budi, seorang siswa dari kelas B, digabungkan, rata-rata nilai mereka menjadi 75,5. Nilai ulangan Budi adalah...', 0, NULL),
(171, 9, 'Salah satu pilar utama dalam pembentukan Masyarakat Ekonomi ASEAN (MEA) adalah...', 0, NULL),
(172, 9, 'Sel darah merah akan mengalami krenasi (mengerut) jika dimasukkan ke dalam larutan yang bersifat...', 0, NULL),
(173, 9, 'Cermati kutipan tajuk rencana berikut! \"Revolusi industri 4.0 adalah sebuah keniscayaan. Tenaga kerja manusia harus digantikan oleh mesin demi efisiensi. Mereka yang tidak mampu beradaptasi, pantas tertinggal oleh zaman.\" Sikap penulis dalam kutipan tersebut adalah...', 0, NULL),
(174, 9, 'Dua buah lingkaran memiliki jari-jari masing-masing 10 cm dan 2 cm. Jika jarak kedua titik pusat lingkaran adalah 17 cm, maka panjang garis singgung persekutuan luar kedua lingkaran tersebut adalah...', 0, NULL),
(175, 9, 'Sebuah benda diletakkan 10 cm di depan sebuah cermin cembung yang memiliki jarak fokus 15 cm. Sifat bayangan yang terbentuk adalah...', 0, NULL),
(176, 9, 'Masuknya budaya K-Pop dan anime yang sangat digemari remaja Indonesia sehingga dikhawatirkan menggeser budaya lokal, merupakan salah satu dampak negatif globalisasi dalam bidang...', 0, NULL),
(177, 9, 'Dalam sebuah kantong terdapat 5 bola merah dan 3 bola biru. Jika diambil dua bola satu per satu tanpa pengembalian, peluang terambilnya kedua bola berwarna merah adalah...', 0, NULL),
(178, 9, 'Pembuatan hormon insulin untuk penderita diabetes dengan memanfaatkan bakteri E. coli adalah contoh produk bioteknologi modern yang memanfaatkan teknik...', 0, NULL),
(179, 9, 'Kalimat \"Istri lurah yang baru itu sangat ramah\" memiliki makna ganda (ambigu) karena...', 0, NULL),
(180, 9, 'Peran utama Indonesia sebagai salah satu pelopor Gerakan Non-Blok (GNB) pada masa Perang Dingin adalah untuk...', 0, NULL),
(181, 10, 'Sebuah kerucut memiliki volume $V$. Jika jari-jari alasnya diperbesar 2 kali dan tingginya diperkecil $\\frac{1}{3}$ kali, volume kerucut yang baru adalah...', 0, NULL),
(182, 10, 'Seorang siswa melakukan percobaan Ingenhousz dengan Hydrilla. Perangkat A diletakkan di tempat terang, Perangkat B di tempat gelap, dan Perangkat C di tempat terang dengan tambahan NaHCO$_3$ (soda kue). Urutan jumlah gelembung oksigen yang dihasilkan dari yang paling banyak ke paling sedikit adalah...', 0, NULL),
(183, 10, 'Perbedaan mendasar antara sistem Tanam Paksa (Cultuurstelsel) era Van den Bosch dengan sistem Politik Pintu Terbuka (Politik Liberal) setelah 1870 adalah...', 0, NULL),
(184, 10, 'Cermati kalimat argumen berikut: \"Siswa A tidak mungkin juara kelas, karena ia berasal dari keluarga miskin dan penampilannya tidak meyakinkan.\" Kalimat tersebut mengandung kesesatan berpikir (logical fallacy) yang menyerang pribadi lawan, bukan argumennya, yang disebut...', 0, NULL),
(185, 10, 'Himpunan penyelesaian dari pertidaksamaan $\\frac{x-2}{x+5} \\ge 0$ adalah...', 0, NULL),
(186, 10, 'Sebuah transformator (trafo) ideal memiliki efisiensi 100%. Jika kumparan primer dihubungkan dengan tegangan 220 V dan menghasilkan tegangan sekunder 55 V, dan kuat arus sekunder adalah 2 A. Kuat arus pada kumparan primer adalah...', 0, NULL),
(187, 10, 'Ketika Bank Indonesia memutuskan untuk menaikkan BI Rate (suku bunga acuan), dampak yang paling diharapkan terjadi pada perekonomian adalah...', 0, NULL),
(188, 10, 'Suatu fungsi linear $f(x) = ax + b$. Jika $f(1) = 5$ dan $f(-1) = 1$, maka nilai dari $f(3)$ adalah...', 0, NULL),
(189, 10, 'Cermati kalimat berikut! \"Karena harga bahan pokok melonjak tinggi, daya beli masyarakat menurun sehingga banyak toko kecil gulung tikar.\" Pola kalimat majemuk bertingkat tersebut adalah...', 0, NULL),
(190, 10, 'Sebanyak 12 gram magnesium (Mg) dibakar dengan oksigen (O$_2$) menghasilkan magnesium oksida (MgO). Jika massa MgO yang dihasilkan adalah 20 gram, berapakah massa oksigen (O$_2$) yang bereaksi? (Berdasarkan Hukum Lavoisier)', 0, NULL),
(191, 10, 'Zona di lepas pantai barat Sumatera, tempat Lempeng Indo-Australia menyusup ke bawah Lempeng Eurasia, menghasilkan rangkaian aktivitas vulkanik yang intensif. Fenomena geologis ini disebut sebagai...', 0, NULL),
(192, 10, 'Rata-rata nilai 15 siswa adalah 78. Setelah nilai 5 siswa lainnya digabungkan, rata-rata nilai total menjadi 80. Rata-rata nilai 5 siswa yang baru bergabung tersebut adalah...', 0, NULL),
(193, 10, 'Dalam suatu jaring-jaring makanan di savana, singa adalah konsumen puncak. Jika terjadi wabah penyakit yang membunuh sebagian besar populasi zebra (herbivora), dampak tidak langsung (indirect effect) yang mungkin terjadi adalah...', 0, NULL),
(194, 10, 'Perhatikan premis-premis berikut! (1) Semua koruptor dihukum berat. (2) Sebagian pejabat adalah koruptor. Kesimpulan (silogisme) yang paling tepat dari kedua premis tersebut adalah...', 0, NULL),
(195, 10, 'Salah satu faktor utama yang menyebabkan kabinet-kabinet pada masa Demokrasi Parlementer (1950-1959) sering jatuh bangun dan tidak berumur panjang adalah...', 0, NULL),
(196, 10, 'Balok es bermassa 200 gram bersuhu -5°C dipanaskan hingga seluruhnya melebur menjadi air bersuhu 0°C. Jika kalor jenis es 0,5 kal/g°C dan kalor lebur es 80 kal/g, jumlah total kalor yang dibutuhkan adalah...', 0, NULL),
(197, 10, 'Sebuah tangga sepanjang 10 meter bersandar pada dinding. Jarak ujung bawah tangga ke dinding adalah 6 meter. Jika ujung bawah tangga digeser 2 meter menjauhi dinding, berapa jauhkah ujung atas tangga bergeser turun dari posisi semula?', 0, NULL),
(198, 10, 'Perdagangan bebas (free trade) dapat memberikan keuntungan bagi suatu negara, namun juga memiliki potensi kerugian. Kerugian utama yang sering dikhawatirkan oleh negara berkembang adalah...', 0, NULL),
(199, 10, 'Proses pernapasan sel (respirasi aerob) yang terjadi di dalam mitokondria pada dasarnya bertujuan untuk...', 0, NULL),
(200, 10, 'Cermati kalimat berikut! \"Rancangan Undang-Undang itu sedang digodok di DPR sebelum akhirnya disahkan.\" Makna konotatif (makna kiasan) dari kata \'digodok\' pada kalimat tersebut adalah...', 0, NULL),
(201, 11, 'Sebuah kereta api berangkat dari kota A menuju kota B dengan kecepatan 60 km/jam. 30 menit kemudian, kereta api lain berangkat dari kota B menuju kota A dengan kecepatan 80 km/jam. Jika jarak kota A dan B adalah 310 km, mereka akan berpapasan setelah kereta api pertama (dari kota A) berjalan selama...', 0, NULL),
(202, 11, 'Sebatang kentang dengan berat awal 20 gram direndam dalam larutan gula 30% selama 1 jam. Setelah ditimbang kembali, berat kentang tersebut kemungkinan besar akan menjadi...', 0, NULL),
(203, 11, 'Pemerintah suatu negara mencetak uang secara besar-besaran untuk membayar utang dalam negeri tanpa diimbangi peningkatan produksi barang dan jasa. Akibatnya, nilai mata uang anjlok dan harga-harga naik secara ekstrem dalam waktu singkat. Fenomena ini disebut...', 0, NULL),
(204, 11, 'Cermati kalimat berikut! \"Kemarin, paman yang tinggal di desa sebelah utara itu membawakan kami oleh-oleh durian Musang King.\" Predikat (P) dari kalimat tersebut adalah...', 0, NULL),
(205, 11, 'Median dari 5 bilangan bulat berurutan (x, x+1, x+2, x+3, x+4) adalah 18. Rata-rata (mean) dari kelima bilangan tersebut adalah...', 0, NULL),
(206, 11, 'Seorang pria bergolongan darah A (heterozigot, $I^A i$) menikah dengan seorang wanita bergolongan darah B (heterozigot, $I^B i$). Persentase kemungkinan mereka memiliki anak bergolongan darah O ($ii$) adalah...', 0, NULL),
(207, 11, 'Pemberontakan PRRI/Permesta yang terjadi pada akhir tahun 1950-an bukan merupakan gerakan separatis murni yang ingin memisahkan diri dari Indonesia. Latar belakang utama gerakan ini adalah...', 0, NULL),
(208, 11, 'Cermati kalimat berikut! \"Suaranya merdu sekali, sampai-sampai kaca di ruangan ini retak semua mendengarnya.\" Kalimat tersebut menggunakan majas yang melebih-lebihkan kenyataan untuk mendapatkan efek penekanan, yang disebut majas...', 0, NULL),
(209, 11, 'Sebuah lingkaran $(\\pi = \\frac{22}{7})$ memiliki luas 154 cm$^2$. Lingkaran tersebut menyinggung keempat sisi sebuah persegi (lingkaran berada di dalam persegi). Luas persegi tersebut adalah...', 0, NULL),
(210, 11, 'Tiga buah resistor (3 $\\Omega$, 6 $\\Omega$, dan 9 $\\Omega$) dirangkai secara paralel. Rangkaian paralel ini kemudian dihubungkan secara seri dengan resistor 2 $\\Omega$ dan sumber tegangan 10 Volt. Kuat arus total yang mengalir dari sumber tegangan adalah...', 0, NULL),
(211, 11, 'Sistem zonasi dalam Penerimaan Peserta Didik Baru (PPDB) bertujuan untuk pemerataan kualitas pendidikan. Namun, salah satu dampak negatif tak terduga (unintended consequence) yang signifikan dari penerapan kebijakan ini di masyarakat adalah...', 0, NULL),
(212, 11, 'Harga 3 baju dan 2 kaos adalah Rp 280.000. Sedangkan harga 1 baju dan 3 kaos adalah Rp 210.000. Harga 5 baju dan 2 kaos adalah...', 0, NULL),
(213, 11, 'Kalimat \"Rapat itu membahas tentang masalah kenaikan UMR\" dianggap tidak efektif karena...', 0, NULL),
(214, 11, 'Seseorang yang sedang menderita flu berat (pilek parah) sering merasa bahwa makanan yang ia makan terasa hambar. Hal ini terjadi karena...', 0, NULL),
(215, 11, 'Strategi Divide et Impera (Pecah Belah) adalah taktik andalan VOC untuk menguasai nusantara. Contoh paling jelas dari penerapan strategi ini adalah...', 0, NULL),
(216, 11, 'Hasil dari $(27)^{\\frac{2}{3}} + (16)^{\\frac{3}{4}} - (125)^{\\frac{1}{3}}$ adalah...', 0, NULL),
(217, 11, 'Suatu atom X memiliki 13 proton dan 14 neutron. Untuk mencapai konfigurasi elektron yang stabil (oktet/duplet), atom ini akan cenderung...', 0, NULL),
(218, 11, 'Cermati kutipan berita berikut! \"Kenaikan harga BBM diumumkan tadi malam oleh pemerintah. Kebijakan ini diharapkan dapat mengurangi beban subsidi energi. Namun, banyak pihak khawatir hal ini akan memicu kenaikan harga barang lainnya.\" Bentuk kata kerja (verba) yang dominan digunakan dalam kutipan tersebut adalah...', 0, NULL),
(219, 11, 'Menjelang Hari Raya Idul Fitri, harga daging sapi dan cabai rawit di Indonesia hampir selalu melonjak tajam, meskipun pasokan dari peternak atau petani relatif stabil. Faktor ekonomi utama yang menyebabkan fenomena ini adalah...', 0, NULL),
(220, 11, 'Dalam sebuah kantong terdapat 4 bola merah dan 6 bola biru. Jika diambil dua bola satu per satu tanpa pengembalian, peluang terambilnya kedua bola berwarna biru adalah...', 0, NULL),
(221, 12, 'Sebuah taman berbentuk persegi panjang memiliki luas 150 m^2. Jika panjang taman 5 meter lebihnya dari lebarnya, keliling taman tersebut adalah...', 0, NULL),
(222, 12, 'Sebuah bola bermassa 2 kg dijatuhkan dari ketinggian 10 meter. Setelah menumbuk lantai, bola memantul kembali hingga ketinggian 8 meter. Jika g = 10 m/s^2, besar energi mekanik yang hilang (berubah menjadi panas dan bunyi) saat tumbukan adalah...', 0, NULL),
(223, 12, 'Salah satu tuntutan utama (yang dikenal sebagai TRITURA) yang disuarakan oleh mahasiswa (KAMI/KAPPI) pasca peristiwa G30S/PKI tahun 1965 adalah...', 0, NULL),
(224, 12, 'Cermati kutipan berikut!\n\"Pejabat itu dikenal murah hati; ia sering menyantuni anak yatim. Namun, banyak yang curiga bahwa itu hanyalah kedok untuk menutupi borok di perusahaannya yang merugikan negara.\"\nSikap (tone) penulis dalam kutipan tersebut terhadap pejabat yang dibicarakan adalah...', 0, NULL),
(225, 12, 'Dalam sebuah kotak terdapat 5 bola merah dan 3 bola biru. Jika diambil dua bola satu per satu tanpa pengembalian, peluang terambilnya bola pertama merah dan bola kedua biru adalah...', 0, NULL),
(226, 12, 'Sebuah kapal barang berlayar dari Samudra Hindia (air asin, massa jenis ρ_A) menuju muara sungai di Kalimantan (air tawar, massa jenis ρ_T). Kita tahu bahwa ρ_A > ρ_T. Agar kapal tetap dapat mengapung (gaya apung = berat kapal), apa yang terjadi pada bagian kapal yang tercelup di air?', 0, NULL),
(227, 12, 'Program Revolusi Hijau yang digalakkan pada masa Orde Baru berhasil meningkatkan produksi beras (swasembada pangan). Namun, program ini mendapat kritik sosial-ekonomi karena...', 0, NULL),
(228, 12, 'Suatu fungsi kuadrat f(x) = x^2 + bx + c memiliki titik puncak (vertex) pada koordinat (3, -1). Nilai dari f(1) adalah...', 0, NULL),
(229, 12, 'Cermati kutipan teks prosedur acak berikut:\n\"(1) Pastikan adonan kalis elastis sebelum didiamkan (proofing). (2) Gunakan ragi yang masih aktif. (3) Jangan campurkan ragi dan garam secara langsung. (4) Oven harus dipanaskan terlebih dahulu.\"\nBerdasarkan petunjuk tersebut, kegagalan yang paling mungkin terjadi jika adonan roti menjadi \"bantat\" (tidak mengembang) adalah...', 0, NULL),
(230, 12, 'Pada manusia, mata cokelat (B) dominan terhadap mata biru (b), dan sifat kidal (t) bersifat resesif terhadap tangan normal/kanan (T). Seorang pria bermata cokelat (heterozigot, Bb) dan tangan normal (heterozigot, Tt) menikah dengan wanita bermata biru (bb) dan tangan normal (heterozigot, Tt). Berapa persentase kemungkinan mereka memiliki anak yang bermata biru dan kidal (bbtt)?', 0, NULL),
(231, 12, 'Alasan pembenar (justifikasi) utama yang digunakan Presiden Soekarno untuk mengeluarkan Dekret Presiden 5 Juli 1959, yang membubarkan Konstituante dan kembali ke UUD 1945, adalah...', 0, NULL),
(232, 12, 'Jumlah angka-angka (digit) dari suatu bilangan yang terdiri dari dua angka adalah 9. Jika angka-angka tersebut dibalik, bilangan yang baru nilainya 27 lebih kecil dari bilangan semula. Bilangan semula tersebut adalah...', 0, NULL),
(233, 12, 'Seorang siswa menguji larutan X. Saat ditetesi indikator lakmus biru, warnanya berubah menjadi merah. Saat ke dalamnya dimasukkan pita magnesium (Mg), muncul gelembung-gelembung gas. Larutan X tersebut kemungkinan besar adalah...', 0, NULL),
(234, 12, 'Cermati kalimat berikut!\n\"Berdasarkan analisa sementara, sistim drainase yang buruk menjadi faktor utama banjir di komplek perumahan itu.\"\nPenulisan kata baku yang tepat untuk kata-kata yang bercetak miring adalah...', 0, NULL),
(235, 12, 'Kawasan Laut Natuna Utara (bagian dari ZEE Indonesia) sering menjadi lokasi ketegangan diplomatik antara Indonesia dan Tiongkok. Hal ini terjadi karena...', 0, NULL),
(236, 12, 'Planet A memiliki massa 2 kali massa Planet B (M_A = 2 M_B) dan jari-jari 2 kali jari-jari Planet B (R_A = 2 R_B). Perbandingan percepatan gravitasi di permukaan Planet A (g_A) dan Planet B (g_B) adalah...', 0, NULL),
(237, 12, 'Perbedaan paling mendasar antara proses Fotosintesis (pada kloroplas) dan Respirasi Seluler (pada mitokondria) adalah...', 0, NULL),
(238, 12, 'Persamaan garis yang melalui titik (2, 5) dan tegak lurus (perpendicular) dengan garis y = (1/3)x + 2 adalah...', 0, NULL),
(239, 12, 'Cermati dialog berikut!\nAndi: \"Filmnya bagus sekali! Aku tidak menyangka ending-nya begitu.\"\nBudi: \"Ah, biasa saja. Aku sudah bisa menebaknya dari pertengahan film.\"\nMakna tersirat (implicit meaning) dari tanggapan Budi adalah...', 0, NULL),
(240, 12, 'Pada masa Demokrasi Terpimpin, politik luar negeri Indonesia yang \"bebas aktif\" mulai menunjukkan kecenderungan yang kuat untuk...', 0, NULL),
(241, 13, 'Sebuah persegi (bujur sangkar) diletakkan di dalam sebuah lingkaran sehingga keempat titik sudutnya menyentuh keliling lingkaran. Jika luas persegi tersebut adalah 50 cm^2, maka luas lingkaran tersebut adalah...', 0, NULL),
(242, 13, 'Sebuah benda ditimbang di udara beratnya 50 N. Ketika dicelupkan seluruhnya ke dalam air (massa jenis air = 1.000 kg/m^3), beratnya di dalam air menjadi 30 N. Jika g = 10 m/s^2, massa jenis benda tersebut adalah...', 0, NULL),
(243, 13, 'Salah satu dampak politik jangka panjang dari kegagalan Konstituante menyusun UUD baru (1956-1959) yang berujung pada Dekret Presiden 5 Juli 1959 adalah...', 0, NULL),
(244, 13, 'Cermati paragraf berikut! \"Fenomena flexing (pamer kekayaan) di media sosial kini menjadi sorotan. Banyak yang memuja, namun tak sedikit yang mencibir. Mereka yang memuja melihatnya sebagai motivasi. Mereka yang mencibir melihatnya sebagai racun sosial yang menumbuhkan iri hati. Pada akhirnya, media sosial hanyalah panggung; penontonlah yang memilih untuk terinspirasi atau teracuni.\" Tujuan utama penulis dalam paragraf tersebut adalah...', 0, NULL),
(245, 13, 'Dalam sebuah kotak terdapat 4 bola merah dan 3 bola biru. Diambil satu bola secara acak, dicatat warnanya, lalu dikembalikan lagi. Pengambilan dilakukan sebanyak 3 kali. Peluang terambilnya tepat 2 bola merah (dari 3 kali pengambilan) adalah...', 0, NULL),
(246, 13, 'Seorang siswa meneliti pengaruh intensitas cahaya terhadap laju fotosintesis Hydrilla. Ia menyiapkan 5 perangkat percobaan yang diletakkan pada jarak berbeda dari sumber cahaya (10 cm, 20 cm, 30 cm, 40 cm, 50 cm). Siswa tersebut mengukur jumlah gelembung O2 yang dihasilkan per menit. Dalam percobaan ini, yang menjadi variabel terikat (dependent variable) adalah...', 0, NULL),
(247, 13, 'Perbedaan mendasar antara inflasi dan kelangkaan adalah...', 0, NULL),
(248, 13, 'Kalimat \"Polisi menembak pencuri dengan pistol\" memiliki makna ganda (ambigu) karena...', 0, NULL),
(249, 13, 'Sebuah peluru ditembakkan ke atas dengan ketinggian h(t) = 40t - 5t^2 (h dalam meter, t dalam detik). Selang waktu (durasi) ketika ketinggian peluru tersebut melebihi 60 meter adalah...', 0, NULL),
(250, 13, 'Sebanyak 4,6 gram logam Natrium (Na) bereaksi habis dengan air (H2O) menghasilkan NaOH dan gas Hidrogen (H2), sesuai reaksi: 2Na + 2H2O → 2NaOH + H2. Jika Ar Na = 23, H = 1, O = 16, volume gas H2 yang dihasilkan pada keadaan Standar (STP) adalah...', 0, NULL),
(251, 13, 'Jepang merupakan negara yang sangat rawan terhadap bencana gempa bumi dan tsunami. Faktor utama yang menyebabkan fenomena geologis ini adalah...', 0, NULL),
(252, 13, 'Dalam suatu gedung pertunjukan, baris paling depan memiliki 10 kursi. Baris di belakangnya selalu bertambah 3 kursi dari baris di depannya. Jika terdapat 20 baris kursi, jumlah total kursi di gedung tersebut adalah...', 0, NULL),
(253, 13, 'Cermati kalimat: \"Ketika pandemi melanda, para siswa yang biasanya belajar di sekolah terpaksa mengikuti pembelajaran jarak jauh dari rumah.\" Induk kalimat (klausa utama) dari kalimat majemuk bertingkat tersebut adalah...', 0, NULL),
(254, 13, 'Sebuah setrika listrik memiliki spesifikasi 300 Watt / 220 Volt. Jika setrika tersebut dipasang pada tegangan 110 Volt, daya listrik yang diserap oleh setrika tersebut menjadi...', 0, NULL),
(255, 13, 'Salah satu kebijakan politik dalam negeri Orde Baru yang bertujuan untuk menciptakan stabilitas politik, namun di sisi lain dikritik karena membatasi oposisi, adalah...', 0, NULL),
(256, 13, 'Sebuah tabung memiliki jari-jari r dan tinggi t. Sebuah kerucut memiliki jari-jari 2r dan tinggi 2t. Perbandingan volume tabung dan volume kerucut tersebut adalah...', 0, NULL),
(257, 13, 'Seorang pria penderita hemofilia (gen resesif terpaut-X, X^hY) menikah dengan seorang wanita normal yang ayahnya penderita hemofilia (wanita ini adalah carrier, X^HX^h). Berapa persentase kemungkinan mereka memiliki anak laki-laki yang normal (tidak hemofilia)?', 0, NULL),
(258, 13, 'Cermati paragraf berikut! \"Setiap atlet profesional pasti berlatih keras setiap hari. Budi berlatih keras setiap hari. Maka, Budi adalah seorang atlet profesional.\" Kelemahan penalaran (silogisme) pada paragraf tersebut adalah...', 0, NULL),
(259, 13, 'Negara A dapat memproduksi 100 mobil atau 50 ton beras per hari. Negara B dapat memproduksi 80 mobil atau 80 ton beras per hari. Berdasarkan teori keunggulan komparatif, perdagangan akan saling menguntungkan jika...', 0, NULL),
(260, 13, 'Seseorang yang menderita miopi (rabun jauh) memiliki titik jauh (punctum remotum) 2 meter. Untuk melihat benda jauh dengan jelas, ia harus menggunakan kacamata dengan kekuatan lensa...', 0, NULL),
(261, 14, 'Sebuah piramida (limas) persegi memiliki alas yang ukurannya sama persis dengan sisi alas sebuah kubus, dan tingginya sama dengan panjang rusuk kubus tersebut. Jika piramida itu diletakkan di dalam kubus, perbandingan volume piramida terhadap volume kubus adalah...', 0, NULL),
(262, 14, 'Dalam suatu ekosistem sawah, terjadi pencemaran pestisida (seperti DDT) yang tidak dapat terurai. Jika jaring-jaring makanan di sana adalah: Padi → Tikus → Ular → Elang, DAN Padi → Serangga → Katak → Ular → Elang. Organisme yang akan mengalami akumulasi pestisida tertinggi (biomagnifikasi) adalah...', 0, NULL),
(263, 14, 'Salah satu kegagalan fundamental di bidang ekonomi pada masa Demokrasi Liberal (1950-1959) yang berkontribusi besar terhadap ketidakstabilan kabinet adalah...', 0, NULL),
(264, 14, 'Cermati kutipan berikut!\n\"Pemerintah lagi-lagi menaikkan harga BBM di tengah himpitan ekonomi. Jelas sekali kebijakan ini tidak pro-rakyat dan hanya mementingkan korporasi besar. Rakyat kecil selalu menjadi korban.\"\nTujuan tersirat (implied) penulis dalam kutipan tersebut adalah...', 0, NULL),
(265, 14, 'Lima tahun lalu, umur Ayah adalah 3 kali umur Budi. Sepuluh tahun dari sekarang, umur Ayah akan menjadi 2 kali umur Budi. Jumlah umur mereka berdua saat ini adalah...', 0, NULL),
(266, 14, 'Sebuah pemanas air listrik (ketel) berdaya 350 Watt digunakan untuk memanaskan 500 gram air dari 20°C hingga 100°C. Jika kalor jenis air c = 4,2 J/g°C dan 1 Joule = 1 Watt.detik (efisiensi 100%), waktu yang diperlukan adalah...', 0, NULL),
(267, 14, 'Fenomena \"kawasan kumuh\" (slum area) yang padat dan tidak teratur di pusat kota-kota besar seperti Jakarta atau Surabaya, secara geografi merupakan dampak spasial (keruangan) langsung dari...', 0, NULL),
(268, 14, 'Cermati pernyataan seorang motivator: \"Dalam hidup ini, kamu harus memilih: fokus 100% pada karir dan sukses, atau kamu akan gagal total dan menjadi pecundang.\"\nPernyataan tersebut mengandung kesesatan berpikir (logical fallacy) karena...', 0, NULL),
(269, 14, 'Dalam sebuah kotak terdapat 4 bola merah dan 6 bola biru. Jika diambil dua bola satu per satu tanpa pengembalian, peluang terambilnya minimal satu bola merah adalah...', 0, NULL),
(270, 14, 'Proses pencernaan kimiawi protein oleh enzim dalam sistem pencernaan manusia pertama kali dimulai di organ...', 0, NULL),
(271, 14, 'Latar belakang utama yang mendorong terbentuknya ASEAN (Perhimpunan Bangsa-bangsa Asia Tenggara) pada tahun 1967 adalah...', 0, NULL),
(272, 14, 'Suatu fungsi kuadrat f(x) memotong sumbu-x di titik (-1, 0) dan (3, 0). Jika fungsi tersebut juga melalui titik (2, -6), maka persamaan fungsi kuadrat tersebut adalah...', 0, NULL),
(273, 14, 'Pada sebuah mikroskop, lensa objektif (yang dekat dengan preparat) akan membentuk bayangan pertama yang sifatnya...', 0, NULL),
(274, 14, 'Cermati kalimat: \"Siswa yang memenangkan olimpiade sains internasional itu mendapat penghargaan dari presiden.\"\nFrasa (klausa) \"memenangkan olimpiade sains internasional itu\" dalam kalimat tersebut berfungsi sebagai...', 0, NULL);
INSERT INTO `pertanyaan` (`id_pertanyaan`, `id_level`, `teks_pertanyaan`, `untuk_turnamen`, `dibuat_oleh`) VALUES
(275, 14, 'Ketika pemerintah Indonesia memberlakukan tarif (bea masuk) yang tinggi untuk produk baja impor dari Tiongkok, dampak yang paling mungkin terjadi di pasar domestik (dalam negeri) adalah...', 0, NULL),
(276, 14, 'Rumus jumlah n suku pertama (S_n) suatu deret aritmetika adalah S_n = 2n^2 + 5n. Suku ke-10 (U_10) deret tersebut adalah...', 0, NULL),
(277, 14, 'Darah yang mengalir dari paru-paru kembali ke jantung melalui vena pulmonalis (vena paru-paru) dan masuk ke serambi kiri memiliki karakteristik...', 0, NULL),
(278, 14, 'Peristiwa yang secara de jure (hukum) dan de facto (fakta) dianggap sebagai titik balik transfer kekuasaan dari Orde Lama (Presiden Soekarno) ke Orde Baru (Jenderal Soeharto) adalah...', 0, NULL),
(279, 14, 'Seutas kawat dengan panjang 100 cm akan dibentuk menjadi sebuah persegi panjang. Jika luas persegi panjang yang terbentuk adalah 600 cm^2, panjang diagonal persegi panjang tersebut adalah...', 0, NULL),
(280, 14, 'Seseorang menggunakan kemeja berwarna hijau murni. Ia kemudian masuk ke sebuah ruangan yang hanya diterangi oleh lampu berwarna merah murni (tidak ada cahaya lain). Kemeja hijau tersebut akan terlihat berwarna...', 0, NULL),
(281, 15, 'Sebuah persegi panjang memiliki panjang (x + 3) cm dan lebar (x - 1) cm. Jika luas persegi panjang tersebut adalah 21 cm^2, maka keliling persegi panjang tersebut adalah...', 0, NULL),
(282, 15, 'Limbah pupuk (nitrat dan fosfat) dari area pertanian yang masuk ke danau dapat memicu ledakan populasi alga (algal bloom). Urutan peristiwa yang paling mungkin terjadi setelah ledakan alga tersebut adalah...', 0, NULL),
(283, 15, 'Peristiwa Malari (Malapetaka Lima Belas Januari) tahun 1974 adalah sebuah demonstrasi mahasiswa besar-besaran yang terjadi pada masa Orde Baru. Protes tersebut pada intinya menyoroti isu...', 0, NULL),
(284, 15, 'Cermati paragraf berikut! \"(1) Banyak yang beranggapan bahwa kecerdasan buatan (AI) hanya akan merebut lapangan kerja. (2) Anggapan ini berfokus pada sisi negatif otomatisasi. (3) Namun, sebuah studi dari Institut Teknologi Global menunjukkan bahwa AI justru akan menciptakan lebih banyak jenis pekerjaan baru. (4) Pekerjaan seperti Pelatih AI atau Analis Etika AI tidak pernah ada 10 tahun lalu.\" Fungsi kalimat (3) dalam struktur paragraf tersebut adalah sebagai...', 0, NULL),
(285, 15, 'Rata-rata nilai ulangan 19 siswa adalah 70. Budi mengikuti ulangan susulan dan nilainya digabungkan, sehingga rata-rata nilai total menjadi 71. Kemudian, nilai Budi dibatalkan dan diganti dengan nilai Ani. Setelah nilai Ani dimasukkan, rata-rata nilai total 20 siswa (termasuk Ani) kembali menjadi 70. Hubungan antara nilai Budi dan nilai Ani adalah...', 0, NULL),
(286, 15, 'Sebuah pemanas air listrik (ketel) memiliki daya 300 Watt dan efisiensi 80%. Pemanas tersebut digunakan untuk memanaskan 0,5 kg air dari 20°C hingga mendidih (100°C). Jika kalor jenis air 4.200 J/kg°C, waktu yang diperlukan hingga air mendidih adalah...', 0, NULL),
(287, 15, 'Untuk mengatasi inflasi yang terlalu tinggi (ekonomi overheating), kebijakan moneter yang paling tepat diambil oleh Bank Indonesia (Bank Sentral) adalah...', 0, NULL),
(288, 15, 'Kotak A berisi 3 bola merah dan 2 bola biru. Kotak B berisi 2 bola merah dan 3 bola biru. Jika satu bola diambil secara acak dari Kotak A dan satu bola dari Kotak B, peluang terambilnya kedua bola berwarna berbeda adalah...', 0, NULL),
(289, 15, 'Gas Asetilena (C2H2) dibakar sempurna sesuai reaksi (belum setara): C2H2(g) + O2(g) → CO2(g) + H2O(g). Jika gas C2H2 yang dibakar bervolume 4 Liter, volume gas CO2 yang dihasilkan (diukur pada suhu dan tekanan yang sama) adalah...', 0, NULL),
(290, 15, 'Cermati dialog berikut! Ibu: \"Wah, kamarmu rapi sekali, Nak. Sampai-sampai ibu tidak bisa menemukan lantai di bawah tumpukan pakaian kotormu.\" Kalimat yang diucapkan Ibu menggunakan majas...', 0, NULL),
(291, 15, 'Pada tanaman bunga pukul empat (Mirabilis jalapa), gen Merah (M) tidak dominan penuh terhadap gen Putih (m). Persilangan antara tanaman berbunga Merah (MM) dan Putih (mm) menghasilkan F1 yang 100% berbunga Pink (Mm). Jika F1 (Pink) disilangkan dengan sesamanya (Mm x Mm), perbandingan fenotipe Merah : Pink : Putih pada F2 adalah...', 0, NULL),
(292, 15, 'Sebuah bandul terbuat dari kerucut dan setengah bola yang alasnya saling berimpit. Diameter setengah bola adalah 14 cm. Jika panjang garis pelukis kerucut adalah 25 cm, volume total bandul tersebut adalah... (π = 22/7)', 0, NULL),
(293, 15, 'Seluruh fenomena cuaca yang kita alami sehari-hari, seperti pembentukan awan, hujan, angin, dan badai petir, terjadi pada lapisan atmosfer...', 0, NULL),
(294, 15, 'Cermati kalimat: \"Meskipun pemerintah telah melarangnya, banyak warga tetap nekat mudik lebaran tahun ini.\" Pola kalimat majemuk bertingkat tersebut adalah...', 0, NULL),
(295, 15, 'Sebuah teropong bintang (teleskop astronomi) sederhana memiliki jarak fokus lensa objektif 120 cm dan jarak fokus lensa okuler 6 cm. Perbesaran (magnifikasi) teropong tersebut untuk pengamatan mata tak berakomodasi adalah...', 0, NULL),
(296, 15, 'Suatu fungsi linear f(x) didefinisikan sebagai f(x) = ax + b. Jika f(0) = -5 dan f(2) = 1, maka nilai dari f(5) adalah...', 0, NULL),
(297, 15, 'Perbedaan konseptual utama antara Konferensi Asia-Afrika (KAA) di Bandung tahun 1955 dengan Gerakan Non-Blok (GNB) di Beograd tahun 1961 adalah...', 0, NULL),
(298, 15, 'Saat es pada suhu 0°C sedang dalam proses melebur menjadi air pada suhu 0°C, energi kalor (kalor laten) yang diserap oleh es digunakan untuk...', 0, NULL),
(299, 15, 'Cermati dialog di ruang keluarga: Ayah: (Melihat jam) \"Wah, sudah jam 10 malam, ya.\" Anak: \"Iya, Yah.\" (sambil terus bermain game di ponsel). Maksud tersirat (implisit) yang paling mungkin dari ucapan Ayah adalah...', 0, NULL),
(300, 15, 'Titik A, B, dan C terletak pada keliling sebuah lingkaran yang berpusat di O. Jika garis AC merupakan diameter lingkaran tersebut, maka besar sudut ∠ABC adalah...', 0, NULL),
(301, 16, 'Sebuah balok memiliki panjang $(x+2)$ cm, lebar $x$ cm, dan tinggi $(x-1)$ cm. Jika luas permukaan balok tersebut adalah 148 cm$^2$, volume balok tersebut adalah...', 0, NULL),
(302, 16, 'Sebuah bandul (massa 0,5 kg) dilepas dari titik A yang tingginya 20 cm di atas titik terendah (B). Jika $g=10$ m/s$^2$, perbandingan Energi Potensial (EP) dan Energi Kinetik (EK) bandul saat berada di titik C, yang tingginya 5 cm di atas B, adalah...', 0, NULL),
(303, 16, 'Alasan utama Perang Dingin (Cold War) antara Amerika Serikat dan Uni Soviet tidak pernah berkembang menjadi perang dunia ketiga secara langsung adalah...', 0, NULL),
(304, 16, 'Cermati kutipan: \"Investasi asing adalah satu-satunya jalan keluar bagi negara berkembang untuk maju. Tanpa suntikan dana dan teknologi dari luar, negara-negara ini pasti akan selamanya terbelakang. Mereka yang menolak investasi asing adalah kaum anti-pembangunan.\" Keberpihakan (bias) penulis dalam kutipan tersebut adalah...', 0, NULL),
(305, 16, 'Rata-rata nilai 30 siswa adalah 75. Rata-rata nilai siswa laki-laki adalah 72, dan rata-rata nilai siswa perempuan adalah 77. Selisih jumlah siswa laki-laki dan perempuan di kelas tersebut adalah...', 0, NULL),
(306, 16, 'Perhatikan persamaan reaksi (belum setara) berikut:\n(1) C$6$H${12}$O$_6$ + O$_2$ $\rightarrow$ CO$_2$ + H$_2$O + Energi (ATP)\n(2) CO$_2$ + H$_2$O + Cahaya $\rightarrow$ C$6$H${12}$O$_6$ + O$_2$\nPernyataan yang paling tepat mengenai kedua reaksi tersebut adalah...', 0, NULL),
(307, 16, 'Jika pemerintah menerapkan kebijakan anggaran defisit (pengeluaran > pendapatan) secara besar-besaran dan terus-menerus, dampak negatif jangka pendek yang paling mungkin terjadi di perekonomian adalah...', 0, NULL),
(308, 16, 'Sebuah dadu (6 sisi) dan dua koin (2 sisi) dilempar bersamaan. Peluang munculnya mata dadu ganjil DAN tepat satu gambar pada koin adalah...', 0, NULL),
(309, 16, 'Perhatikan penalaran berikut:\nPremis 1: Jika hari hujan, jalanan basah.\nPremis 2: Jalanan basah.\nKesimpulan: Hari ini hujan.\nPenalaran tersebut dianggap tidak sah (invalid) karena...', 0, NULL),
(310, 16, 'Sebuah sendok yang dicelupkan sebagian ke dalam gelas berisi air terlihat patah atau bengkok jika dilihat dari samping. Fenomena optik ini disebabkan oleh...', 0, NULL),
(311, 16, 'Sebuah segitiga di kuadran I dibatasi oleh garis $y = 2x$, sumbu-x, dan garis vertikal $x = 4$. Luas segitiga tersebut adalah...', 0, NULL),
(312, 16, 'Perbedaan fundamental antara konsep modernisasi dan westernisasi adalah...', 0, NULL),
(313, 16, 'Cermati kalimat: \"Pidatonya yang berapi-api berhasil membakar semangat para demonstran.\" Makna kata \"membakar\" dalam kalimat tersebut mengalami...', 0, NULL),
(314, 16, 'Seorang wanita bergolongan darah A (genotipe $I^A i$) memiliki seorang anak bergolongan darah O (genotipe $ii$). Pria manakah di bawah ini yang secara genetik tidak mungkin menjadi ayah biologis anak tersebut?', 0, NULL),
(315, 16, 'Suatu barisan aritmetika memiliki 15 suku. Suku pertama adalah 5 dan suku terakhir (suku ke-15) adalah 61. Suku tengah (suku ke-8) barisan tersebut adalah...', 0, NULL),
(316, 16, 'Sebanyak 10 gram Kalsium (Ca, Ar=40) direaksikan dengan 10 gram gas Oksigen (O$_2$, Ar=16) membentuk Kalsium Oksida (CaO). Reaksi: $2$Ca + O$_2$ $\rightarrow$ $2$CaO$. Massa CaO (Mr=56) yang terbentuk adalah...', 0, NULL),
(317, 16, 'Konsep \"Dwi Fungsi ABRI\" yang diterapkan sebagai pilar utama pemerintahan Orde Baru memiliki makna bahwa ABRI memiliki dua fungsi, yaitu...', 0, NULL),
(318, 16, 'Diberikan kubus ABCD.EFGH dengan panjang rusuk $s$. Jika $alpha$ adalah sudut yang terbentuk antara diagonal ruang AG dan bidang alas ABCD, maka nilai $cos(alpha)$ adalah...', 0, NULL),
(319, 16, 'Tiga resistor: $R_1=2Omega$, $R_2=3Omega$, dan $R_3=6Omega$. $R_2$ dan $R_3$ dirangkai paralel, kemudian diseri dengan $R_1$. Rangkaian ini dihubungkan ke sumber tegangan 12 Volt. Beda potensial (tegangan) yang terukur jika voltmeter dipasang paralel pada $R_2$ adalah...', 0, NULL),
(320, 16, 'Cermati kalimat: \"Pria itu memberitahu temannya bahwa dia baru saja memenangkan lotre.\" Kalimat tersebut tidak efektif karena ambigu (bermakna ganda) pada aspek...', 0, NULL),
(321, 17, 'Seutas kawat sepanjang 120 cm akan digunakan untuk membuat kerangka sebuah balok. Jika perbandingan Panjang : Lebar : Tinggi balok adalah (4 : 3 : 2), volume balok tersebut adalah...', 0, NULL),
(322, 17, 'Sebuah benda jika dicelupkan ke air (ρ_air=1 g/cm³) akan terapung dengan 3/4 bagian volumenya tercelup. Jika benda yang sama diletakkan di cairan B, 1/2 bagian volumenya tercelup. Massa jenis cairan B tersebut adalah...', 0, NULL),
(323, 17, 'Kebijakan \"Normalisasi Kehidupan Kampus/Badan Koordinasi Kemahasiswaan\" (NKK/BKK) yang diterapkan pemerintah Orde Baru pasca peristiwa Malari 1974 bertujuan utama untuk...', 0, NULL),
(324, 17, 'Cermati kutipan resensi buku berikut: \"Buku ini wajib dibaca oleh siapa pun yang mengaku peduli pada lingkungan. Penulisnya, seorang aktivis ternama, memaparkan data yang tak terbantahkan. Mereka yang tidak setuju dengan buku ini pastilah bagian dari perusak bumi.\" Sikap penulis resensi tersebut terhadap buku yang dibahas adalah...', 0, NULL),
(325, 17, 'Sebuah fungsi kuadrat f(x) = ax² + bx + c memotong sumbu-y di titik (0, 12) dan memiliki titik puncak (vertex) di koordinat (2, 4). Nilai dari f(5) adalah...', 0, NULL),
(326, 17, 'Dalam suatu piramida energi ekosistem laut, fitoplankton (produsen) memiliki total energi 10.000 kJ. Jika efisiensi transfer energi antar tingkat trofik adalah 10%, energi yang diterima oleh ikan besar (konsumen tersier) adalah...', 0, NULL),
(327, 17, 'Andi memiliki uang Rp 500.000. Pilihan yang ia miliki, diurutkan dari yang paling diinginkan: (1) Membeli sepatu, (2) Membeli game baru, (3) Menabung. Ia akhirnya memutuskan membeli sepatu. Opportunity cost (biaya peluang) dari keputusan tersebut adalah...', 0, NULL),
(328, 17, 'Dalam sebuah kotak terdapat 4 bola merah dan 2 bola biru. Jika diambil dua bola sekaligus secara acak, peluang terambilnya 1 bola merah dan 1 bola biru adalah...', 0, NULL),
(329, 17, 'Sebanyak 20 gram Natrium Hidroksida (NaOH) dilarutkan ke dalam air hingga volume larutan menjadi 500 mL. Jika Ar Na=23, O=16, dan H=1, konsentrasi (Molaritas) larutan yang terbentuk adalah...', 0, NULL),
(330, 17, 'Cermati kalimat: \"Banjir bandang itu terjadi akibat hutan di kawasan hulu yang telah beralih fungsi menjadi permukiman mewah.\" Makna tersirat (inferensi) yang paling logis dari kalimat tersebut adalah...', 0, NULL),
(331, 17, 'Diketahui persegi ABCD. Titik P adalah titik tengah sisi CD dan Q adalah titik tengah sisi AD. Jika luas segitiga PBQ adalah 45 cm², maka luas persegi ABCD adalah...', 0, NULL),
(332, 17, 'Sebanyak 100 gram air bersuhu 80°C dicampur dengan m gram es bersuhu 0°C. Jika suhu akhir campuran adalah 20°C (dan semua es telah melebur), maka massa es (m) adalah... (Kalor jenis air = 1 kal/g°C, Kalor lebur es = 80 kal/g)', 0, NULL),
(333, 17, 'Maklumat Pemerintah 3 November 1945 yang dikeluarkan oleh Wakil Presiden Mohammad Hatta memiliki dampak fundamental pada sistem politik Indonesia muda, yaitu...', 0, NULL),
(334, 17, 'Cermati kalimat: \"Menurut para ahli-ahli, sistim pernapasan paus berbeda dengan mamalia daripada ikan.\" Kalimat tersebut tidak efektif karena memiliki kesalahan...', 0, NULL),
(335, 17, 'Diketahui sistem persamaan (1/x) + (1/y) = 5 dan (2/x) - (3/y) = -5. Nilai dari y - x adalah...', 0, NULL),
(336, 17, 'Seorang wanita normal (yang ayahnya menderita buta warna) menikah dengan seorang pria normal. Persentase kemungkinan mereka memiliki anak perempuan yang menderita buta warna adalah...', 0, NULL),
(337, 17, 'Angin Muson Barat yang bertiup dari Benua Asia menuju Benua Australia (melintasi Indonesia) pada periode Oktober-April membawa dampak signifikan bagi Indonesia, yaitu...', 0, NULL),
(338, 17, 'Titik P(3, -2) dicerminkan terhadap sumbu-Y, kemudian dilanjutkan dengan rotasi 90° berlawanan arah jarum jam dengan pusat (0,0). Koordinat bayangan akhir (P\') adalah...', 0, NULL),
(339, 17, 'Seorang penderita hipermetropi (rabun dekat) memiliki titik dekat mata (Punctum Proximum) 50 cm. Agar ia dapat membaca buku dengan jelas pada jarak normal (25 cm), ia memerlukan kacamata berkekuatan...', 0, NULL),
(340, 17, 'Perbedaan konseptual utama antara organisasi regional seperti ASEAN dan forum ekonomi seperti APEC (Asia-Pacific Economic Cooperation) adalah...', 0, NULL),
(341, 18, 'Sebuah persegi panjang berukuran 8 cm x 10 cm. Volume tabung A terbentuk jika persegi panjang itu diputar 360° mengelilingi sisi 10 cm. Volume tabung B terbentuk jika diputar 360° mengelilingi sisi 8 cm. Perbandingan volume A dan volume B adalah...', 0, NULL),
(342, 18, 'Sebuah pemanas air listrik bertuliskan 400 Watt / 220 Volt. Pemanas tersebut digunakan untuk memanaskan air hingga mendidih dan membutuhkan waktu 5 menit. Jika pemanas yang sama dipasang pada sumber tegangan 110 Volt, waktu yang dibutuhkan hingga air tersebut mendidih adalah... (Asumsikan kalor yang hilang diabaikan)', 0, NULL),
(343, 18, 'Pergeseran paling fundamental dalam politik luar negeri Indonesia dari era Demokrasi Terpimpin (Orde Lama) ke era Orde Baru adalah...', 0, NULL),
(344, 18, 'Cermati argumen berikut: \"Film itu pasti sangat bagus dan berkualitas. Buktinya, film itu trending topic nomor satu di media sosial dan ditonton oleh jutaan orang (box office).\" Kesesatan berpikir (logical fallacy) dalam argumen tersebut adalah...', 0, NULL),
(345, 18, 'Sebuah kotak berisi 3 bola merah dan 2 bola biru. Diambil satu bola secara acak (tidak dilihat warnanya) dan tidak dikembalikan. Kemudian diambil satu bola lagi. Peluang bola kedua yang terambil adalah Merah adalah...', 0, NULL),
(346, 18, 'Pada persilangan dihibrid antara tanaman bergenotipe AaBb dengan sesamanya (AaBb), persentase peluang untuk mendapatkan keturunan dengan genotipe heterozigot sempurna (AaBb) adalah...', 0, NULL),
(347, 18, 'Ketika harga cabai naik 50%, permintaan konsumen hanya turun 10%. Sebaliknya, ketika harga smartphone model terbaru naik 10%, permintaan konsumen turun 30%. Pernyataan yang paling tepat adalah...', 0, NULL),
(348, 18, 'Cermati kalimat: \"Siswa yang memenangkan medali emas itu mengaku bahwa ia mendedikasikan kemenangannya untuk orang tuanya.\" Klausa (anak kalimat) yang bercetak miring dalam kalimat tersebut berfungsi sebagai...', 0, NULL),
(349, 18, 'Titik P berada di luar lingkaran yang berpusat di O. Garis PA dan PB adalah garis singgung lingkaran di titik A dan B. Jika jarak PO adalah 26 cm dan jari-jari lingkaran adalah 10 cm, maka panjang tali busur AB adalah...', 0, NULL),
(350, 18, 'Sebanyak 10 gram gas Hidrogen (H₂) direaksikan dengan 10 gram gas Oksigen (O₂) untuk membentuk uap air (H₂O) sesuai persamaan reaksi 2H₂ + O₂ → 2H₂O. (Ar H=1, O=16). Pernyataan yang benar adalah...', 0, NULL),
(351, 18, 'Suatu negara mencatat angka kelahiran yang masih sangat tinggi, namun angka kematian menurun drastis berkat perbaikan sanitasi dan program vaksinasi massal. Dampak demografis langsung dari kondisi ini (Tahap II Transisi Demografi) adalah...', 0, NULL),
(352, 18, 'Budi berkendara dari kota A ke kota B dengan kecepatan konstan 60 km/jam. Ia kemudian langsung kembali dari kota B ke kota A melalui jalur yang sama dengan kecepatan konstan 40 km/jam. Kecepatan rata-rata Budi untuk seluruh perjalanan (pulang-pergi) adalah...', 0, NULL),
(353, 18, 'Sebuah tabung kolom udara diisi air. Garpu tala 340 Hz digetarkan di atasnya. Resonansi pertama (bunyi terkeras pertama) terdengar saat panjang kolom udara di atas air adalah 25 cm. Resonansi kedua akan terdengar saat panjang kolom udara...', 0, NULL),
(354, 18, '\"Petisi 50\" yang muncul pada masa Orde Baru (tahun 1980) merupakan dokumen yang berisi...', 0, NULL),
(355, 18, 'Cermati kutipan: \"Gedung baru itu akhirnya diresmikan, meskipun menghabiskan dana yang luar biasa besar dan molor dari jadwal yang dijanjikan. Warga tentu berharap fasilitas publik ini sepadan dengan biayanya.\" Nada (tone) penulis dalam kutipan tersebut adalah...', 0, NULL),
(356, 18, 'Sebuah tiang bendera setinggi 8 meter memiliki bayangan di tanah. Seorang siswa setinggi 1,6 meter berdiri sejauh 6 meter dari tiang, di mana ujung bayangan siswa berimpit sempurna dengan ujung bayangan tiang. Panjang bayangan siswa tersebut adalah...', 0, NULL),
(357, 18, 'Enzim pepsin, yang berperan memecah protein, bekerja secara optimal di lambung pada pH 2 (sangat asam). Jika enzim pepsin murni dipindahkan ke dalam larutan usus halus yang memiliki pH 8 (basa), aktivitas enzim pepsin tersebut akan...', 0, NULL),
(358, 18, 'Pemerintah suatu negara mengumumkan bahwa \"Angka Gini Ratio\" mereka memburuk, naik dari 0,38 menjadi 0,41. Hal ini mengindikasikan...', 0, NULL),
(359, 18, 'Diketahui g(x) = 2x² - x dan fungsi komposisi (f ∘ g)(x) = 4x² - 2x + 5. Nilai dari f(10) adalah...', 0, NULL),
(360, 18, 'Sebuah magnet batang digerakkan keluar-masuk kumparan kawat (solenoida) yang terhubung ke galvanometer. GGL (tegangan) induksi yang dihasilkan akan menjadi semakin besar jika...', 0, NULL),
(361, 19, 'Sebuah lingkaran L menyinggung keempat sisi sebuah persegi P1 (lingkaran di dalam persegi). Sebuah persegi P2 diletakkan di dalam lingkaran L sehingga keempat titik sudutnya menyentuh keliling lingkaran L. Perbandingan Luas P1 : Luas P2 adalah...', 0, NULL),
(362, 19, 'Sebanyak 100 mL larutan HCl 0,2 M dicampur dengan 100 mL larutan Ca(OH)2 0,2 M. Setelah bereaksi, sifat campuran larutan yang dihasilkan dan pH-nya adalah...', 0, NULL),
(363, 19, 'Perbedaan fundamental antara kebijakan \"Program Benteng\" (era Demokrasi Liberal) dan \"Repelita\" (Rencana Pembangunan Lima Tahun era Orde Baru) adalah...', 0, NULL),
(364, 19, 'Cermati penalaran berikut:\nPremis 1: \"Jika seorang siswa rajin belajar, ia akan mendapat nilai 100.\"\nFakta: \"Budi adalah siswa yang rajin belajar, namun ia hanya mendapat nilai 90.\"\nKesimpulan logis yang sah (valid) berdasarkan fakta tersebut adalah...', 0, NULL),
(365, 19, 'Diketahui f(x) = 2x - 1 dan fungsi komposisi (f ∘ g)(x) = 4x² + 2x - 1. Rumus g(x) adalah...', 0, NULL),
(366, 19, 'Seseorang dengan mata normal (titik dekat, PP = 25 cm) menggunakan lup (kaca pembesar) berkekuatan 10 Dioptri. Perbesaran maksimum yang bisa ia peroleh (mata berakomodasi maksimum) adalah...', 0, NULL),
(367, 19, 'Negara A mencatat pertumbuhan PDB 7%, namun Gini Ratio-nya naik dari 0,40 menjadi 0,45. Negara B mencatat pertumbuhan PDB 3%, namun Gini Ratio-nya turun dari 0,35 menjadi 0,30. Interpretasi yang paling tepat adalah...', 0, NULL),
(368, 19, 'Dalam sebuah kantong terdapat 5 bola Merah dan 3 bola Biru. Jika diambil tiga bola sekaligus secara acak, peluang terambilnya paling sedikit 1 bola Merah adalah...', 0, NULL),
(369, 19, 'Tanaman mangga bergenotipe (BbKk) disilangkan dengan (bbkk). (B=Buah besar dominan thd b=kecil; K=Kuning dominan thd k=hijau). Jika dihasilkan 200 keturunan, jumlah keturunan yang berfenotipe (Kecil, Kuning) diperkirakan sebanyak...', 0, NULL),
(370, 19, 'Cermati kalimat: \"Untuk mengefisienkan waktu, rapat ini akan segera kita mulai.\" Penggunaan kata \"mengefisienkan\" pada kalimat tersebut tidak tepat karena...', 0, NULL),
(371, 19, 'Rata-rata nilai ulangan 8 siswa adalah 75. Dua siswa (A dan B) mengikuti ulangan susulan sehingga rata-rata nilai 10 siswa tersebut menjadi 78. Jika nilai A adalah 10 lebihnya dari nilai B (A = B + 10), maka nilai A adalah...', 0, NULL),
(372, 19, 'Sebuah pemanas listrik 100 Watt (efisiensi 100%) dicelupkan ke dalam 500 gram es bersuhu -10°C. Waktu yang dibutuhkan HANYA untuk meleburkan es setelah suhunya mencapai 0°C adalah... (c_es=2100 J/kg°C, L_es=336.000 J/kg)', 0, NULL),
(373, 19, 'Secara filosofi ekonomi, perbedaan utama antara \"Demokrasi Terpimpin\" era Soekarno dan \"Orde Baru\" era Soeharto adalah...', 0, NULL),
(374, 19, 'Cermati kutipan: \"Data BPS menunjukkan 9 dari 10 pemuda desa pindah ke kota, meninggalkan lahan tani. Akibatnya, 80% petani kita berusia di atas 50 tahun. Siapa yang akan memberi kita makan 20 tahun lagi jika tren ini berlanjut?\" Tujuan implisit (tersirat) penulis dalam paragraf tersebut adalah...', 0, NULL),
(375, 19, 'Diketahui limas T.ABCD dengan alas persegi ABCD yang panjang rusuknya 12 cm. Jika panjang semua rusuk tegak (TA, TB, TC, TD) adalah 10 cm, jarak titik puncak T ke bidang alas ABCD adalah...', 0, NULL),
(376, 19, 'Perhatikan rangkaian 5 resistor berikut. R1=10 Ω, R2=5 Ω, R3=6 Ω, R4=3 Ω, dan R5=8 Ω (R5 di tengah, menghubungkan R1-R3 dan R2-R4). Hambatan total (ekivalen) dari rangkaian tersebut adalah...', 0, NULL),
(377, 19, 'Pak Budi adalah seorang guru SD. Ia bekerja keras dan berhasil menyekolahkan anaknya hingga menjadi seorang dokter spesialis bedah. Dalam sosiologi, kasus yang dialami anak Pak Budi ini merupakan contoh...', 0, NULL),
(378, 19, 'Seorang siswa (tinggi badan 1,5 m) mengamati puncak tiang bendera dengan sudut elevasi 30°. Ia lalu berjalan 20 meter mendekati tiang, dan sudut elevasi menjadi 60°. Tinggi tiang bendera tersebut adalah...', 0, NULL),
(379, 19, 'Perhatikan jaring-jaring makanan berikut:\n(Rumput → Belalang → Katak → Ular → Elang) DAN (Rumput → Tikus → Ular → Elang).\nJika populasi Katak musnah akibat penyakit, dampak langsung yang paling mungkin terjadi adalah...', 0, NULL),
(380, 19, 'Alasan utama Indonesia memutuskan untuk \"kembali\" menjadi anggota PBB (Perserikatan Bangsa-Bangsa) pada tahun 1966, setelah sempat keluar pada tahun 1965, adalah...', 0, NULL),
(381, 20, 'Sebuah kerucut memiliki jari-jari alas 6 cm dan tinggi 8 cm. Sebuah bola padat dimasukkan ke dalam kerucut tersebut sehingga menyinggung alas dan selimut kerucut. Jari-jari bola terbesar yang mungkin adalah...', 0, NULL),
(382, 20, 'Sebuah benda ditimbang di udara beratnya 100 N. Saat ditimbang di dalam air (massa jenis 1.000 kg/m^3), beratnya menjadi 80 N. Jika benda yang sama ditimbang di dalam cairan X, beratnya menjadi 84 N. Massa jenis cairan X adalah...', 0, NULL),
(383, 20, 'Perbedaan fundamental yang menjadi pemicu kejatuhan Orde Lama (1966) dan Orde Baru (1998) adalah...', 0, NULL),
(384, 20, 'Cermati penalaran berikut: \"Data statistik di kota X menunjukkan bahwa selama musim panas, penjualan es krim meningkat. Pada periode yang sama, angka kejahatan perampokan juga meningkat. Maka, disimpulkan bahwa es krim menyebabkan orang berbuat jahat.\"', 0, NULL),
(385, 20, 'Budi dan Candra bekerja bersama-sama dapat mengecat rumah dalam 4 hari. Jika Budi bekerja sendirian, ia dapat menyelesaikannya dalam 6 hari. Waktu yang dibutuhkan Candra untuk mengecat rumah sendirian adalah...', 0, NULL),
(386, 20, 'Seorang pria bergolongan darah AB dan tidak buta warna (I^A I^B X^C Y) menikah dengan seorang wanita bergolongan darah O yang ayahnya penderita buta warna (wanita ini carrier, ii X^C X^c). Peluang mereka memiliki anak laki-laki yang menderita buta warna DAN bergolongan darah B adalah...', 0, NULL),
(387, 20, 'Negara A memproduksi 100 mobil atau 50 ton beras. Negara B memproduksi 80 mobil atau 80 ton beras. Berdasarkan teori keunggulan komparatif, perdagangan internasional akan menguntungkan kedua negara jika termin perdagangan (harga tukar) yang disepakati adalah...', 0, NULL),
(388, 20, 'Dua buah dadu (6 sisi) dilempar bersamaan. Diketahui bahwa jumlah mata dadu yang muncul adalah 8. Peluang bahwa salah satu mata dadu yang muncul adalah 2 adalah...', 0, NULL),
(389, 20, 'Sebanyak 10 Liter gas Nitrogen (N2) direaksikan dengan 24 Liter gas Hidrogen (H2) pada suhu dan tekanan yang sama, sesuai reaksi: N2(g) + 3H2(g) → 2NH3(g). Volume gas total (sisa reaktan + produk) setelah reaksi selesai adalah...', 0, NULL),
(390, 20, 'Cermati dialog: Andi: \"Maaf, aku tidak sengaja menjatuhkan laptop barumu hingga layarnya retak parah.\" Budi: \"Oh, bagus sekali. Bagus sekali. Padahal aku harus presentasi penting besok pagi.\" Maksud utama ucapan \"Bagus sekali\" dari Budi adalah untuk mengekspresikan...', 0, NULL),
(391, 20, 'Sebuah kapal berlayar 12 km ke arah timur (jurusan 090°), kemudian berbelok lurus 16 km ke arah selatan (jurusan 180°). Jarak terpendek kapal tersebut dari titik awal keberangkatan adalah...', 0, NULL),
(392, 20, 'Sebuah mikroskop memiliki jarak fokus lensa objektif 2 cm dan lensa okuler 5 cm. Sebuah benda diletakkan 2,5 cm di depan lensa objektif. Jika pengamatan dilakukan dengan mata tidak berakomodasi (Sn = 25 cm), perbesaran total mikroskop adalah...', 0, NULL),
(393, 20, 'Sebuah pulau terisolasi hanya memiliki ekosistem rumput dan rusa. Manusia kemudian memasukkan (mengintroduksi) kelinci ke pulau tersebut. Kelinci berkembang biak jauh lebih cepat daripada rusa. Dampak ekologis jangka panjang yang paling mungkin terjadi adalah...', 0, NULL),
(394, 20, 'Dikeluarkannya Dekret Presiden 5 Juli 1959 yang membubarkan Konstituante dan memberlakukan kembali UUD 1945, ditinjau dari hukum tata negara (berdasarkan UUDS 1950 yang berlaku saat itu), adalah sebuah tindakan...', 0, NULL),
(395, 20, 'Rata-rata nilai ulangan 30 siswa adalah 78. Jika 5 nilai siswa susulan digabungkan, rata-rata nilai total (35 siswa) menjadi 80. Rata-rata nilai dari 5 siswa susulan tersebut adalah...', 0, NULL),
(396, 20, 'Larutan A memiliki pH = 2. Larutan B memiliki pH = 5. Pernyataan yang paling tepat mengenai kedua larutan tersebut adalah...', 0, NULL),
(397, 20, 'Sebuah benda bergerak dari keadaan diam, lalu mengalami percepatan konstan 2 m/s^2 selama 5 detik. Setelah itu, benda bergerak dengan kecepatan konstan selama 10 detik. Jarak total yang ditempuh benda selama 15 detik tersebut adalah...', 0, NULL),
(398, 20, 'Mengapa gempa bumi akibat pergeseran lempeng di zona subduksi (misal: Palung Sunda, barat Sumatera) memiliki potensi tsunami yang jauh lebih besar dibandingkan gempa akibat patahan geser (misal: Sesar Semangko, di daratan Sumatera)?', 0, NULL),
(399, 20, 'Cermati kalimat: \"Pria itu melihat wanita di taman dengan teropong.\" Ambiguitas (makna ganda) yang paling mungkin dari kalimat tersebut adalah...', 0, NULL),
(400, 20, 'Sebuah kerucut besar memiliki jari-jari alas 10 cm dan tinggi 12 cm. Kerucut tersebut dipotong secara horizontal 6 cm dari puncaknya (atau 6 cm dari alas). Volume bagian bawah kerucut (disebut frustum atau kerucut terpancung) yang tersisa adalah...', 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesertaturnamen`
--

CREATE TABLE `pesertaturnamen` (
  `id_peserta` int(11) NOT NULL,
  `id_turnamen` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `skor_akhir` int(11) DEFAULT 0,
  `peringkat` int(11) DEFAULT NULL,
  `joined_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('active','eliminated','finished') DEFAULT 'active',
  `lives_remaining` int(11) DEFAULT 3,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesertaturnamen`
--

INSERT INTO `pesertaturnamen` (`id_peserta`, `id_turnamen`, `id_pengguna`, `skor_akhir`, `peringkat`, `joined_at`, `status`, `lives_remaining`, `created_at`, `updated_at`) VALUES
(9, 2, 10, 0, NULL, '2025-11-14 23:44:25', 'active', 3, '2025-11-14 16:44:25', '2025-11-14 16:44:25'),
(11, 2, 13, 0, NULL, '2025-11-14 23:46:40', 'active', 3, '2025-11-14 16:46:40', '2025-11-14 16:46:40'),
(12, 10, 12, 0, NULL, '2025-11-14 16:48:07', 'active', 3, '2025-11-14 23:48:07', '2025-11-14 23:48:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pilihanjawaban`
--

CREATE TABLE `pilihanjawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_pertanyaan` int(11) NOT NULL,
  `teks_jawaban` text NOT NULL,
  `adalah_benar` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pilihanjawaban`
--

INSERT INTO `pilihanjawaban` (`id_jawaban`, `id_pertanyaan`, `teks_jawaban`, `adalah_benar`) VALUES
(1, 1, 'Bunga', 0),
(2, 1, 'Batang', 0),
(3, 1, 'Akar', 0),
(4, 1, 'Daun', 1),
(5, 2, 'Globe', 0),
(6, 2, 'Ruang', 0),
(7, 2, 'Atlas', 0),
(8, 2, 'Peta', 1),
(9, 3, 'Vitamin A pada wortel', 0),
(10, 3, 'Manfaat wortel bagi kesehatan tubuh', 1),
(11, 3, 'Kesehatan tubuh bergantung pada wortel', 0),
(12, 3, 'Wortel sebagai obat tradisional', 0),
(13, 4, '(32 × 8) × (32 × 7)', 0),
(14, 4, '(32 × 8) + (32 × 7)', 1),
(15, 4, '32 × 15', 0),
(16, 4, '(32+8) × (32+7)', 0),
(17, 5, 'Melakukan eksperimen', 0),
(18, 5, 'Menyusun hipotesis', 0),
(19, 5, 'Melakukan observasi', 1),
(20, 5, 'Menarik kesimpulan', 0),
(21, 6, 'Geologis', 0),
(22, 6, 'Geografis', 0),
(23, 6, 'Astronomis', 1),
(24, 6, 'Absolut', 0),
(25, 7, 'Mencair', 0),
(26, 7, 'Menguap', 0),
(27, 7, 'Membeku', 1),
(28, 7, 'Menyublim', 0),
(29, 8, 'Angin darat dan angin laut', 0),
(30, 8, 'Angin muson barat dan angin muson timur', 1),
(31, 8, 'Letak astronomis Indonesia', 0),
(32, 8, 'Bentuk negara kepulauan', 0),
(33, 9, 'Bentuk daun tanaman dikotil', 0),
(34, 9, 'Bentuk biji pada tanaman dikotil', 0),
(35, 9, 'Ciri-ciri khusus tanaman dikotil', 1),
(36, 9, 'Macam-macam tanaman dikotil', 0),
(37, 10, '17°C', 0),
(38, 10, '20°C', 0),
(39, 10, '26°C', 1),
(40, 10, '29°C', 0),
(41, 11, 'Kucing dan Anjing', 0),
(42, 11, 'Burung dan Ayam', 0),
(43, 11, 'Ikan dan Katak', 1),
(44, 11, 'Manusia dan Kera', 0),
(45, 12, '4', 0),
(46, 12, '5', 0),
(47, 12, '6', 1),
(48, 12, '7', 0),
(49, 13, 'Soekarno dan Mohammad Hatta', 1),
(50, 13, 'Sutan Sjahrir dan Amir Syarifuddin', 0),
(51, 13, 'Ki Hajar Dewantara dan H. Agus Salim', 0),
(52, 13, 'Sayuti Melik dan B.M. Diah', 0),
(53, 14, 'Ayah membeli koran dan majalah.', 0),
(54, 14, 'Kamu boleh bermain atau belajar.', 0),
(55, 14, 'Rina tidak masuk sekolah karena sakit.', 0),
(56, 14, 'Setelah sarapan, adik berangkat ke sekolah.', 1),
(57, 15, 'Volt', 0),
(58, 15, 'Ohm', 0),
(59, 15, 'Watt', 0),
(60, 15, 'Ampere', 1),
(61, 16, 'Indonesia', 0),
(62, 16, 'Thailand', 0),
(63, 16, 'Vietnam', 1),
(64, 16, 'Malaysia', 0),
(65, 17, '24 cm', 0),
(66, 17, '48 cm', 1),
(67, 17, '144 cm', 0),
(68, 17, '60 cm', 0),
(69, 18, 'Taman Nasional Komodo hanya melindungi komodo.', 0),
(70, 18, 'Habitat asli komodo berada di Pulau Sumbawa.', 0),
(71, 18, 'Komodo adalah satu-satunya hewan di Taman Nasional Komodo.', 0),
(72, 18, 'Taman Nasional Komodo memiliki keindahan bawah laut.', 1),
(73, 19, 'Parasitisme', 0),
(74, 19, 'Komensalisme', 0),
(75, 19, 'Mutualisme', 1),
(76, 19, 'Predasi', 0),
(77, 20, 'Primer', 1),
(78, 20, 'Sekunder', 0),
(79, 20, 'Tersier', 0),
(80, 20, 'Rohani', 0),
(81, 21, '0', 0),
(82, 21, '20', 0),
(83, 21, '50', 1),
(84, 21, '30', 0),
(85, 22, 'Panjang, volume, massa, dan kecepatan', 0),
(86, 22, 'Panjang, massa, waktu, dan suhu', 1),
(87, 22, 'Massa, usaha, waktu, dan suhu', 0),
(88, 22, 'Massa, waktu, gaya, dan suhu', 0),
(89, 23, 'Asosiatif', 0),
(90, 23, 'Disosiatif', 1),
(91, 23, 'Akomodatif', 0),
(92, 23, 'Asimilasi', 0),
(93, 24, 'Jangka sorong', 0),
(94, 24, 'Mistar', 0),
(95, 24, 'Neraca', 0),
(96, 24, 'Gelas ukur', 1),
(97, 25, 'Unik dan indah', 1),
(98, 25, 'Mahal dan langka', 0),
(99, 25, 'Aneh dan ganjil', 0),
(100, 25, 'Luas dan terbuka', 0),
(101, 26, '3^-10', 0),
(102, 26, '3^7', 0),
(103, 26, '3^3', 1),
(104, 26, '3^-7', 0),
(105, 27, 'Difusi', 0),
(106, 27, 'Osmosis', 0),
(107, 27, 'Ekskresi', 0),
(108, 27, 'Respirasi', 1),
(109, 28, 'APEC', 0),
(110, 28, 'PBB', 0),
(111, 28, 'ASEAN', 1),
(112, 28, 'Uni Eropa', 0),
(113, 29, 'Pingsan', 0),
(114, 29, 'Ragu-ragu', 0),
(115, 29, 'Marah', 1),
(116, 29, 'Memaksa', 0),
(117, 30, '5 m di bawah permukaan laut', 0),
(118, 30, '35 m di atas permukaan laut', 0),
(119, 30, '5 m di atas permukaan laut', 0),
(120, 30, '35 m di bawah permukaan laut', 1),
(121, 31, 'Oksigen dan uap air', 0),
(122, 31, 'Urea dan keringat', 0),
(123, 31, 'Karbon dioksida dan uap air', 1),
(124, 31, 'Oksigen dan karbon dioksida', 0),
(125, 32, 'Lamin', 0),
(126, 32, 'Honai', 0),
(127, 32, 'Joglo', 0),
(128, 32, 'Gadang', 1),
(129, 33, 'Menguap', 0),
(130, 33, 'Mengembun', 1),
(131, 33, 'Menyublim', 0),
(132, 33, 'Membeku', 0),
(133, 34, '2 : 3', 0),
(134, 34, '1 : 2', 0),
(135, 34, '2 : 5', 1),
(136, 34, '3 : 5', 0),
(137, 35, 'Dengan memakan madu tersebut kita bebas dari pencemaran.', 0),
(138, 35, 'Madu tersebut adalah makanan yang bebas dari pencemaran.', 1),
(139, 35, 'Makanan bagi orang yang terbebas dari pencemaran.', 0),
(140, 35, 'Makanan tersebut menyembuhkan penyakit dari pencemaran.', 0),
(141, 36, 'Pulau Jawa lebih luas', 0),
(142, 36, 'Pulau Jawa memiliki tanah yang sangat subur', 1),
(143, 36, 'Kebijakan pemerintah', 0),
(144, 36, 'Pulau Jawa lebih kaya sumber daya tambang', 0),
(145, 37, 'Hidung', 0),
(146, 37, 'Trakea', 1),
(147, 37, 'Alveolus', 0),
(148, 37, 'Paru-paru', 0),
(149, 38, '{1,3,5,7,9}', 0),
(150, 38, '{1,3,5,7,9,10}', 1),
(151, 38, '{2,4,6,8}', 0),
(152, 38, '{1,2,3,4,5,6,7,8,9,10}', 0),
(153, 39, 'Peralihan', 0),
(154, 39, 'Timur (Australis)', 1),
(155, 39, 'Barat (Asiatis)', 0),
(156, 39, 'Tengah', 0),
(157, 40, 'Pekerja keras dan disiplin', 1),
(158, 40, 'Berjuang untuk keluarga', 0),
(159, 40, 'Berpindah tempat untuk mencari ilmu', 0),
(160, 40, 'Melanjutkan SMP dan SMA di Bandung', 0),
(161, 41, '75', 0),
(162, 41, '85', 1),
(163, 41, '90', 0),
(164, 41, '105', 0),
(165, 42, '0,25 Hz', 0),
(166, 42, '4 Hz', 1),
(167, 42, '15 Hz', 0),
(168, 42, '900 Hz', 0),
(169, 43, 'Kesempatan antara (intervening opportunity)', 0),
(170, 43, 'Saling melengkapi (complementarity)', 1),
(171, 43, 'Kemudahan transfer (transferability)', 0),
(172, 43, 'Persaingan', 0),
(173, 44, '4', 0),
(174, 44, '3', 0),
(175, 44, '2', 0),
(176, 44, '1', 1),
(177, 45, '15 km', 0),
(178, 45, '40 km', 0),
(179, 45, '60 km', 1),
(180, 45, '150 km', 0),
(181, 46, 'Tegak lurus dengan arah getarnya', 0),
(182, 46, 'Sejajar dengan arah getarnya', 1),
(183, 46, 'Berlawanan dengan arah getarnya', 0),
(184, 46, 'Membentuk sudut dengan arah getarnya', 0),
(185, 47, '3', 1),
(186, 47, '4', 0),
(187, 47, '5', 0),
(188, 47, '6', 0),
(189, 48, 'Evolusi', 0),
(190, 48, 'Revolusi', 1),
(191, 48, 'Modernisasi', 0),
(192, 48, 'Westernisasi', 0),
(193, 49, '8,3 m', 0),
(194, 49, '8,5 m', 1),
(195, 49, '8,7 m', 0),
(196, 49, '8,8 m', 0),
(197, 50, '2 pekerja', 0),
(198, 50, '4 pekerja', 1),
(199, 50, '5 pekerja', 0),
(200, 50, '24 pekerja', 0),
(201, 51, 'Asosiatif berupa kerja sama', 0),
(202, 51, 'Disosiatif berupa konflik', 1),
(203, 51, 'Asosiatif berupa akomodasi', 0),
(204, 51, 'Disosiatif berupa persaingan', 0),
(205, 52, 'Menulis novel yang sangat laku dan seorang Master Ekonomi Mikro', 1),
(206, 52, 'Penulis novel usia muda yang digemari karyanya', 0),
(207, 52, 'Seorang penulis berbakat yang pertama kali menulis', 0),
(208, 52, 'Seorang penulis cerpen terkenal pada masa sekarang', 0),
(209, 53, 'Pupil – kornea – lensa mata – bayangan ditangkap retina', 0),
(210, 53, 'Pupil – iris – kornea – lensa mata – bayangan ditangkap retina', 0),
(211, 53, 'Kornea – pupil – iris – lensa mata – bayangan ditangkap retina', 0),
(212, 53, 'Kornea – pupil – lensa mata – bayangan ditangkap retina', 1),
(213, 54, 'Rp 125.000,00', 0),
(214, 54, 'Rp 120.000,00', 0),
(215, 54, 'Rp 100.000,00', 1),
(216, 54, 'Rp 150.000,00', 0),
(217, 55, 'Habitat binatang laut untuk berlindung dan mencari makan', 1),
(218, 55, 'Tempat wisata pantai yang indah', 0),
(219, 55, 'Sumber kayu untuk bahan bangunan', 0),
(220, 55, 'Lokasi budidaya mutiara', 0),
(221, 56, '-3/2', 0),
(222, 56, '-2/3', 0),
(223, 56, '2/3', 1),
(224, 56, '3/2', 0),
(225, 57, 'Maya, tegak, diperkecil', 1),
(226, 57, 'Maya, tegak, diperbesar', 0),
(227, 57, 'Nyata, terbalik, diperkecil', 0),
(228, 57, 'Nyata, terbalik, diperbesar', 0),
(229, 58, 'Lokasi absolut', 0),
(230, 58, 'Lokasi relatif', 1),
(231, 58, 'Lokasi tetap', 0),
(232, 58, 'Lokasi geografis', 0),
(233, 59, '(1)', 0),
(234, 59, '(2)', 0),
(235, 59, '(3)', 1),
(236, 59, '(4)', 0),
(237, 60, '80 cm2', 0),
(238, 60, '96 cm2', 1),
(239, 60, '120 cm2', 0),
(240, 60, '160 cm2', 0),
(321, 61, '300x', 0),
(322, 61, '400x', 1),
(323, 61, '500x', 0),
(324, 61, '50x', 0),
(325, 62, 'Mencanangkan program Keluarga Berencana (KB)', 0),
(326, 62, 'Melaksanakan program transmigrasi', 1),
(327, 62, 'Membatasi arus urbanisasi', 0),
(328, 62, 'Membangun industri di Pulau Jawa', 0),
(329, 63, '3,75 m', 1),
(330, 63, '3,50 m', 0),
(331, 63, '4,00 m', 0),
(332, 63, '4,25 m', 0),
(333, 64, 'Proton', 0),
(334, 64, 'Neutron', 1),
(335, 64, 'Nukleus', 0),
(336, 64, 'Elektron', 0),
(337, 65, 'Hambatan', 0),
(338, 65, 'Gabungan', 1),
(339, 65, 'Kecocokan', 0),
(340, 65, 'Pemisahan', 0),
(341, 66, '(1) dan (2)', 0),
(342, 66, '(1) dan (3)', 1),
(343, 66, '(2) dan (4)', 0),
(344, 66, '(3) dan (4)', 0),
(345, 67, 'Partenogenesis', 1),
(346, 67, 'Fragmentasi', 0),
(347, 67, 'Tunas', 0),
(348, 67, 'Pembelahan biner', 0),
(349, 68, 'Tingkat pendidikan yang tinggi', 0),
(350, 68, 'Ketersediaan sumber air bersih', 1),
(351, 68, 'Tersedianya pusat-pusat hiburan', 0),
(352, 68, 'Sarana transportasi yang modern', 0),
(353, 69, '36 pohon', 0),
(354, 69, '37 pohon', 0),
(355, 69, '44 pohon', 1),
(356, 69, '45 pohon', 0),
(357, 70, 'Meyakinkan dengan cara membujuk', 1),
(358, 70, 'Memberi tahu dengan cara kekerasan', 0),
(359, 70, 'Meyakinkan dengan memberikan ceramah', 0),
(360, 70, 'Memberikan imbauan menuju kebaikan', 0),
(361, 71, '20', 1),
(362, 71, '30', 0),
(363, 71, '45', 0),
(364, 71, '50', 0),
(365, 72, 'Feromagnetik', 1),
(366, 72, 'Paramagnetik', 0),
(367, 72, 'Diamagnetik', 0),
(368, 72, 'Elektromagnetik', 0),
(369, 73, 'Dikenalnya sistem kerajaan', 0),
(370, 73, 'Munculnya sistem kasta dalam masyarakat', 1),
(371, 73, 'Penggunaan bahasa Sanskerta', 0),
(372, 73, 'Pembangunan candi sebagai tempat ibadah', 0),
(373, 74, '(1)', 1),
(374, 74, '(2)', 0),
(375, 74, '(3)', 0),
(376, 74, '(4)', 0),
(377, 75, '175', 0),
(378, 75, '190', 0),
(379, 75, '195', 1),
(380, 75, '210', 0),
(381, 76, 'Induksi', 0),
(382, 76, 'Menggosok', 0),
(383, 76, 'Elektromagnetik', 1),
(384, 76, 'Alami', 0),
(385, 77, '(1), (2), dan (3)', 0),
(386, 77, '(2), (3), dan (1)', 1),
(387, 77, '(3), (1), dan (2)', 0),
(388, 77, '(2), (1), dan (3)', 0),
(389, 78, '120 cm^3', 0),
(390, 78, '240 cm^3', 0),
(391, 78, '360 cm^3', 0),
(392, 78, '720 cm^3', 1),
(393, 79, 'Kutub magnet', 0),
(394, 79, 'Medan magnet', 0),
(395, 79, 'Garis-garis gaya magnet', 1),
(396, 79, 'Fluks magnet', 0),
(397, 80, 'Status quo', 0),
(398, 80, 'Kekosongan kekuasaan (vacuum of power)', 1),
(399, 80, 'Perang kemerdekaan', 0),
(400, 80, 'Perjanjian damai', 0),
(401, 81, 'A. Perhatian terhadap lansia', 1),
(402, 81, 'B. Undang-undang lansia', 0),
(403, 81, 'C. Masalah akibat lansia', 0),
(404, 81, 'D. Lahan untuk lansia', 0),
(405, 82, 'A. (-1, 0) dan (4, 0)', 1),
(406, 82, 'B. (1, 0) dan (-4, 0)', 0),
(407, 82, 'C. (1, 0) dan (-4, 0)', 0),
(408, 82, 'D. (-1, 0) dan (-4, 0)', 0),
(409, 83, 'A. Insulin', 0),
(410, 83, 'B. Vaksin', 0),
(411, 83, 'C. Tempe', 1),
(412, 83, 'D. Tanaman transgenik', 0),
(413, 84, 'A. Rp 110.000,00', 0),
(414, 84, 'B. Rp 115.000,00', 0),
(415, 84, 'C. Rp 130.000,00', 1),
(416, 84, 'D. Rp 135.000,00', 0),
(417, 85, 'A. Hening', 1),
(418, 85, 'B. Takut', 0),
(419, 85, 'C. Haru', 0),
(420, 85, 'D. Sedih', 0),
(421, 86, 'A. 2/36', 0),
(422, 86, 'B. 4/36', 0),
(423, 86, 'C. 5/36', 1),
(424, 86, 'D. 6/36', 0),
(425, 87, 'A. Aluvial', 0),
(426, 87, 'B. Humus', 1),
(427, 87, 'C. Laterit', 0),
(428, 87, 'D. Gambut', 0),
(429, 88, 'A. Nyata, terbalik, diperbesar', 0),
(430, 88, 'B. Nyata, tegak, diperbesar', 0),
(431, 88, 'C. Maya, tegak, diperbesar', 1),
(432, 88, 'D. Maya, terbalik, diperbesar', 0),
(433, 89, 'A. 3140 cm3', 0),
(434, 89, 'B. 628 cm3', 0),
(435, 89, 'C. 6280 cm3', 0),
(436, 89, 'D. 12560 cm3', 1),
(437, 90, 'A. Budi Utomo', 1),
(438, 90, 'B. Sarekat Islam', 0),
(439, 90, 'C. Indische Partij', 0),
(440, 90, 'D. Perhimpunan Indonesia', 0),
(441, 91, 'A. Masyarakat', 1),
(442, 91, 'B. Pemerintah', 0),
(443, 91, 'C. Korban bencana', 0),
(444, 91, 'D. Media massa', 0),
(445, 92, 'A. Resesif', 0),
(446, 92, 'B. Dominan', 1),
(447, 92, 'C. Genotipe', 0),
(448, 92, 'D. Fenotipe', 0),
(449, 93, 'A. 80', 0),
(450, 93, 'B. 85', 0),
(451, 93, 'C. 90', 1),
(452, 93, 'D. 95', 0),
(453, 94, 'A. Penipisan lapisan ozon', 0),
(454, 94, 'B. Efek rumah kaca', 1),
(455, 94, 'C. Hujan asam', 0),
(456, 94, 'D. Letusan gunung berapi', 0),
(457, 95, 'A. Gonosom', 1),
(458, 95, 'B. Autosom', 0),
(459, 95, 'C. Alel', 0),
(460, 95, 'D. Haploid', 0),
(461, 96, 'A. 5/8', 0),
(462, 96, 'B. 5/3', 0),
(463, 96, 'C. 3/8', 1),
(464, 96, 'D. 3/5', 0),
(465, 97, 'A. Ujian hidup seseorang', 1),
(466, 97, 'B. Kebahagiaan keluarga', 0),
(467, 97, 'C. Seseorang yang memiliki harta', 0),
(468, 97, 'D. Tanggung jawab atas wewenang', 0),
(469, 98, 'A. 880 volt', 0),
(470, 98, 'B. 220 volt', 0),
(471, 98, 'C. 55 volt', 1),
(472, 98, 'D. 27,5 volt', 0),
(473, 99, 'A. Padi dan jagung', 0),
(474, 99, 'B. Kopi, tebu, dan nila', 1),
(475, 99, 'C. Kelapa sawit dan karet', 0),
(476, 99, 'D. Cengkeh dan pala', 0),
(477, 100, 'A. 10 cm', 0),
(478, 100, 'B. 12 cm', 0),
(479, 100, 'C. 15 cm', 1),
(480, 100, 'D. 16 cm', 0),
(481, 101, 'A. 10 cm', 0),
(482, 101, 'B. 15 cm', 0),
(483, 101, 'C. 30 cm', 0),
(484, 101, 'D. 45 cm', 1),
(485, 102, 'A. Pertukaran budaya antarnegara', 0),
(486, 102, 'B. Perdagangan bebas dan pasar global', 1),
(487, 102, 'C. Peningkatan migrasi internasional', 0),
(488, 102, 'D. Penyebaran informasi melalui internet', 0),
(489, 103, 'A. 7', 0),
(490, 103, 'B. 8', 1),
(491, 103, 'C. 9', 0),
(492, 103, 'D. 10', 0),
(493, 104, 'A. Jika banjir Jakarta yang akan datang ternyata lebih besar, berarti itu menjadi kado terburuk pada awal tahun jabatan gubernur.', 1),
(494, 104, 'B. Perbaikan saluran air di permukiman kumuh belum sempat dilakukan.', 0),
(495, 104, 'C. Perbaikan saluran air terhambat administrasi anggaran.', 0),
(496, 104, 'D. Banjir Jakarta akan datang lebih besar dari tahun lalu.', 0),
(497, 105, 'A. 1,25 N', 0),
(498, 105, 'B. 9 N', 0),
(499, 105, 'C. 20 N', 1),
(500, 105, 'D. 25 N', 0),
(501, 106, 'A. (1) dan (2)', 1),
(502, 106, 'B. (1) dan (3)', 0),
(503, 106, 'C. (2) dan (4)', 0),
(504, 106, 'D. (3) dan (4)', 0),
(505, 107, 'A. 7', 0),
(506, 107, 'B. 7,5', 0),
(507, 107, 'C. 8', 1),
(508, 107, 'D. 8,5', 0),
(509, 108, 'A. Yoghurt dan keju', 0),
(510, 108, 'B. Tempe dan kecap', 0),
(511, 108, 'C. Insulin dan antibiotik', 1),
(512, 108, 'D. Tanaman tahan hama', 0),
(513, 109, 'A. Mengirim pasukan perdamaian', 0),
(514, 109, 'B. Membentuk Komisi Tiga Negara (KTN)', 1),
(515, 109, 'C. Memberikan bantuan ekonomi kepada Indonesia', 0),
(516, 109, 'D. Mengakui kemerdekaan Indonesia secara sepihak', 0),
(517, 110, 'A. Teks 1 membahas manfaat tidur, Teks 2 membahas penyebab kurang tidur.', 0),
(518, 110, 'B. Teks 1 membahas dampak positif tidur, Teks 2 membahas dampak negatif kurang tidur.', 1),
(519, 110, 'C. Teks 1 membahas penelitian tentang remaja, Teks 2 membahas kesehatan secara umum.', 0),
(520, 110, 'D. Teks 1 membahas daya ingat, Teks 2 membahas obesitas.', 0),
(521, 111, 'A. 1 Hz dan 10 cm', 0),
(522, 111, 'B. 1 Hz dan 5 cm', 1),
(523, 111, 'C. 2 Hz dan 10 cm', 0),
(524, 111, 'D. 2 Hz dan 5 cm', 0),
(525, 112, 'A. 1.100 cm²', 0),
(526, 112, 'B. 1.122 cm²', 0),
(527, 112, 'C. 1.144 cm²', 1),
(528, 112, 'D. 1.166 cm²', 0),
(529, 113, 'A. Pembangunan jalan tol yang memperlancar transportasi', 0),
(530, 113, 'B. Program vaksinasi massal untuk mencegah penyakit', 0),
(531, 113, 'C. Kemacetan lalu lintas akibat meningkatnya jumlah kendaraan pribadi', 1),
(532, 113, 'D. Penggunaan internet untuk pembelajaran jarak jauh', 0),
(533, 114, 'A. (1) dan (2)', 1),
(534, 114, 'B. (1) dan (3)', 0),
(535, 114, 'C. (2) dan (4)', 0),
(536, 114, 'D. (3) dan (4)', 0),
(537, 115, 'A. 40 meter', 0),
(538, 115, 'B. 60 meter', 0),
(539, 115, 'C. 70 meter', 1),
(540, 115, 'D. 80 meter', 0),
(541, 116, 'A. Hipermetropi', 0),
(542, 116, 'B. Miopi', 1),
(543, 116, 'C. Presbiopi', 0),
(544, 116, 'D. Astigmatisme', 0),
(545, 117, 'A. Orang pertama pelaku utama', 1),
(546, 117, 'B. Orang pertama pelaku sampingan', 0),
(547, 117, 'C. Orang ketiga serba tahu', 0),
(548, 117, 'D. Orang ketiga pengamat', 0),
(549, 118, 'A. Terbukanya lapangan kerja baru', 0),
(550, 118, 'B. Peningkatan pendapatan daerah', 0),
(551, 118, 'C. Pencemaran lingkungan', 1),
(552, 118, 'D. Tumbuhnya sektor ekonomi informal', 0),
(553, 119, 'A. 115 km', 0),
(554, 119, 'B. 125 km', 1),
(555, 119, 'C. 150 km', 0),
(556, 119, 'D. 175 km', 0),
(557, 120, 'A. Kloning', 0),
(558, 120, 'B. Hibridoma', 0),
(559, 120, 'C. Bioleaching', 1),
(560, 120, 'D. Fermentasi', 0),
(721, 121, '1', 0),
(722, 121, '2', 0),
(723, 121, '3', 1),
(724, 121, '4', 0),
(725, 122, 'Laporan', 0),
(726, 122, 'Deskripsi', 0),
(727, 122, 'Prosedur', 1),
(728, 122, 'Eksposisi', 0),
(729, 123, 'Ideologi negara', 0),
(730, 123, 'Jumlah penduduk', 0),
(731, 123, 'Sumber daya alam', 1),
(732, 123, 'Sistem pemerintahan', 0),
(733, 124, '0,25 A', 0),
(734, 124, '0,5 A', 0),
(735, 124, '1 A', 1),
(736, 124, '2 A', 0),
(737, 125, '8 cm', 0),
(738, 125, '9 cm', 0),
(739, 125, '10 cm', 1),
(740, 125, '12 cm', 0),
(741, 126, 'Asimilasi', 0),
(742, 126, 'Akulturasi', 1),
(743, 126, 'Akomodasi', 0),
(744, 126, 'Kerja sama', 0),
(745, 127, '1/9', 0),
(746, 127, '2/9', 1),
(747, 127, '1/5', 0),
(748, 127, '4/5', 0),
(749, 128, 'Penulisan judul novel', 1),
(750, 128, 'Penggunaan kata \"meresensi\"', 0),
(751, 128, 'Penggunaan kata \"dikumpulkan\"', 0),
(752, 128, 'Penulisan kata \"hari ini\"', 0),
(753, 129, 'Ikan kecil', 0),
(754, 129, 'Zooplankton', 0),
(755, 129, 'Fitoplankton', 1),
(756, 129, 'Bakteri pengurai', 0),
(757, 130, 'Edukasi, Urbanisasi, Modernisasi', 0),
(758, 130, 'Irigasi, Transmigrasi, Industrialisasi', 0),
(759, 130, 'Edukasi, Irigasi, Transmigrasi', 1),
(760, 130, 'Edukasi, Irigasi, Westernisasi', 0),
(761, 131, '-5/2', 0),
(762, 131, '5/2', 1),
(763, 131, '-3/2', 0),
(764, 131, '3/2', 0),
(765, 132, 'Pemantulan', 0),
(766, 132, 'Pembiasan', 1),
(767, 132, 'Difraksi', 0),
(768, 132, 'Interferensi', 0),
(769, 133, 'Diskriminasi rasial', 0),
(770, 133, 'Kemiskinan struktural', 0),
(771, 133, 'Tingkat pendidikan yang tinggi', 1),
(772, 133, 'Bencana alam', 0),
(773, 134, 'Masyarakat DKI sangat antusias menyambut permainan tersebut.', 0),
(774, 134, 'Permainan hanya dapat dilakukan di Balai Kota.', 0),
(775, 134, 'Tidak semua masyarakat setuju dengan ajakan tersebut.', 1),
(776, 134, 'Pemerintah DKI melarang masyarakat bermain gim.', 0),
(777, 135, '20 J', 0),
(778, 135, '100 J', 0),
(779, 135, '200 J', 1),
(780, 135, '220 J', 0),
(781, 136, '(-3, 5)', 0),
(782, 136, '(3, 5)', 0),
(783, 136, '(-3, -5)', 1),
(784, 136, '(5, -3)', 0),
(785, 137, 'Belanda mengakui kedaulatan RI atas seluruh wilayah Hindia Belanda', 0),
(786, 137, 'Belanda mengakui secara de facto wilayah RI meliputi Jawa, Sumatera, dan Madura', 1),
(787, 137, 'Akan dibentuk negara federal dengan nama Republik Indonesia Serikat', 0),
(788, 137, 'Akan diadakan pemungutan suara untuk menentukan nasib Papua', 0),
(789, 138, '0,67 s', 1),
(790, 138, '1,5 s', 0),
(791, 138, '2 s', 0),
(792, 138, '40 s', 0),
(793, 139, 'Prestasi kontingen Indonesia buruk karena urutan kelima.', 0),
(794, 139, 'Prestasi terburuk karena perolehan emas terendah.', 0),
(795, 139, 'Prestasi terburuk karena masalah dana, koordinasi, dan pembinaan.', 1),
(796, 139, 'Pembinaan atlet usia dini belum fokus.', 0),
(797, 140, '(5, 8)', 0),
(798, 140, '(6, 15)', 1),
(799, 140, '(-1, 2)', 0),
(800, 140, '(2/3, 5/3)', 0),
(881, 141, 'Populasi padi meningkat', 0),
(882, 141, 'Populasi elang meningkat', 0),
(883, 141, 'Populasi tikus meningkat', 1),
(884, 141, 'Populasi katak menurun', 0),
(885, 142, 'Teuku Abdul Jalil', 0),
(886, 142, 'K.H. Zaenal Mustafa', 1),
(887, 142, 'Supriyadi', 0),
(888, 142, 'K.H. Zaenal Mustafa', 0),
(889, 143, '1.386 cm³', 0),
(890, 143, '2.425,5 cm³', 0),
(891, 143, '4.851 cm³', 1),
(892, 143, '9.702 cm³', 0),
(893, 144, '1 bulat : 3 keriput', 0),
(894, 144, 'Semua bulat', 0),
(895, 144, '1 bulat : 1 keriput', 0),
(896, 144, '3 bulat : 1 keriput', 1),
(897, 145, 'Menggunakan kata \"sedang\"', 0),
(898, 145, 'Menggunakan bentuk kata jamak ganda', 1),
(899, 145, 'Tidak memiliki subjek yang jelas', 0),
(900, 145, 'Menggunakan kata \"dari\"', 0),
(901, 146, 'Dewan Perwakilan Rakyat (DPR)', 0),
(902, 146, 'Majelis Permusyawaratan Rakyat (MPR)', 0),
(903, 146, 'Badan Pemeriksa Keuangan (BPK)', 1),
(904, 146, 'Mahkamah Agung (MA)', 0),
(905, 147, '30 meter', 0),
(906, 147, '40 meter', 0),
(907, 147, '45 meter', 1),
(908, 147, '50 meter', 0),
(909, 148, 'Filtrasi', 0),
(910, 148, 'Kromatografi', 0),
(911, 148, 'Distilasi', 1),
(912, 148, 'Sublimasi', 0),
(913, 149, 'Selubung mielin', 1),
(914, 149, 'Dendrit', 0),
(915, 149, 'Badan sel', 0),
(916, 149, 'Akson', 0),
(917, 150, '0,5', 0),
(918, 150, '1,25', 1),
(919, 150, '2', 0),
(920, 150, '2,5', 0),
(921, 151, 'Memberikan kemerdekaan kepada Indonesia', 0),
(922, 151, 'Menarik simpati rakyat Indonesia agar membantu Jepang dalam Perang Pasifik', 1),
(923, 151, 'Mempersiapkan dasar negara Indonesia yang sesuai dengan keinginan Jepang', 0),
(924, 151, 'Melatih para pemuda Indonesia dalam bidang militer', 0),
(925, 152, 'Pendidikan karakter tidak perlu diajarkan di sekolah.', 0),
(926, 152, 'Semua guru pasti sudah kompeten dalam mengajarkan pendidikan karakter.', 0),
(927, 152, 'Perlu adanya sinergi antara pemerintah, sekolah, dan orang tua untuk mengatasi kendala implementasi pendidikan karakter.', 1),
(928, 152, 'Kurikulum adalah satu-satunya penyebab gagalnya pendidikan karakter.', 0),
(929, 153, 'Besi', 0),
(930, 153, 'Aluminium', 0),
(931, 153, 'Oksigen', 1),
(932, 153, 'Silikon', 0),
(933, 154, 'a + 2b', 0),
(934, 154, '2a + b', 1),
(935, 154, 'a² + b', 0),
(936, 154, '2ab', 0),
(937, 155, 'Tingkat pertumbuhan penduduk yang tinggi', 0),
(938, 155, 'Sebagian besar penduduk bekerja di sektor agraris', 0),
(939, 155, 'Tingkat pendapatan per kapita yang tinggi', 1),
(940, 155, 'Ketergantungan yang tinggi pada impor teknologi', 0),
(941, 156, '2 detik', 0),
(942, 156, '5 detik', 1),
(943, 156, '10 detik', 0),
(944, 156, '20 detik', 0),
(945, 157, '3 cm', 0),
(946, 157, '4 cm', 0),
(947, 157, '6 cm', 1),
(948, 157, '9 cm', 0),
(949, 158, 'Ucapan terima kasih kepada hadirin', 0),
(950, 158, 'Permohonan maaf atas kesalahan', 0),
(951, 158, 'Ajakan untuk peduli terhadap lingkungan', 1),
(952, 158, 'Penjelasan tentang dampak sampah', 0),
(953, 159, 'Golongan tua dan pihak Jepang mengenai waktu proklamasi', 0),
(954, 159, 'Golongan muda dan golongan tua mengenai waktu proklamasi kemerdekaan', 1),
(955, 159, 'Soekarno dan Hatta mengenai isi teks proklamasi', 0),
(956, 159, 'Sutan Sjahrir dan golongan muda mengenai cara memproklamasikan kemerdekaan', 0),
(957, 160, '48', 0),
(958, 160, '64', 0),
(959, 160, '96', 1),
(960, 160, '128', 0),
(961, 161, '18 meter', 0),
(962, 161, '24 meter', 1),
(963, 161, '30 meter', 0),
(964, 161, '36 meter', 0),
(965, 162, '1 : 1', 0),
(966, 162, '1 : 2', 0),
(967, 162, '2 : 1', 1),
(968, 162, '4 : 1', 0),
(969, 163, 'Sah dan benar', 1),
(970, 163, 'Sah, tetapi kesimpulannya salah', 0),
(971, 163, 'Tidak sah karena premis khususnya salah', 0),
(972, 163, 'Tidak sah karena kesimpulannya tidak mengikuti premis', 0),
(973, 164, 'Kekurangan tenaga kerja produktif', 0),
(974, 164, 'Tingginya angka ketergantungan (dependency ratio) usia tua', 0),
(975, 164, 'Ledakan angkatan kerja yang tidak terserap lapangan kerja', 1),
(976, 164, 'Menurunnya angka kelahiran secara drastis', 0),
(977, 165, '6,25%', 0),
(978, 165, '18,75%', 1),
(979, 165, '37,5%', 0),
(980, 165, '56,25%', 0),
(981, 166, 'a(1+b)/(1+a)', 1),
(982, 166, 'b(1+a)/(1+b)', 0),
(983, 166, '(ab+1)/(a+1)', 0),
(984, 166, 'ab + a', 0),
(985, 167, 'Menentukan inflasi tinggi', 0),
(986, 167, 'Mengurangi jumlah uang yang beredar untuk menekan inflasi tinggi', 1),
(987, 167, 'Membayar utang luar negeri hasil dari Konferensi Meja Bundar', 0),
(988, 167, 'Memberikan kredit usaha kepada pengusaha pribumi (Program Benteng)', 0),
(989, 168, 'Sesuatu yang tinggi dan tak terjangkau', 0),
(990, 168, 'Ketidakpastian dalam sebuah hubungan', 0),
(991, 168, 'Ketulusan dalam memberi tanpa mengharap balasan', 1),
(992, 168, 'Kesedihan dan kemurungan yang mendalam', 0),
(993, 169, '1, 3, 3, 4', 0),
(994, 169, '1, 5, 3, 4', 1),
(995, 169, '2, 7, 6, 8', 0),
(996, 169, '2, 10, 6, 8', 0),
(997, 170, '85', 0),
(998, 170, '90', 0),
(999, 170, '95', 1),
(1000, 170, '100', 0),
(1001, 171, 'Menciptakan mata uang tunggal untuk seluruh Asia Tenggara', 0),
(1002, 171, 'Menjadikan ASEAN sebagai pasar tunggal dan basis produksi', 1),
(1003, 171, 'Membentuk pakta pertahanan militer bersama', 0),
(1004, 171, 'Menyeragamkan sistem pendidikan di semua negara anggota', 0),
(1005, 172, 'Hipertonik (misalnya larutan garam pekat)', 1),
(1006, 172, 'Hipotonik (misalnya akuades)', 0),
(1007, 172, 'Isotonik (misalnya larutan garam fisiologis 0,9%)', 0),
(1008, 172, 'Netral (pH 7)', 0),
(1009, 173, 'Pesimistis terhadap kemajuan teknologi', 0),
(1010, 173, 'Objektif dan netral dalam memandang masalah', 0),
(1011, 173, 'Mendukung efisiensi teknologi dan cenderung mengabaikan sisi humanis', 1),
(1012, 173, 'Menolak perubahan dan mendukung pelestarian tenaga kerja manusia', 0),
(1013, 174, '8 cm', 0),
(1014, 174, '12 cm', 0),
(1015, 174, '15 cm', 1),
(1016, 174, '16 cm', 0),
(1017, 175, 'Nyata, terbalik, diperbesar', 0),
(1018, 175, 'Nyata, tegak, diperkecil', 0),
(1019, 175, 'Maya, terbalik, diperbesar', 0),
(1020, 175, 'Maya, tegak, diperkecil', 1),
(1021, 176, 'Ekonomi', 0),
(1022, 176, 'Politik', 0),
(1023, 176, 'Sosial-Budaya', 1),
(1024, 176, 'Pertahanan dan Keamanan', 0),
(1025, 177, '5/14', 1),
(1026, 177, '25/64', 0),
(1027, 177, '5/8', 0),
(1028, 177, '3/28', 0),
(1029, 178, 'Hibridoma (fusi sel)', 0),
(1030, 178, 'Kloning transfer inti', 0),
(1031, 178, 'Kultur jaringan', 0),
(1032, 178, 'Rekayasa genetika (DNA rekombinan)', 1),
(1033, 179, 'Penggunaan kata \"sangat\" yang berlebihan', 0),
(1034, 179, 'Ketidakjelasan subjek kalimat', 0),
(1035, 179, 'Ketidakjelasan frasa \"yang baru\" (apakah \"istri\" atau \"lurah\"-nya)', 1),
(1036, 179, 'Penggunaan kata \"itu\" yang tidak perlu', 0),
(1037, 180, 'Membentuk aliansi militer baru untuk menandingi NATO dan Pakta Warsawa', 0),
(1038, 180, 'Meredakan ketegangan antara Blok Barat (Amerika Serikat) dan Blok Timur (Uni Soviet)', 1),
(1039, 180, 'Memperoleh bantuan ekonomi dari kedua blok yang berseteru', 0),
(1040, 180, 'Menjadi penengah dalam konflik internal negara-negara Asia Afrika', 0),
(1041, 181, 'A. $\\frac{2}{3} V$', 0),
(1042, 181, 'B. $\\frac{4}{3} V$', 0),
(1043, 181, 'C. $2 V$', 1),
(1044, 181, 'D. $4 V$', 0),
(1045, 182, 'A. A > C > B', 0),
(1046, 182, 'B. C > A > B', 1),
(1047, 182, 'C. B > A > C', 0),
(1048, 182, 'D. C > B > A', 0),
(1049, 183, 'A. Tanam Paksa berfokus pada kesejahteraan pribumi, Politik Pintu Terbuka berfokus pada keuntungan Belanda.', 0),
(1050, 183, 'B. Tanam Paksa dikelola oleh negara (pemerintah kolonial), Politik Pintu Terbuka memberi peran besar bagi swasta (investor asing).', 1),
(1051, 183, 'C. Tanam Paksa hanya menanam kopi, Politik Pintu Terbuka menanam semua komoditas.', 0),
(1052, 183, 'D. Tanam Paksa didukung oleh Raja Belanda, Politik Pintu Terbuka ditentang oleh Raja Belanda.', 0),
(1053, 184, 'A. Straw Man (Orang-orangan Sawah)', 0),
(1054, 184, 'B. Hasty Generalization (Generalisasi Terburu-buru)', 0),
(1055, 184, 'C. Ad Hominem', 1),
(1056, 184, 'D. Slippery Slope (Lereng Licin)', 0),
(1057, 185, 'A. $x \\le -5$ atau $x \\ge 2$', 0),
(1058, 185, 'B. $x < -5$ atau $x \\ge 2$', 1),
(1059, 185, 'C. $-5 \\le x \\le 2$', 0),
(1060, 185, 'D. $-5 < x \\le 2$', 0),
(1061, 186, 'A. 0,5 A', 1),
(1062, 186, 'B. 2 A', 0),
(1063, 186, 'C. 4 A', 0),
(1064, 186, 'D. 8 A', 0),
(1065, 187, 'A. Jumlah uang beredar meningkat dan inflasi naik', 0),
(1066, 187, 'B. Jumlah uang beredar berkurang dan inflasi turun', 1),
(1067, 187, 'C. Harga barang-barang menjadi lebih murah', 0),
(1068, 187, 'D. Minat masyarakat untuk mengambil kredit meningkat', 0),
(1069, 188, 'A. 7', 0),
(1070, 188, 'B. 9', 0),
(1071, 188, 'C. 11', 1),
(1072, 188, 'D. 13', 0),
(1073, 189, 'A. Anak kalimat (sebab) - Induk kalimat - Anak kalimat (akibat)', 1),
(1074, 189, 'B. Induk kalimat - Anak kalimat (sebab) - Anak kalimat (akibat)', 0),
(1075, 189, 'C. Anak kalimat (akibat) - Induk kalimat - Anak kalimat (sebab)', 0),
(1076, 189, 'D. Induk kalimat - Anak kalimat (perluasan)', 0),
(1077, 190, 'A. 8 gram', 1),
(1078, 190, 'B. 12 gram', 0),
(1079, 190, 'C. 20 gram', 0),
(1080, 190, 'D. 32 gram', 0),
(1081, 191, 'A. Zona divergensi', 0),
(1082, 191, 'B. Mid-oceanic ridge (Punggungan tengah samudra)', 0),
(1083, 191, 'C. Jalur Cincin Api (Ring of Fire) / Busur vulkanik', 1),
(1084, 191, 'D. Hotspot (Titik panas)', 0),
(1085, 192, 'A. 82', 0),
(1086, 192, 'B. 84', 0),
(1087, 192, 'C. 86', 1),
(1088, 192, 'D. 88', 0),
(1089, 193, 'A. Populasi rumput meningkat drastis', 0),
(1090, 193, 'B. Populasi singa menurun karena kekurangan makanan', 1),
(1091, 193, 'C. Populasi wildebeest (herbivora lain) menurun karena kompetisi dengan zebra berkurang', 0),
(1092, 193, 'D. Populasi wildebeest (herbivora lain) menurun karena menjadi target utama perburuan singa', 0),
(1093, 194, 'A. Semua pejabat dihukum berat.', 0),
(1094, 194, 'B. Sebagian pejabat dihukum berat.', 1),
(1095, 194, 'C. Tidak ada pejabat yang dihukum berat.', 0),
(1096, 194, 'D. Sebagian koruptor adalah pejabat.', 0),
(1097, 195, 'A. Intervensi militer yang terlalu kuat dalam pemerintahan', 0),
(1098, 195, 'B. Adanya sistem multipartai yang sangat banyak sehingga sulit membangun koalisi yang stabil', 1),
(1099, 195, 'C. Terlalu kuatnya kekuasaan Presiden Soekarno dalam membubarkan kabinet', 0),
(1100, 195, 'D. Sering terjadinya pemberontakan daerah (PRRI/Permesta)', 0),
(1101, 196, 'A. 8.000 kalori', 0),
(1102, 196, 'B. 8.500 kalori', 0),
(1103, 196, 'C. 16.000 kalori', 1),
(1104, 196, 'D. 16.500 kalori', 0),
(1105, 197, 'A. 2 meter', 0),
(1106, 197, 'B. 3 meter', 1),
(1107, 197, 'C. 4 meter', 0),
(1108, 197, 'D. 6 meter', 0),
(1109, 198, 'A. Masuknya tenaga kerja asing secara ilegal', 0),
(1110, 198, 'B. Meningkatnya harga barang impor sehingga terjadi inflasi', 0),
(1111, 198, 'C. Industri lokal kalah bersaing dengan produk impor yang lebih murah', 1),
(1112, 198, 'D. Terkurasnya cadangan devisa negara untuk membeli barang impor', 0),
(1113, 199, 'A. Menghasilkan oksigen dan glukosa untuk sel', 0),
(1114, 199, 'B. Memecah karbohidrat kompleks menjadi glukosa', 0),
(1115, 199, 'C. Mengubah energi kimia dalam glukosa menjadi energi siap pakai (ATP)', 1),
(1116, 199, 'D. Mendinginkan sel agar tidak terjadi overheating', 0),
(1117, 200, 'A. Dimasak hingga matang', 0),
(1118, 200, 'B. Dibahas dan dimatangkan secara mendalam', 1),
(1119, 200, 'C. Dibatalkan secara sepihak', 0),
(1120, 200, 'D. Disimpan dalam arsip', 0),
(1121, 201, 'A. 2 jam', 0),
(1122, 201, 'B. 2 jam 30 menit', 0),
(1123, 201, 'C. 2 jam 45 menit', 1),
(1124, 201, 'D. 3 jam', 0),
(1125, 202, 'A. 25 gram, karena terjadi osmosis (air masuk ke kentang)', 0),
(1126, 202, 'B. 15 gram, karena terjadi osmosis (air keluar dari kentang)', 1),
(1127, 202, 'C. 20 gram, karena larutan bersifat isotonik', 0),
(1128, 202, 'D. 15 gram, karena terjadi difusi (gula masuk ke kentang)', 0),
(1129, 203, 'A. Deflasi', 0),
(1130, 203, 'B. Resesi', 0),
(1131, 203, 'C. Stagflasi', 0),
(1132, 203, 'D. Hiperinflasi', 1),
(1133, 204, 'A. membawakan', 1),
(1134, 204, 'B. tinggal di desa sebelah utara itu', 0),
(1135, 204, 'C. membawakan kami oleh-oleh durian Musang King', 0),
(1136, 204, 'D. paman yang tinggal di desa sebelah utara itu', 0),
(1137, 205, 'A. 16', 0),
(1138, 205, 'B. 17', 0),
(1139, 205, 'C. 18', 1),
(1140, 205, 'D. 19', 0),
(1141, 206, 'A. 0%', 0),
(1142, 206, 'B. 25%', 1),
(1143, 206, 'C. 50%', 0),
(1144, 206, 'D. 75%', 0),
(1145, 207, 'A. Keinginan mengganti ideologi Pancasila dengan ideologi komunis', 0),
(1146, 207, 'B. Penolakan terhadap hasil Konferensi Meja Bundar (KMB)', 0),
(1147, 207, 'C. Kekecewaan daerah terhadap alokasi dana dan ketimpangan pembangunan oleh pemerintah pusat', 1),
(1148, 207, 'D. Pengaruh Blok Barat yang ingin menguasai sumber daya alam di daerah', 0),
(1149, 208, 'A. Ironi', 0),
(1150, 208, 'B. Metafora', 0),
(1151, 208, 'C. Hiperbola', 1),
(1152, 208, 'D. Personifikasi', 0),
(1153, 209, 'A. 154 cm$^2$', 0),
(1154, 209, 'B. 169 cm$^2$', 0),
(1155, 209, 'C. 196 cm$^2$', 1),
(1156, 209, 'D. 225 cm$^2$', 0),
(1157, 210, 'A. 2 A', 0),
(1158, 210, 'B. 2,5 A', 1),
(1159, 210, 'C. 3 A', 0),
(1160, 210, 'D. 5 A', 0),
(1161, 211, 'A. Meningkatnya kualitas sekolah di daerah pinggiran secara instan', 0),
(1162, 211, 'B. Timbulnya praktik manipulasi data kependudukan (KK) agar dekat dengan sekolah favorit', 1),
(1163, 211, 'C. Menurunnya angka putus sekolah karena biaya transportasi berkurang', 0),
(1164, 211, 'D. Persaingan antar siswa menjadi lebih sehat dan sportif', 0),
(1165, 212, 'A. Rp 400.000', 0),
(1166, 212, 'B. Rp 420.000', 1),
(1167, 212, 'C. Rp 440.000', 0),
(1168, 212, 'D. Rp 460.000', 0),
(1169, 213, 'A. Menggunakan kata \"masalah\" yang tidak perlu', 1),
(1170, 213, 'B. Kesalahan penulisan kata \"UMR\"', 0),
(1171, 213, 'C. Menggunakan kata \"itu\" yang tidak jelas', 0),
(1172, 213, 'D. Kerancuan makna (pleonasme) pada kata \"membahas\" dan \"tentang\"', 0),
(1173, 214, 'A. Lidah tidak dapat berfungsi saat suhu tubuh tinggi (demam)', 0),
(1174, 214, 'B. Indera pengecap (rasa) sangat dipengaruhi oleh indera pembau (penciuman) yang terganggu oleh lendir', 1),
(1175, 214, 'C. Virus flu merusak papila-papila pada permukaan lidah', 0),
(1176, 214, 'D. Hidung tersumbat menghalangi makanan masuk ke kerongkongan', 0),
(1177, 215, 'A. Membangun benteng di setiap pelabuhan dagang', 0),
(1178, 215, 'B. Melakukan pelayaran Hongi untuk mengawasi perdagangan rempah-rempah', 0),
(1179, 215, 'C. Mendukung salah satu pangeran dalam konflik suksesi (perebutan takhta) di sebuah kerajaan', 1),
(1180, 215, 'D. Menerapkan sistem tanam paksa kepada rakyat', 0),
(1181, 216, 'A. 9', 0),
(1182, 216, 'B. 12', 1),
(1183, 216, 'C. 15', 0),
(1184, 216, 'D. 21', 0),
(1185, 217, 'A. Melepaskan 3 elektron (membentuk ion X$^{3+}$)', 1),
(1186, 217, 'B. Menangkap 1 elektron (membentuk ion X$^{-}$)', 0),
(1187, 217, 'C. Melepaskan 1 elektron (membentuk ion X$^{+}$)', 0),
(1188, 217, 'D. Menangkap 5 elektron (membentuk ion X$^{5-}$)', 0),
(1189, 218, 'A. Verba aktif transitif', 0),
(1190, 218, 'B. Verba pasif dan verba aktif intransitif', 1),
(1191, 218, 'C. Hanya verba aktif', 0),
(1192, 218, 'D. Hanya verba pasif', 0),
(1193, 219, 'A. Cost-push inflation (kenaikan biaya produksi)', 0),
(1194, 219, 'B. Demand-pull inflation (lonjakan permintaan masyarakat secara drastis)', 1),
(1195, 219, 'C. Penimbunan barang (kartel) oleh semua pedagang', 0),
(1196, 219, 'D. Kegagalan panen serentak di seluruh negeri', 0),
(1197, 220, 'A. $\\frac{1}{3}$', 0),
(1198, 220, 'B. $\\frac{1}{2}$', 0),
(1199, 220, 'C. $\\frac{12}{30}$', 1),
(1200, 220, 'D. $\\frac{36}{100}$', 0),
(1201, 221, 'A. 40 meter', 0),
(1202, 221, 'B. 50 meter', 0),
(1203, 221, 'C. 60 meter', 1),
(1204, 221, 'D. 70 meter', 0),
(1205, 222, 'A. 20 Joule', 0),
(1206, 222, 'B. 40 Joule', 1),
(1207, 222, 'C. 160 Joule', 0),
(1208, 222, 'D. 200 Joule', 0),
(1209, 223, 'A. Pembubaran Partai Komunis Indonesia (PKI) dan ormas-ormasnya', 1),
(1210, 223, 'B. Pengembalian UUD 1945 secara murni dan konsekuen', 0),
(1211, 223, 'C. Nasionalisasi seluruh perusahaan asing di Indonesia', 0),
(1212, 223, 'D. Pembentukan kabinet baru yang netral secara politik', 0),
(1213, 224, 'A. Mengagumi', 0),
(1214, 224, 'B. Objektif', 0),
(1215, 224, 'C. Skeptis (Meragukan)', 1),
(1216, 224, 'D. Simpati', 0),
(1217, 225, 'A. 15/64', 0),
(1218, 225, 'B. 15/56', 1),
(1219, 225, 'C. 8/56', 0),
(1220, 225, 'D. 25/64', 0),
(1221, 226, 'A. Berkurang, karena air tawar lebih \"ringan\"', 0),
(1222, 226, 'B. Bertambah (kapal sedikit tenggelam), untuk memindahkan volume air tawar yang lebih besar', 1),
(1223, 226, 'C. Tetap, karena berat kapal tidak berubah', 0),
(1224, 226, 'D. Tetap, karena gaya apung tidak tergantung massa jenis cairan', 0),
(1225, 227, 'A. Gagal total meningkatkan produksi padi', 0),
(1226, 227, 'B. Menyebabkan petani terlalu mandiri dan tidak patuh pada pemerintah', 0),
(1227, 227, 'C. Cenderung menguntungkan petani kaya (pemilik lahan luas) dan membuat petani kecil (buruh tani) semakin terpinggirkan', 1),
(1228, 227, 'D. Menggunakan teknologi yang terlalu tradisional', 0),
(1229, 228, 'A. -1', 0),
(1230, 228, 'B. 3', 0),
(1231, 228, 'C. 4', 1),
(1232, 228, 'D. 8', 0),
(1233, 229, 'A. Suhu oven terlalu panas', 0),
(1234, 229, 'B. Adonan terlalu lama didiamkan', 0),
(1235, 229, 'C. Ragi tidak aktif atau mati karena bertemu garam', 1),
(1236, 229, 'D. Adonan kurang kalis', 0),
(1237, 230, 'A. 50%', 0),
(1238, 230, 'B. 25%', 0),
(1239, 230, 'C. 18,75%', 0),
(1240, 230, 'D. 12,5%', 1),
(1241, 231, 'A. Terjadinya pemberontakan G30S/PKI', 0),
(1242, 231, 'B. Desakan dari PBB untuk menstabilkan negara', 0),
(1243, 231, 'C. Kegagalan Dewan Konstituante dalam menetapkan UUD baru setelah bertahun-tahun bersidang', 1),
(1244, 231, 'D. Kemenangan Indonesia dalam pembebasan Irian Barat', 0),
(1245, 232, 'A. 36', 0),
(1246, 232, 'B. 45', 0),
(1247, 232, 'C. 54', 1),
(1248, 232, 'D. 63', 0),
(1249, 233, 'A. Larutan garam dapur (netral)', 0),
(1250, 233, 'B. Larutan cuka (asam)', 1),
(1251, 233, 'C. Larutan sabun (basa)', 0),
(1252, 233, 'D. Akuades (netral)', 0),
(1253, 234, 'A. analisa, sistim, komplek', 0),
(1254, 234, 'B. analisis, sistem, kompleks', 1),
(1255, 234, 'C. analisis, sistim, komplek', 0),
(1256, 234, 'D. analisa, sistem, kompleks', 0),
(1257, 235, 'A. Tiongkok mengklaim wilayah tersebut sebagai laut teritorialnya', 0),
(1258, 235, 'B. Adanya sengketa batas darat antara Indonesia dan Tiongkok', 0),
(1259, 235, 'C. Klaim \"Nine-Dash Line\" (Sembilan Garis Putus-putus) Tiongkok tumpang tindih dengan Zona Ekonomi Eksklusif (ZEE) Indonesia', 1),
(1260, 235, 'D. Indonesia melarang kapal dagang Tiongkok melintas', 0),
(1261, 236, 'A. 1 : 1', 0),
(1262, 236, 'B. 1 : 2', 1),
(1263, 236, 'C. 2 : 1', 0),
(1264, 236, 'D. 4 : 1', 0),
(1265, 237, 'A. Fotosintesis terjadi pada hewan, Respirasi pada tumbuhan', 0),
(1266, 237, 'B. Fotosintesis adalah proses menyimpan energi (anabolisme), Respirasi adalah proses melepaskan energi (katabolisme)', 1),
(1267, 237, 'C. Fotosintesis membutuhkan Oksigen, Respirasi membutuhkan Karbon Dioksida', 0),
(1268, 237, 'D. Fotosintesis menghasilkan ATP, Respirasi menghasilkan Glukosa', 0),
(1269, 238, 'A. y = -3x + 11', 1),
(1270, 238, 'B. y = 3x - 1', 0),
(1271, 238, 'C. y = -1/3x + 17/3', 0),
(1272, 238, 'D. y = 1/3x + 13/3', 0),
(1273, 239, 'A. Budi setuju bahwa filmnya bagus', 0),
(1274, 239, 'B. Budi ingin menunjukkan bahwa dirinya lebih kritis atau jeli daripada Andi', 1),
(1275, 239, 'C. Budi tidak menonton filmnya sampai selesai', 0),
(1276, 239, 'D. Budi tidak mengerti jalan cerita film tersebut', 0),
(1277, 240, 'A. Mendekat pada Blok Timur (Komunis), yang terlihat dari poros Jakarta-Peking', 1),
(1278, 240, 'B. Mendekat pada Blok Barat (Kapitalis), yang terlihat dari bantuan ekonomi AS', 0),
(1279, 240, 'C. Benar-benar netral dan tidak memihak siapa pun', 0),
(1280, 240, 'D. Menutup diri dari semua hubungan internasional (Isolasionisme)', 0),
(1921, 241, 'A. 20π cm^2', 0),
(1922, 241, 'B. 25π cm^2', 1),
(1923, 241, 'C. 30π cm^2', 0),
(1924, 241, 'D. 50π cm^2', 0),
(1925, 242, 'A. 1.500 kg/m^3', 0),
(1926, 242, 'B. 2.000 kg/m^3', 1),
(1927, 242, 'C. 2.500 kg/m^3', 0),
(1928, 242, 'D. 3.000 kg/m^3', 0),
(1929, 243, 'A. Menguatnya sistem multipartai dalam demokrasi parlementer', 0),
(1930, 243, 'B. Terkonsentrasinya kekuasaan di tangan Presiden (eksekutif)', 1),
(1931, 243, 'C. Keberhasilan partai-partai agama dalam memperjuangkan Piagam Jakarta', 0),
(1932, 243, 'D. Melemahnya peran militer dalam kancah perpolitikan nasional', 0),
(1933, 244, 'A. Mengkritik keras para influencer yang melakukan flexing', 0),
(1934, 244, 'B. Membela para influencer sebagai sumber motivasi kesuksesan', 0),
(1935, 244, 'C. Menjelaskan dampak negatif flexing secara rinci bagi masyarakat', 0),
(1936, 244, 'D. Menampilkan dua sisi perdebatan dan mengembalikan penilaian kepada pembaca', 1),
(1937, 245, 'A. 48/343', 0),
(1938, 245, 'B. 64/343', 0),
(1939, 245, 'C. 144/343', 1),
(1940, 245, 'D. 192/343', 0),
(1941, 246, 'A. Jarak tanaman dari sumber cahaya', 0),
(1942, 246, 'B. Jumlah gelembung O2 yang dihasilkan', 1),
(1943, 246, 'C. Jenis tanaman Hydrilla yang digunakan', 0),
(1944, 246, 'D. Suhu air dalam tabung reaksi', 0),
(1945, 247, 'A. Inflasi adalah masalah moneter (nilai uang menurun), kelangkaan adalah masalah fundamental ekonomi (kebutuhan tak terbatas vs alat pemuas terbatas)', 1),
(1946, 247, 'B. Inflasi disebabkan oleh permintaan tinggi, kelangkaan disebabkan oleh penawaran rendah', 0),
(1947, 247, 'C. Inflasi hanya terjadi di negara maju, kelangkaan hanya di negara berkembang', 0),
(1948, 247, 'D. Inflasi selalu merugikan konsumen, kelangkaan selalu menguntungkan produsen', 0),
(1949, 248, 'A. Tidak jelas lokasi penembakannya', 0),
(1950, 248, 'B. Tidak jelas apakah pencuri itu tewas atau tidak', 0),
(1951, 248, 'C. Tidak jelas apakah pistol adalah alat untuk menembak, atau pencuri itu sedang memegang pistol saat ditembak', 1),
(1952, 248, 'D. Tidak jelas siapa pemilik pistol tersebut', 0),
(1953, 249, 'A. 2 detik', 1),
(1954, 249, 'B. 4 detik', 0),
(1955, 249, 'C. 6 detik', 0),
(1956, 249, 'D. 8 detik', 0),
(1957, 250, 'A. 1,12 Liter', 0),
(1958, 250, 'B. 2,24 Liter', 1),
(1959, 250, 'C. 4,48 Liter', 0),
(1960, 250, 'D. 11,2 Liter', 0),
(1961, 251, 'A. Jepang merupakan negara kepulauan yang dikelilingi lautan dalam', 0),
(1962, 251, 'B. Iklim subtropis di Jepang menyebabkan pelapukan batuan yang cepat', 0),
(1963, 251, 'C. Posisi Jepang yang terletak pada pertemuan tiga lempeng tektonik besar (Pasifik, Eurasia, dan Filipina)', 1),
(1964, 251, 'D. Aktivitas vulkanik bawah laut yang masif akibat pemanasan global', 0),
(1965, 252, 'A. 770 kursi', 1),
(1966, 252, 'B. 820 kursi', 0),
(1967, 252, 'C. 870 kursi', 0),
(1968, 252, 'D. 900 kursi', 0),
(1969, 253, 'A. Ketika pandemi melanda', 0),
(1970, 253, 'B. para siswa yang biasanya belajar di sekolah', 0),
(1971, 253, 'C. para siswa terpaksa mengikuti pembelajaran jarak jauh dari rumah', 1),
(1972, 253, 'D. yang biasanya belajar di sekolah', 0),
(1973, 254, 'A. 75 Watt', 1),
(1974, 254, 'B. 150 Watt', 0),
(1975, 254, 'C. 300 Watt', 0),
(1976, 254, 'D. 600 Watt', 0),
(1977, 255, 'A. Penerapan Dwi Fungsi ABRI', 0),
(1978, 255, 'B. Fusi (penggabungan) partai-partai politik menjadi tiga kekuatan (PDI, PPP, Golkar)', 1),
(1979, 255, 'C. Pelaksanaan Pemilu setiap lima tahun sekali secara konsisten', 0),
(1980, 255, 'D. Pembentukan Kabinet Pembangunan', 0),
(1981, 256, 'A. 1 : 2', 0),
(1982, 256, 'B. 3 : 4', 0),
(1983, 256, 'C. 2 : 3', 0),
(1984, 256, 'D. 3 : 8', 1),
(1985, 257, 'A. 0%', 0),
(1986, 257, 'B. 25%', 0),
(1987, 257, 'C. 50%', 1),
(1988, 257, 'D. 75%', 0),
(1989, 258, 'A. Premis umumnya (kalimat 1) salah, tidak semua atlet berlatih keras', 0),
(1990, 258, 'B. Premis khususnya (kalimat 2) tidak relevan dengan kesimpulan', 0),
(1991, 258, 'C. Kesimpulannya tidak sah, karena berlatih keras bukan hanya milik atlet profesional', 1),
(1992, 258, 'D. Kesimpulannya bersifat negatif, padahal premisnya positif', 0),
(1993, 259, 'A. Negara A fokus pada mobil, Negara B fokus pada beras', 1),
(1994, 259, 'B. Negara A fokus pada beras, Negara B fokus pada mobil', 0),
(1995, 259, 'C. Kedua negara hanya memproduksi mobil', 0),
(1996, 259, 'D. Kedua negara tidak melakukan perdagangan karena Negara B lebih unggul', 0),
(1997, 260, 'A. -0,5 Dioptri', 1),
(1998, 260, 'B. +0,5 Dioptri', 0),
(1999, 260, 'C. -2 Dioptri', 0),
(2000, 260, 'D. +2 Dioptri', 0),
(2001, 261, 'A. 1 : 2', 0),
(2002, 261, 'B. 1 : 3', 1),
(2003, 261, 'C. 2 : 3', 0),
(2004, 261, 'D. 1 : 4', 0),
(2005, 262, 'A. Padi', 0),
(2006, 262, 'B. Serangga', 0),
(2007, 262, 'C. Ular', 0),
(2008, 262, 'D. Elang', 1),
(2009, 263, 'A. Kegagalan total Program Benteng yang bertujuan menumbuhkan wirausaha pribumi', 0),
(2010, 263, 'B. Defisit anggaran yang terus-menerus dan tingkat inflasi yang tinggi akibat ketidakstabilan politik', 1),
(2011, 263, 'C. Nasionalisasi De Javasche Bank menjadi Bank Indonesia', 0),
(2012, 263, 'D. Keberhasilan program Tanam Paksa yang dilanjutkan', 0),
(2013, 264, 'A. Melaporkan berita kenaikan BBM secara objektif', 0),
(2014, 264, 'B. Menganalisis dampak ekonomi kenaikan BBM', 0),
(2015, 264, 'C. Membangun opini publik untuk menentang kebijakan tersebut', 1),
(2016, 264, 'D. Mengusulkan solusi alternatif pengganti BBM', 0),
(2017, 265, 'A. 50 tahun', 0),
(2018, 265, 'B. 60 tahun', 1),
(2019, 265, 'C. 70 tahun', 0),
(2020, 265, 'D. 80 tahun', 0),
(2021, 266, 'A. 6 menit', 0),
(2022, 266, 'B. 8 menit', 1),
(2023, 266, 'C. 10 menit', 0),
(2024, 266, 'D. 12 menit', 0),
(2025, 267, 'A. Proses transmigrasi dari Jawa ke luar Jawa', 0),
(2026, 267, 'B. Angka kelahiran yang tinggi di pusat kota', 0),
(2027, 267, 'C. Tingkat urbanisasi yang tinggi tanpa diimbangi ketersediaan lapangan kerja dan perumahan yang layak', 1),
(2028, 267, 'D. Kebijakan tata ruang kota yang salah sejak awal', 0),
(2029, 268, 'A. Menyerang karakter pribadi orang yang tidak setuju', 0),
(2030, 268, 'B. Menggunakan popularitas untuk membenarkan argumen', 0),
(2031, 268, 'C. Menganggap sesuatu pasti benar karena sudah terjadi di masa lalu', 0),
(2032, 268, 'D. Menyajikan hanya dua pilihan ekstrem (False Dilemma), padahal ada banyak pilihan lain di antaranya', 1),
(2033, 269, 'A. 2/3', 1),
(2034, 269, 'B. 1/3', 0),
(2035, 269, 'C. 15/22', 0),
(2036, 269, 'D. 7/15', 0),
(2037, 270, 'A. Mulut (oleh enzim ptialin/amilase)', 0),
(2038, 270, 'B. Lambung (oleh enzim pepsin)', 1),
(2039, 270, 'C. Usus halus (oleh enzim tripsin)', 0),
(2040, 270, 'D. Hati (oleh cairan empedu)', 0),
(2041, 271, 'A. Keinginan untuk membentuk pakta militer tandingan NATO dan Pakta Warsawa', 0),
(2042, 271, 'B. Keinginan bersama untuk menciptakan stabilitas kawasan dan kerja sama ekonomi di tengah situasi Perang Dingin', 1),
(2043, 271, 'C. Respon langsung terhadap berdirinya negara Singapura', 0),
(2044, 271, 'D. Tujuan untuk menciptakan satu mata uang tunggal di Asia Tenggara', 0),
(2045, 272, 'A. f(x) = x^2 - 2x - 3', 0),
(2046, 272, 'B. f(x) = 2x^2 - 4x - 6', 0),
(2047, 272, 'C. f(x) = -2x^2 + 4x + 6', 1),
(2048, 272, 'D. f(x) = 3x^2 - 6x - 9', 0),
(2049, 273, 'A. Nyata, terbalik, diperbesar', 1),
(2050, 273, 'B. Maya, tegak, diperbesar', 0),
(2051, 273, 'C. Nyata, tegak, diperkecil', 0),
(2052, 273, 'D. Maya, terbalik, diperbesar', 0),
(2053, 274, 'A. Predikat', 0),
(2054, 274, 'B. Objek', 0),
(2055, 274, 'C. Perluasan Subjek (Atribut Subjek)', 1),
(2056, 274, 'D. Keterangan Waktu', 0),
(2057, 275, 'A. Harga baja impor menjadi lebih murah', 0),
(2058, 275, 'B. Produsen baja domestik (misal: Krakatau Steel) terlindungi dari persaingan dan berpotensi menaikkan harga jualnya', 1),
(2059, 275, 'C. Konsumen (misal: industri otomotif) diuntungkan karena mendapat bahan baku yang lebih murah', 0),
(2060, 275, 'D. Kualitas baja impor akan meningkat drastis', 0),
(2061, 276, 'A. 40', 0),
(2062, 276, 'B. 43', 0),
(2063, 276, 'C. 45', 1),
(2064, 276, 'D. 250', 0),
(2065, 277, 'A. Kaya oksigen (O2) dan miskin karbon dioksida (CO2)', 1),
(2066, 277, 'B. Miskin oksigen (O2) dan kaya karbon dioksida (CO2)', 0),
(2067, 277, 'C. Miskin oksigen (O2) dan miskin karbon dioksida (CO2)', 0),
(2068, 277, 'D. Kaya oksigen (O2) dan kaya karbon dioksida (CO2)', 0),
(2069, 278, 'A. Peristiwa G30S/PKI tahun 1965', 0),
(2070, 278, 'B. Dikeluarkannya Surat Perintah Sebelas Maret (Supersemar) 1966', 1),
(2071, 278, 'C. Pelaksanaan Pemilu pertama Orde Baru tahun 1971', 0),
(2072, 278, 'D. Pembubaran PKI dan ormas-ormasnya', 0),
(2073, 279, 'A. 10√13 cm', 1),
(2074, 279, 'B. 10√15 cm', 0),
(2075, 279, 'C. 50 cm', 0),
(2076, 279, 'D. 25 cm', 0),
(2077, 280, 'A. Hijau', 0),
(2078, 280, 'B. Merah', 0),
(2079, 280, 'C. Kuning', 0),
(2080, 280, 'D. Hitam', 1),
(2081, 281, 'A. 16 cm', 0),
(2082, 281, 'B. 20 cm', 1),
(2083, 281, 'C. 24 cm', 0),
(2084, 281, 'D. 32 cm', 0),
(2085, 282, 'A. Alga mati → Oksigen terlarut meningkat → Ikan mati', 0),
(2086, 282, 'B. Alga mati → Bakteri dekomposer meledak → Oksigen terlarut habis → Ikan mati', 1),
(2087, 282, 'C. Ikan mati → Bakteri dekomposer meledak → Oksigen terlarut habis → Alga mati', 0),
(2088, 282, 'D. Bakteri dekomposer meledak → Alga mati → Ikan mati → Oksigen terlarut habis', 0),
(2089, 283, 'A. Pembubaran partai-partai politik', 0),
(2090, 283, 'B. Korupsi yang merajalela di kalangan pejabat', 0),
(2091, 283, 'C. Dominasi modal asing (terutama Jepang) dalam perekonomian nasional', 1),
(2092, 283, 'D. Kenaikan harga bahan bakar minyak (BBM)', 0),
(2093, 284, 'A. Kalimat utama (tesis)', 0),
(2094, 284, 'B. Kalimat penjelas (elaborasi)', 0),
(2095, 284, 'C. Kalimat sanggahan (antitesis)', 1),
(2096, 284, 'D. Kalimat kesimpulan', 0),
(2097, 285, 'A. Nilai Budi = Nilai Ani', 0),
(2098, 285, 'B. Nilai Budi > Nilai Ani', 1),
(2099, 285, 'C. Nilai Budi < Nilai Ani', 0),
(2100, 285, 'D. Tidak dapat ditentukan', 0),
(2101, 286, 'A. 500 detik', 0),
(2102, 286, 'B. 560 detik', 0),
(2103, 286, 'C. 700 detik', 1),
(2104, 286, 'D. 875 detik', 0),
(2105, 287, 'A. Menurunkan suku bunga acuan (BI Rate) agar kredit lebih murah', 0),
(2106, 287, 'B. Menaikkan suku bunga acuan (BI Rate) untuk mengurangi peredaran uang', 1),
(2107, 287, 'C. Mencetak lebih banyak uang untuk menambah daya beli masyarakat', 0),
(2108, 287, 'D. Membeli surat-surat berharga (SBN) dari bank umum', 0),
(2109, 288, 'A. 9/25', 0),
(2110, 288, 'B. 12/25', 1),
(2111, 288, 'C. 13/25', 0),
(2112, 288, 'D. 6/25', 0),
(2113, 289, 'A. 2 Liter', 0),
(2114, 289, 'B. 4 Liter', 0),
(2115, 289, 'C. 8 Liter', 1),
(2116, 289, 'D. 16 Liter', 0),
(2117, 290, 'A. Metafora', 0),
(2118, 290, 'B. Ironi', 1),
(2119, 290, 'C. Eufemisme', 0),
(2120, 290, 'D. Simile', 0),
(2121, 291, 'A. 3 : 1', 0),
(2122, 291, 'B. 1 : 1', 0),
(2123, 291, 'C. 1 : 2 : 1', 1),
(2124, 291, 'D. 9 : 3 : 3 : 1', 0),
(2125, 292, 'A. 1.232 cm^3', 0),
(2126, 292, 'B. 1.540 cm^3', 0),
(2127, 292, 'C. 1.950,67 cm^3', 1),
(2128, 292, 'D. 2.464 cm^3', 0),
(2129, 293, 'A. Troposfer', 1),
(2130, 293, 'B. Stratosfer', 0),
(2131, 293, 'C. Mesosfer', 0),
(2132, 293, 'D. Termosfer (Ionosfer)', 0),
(2133, 294, 'A. Induk Kalimat - Anak Kalimat (Keterangan)', 0),
(2134, 294, 'B. Anak Kalimat (Keterangan) - Induk Kalimat', 1),
(2135, 294, 'C. Anak Kalimat (Subjek) - Induk Kalimat', 0),
(2136, 294, 'D. Setara berlawanan', 0),
(2137, 295, 'A. 6 kali', 0),
(2138, 295, 'B. 20 kali', 0),
(2139, 295, 'C. 114 kali', 1),
(2140, 295, 'D. 126 kali', 0),
(2141, 296, 'A. 7', 0),
(2142, 296, 'B. 10', 0),
(2143, 296, 'C. 13', 1),
(2144, 296, 'D. 15', 0),
(2145, 297, 'A. KAA hanya fokus pada ekonomi, GNB fokus pada militer', 0),
(2146, 297, 'B. KAA menentang Blok Barat, GNB menentang Blok Timur', 0),
(2147, 297, 'C. KAA berlingkup regional (Asia-Afrika), GNB berlingkup global dan menekankan netralitas Perang Dingin', 1),
(2148, 297, 'D. KAA didukung Uni Soviet, GNB didukung Amerika Serikat', 0),
(2149, 298, 'A. Menaikkan suhu dan energi kinetik rata-rata partikel', 0),
(2150, 298, 'B. Menaikkan suhu tanpa mengubah energi potensial partikel', 0),
(2151, 298, 'C. Mengubah energi kinetik partikel tanpa mengubah suhu', 0),
(2152, 298, 'D. Mengubah jarak antar partikel (energi potensial) tanpa mengubah suhu', 1),
(2153, 299, 'A. Memberi tahu informasi waktu kepada anak', 0),
(2154, 299, 'B. Mengeluh karena ia sudah mengantuk', 0),
(2155, 299, 'C. Meminta anak untuk segera berhenti bermain dan tidur', 1),
(2156, 299, 'D. Bertanya kepada anak apakah jam dindingnya akurat', 0),
(2157, 300, 'A. 45°', 0),
(2158, 300, 'B. 60°', 0),
(2159, 300, 'C. 90°', 1),
(2160, 300, 'D. 120°', 0),
(2161, 301, 'A. 105 cm$^3$', 0),
(2162, 301, 'B. 120 cm$^3$', 1),
(2163, 301, 'C. 135 cm$^3$', 0),
(2164, 301, 'D. 148 cm$^3$', 0),
(2165, 302, 'A. 1 : 3', 0),
(2166, 302, 'B. 1 : 4', 0),
(2167, 302, 'C. 3 : 1', 1);
INSERT INTO `pilihanjawaban` (`id_jawaban`, `id_pertanyaan`, `teks_jawaban`, `adalah_benar`) VALUES
(2168, 302, 'D. 4 : 1', 0),
(2169, 303, 'A. Larangan tegas dari Perserikatan Bangsa-Bangsa (PBB)', 0),
(2170, 303, 'B. Kehancuran ekonomi kedua negara akibat Perang Dunia II', 0),
(2171, 303, 'C. Adanya kesadaran Mutual Assured Destruction (MAD) akibat kepemilikan senjata nuklir oleh kedua belah pihak', 1),
(2172, 303, 'D. Fokus kedua negara untuk mengurus negara-negara jajahan mereka', 0),
(2173, 304, 'A. Pro-pembangunan mandiri dan anti-utang luar negeri', 0),
(2174, 304, 'B. Sangat pro-investasi asing dan menolak pandangan alternatif', 1),
(2175, 304, 'C. Netral dan objektif dalam memaparkan data', 0),
(2176, 304, 'D. Anti-teknologi modern', 0),
(2177, 305, 'A. 2 orang', 0),
(2178, 305, 'B. 5 orang', 0),
(2179, 305, 'C. 6 orang', 1),
(2180, 305, 'D. 10 orang', 0),
(2181, 306, 'A. (1) adalah fotosintesis (anabolisme) di mitokondria, (2) adalah respirasi (katabolisme) di kloroplas', 0),
(2182, 306, 'B. (1) adalah respirasi (katabolisme) di mitokondria, (2) adalah fotosintesis (anabolisme) di kloroplas', 1),
(2183, 306, 'C. (1) adalah fotosintesis (katabolisme), (2) adalah respirasi (anabolisme)', 0),
(2184, 306, 'D. (1) adalah respirasi (anabolisme), (2) adalah fotosintesis (katabolisme)', 0),
(2185, 307, 'A. Deflasi (penurunan harga barang secara umum)', 0),
(2186, 307, 'B. Peningkatan laju inflasi (kenaikan harga barang)', 1),
(2187, 307, 'C. Penguatan nilai tukar mata uang domestik', 0),
(2188, 307, 'D. Penurunan suku bunga bank', 0),
(2189, 308, 'A. 1/8', 0),
(2190, 308, 'B. 1/4', 0),
(2191, 308, 'C. 3/8', 1),
(2192, 308, 'D. 1/2', 0),
(2193, 309, 'A. Premis 1 adalah pernyataan yang salah', 0),
(2194, 309, 'B. Kesimpulannya bisa saja salah (jalanan bisa basah karena baru saja disiram, bukan karena hujan)', 1),
(2195, 309, 'C. Premis 2 tidak relevan dengan kesimpulan', 0),
(2196, 309, 'D. Kesimpulannya negatif padahal premisnya positif', 0),
(2197, 310, 'A. Pemantulan sempurna cahaya di permukaan air', 0),
(2198, 310, 'B. Pembiasan (refraksi) cahaya saat melewati medium (air dan udara) yang kerapatannya berbeda', 1),
(2199, 310, 'C. Difraksi (pelenturan) cahaya pada celah sempit', 0),
(2200, 310, 'D. Polarisasi (penyerapan arah getar) cahaya', 0),
(2201, 311, 'A. 8 satuan luas', 0),
(2202, 311, 'B. 12 satuan luas', 0),
(2203, 311, 'C. 16 satuan luas', 1),
(2204, 311, 'D. 32 satuan luas', 0),
(2205, 312, 'A. Modernisasi adalah peniruan budaya Barat, westernisasi adalah kemajuan IPTEK', 0),
(2206, 312, 'B. Modernisasi berfokus pada kemajuan IPTEK dan pola pikir rasional, westernisasi adalah peniruan budaya Barat (gaya hidup, pakaian) secara mentah-mentah', 1),
(2207, 312, 'C. Modernisasi berasal dari Timur, westernisasi berasal dari Barat', 0),
(2208, 312, 'D. Tidak ada perbedaan, keduanya adalah istilah yang sama', 0),
(2209, 313, 'A. Penyempitan makna (spesialisasi)', 0),
(2210, 313, 'B. Perluasan makna (generalisasi)', 0),
(2211, 313, 'C. Pergeseran makna kiasan (metafora)', 1),
(2212, 313, 'D. Pergeseran makna sinestesia', 0),
(2213, 314, 'A. Pria bergolongan darah A (genotipe $I^A i$)', 0),
(2214, 314, 'B. Pria bergolongan darah B (genotipe $I^B i$)', 0),
(2215, 314, 'C. Pria bergolongan darah O (genotipe $ii$)', 0),
(2216, 314, 'D. Pria bergolongan darah AB (genotipe $I^A I^B$)', 1),
(2217, 315, 'A. 30', 0),
(2218, 315, 'B. 33', 0),
(2219, 315, 'C. 35', 1),
(2220, 315, 'D. 36', 0),
(2221, 316, 'A. 14 gram', 0),
(2222, 316, 'B. 17,5 gram', 0),
(2223, 316, 'C. 20 gram', 1),
(2224, 316, 'D. 28 gram', 0),
(2225, 317, 'A. Menjaga wilayah darat dan wilayah laut Indonesia', 0),
(2226, 317, 'B. Melindungi Presiden dan melindungi rakyat', 0),
(2227, 317, 'C. Berfungsi sebagai kekuatan pertahanan keamanan (Hankam) sekaligus kekuatan sosial-politik (Sospol)', 1),
(2228, 317, 'D. Menjalankan fungsi legislatif (MPR) sekaligus fungsi eksekutif (Menteri)', 0),
(2229, 318, 'A. (1/2)√2', 0),
(2230, 318, 'B. (1/2)√3', 0),
(2231, 318, 'C. (1/3)√3', 1),
(2232, 318, 'D. (1/3)√6', 0),
(2233, 319, 'A. 3 Volt', 0),
(2234, 319, 'B. 4 Volt', 1),
(2235, 319, 'C. 6 Volt', 0),
(2236, 319, 'D. 8 Volt', 0),
(2237, 320, 'A. Waktu kejadian (kata \"baru saja\")', 0),
(2238, 320, 'B. Jenis lotre yang dimenangkan', 0),
(2239, 320, 'C. Kata ganti \"dia\" (tidak jelas merujuk ke \"Pria itu\" atau \"temannya\")', 1),
(2240, 320, 'D. Jumlah uang yang dimenangkan', 0),
(2241, 321, '480 cm³', 0),
(2242, 321, '768 cm³', 1),
(2243, 321, '1.500 cm³', 0),
(2244, 321, '6.000 cm³', 0),
(2245, 322, '0,50 g/cm³', 0),
(2246, 322, '0,75 g/cm³', 1),
(2247, 322, '1,25 g/cm³', 0),
(2248, 322, '1,50 g/cm³', 0),
(2249, 323, 'Meningkatkan anggaran riset dan teknologi di universitas', 0),
(2250, 323, 'Meredam aktivitas politik kritis mahasiswa dan memfokuskan mereka pada kegiatan akademik', 1),
(2251, 323, 'Mendorong mahasiswa untuk bergabung dengan partai politik Golkar', 0),
(2252, 323, 'Mempermudah pertukaran pelajar antar universitas', 0),
(2253, 324, 'Objektif dan netral dalam menyampaikan fakta', 0),
(2254, 324, 'Kritis dan meragukan data yang disajikan penulis buku', 0),
(2255, 324, 'Sangat setuju, cenderung bias, dan tidak memberi ruang untuk pandangan berbeda', 1),
(2256, 324, 'Hanya ingin mempromosikan penulisnya, bukan isi bukunya', 0),
(2257, 325, '19', 0),
(2258, 325, '22', 1),
(2259, 325, '25', 0),
(2260, 325, '30', 0),
(2261, 326, '1.000 kJ', 0),
(2262, 326, '100 kJ', 0),
(2263, 326, '10 kJ', 1),
(2264, 326, '1 kJ', 0),
(2265, 327, 'Nilai dari membeli sepatu (Rp 500.000)', 0),
(2266, 327, 'Kepuasan dari membeli game baru (alternatif terbaik yang dilepaskan)', 1),
(2267, 327, 'Kepuasan dari membeli game baru DAN menabung', 0),
(2268, 327, 'Tidak ada, karena ia menggunakan uangnya sendiri', 0),
(2269, 328, '8/36', 0),
(2270, 328, '4/15', 1),
(2271, 328, '8/30', 0),
(2272, 328, '8/15', 0),
(2273, 329, '0,5 M', 0),
(2274, 329, '1,0 M', 1),
(2275, 329, '2,0 M', 0),
(2276, 329, '4,0 M', 0),
(2277, 330, 'Banjir bandang adalah fenomena alam biasa', 0),
(2278, 330, 'Semua permukiman mewah menyebabkan banjir', 0),
(2279, 330, 'Telah terjadi kegagalan dalam tata ruang atau pengawasan alih fungsi lahan', 1),
(2280, 330, 'Hutan di kawasan hulu tidak lagi menghasilkan oksigen', 0),
(2281, 331, '90 cm²', 0),
(2282, 331, '120 cm²', 0),
(2283, 331, '135 cm²', 0),
(2284, 331, '180 cm²', 1),
(2285, 332, '50 gram', 1),
(2286, 332, '60 gram', 0),
(2287, 332, '75 gram', 0),
(2288, 332, '100 gram', 0),
(2289, 333, 'Mengakhiri sistem pemerintahan Presidensial', 0),
(2290, 333, 'Memperkenalkan sistem Demokrasi Terpimpin', 0),
(2291, 333, 'Mengubah sistem satu partai (PNI) menjadi sistem multipartai', 1),
(2292, 333, 'Memindahkan ibu kota negara dari Jakarta ke Yogyakarta', 0),
(2293, 334, 'Pemborosan kata (pleonasme), kata tidak baku, dan konjungsi yang tidak tepat', 1),
(2294, 334, 'Tidak memiliki subjek yang jelas dan predikat yang rancu', 0),
(2295, 334, 'Penggunaan tanda baca yang salah dan salah ketik', 0),
(2296, 334, 'Penggunaan kata depan yang tidak perlu dan kata tidak baku', 0),
(2297, 335, '-1/6', 0),
(2298, 335, '1/6', 1),
(2299, 335, '-1', 0),
(2300, 335, '5', 0),
(2301, 336, '0%', 1),
(2302, 336, '25%', 0),
(2303, 336, '50%', 0),
(2304, 336, '75%', 0),
(2305, 337, 'Musim kemarau, karena udara dari Asia bersifat kering dan dingin', 0),
(2306, 337, 'Musim hujan, karena angin tersebut membawa banyak uap air setelah melintasi Samudra Hindia dan Laut Cina Selatan', 1),
(2307, 337, 'Musim pancaroba, karena anginnya tidak stabil', 0),
(2308, 337, 'Musim dingin, karena udara dari Asia (Siberia) bersifat dingin', 0),
(2309, 338, '(-2, -3)', 0),
(2310, 338, '(2, 3)', 1),
(2311, 338, '(2, -3)', 0),
(2312, 338, '(-2, 3)', 0),
(2313, 339, '+1 Dioptri', 1),
(2314, 339, '-1 Dioptri', 0),
(2315, 339, '+2 Dioptri', 0),
(2316, 339, '-2 Dioptri', 0),
(2317, 340, 'ASEAN memiliki pakta militer bersama, sedangkan APEC tidak', 0),
(2318, 340, 'APEC hanya beranggotakan negara-negara Asia, sedangkan ASEAN anggotanya global', 0),
(2319, 340, 'ASEAN berfokus pada regionalisme geografis yang erat (Asia Tenggara) dengan pilar politik, ekonomi, dan sosial-budaya, sedangkan APEC berfokus murni pada liberalisasi ekonomi lintas benua', 1),
(2320, 340, 'ASEAN menggunakan mata uang tunggal, sedangkan APEC tidak', 0),
(2321, 341, '2 : 3', 0),
(2322, 341, '3 : 4', 0),
(2323, 341, '4 : 5', 1),
(2324, 341, '5 : 6', 0),
(2325, 342, '1,25 menit', 0),
(2326, 342, '2,5 menit', 0),
(2327, 342, '10 menit', 0),
(2328, 342, '20 menit', 1),
(2329, 343, 'Dari pro-Barat menjadi pro-Timur (Komunis)', 0),
(2330, 343, 'Dari anti-kolonialisme menjadi mendukung kolonialisme', 0),
(2331, 343, 'Dari politik \"mercusuar\" yang konfrontatif dan condong ke Blok Timur, menjadi politik pragmatis, pro-Barat, dan fokus pada stabilitas regional (ASEAN)', 1),
(2332, 343, 'Dari bebas-aktif menjadi politik isolasi (menutup diri)', 0),
(2333, 344, 'Ad Hominem (menyerang pribadi)', 0),
(2334, 344, 'Straw Man (menyederhanakan argumen lawan)', 0),
(2335, 344, 'Appeal to Popularity / Ad Populum (menganggap sesuatu benar karena populer)', 1),
(2336, 344, 'False Dilemma (menyajikan hanya dua pilihan)', 0),
(2337, 345, '1/2', 0),
(2338, 345, '3/5', 1),
(2339, 345, '2/5', 0),
(2340, 345, '7/10', 0),
(2341, 346, '56,25% (9/16)', 0),
(2342, 346, '37,5% (6/16)', 0),
(2343, 346, '25% (4/16)', 1),
(2344, 346, '12,5% (2/16)', 0),
(2345, 347, 'Permintaan cabai bersifat elastis, permintaan smartphone inelastis', 0),
(2346, 347, 'Permintaan cabai bersifat inelastis, permintaan smartphone elastis', 1),
(2347, 347, 'Kedua permintaan bersifat elastis', 0),
(2348, 347, 'Kedua permintaan bersifat inelastis', 0),
(2349, 348, 'Perluasan Subjek', 0),
(2350, 348, 'Objek (pelengkap dari predikat \"mengaku\")', 1),
(2351, 348, 'Keterangan Cara', 0),
(2352, 348, 'Keterangan Waktu', 0),
(2353, 349, '24 cm', 0),
(2354, 349, '240/13 cm', 1),
(2355, 349, '120/13 cm', 0),
(2356, 349, '20 cm', 0),
(2357, 350, 'Hidrogen dan Oksigen keduanya habis bereaksi', 0),
(2358, 350, 'Hidrogen habis bereaksi, Oksigen bersisa', 1),
(2359, 350, 'Oksigen habis bereaksi, Hidrogen bersisa', 0),
(2360, 350, 'Tidak terjadi reaksi karena massa tidak setara', 0),
(2361, 351, 'Pertumbuhan penduduk negatif (populasi berkurang)', 0),
(2362, 351, 'Ledakan penduduk (population boom)', 1),
(2363, 351, 'Proporsi penduduk usia tua (lansia) meningkat pesat', 0),
(2364, 351, 'Angka emigrasi (keluar negara) meningkat', 0),
(2365, 352, '45 km/jam', 1),
(2366, 352, '48 km/jam', 0),
(2367, 352, '50 km/jam', 0),
(2368, 352, '52 km/jam', 0),
(2369, 353, '50 cm', 0),
(2370, 353, '60 cm', 0),
(2371, 353, '75 cm', 1),
(2372, 353, '100 cm', 0),
(2373, 354, 'Tuntutan 50 partai politik agar Pemilu diulang', 0),
(2374, 354, 'Protes 50 jenderal ABRI terhadap program KB', 0),
(2375, 354, 'Pernyataan keprihatinan 50 tokoh (sipil dan militer) yang mengkritik interpretasi Presiden Soeharto terhadap Pancasila dan Dwi Fungsi ABRI', 1),
(2376, 354, 'Usulan 50 ulama untuk menjadikan Indonesia negara Islam', 0),
(2377, 355, 'Antusias dan bangga', 0),
(2378, 355, 'Objektif dan netral', 0),
(2379, 355, 'Sinis dan kritis terselubung', 1),
(2380, 355, 'Sedih dan pasrah', 0),
(2381, 356, '1,2 meter', 0),
(2382, 356, '1,5 meter', 1),
(2383, 356, '1,8 meter', 0),
(2384, 356, '2,0 meter', 0),
(2385, 357, 'Meningkat drastis karena bertemu substrat baru', 0),
(2386, 357, 'Berhenti total (terdenaturasi) karena pH sangat tidak optimal', 1),
(2387, 357, 'Tetap sama, karena suhu tubuh tidak berubah', 0),
(2388, 357, 'Berubah fungsi menjadi enzim amilase untuk memecah karbohidrat', 0),
(2389, 358, 'Terjadinya kenaikan harga barang (inflasi) yang tinggi', 0),
(2390, 358, 'Terjadinya pelebaran ketimpangan pendapatan antara si kaya dan si miskin', 1),
(2391, 358, 'Terjadinya peningkatan utang luar negeri', 0),
(2392, 358, 'Terjadinya perlambatan pertumbuhan ekonomi (PDB)', 0),
(2393, 359, '15', 0),
(2394, 359, '20', 0),
(2395, 359, '25', 1),
(2396, 359, '105', 0),
(2397, 360, 'Magnet digerakkan lebih lambat dan jumlah lilitan dikurangi', 0),
(2398, 360, 'Magnet yang digunakan lebih lemah dan digerakkan lebih lambat', 0),
(2399, 360, 'Jumlah lilitan kumparan ditambah dan magnet digerakkan lebih cepat', 1),
(2400, 360, 'Kawat kumparan diganti dengan kawat yang lebih tebal (hambatan kecil)', 0),
(2401, 361, '1 : 1', 0),
(2402, 361, '√2 : 1', 0),
(2403, 361, '2 : 1', 1),
(2404, 361, '4 : 1', 0),
(2405, 362, 'Netral (pH = 7)', 0),
(2406, 362, 'Asam (pH < 7)', 0),
(2407, 362, 'Basa (pH > 7)', 1),
(2408, 362, 'Membentuk garam yang terhidrolisis', 0),
(2409, 363, 'Program Benteng berfokus menumbuhkan kelas pengusaha pribumi (importir), Repelita berfokus pada pembangunan infrastruktur dan pertanian', 1),
(2410, 363, 'Program Benteng adalah kebijakan pertanian, Repelita adalah kebijakan industri', 0),
(2411, 363, 'Program Benteng anti-investasi asing, Repelita pro-investasi asing', 0),
(2412, 363, 'Program Benteng berhasil, Repelita gagal', 0),
(2413, 364, 'Budi sebenarnya tidak rajin belajar', 0),
(2414, 364, 'Premis 1 (pernyataan \"jika-maka\" tersebut) pasti salah', 1),
(2415, 364, 'Siswa yang mendapat nilai 90 berarti tidak rajin', 0),
(2416, 364, 'Guru Budi salah menilai', 0),
(2417, 365, '2x² + x', 1),
(2418, 365, '2x² + x - 1', 0),
(2419, 365, '8x² + 4x - 3', 0),
(2420, 365, '4x² + 2x', 0),
(2421, 366, '2,5 kali', 0),
(2422, 366, '3,5 kali', 1),
(2423, 366, '10 kali', 0),
(2424, 366, '25 kali', 0),
(2425, 367, 'Pertumbuhan Negara A lebih berkualitas (inklusif) daripada Negara B', 0),
(2426, 367, 'Pertumbuhan Negara B lebih berkualitas dan merata, meskipun lambat, daripada Negara A', 1),
(2427, 367, 'Kedua negara mengalami kemunduran ekonomi', 0),
(2428, 367, 'Gini Ratio tidak berhubungan dengan pertumbuhan PDB', 0),
(2429, 368, '1/56', 0),
(2430, 368, '10/56', 0),
(2431, 368, '45/56', 0),
(2432, 368, '55/56', 1),
(2433, 369, '25', 0),
(2434, 369, '50', 1),
(2435, 369, '75', 0),
(2436, 369, '100', 0),
(2437, 370, 'Waktu adalah kata benda abstrak yang tidak bisa dibuat menjadi efisien', 1),
(2438, 370, 'Kata tersebut tidak baku, seharusnya \"meng-efisien-kan\"', 0),
(2439, 370, 'Seharusnya menggunakan kata \"efektif\", bukan \"efisien\"', 0),
(2440, 370, 'Kata \"mengefisienkan\" bermakna ganda (ambigu)', 0),
(2441, 371, '85', 0),
(2442, 371, '90', 1),
(2443, 371, '95', 0),
(2444, 371, '100', 0),
(2445, 372, '210 detik (3,5 menit)', 0),
(2446, 372, '1680 detik (28 menit)', 1),
(2447, 372, '1890 detik (31,5 menit)', 0),
(2448, 372, '840 detik (14 menit)', 0),
(2449, 373, 'Demokrasi Terpimpin menerapkan Etatisme (kontrol negara kuat), Orde Baru menerapkan Neoliberalisme (investasi asing dan swasta kuat)', 1),
(2450, 373, 'Demokrasi Terpimpin pro-Barat, Orde Baru pro-Timur', 0),
(2451, 373, 'Demokrasi Terpimpin fokus pada pertanian, Orde Baru fokus pada industri berat', 0),
(2452, 373, 'Demokrasi Terpimpin anti-utang, Orde Baru anti-utang', 0),
(2453, 374, 'Menyajikan data statistik pertanian secara objektif', 0),
(2454, 374, 'Menggugah keprihatinan pembaca tentang krisis regenerasi petani', 1),
(2455, 374, 'Menghibur pembaca dengan fakta unik di pedesaan', 0),
(2456, 374, 'Menjelaskan proses urbanisasi dari desa ke kota', 0),
(2457, 375, '8 cm', 0),
(2458, 375, '√28 cm (atau 2√7 cm)', 1),
(2459, 375, '√52 cm (atau 2√13 cm)', 0),
(2460, 375, '6 cm', 0),
(2461, 376, '32 Ω', 0),
(2462, 376, '16/3 Ω', 0),
(2463, 376, '24/5 Ω', 1),
(2464, 376, '0 Ω (Hubung singkat)', 0),
(2465, 377, 'Mobilitas Horizontal', 0),
(2466, 377, 'Mobilitas Vertikal Antargenerasi (Naik)', 1),
(2467, 377, 'Mobilitas Vertikal Intragenerasi (Naik)', 0),
(2468, 377, 'Mobilitas Vertikal Antargenerasi (Turun)', 0),
(2469, 378, '(1,5 + 10√3) meter', 1),
(2470, 378, '(1,5 + 20√3) meter', 0),
(2471, 378, '11,5 meter', 0),
(2472, 378, '21,5 meter', 0),
(2473, 379, 'Populasi Ular akan musnah karena kehabisan makanan', 0),
(2474, 379, 'Populasi Belalang meningkat drastis, menyebabkan populasi Rumput menurun drastis', 1),
(2475, 379, 'Populasi Tikus akan menurun drastis karena diburu Katak', 0),
(2476, 379, 'Populasi Elang akan meningkat karena Ular lebih mudah ditangkap', 0),
(2477, 380, 'Kekecewaan terhadap Blok Timur (Uni Soviet dan Tiongkok)', 0),
(2478, 380, 'Perubahan fundamental politik luar negeri dari Konfrontasi (Orla) menjadi Diplomasi dan Pragmatisme Ekonomi (Orba)', 1),
(2479, 380, 'PBB membatalkan keanggotaan Malaysia', 0),
(2480, 380, 'Desakan dari negara-negara Gerakan Non-Blok (GNB)', 0),
(2481, 381, '2 cm', 0),
(2482, 381, '2,5 cm', 0),
(2483, 381, '3 cm', 1),
(2484, 381, '4 cm', 0),
(2485, 382, '700 kg/m^3', 0),
(2486, 382, '800 kg/m^3', 1),
(2487, 382, '1.200 kg/m^3', 0),
(2488, 382, '1.250 kg/m^3', 0),
(2489, 383, 'Orde Lama jatuh karena krisis politik (G30S, Tritura), Orde Baru jatuh karena krisis ekonomi (Krismon 1998)', 1),
(2490, 383, 'Orde Lama jatuh karena krisis ekonomi, Orde Baru jatuh karena krisis politik', 0),
(2491, 383, 'Keduanya jatuh murni karena intervensi militer', 0),
(2492, 383, 'Keduanya jatuh murni karena demonstrasi mahasiswa', 0),
(2493, 384, 'Data statistik yang digunakan pasti salah', 0),
(2494, 384, 'Mengabaikan variabel tersembunyi (cuaca panas) yang memengaruhi kedua faktor (korelasi bukan kausalitas)', 1),
(2495, 384, 'Terlalu cepat mengambil kesimpulan (generalisasi)', 0),
(2496, 384, 'Menggunakan data yang tidak relevan', 0),
(2497, 385, '8 hari', 0),
(2498, 385, '10 hari', 0),
(2499, 385, '12 hari', 1),
(2500, 385, '14 hari', 0),
(2501, 386, '0%', 0),
(2502, 386, '12,5% (1/8)', 1),
(2503, 386, '25% (1/4)', 0),
(2504, 386, '50% (1/2)', 0),
(2505, 387, '1 mobil ditukar 0,4 ton beras', 0),
(2506, 387, '1 mobil ditukar 0,8 ton beras', 1),
(2507, 387, '1 mobil ditukar 1,2 ton beras', 0),
(2508, 387, '1 mobil ditukar 2,0 ton beras', 0),
(2509, 388, '1/6', 0),
(2510, 388, '2/11', 1),
(2511, 388, '1/5', 0),
(2512, 388, '2/5', 0),
(2513, 389, '16 Liter', 1),
(2514, 389, '18 Liter', 0),
(2515, 389, '26 Liter', 0),
(2516, 389, '34 Liter', 0),
(2517, 390, 'Pujian tulus atas kejujuran Andi', 0),
(2518, 390, 'Rasa lega karena laptopnya tidak hancur total', 0),
(2519, 390, 'Kemarahan, kekecewaan, dan sindiran tajam (sarkasme)', 1),
(2520, 390, 'Kebingungan atas apa yang harus dilakukannya', 0),
(2521, 391, '18 km', 0),
(2522, 391, '20 km', 1),
(2523, 391, '24 km', 0),
(2524, 391, '28 km', 0),
(2525, 392, '20 kali', 0),
(2526, 392, '25 kali', 0),
(2527, 392, '40 kali', 1),
(2528, 392, '50 kali', 0),
(2529, 393, 'Populasi rusa meningkat karena memiliki teman baru', 0),
(2530, 393, 'Populasi rusa menurun drastis atau punah karena kalah dalam kompetisi memperebutkan rumput', 1),
(2531, 393, 'Populasi rumput meningkat pesat karena dimakan oleh dua herbivora', 0),
(2532, 393, 'Rusa dan kelinci akan bersimbiosis mutualisme', 0),
(2533, 394, 'Sah, karena disetujui oleh Konstituante', 0),
(2534, 394, 'Sah, karena merupakan hak prerogatif Presiden', 0),
(2535, 394, 'Inkonstitusional, namun dibenarkan secara politik atas dasar \"hukum darurat negara\" (staatsnoodrecht)', 1),
(2536, 394, 'Ilegal, dan langsung dibatalkan oleh Mahkamah Agung', 0),
(2537, 395, '88', 0),
(2538, 395, '90', 0),
(2539, 395, '92', 1),
(2540, 395, '94', 0),
(2541, 396, 'Larutan A lebih asam 3 kali lipat dari Larutan B', 0),
(2542, 396, 'Larutan B lebih basa 3 kali lipat dari Larutan A', 0),
(2543, 396, 'Konsentrasi ion H+ di Larutan A adalah 1.000 kali lebih banyak daripada di Larutan B', 1),
(2544, 396, 'Konsentrasi ion H+ di Larutan B adalah 1.000 kali lebih banyak daripada di Larutan A', 0),
(2545, 397, '100 meter', 0),
(2546, 397, '125 meter', 1),
(2547, 397, '150 meter', 0),
(2548, 397, '175 meter', 0),
(2549, 398, 'Gempa subduksi selalu lebih dangkal', 0),
(2550, 398, 'Gempa subduksi menyebabkan perpindahan vertikal (naik-turun) dasar laut secara masif, yang memindahkan volume air laut', 1),
(2551, 398, 'Gempa patahan geser melepaskan energi yang lebih kecil', 0),
(2552, 398, 'Gempa patahan geser hanya bergerak horizontal dan tidak memindahkan volume air laut secara signifikan', 0),
(2553, 399, 'Tidak jelas kapan kejadian itu terjadi', 0),
(2554, 399, 'Tidak jelas apakah pria itu menggunakan teropong untuk melihat, atau wanita yang dilihatnya sedang memegang teropong', 1),
(2555, 399, 'Tidak jelas jenis teropong yang digunakan', 0),
(2556, 399, 'Tidak jelas siapa nama pria atau wanita itu', 0),
(2557, 400, '$50\\pi$ cm^3', 0),
(2558, 400, '$100\\pi$ cm^3', 0),
(2559, 400, '$350\\pi$ cm^3', 0),
(2560, 400, '$400\\pi$ cm^3', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `progreslevelpengguna`
--

CREATE TABLE `progreslevelpengguna` (
  `id_progres` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `exp` int(11) DEFAULT 0,
  `bintang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `progreslevelpengguna`
--

INSERT INTO `progreslevelpengguna` (`id_progres`, `id_pengguna`, `id_level`, `exp`, `bintang`) VALUES
(28, 14, 1, 121, 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayatpertandingan`
--

CREATE TABLE `riwayatpertandingan` (
  `id_pertandingan` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_level` int(11) DEFAULT NULL,
  `id_turnamen` int(11) DEFAULT NULL,
  `exp_didapat` int(11) NOT NULL,
  `bintang_didapat` int(11) DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayatpertandingan`
--

INSERT INTO `riwayatpertandingan` (`id_pertandingan`, `id_pengguna`, `id_level`, `id_turnamen`, `exp_didapat`, `bintang_didapat`, `waktu_selesai`) VALUES
(1, 1, 1, NULL, 100, 5, '2025-10-09 09:28:07'),
(2, 14, 20, 2, 500, 5, '2025-11-15 07:39:38');

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
('cC4So902FzuaOqQh6tgbZaBGb4AYVdIgrvPvgRDD', NULL, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWdBNG8zRGVCbVJwYzVENEFudU9zblB5anJwU1VNaEZuMnlnMnlaQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sZWFkZXJib2FyZC90b3AxMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763223718),
('QkBAZN9576jq8MLNWJZN0OFPghJfTCGEYj4KARuo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiM1pqOGk0TU1aeUF2aTQwQjJmdmhTRTZmUzBpWEE5NkNHYWJDckxSOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czoxMToicGVuZ2d1bmFfaWQiO2k6MTc7czoxNzoicGVuZ2d1bmFfdXNlcm5hbWUiO3M6NzoiQW5vbWFsaSI7czoxMzoicGVuZ2d1bmFfcm9sZSI7czo3OiJzdHVkZW50Ijt9', 1763224266),
('qyU1UGTxXch3yLJrfLZv12Kw2IEElJvupS02BWQs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSE1KYTNiM0Z6N2Z2SFU2eDYzVUZYMjJwMXNUdzRTYnMxMm5La0paViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czoxMToicGVuZ2d1bmFfaWQiO2k6MTQ7czoxNzoicGVuZ2d1bmFfdXNlcm5hbWUiO3M6MzoibWFuIjtzOjEzOiJwZW5nZ3VuYV9yb2xlIjtzOjc6InN0dWRlbnQiO30=', 1763222303),
('rbPCMdTUP5Muk7OBF1xS7E5tLiBqut84G22aRv6n', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZ0xqeThtaURtT1VEb1pOVDd5SG12cDVHcXZHR0I1Qjlva2JTbXNhVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sZWFkZXJib2FyZC90b3AxMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjExOiJwZW5nZ3VuYV9pZCI7aToxNDtzOjE3OiJwZW5nZ3VuYV91c2VybmFtZSI7czozOiJtYW4iO3M6MTM6InBlbmdndW5hX3JvbGUiO3M6Nzoic3R1ZGVudCI7fQ==', 1763221985);

-- --------------------------------------------------------

--
-- Struktur dari tabel `turnamen`
--

CREATE TABLE `turnamen` (
  `id_turnamen` int(11) NOT NULL,
  `nama_turnamen` varchar(100) NOT NULL,
  `kode_room` varchar(10) NOT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `level_minimal` int(11) DEFAULT 20,
  `status` varchar(50) NOT NULL DEFAULT 'Menunggu',
  `tanggal_pelaksanaan` datetime DEFAULT NULL,
  `durasi_pengerjaan` int(11) DEFAULT 45,
  `max_peserta` int(11) DEFAULT 30,
  `deskripsi` text DEFAULT NULL,
  `bonus_exp` int(11) DEFAULT 500,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `turnamen`
--

INSERT INTO `turnamen` (`id_turnamen`, `nama_turnamen`, `kode_room`, `dibuat_oleh`, `level_minimal`, `status`, `tanggal_pelaksanaan`, `durasi_pengerjaan`, `max_peserta`, `deskripsi`, `bonus_exp`, `created_at`, `updated_at`) VALUES
(2, 'k', 'OBJKY', 12, 20, 'Menunggu', '2025-11-15 06:29:06', 45, 30, 'm', 500, '2025-11-14 23:29:39', '2025-11-14 23:29:39'),
(3, 'ujian matematika', 'MCTOI0', 9, 1, 'Menunggu', '2025-11-09 00:49:00', 45, 30, 'snakjdnkjn', 500, '2025-11-08 10:53:16', '2025-11-09 05:40:21'),
(10, 'k', 'K2HPBQ', 12, 20, 'Menunggu', '2025-11-15 06:47:00', 45, 30, 'k', 500, '2025-11-14 16:48:07', '2025-11-14 16:48:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `turnamen_jawaban_peserta`
--

CREATE TABLE `turnamen_jawaban_peserta` (
  `id` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `id_pertanyaan_turnamen` int(11) NOT NULL,
  `id_jawaban_dipilih` int(11) DEFAULT NULL,
  `waktu_jawab` int(11) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `answered_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `turnamen_pertanyaan`
--

CREATE TABLE `turnamen_pertanyaan` (
  `id` int(11) NOT NULL,
  `id_turnamen` int(11) NOT NULL,
  `teks_pertanyaan` text NOT NULL,
  `poin_per_soal` int(11) DEFAULT 10,
  `waktu_pengerjaan` int(11) DEFAULT 30,
  `tingkat_kesulitan` enum('mudah','sedang','sulit') DEFAULT 'sedang',
  `mata_pelajaran` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `turnamen_pertanyaan`
--

INSERT INTO `turnamen_pertanyaan` (`id`, `id_turnamen`, `teks_pertanyaan`, `poin_per_soal`, `waktu_pengerjaan`, `tingkat_kesulitan`, `mata_pelajaran`, `created_at`) VALUES
(2, 3, 'sajnda', 10, 30, 'sedang', 'matematika', '2025-11-08 10:53:16'),
(9, 10, 'l', 10, 30, 'sedang', 'matematika', '2025-11-14 16:48:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `turnamen_pilihan_jawaban`
--

CREATE TABLE `turnamen_pilihan_jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_pertanyaan_turnamen` int(11) NOT NULL,
  `teks_jawaban` text NOT NULL,
  `adalah_benar` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `turnamen_pilihan_jawaban`
--

INSERT INTO `turnamen_pilihan_jawaban` (`id_jawaban`, `id_pertanyaan_turnamen`, `teks_jawaban`, `adalah_benar`) VALUES
(5, 2, 'akjda', 1),
(6, 2, 'ajsnda', 0),
(7, 2, 'ajsndka', 0),
(8, 2, 'ajndka', 0),
(33, 9, 'l', 1),
(34, 9, 'm', 0),
(35, 9, 'n', 0),
(36, 9, 'o', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'pa jarrr', 'pajarrr880@gmail.com', '100178159551451873969', NULL, '$2y$12$RB5aIWp2iqsDRhJlj/qrzO31z/Say8at7njsQVBhN5N1QlPZPmoLW', NULL, '2025-10-10 23:27:33', '2025-10-10 23:29:09'),
(2, 'Fajar Ali Hamzah_ MVP', 'pajarali15@gmail.com', '115700289121580866720', NULL, '$2y$12$OxTAKAEtATT.eM8D/XSwmep1bFjsTtk/QO4aLcSRhCm0cUTBEBFG.', NULL, '2025-10-10 23:32:38', '2025-10-10 23:32:38');

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
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indeks untuk tabel `kisi_kisi`
--
ALTER TABLE `kisi_kisi`
  ADD PRIMARY KEY (`id_kisi`),
  ADD KEY `id_level` (`id_level`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

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
-- Indeks untuk tabel `pencapaian`
--
ALTER TABLE `pencapaian`
  ADD PRIMARY KEY (`id_pencapaian`);

--
-- Indeks untuk tabel `pencapaianpengguna`
--
ALTER TABLE `pencapaianpengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pengguna` (`id_pengguna`,`id_pencapaian`),
  ADD KEY `id_pencapaian` (`id_pencapaian`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Indeks untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`),
  ADD KEY `id_level` (`id_level`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indeks untuk tabel `pesertaturnamen`
--
ALTER TABLE `pesertaturnamen`
  ADD PRIMARY KEY (`id_peserta`),
  ADD UNIQUE KEY `id_turnamen` (`id_turnamen`,`id_pengguna`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `pilihanjawaban`
--
ALTER TABLE `pilihanjawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_pertanyaan` (`id_pertanyaan`);

--
-- Indeks untuk tabel `progreslevelpengguna`
--
ALTER TABLE `progreslevelpengguna`
  ADD PRIMARY KEY (`id_progres`),
  ADD UNIQUE KEY `id_pengguna` (`id_pengguna`,`id_level`),
  ADD KEY `id_level` (`id_level`);

--
-- Indeks untuk tabel `riwayatpertandingan`
--
ALTER TABLE `riwayatpertandingan`
  ADD PRIMARY KEY (`id_pertandingan`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_level` (`id_level`),
  ADD KEY `id_turnamen` (`id_turnamen`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `turnamen`
--
ALTER TABLE `turnamen`
  ADD PRIMARY KEY (`id_turnamen`),
  ADD UNIQUE KEY `kode_room` (`kode_room`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indeks untuk tabel `turnamen_jawaban_peserta`
--
ALTER TABLE `turnamen_jawaban_peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peserta` (`id_peserta`),
  ADD KEY `id_pertanyaan_turnamen` (`id_pertanyaan_turnamen`);

--
-- Indeks untuk tabel `turnamen_pertanyaan`
--
ALTER TABLE `turnamen_pertanyaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_turnamen` (`id_turnamen`);

--
-- Indeks untuk tabel `turnamen_pilihan_jawaban`
--
ALTER TABLE `turnamen_pilihan_jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_pertanyaan_turnamen` (`id_pertanyaan_turnamen`);

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
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kisi_kisi`
--
ALTER TABLE `kisi_kisi`
  MODIFY `id_kisi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pencapaian`
--
ALTER TABLE `pencapaian`
  MODIFY `id_pencapaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pencapaianpengguna`
--
ALTER TABLE `pencapaianpengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT untuk tabel `pesertaturnamen`
--
ALTER TABLE `pesertaturnamen`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pilihanjawaban`
--
ALTER TABLE `pilihanjawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2561;

--
-- AUTO_INCREMENT untuk tabel `progreslevelpengguna`
--
ALTER TABLE `progreslevelpengguna`
  MODIFY `id_progres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `riwayatpertandingan`
--
ALTER TABLE `riwayatpertandingan`
  MODIFY `id_pertandingan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `turnamen`
--
ALTER TABLE `turnamen`
  MODIFY `id_turnamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `turnamen_jawaban_peserta`
--
ALTER TABLE `turnamen_jawaban_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `turnamen_pertanyaan`
--
ALTER TABLE `turnamen_pertanyaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `turnamen_pilihan_jawaban`
--
ALTER TABLE `turnamen_pilihan_jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kisi_kisi`
--
ALTER TABLE `kisi_kisi`
  ADD CONSTRAINT `kisi_kisi_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`);

--
-- Ketidakleluasaan untuk tabel `pencapaianpengguna`
--
ALTER TABLE `pencapaianpengguna`
  ADD CONSTRAINT `pencapaianpengguna_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `pencapaianpengguna_ibfk_2` FOREIGN KEY (`id_pencapaian`) REFERENCES `pencapaian` (`id_pencapaian`);

--
-- Ketidakleluasaan untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD CONSTRAINT `pertanyaan_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`),
  ADD CONSTRAINT `pertanyaan_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Ketidakleluasaan untuk tabel `pesertaturnamen`
--
ALTER TABLE `pesertaturnamen`
  ADD CONSTRAINT `pesertaturnamen_ibfk_1` FOREIGN KEY (`id_turnamen`) REFERENCES `turnamen` (`id_turnamen`),
  ADD CONSTRAINT `pesertaturnamen_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Ketidakleluasaan untuk tabel `pilihanjawaban`
--
ALTER TABLE `pilihanjawaban`
  ADD CONSTRAINT `pilihanjawaban_ibfk_1` FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `progreslevelpengguna`
--
ALTER TABLE `progreslevelpengguna`
  ADD CONSTRAINT `progreslevelpengguna_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `progreslevelpengguna_ibfk_2` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`);

--
-- Ketidakleluasaan untuk tabel `riwayatpertandingan`
--
ALTER TABLE `riwayatpertandingan`
  ADD CONSTRAINT `riwayatpertandingan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `riwayatpertandingan_ibfk_2` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`),
  ADD CONSTRAINT `riwayatpertandingan_ibfk_3` FOREIGN KEY (`id_turnamen`) REFERENCES `turnamen` (`id_turnamen`);

--
-- Ketidakleluasaan untuk tabel `turnamen`
--
ALTER TABLE `turnamen`
  ADD CONSTRAINT `turnamen_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Ketidakleluasaan untuk tabel `turnamen_jawaban_peserta`
--
ALTER TABLE `turnamen_jawaban_peserta`
  ADD CONSTRAINT `turnamen_jawaban_ibfk_1` FOREIGN KEY (`id_peserta`) REFERENCES `pesertaturnamen` (`id_peserta`) ON DELETE CASCADE,
  ADD CONSTRAINT `turnamen_jawaban_ibfk_2` FOREIGN KEY (`id_pertanyaan_turnamen`) REFERENCES `turnamen_pertanyaan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `turnamen_pertanyaan`
--
ALTER TABLE `turnamen_pertanyaan`
  ADD CONSTRAINT `turnamen_pertanyaan_ibfk_1` FOREIGN KEY (`id_turnamen`) REFERENCES `turnamen` (`id_turnamen`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `turnamen_pilihan_jawaban`
--
ALTER TABLE `turnamen_pilihan_jawaban`
  ADD CONSTRAINT `turnamen_pilihan_ibfk_1` FOREIGN KEY (`id_pertanyaan_turnamen`) REFERENCES `turnamen_pertanyaan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
