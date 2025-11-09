-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 28 Okt 2025 pada 16.28
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

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
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kisi_kisi`
--

CREATE TABLE `kisi_kisi` (
  `id_kisi` bigint UNSIGNED NOT NULL,
  `id_level` int NOT NULL,
  `topik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_soal` int NOT NULL,
  `waktu_menit` int NOT NULL,
  `jenis_soal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kisi_kisi`
--

INSERT INTO `kisi_kisi` (`id_kisi`, `id_level`, `topik`, `jumlah_soal`, `waktu_menit`, `jenis_soal`) VALUES
(1, 1, '[\n  {\n    \"nama\": \"Fotosintesis dan Organ Tumbuhan\",\n    \"submateri\": [\"Fungsi daun dalam fotosintesis\", \"Struktur organ tumbuhan\", \"Proses fotosintesis\"]\n  },\n  {\n    \"nama\": \"Peta dan Geografi Dasar\",\n    \"submateri\": [\"Pengertian peta\", \"Skala peta\", \"Simbol dan unsur peta\"]\n  },\n  {\n    \"nama\": \"Ide Pokok Teks Nonfiksi\",\n    \"submateri\": [\"Menentukan ide pokok paragraf\", \"Makna kalimat utama\", \"Isi teks informatif\"]\n  },\n  {\n    \"nama\": \"Operasi Hitung dan Sifat Distributif\",\n    \"submateri\": [\"Sifat distributif perkalian terhadap penjumlahan\", \"Operasi bilangan bulat\", \"Penyederhanaan bentuk aljabar sederhana\"]\n  },\n  {\n    \"nama\": \"Metode Ilmiah\",\n    \"submateri\": [\"Langkah-langkah metode ilmiah\", \"Observasi dan perumusan masalah\", \"Hipotesis dan eksperimen\"]\n  },\n  {\n    \"nama\": \"Letak Geografis dan Astronomis Indonesia\",\n    \"submateri\": [\"Letak astronomis\", \"Letak geografis\", \"Pengaruh letak terhadap iklim\"]\n  },\n  {\n    \"nama\": \"Perubahan Wujud Zat\",\n    \"submateri\": [\"Melepaskan dan menyerap kalor\", \"Menguap, mengembun, membeku, menyublim\", \"Perubahan fisika zat\"]\n  },\n  {\n    \"nama\": \"Iklim dan Musim di Indonesia\",\n    \"submateri\": [\"Penyebab dua musim\", \"Pengaruh angin monsun\", \"Letak geografis terhadap iklim\"]\n  },\n  {\n    \"nama\": \"Tumbuhan Dikotil\",\n    \"submateri\": [\"Ciri-ciri tumbuhan dikotil\", \"Perbedaan monokotil dan dikotil\", \"Struktur akar dan daun\"]\n  },\n  {\n    \"nama\": \"Perubahan Suhu dan Satuan Suhu\",\n    \"submateri\": [\"Kenaikan suhu per waktu\", \"Operasi bilangan positif\", \"Konsep perubahan suhu dalam derajat Celcius\"]\n  },\n  {\n    \"nama\": \"Klasifikasi Hewan\",\n    \"submateri\": [\"Hewan berdarah panas dan dingin\", \"Ciri poikiloterm\", \"Contoh hewan poikiloterm\"]\n  },\n  {\n    \"nama\": \"Persamaan Linear Satu Variabel\",\n    \"submateri\": [\"Konsep PLDV\", \"Langkah menyelesaikan persamaan sederhana\", \"Nilai variabel\"]\n  },\n  {\n    \"nama\": \"Proklamasi Kemerdekaan Indonesia\",\n    \"submateri\": [\"Tokoh proklamasi\", \"Peristiwa proklamasi 17 Agustus 1945\", \"Isi teks proklamasi\"]\n  },\n  {\n    \"nama\": \"Kata Hubung (Konjungsi) Temporal\",\n    \"submateri\": [\"Fungsi konjungsi waktu\", \"Contoh kalimat dengan konjungsi temporal\", \"Makna hubungan waktu\"]\n  },\n  {\n    \"nama\": \"Besaran dan Satuan Listrik\",\n    \"submateri\": [\"Satuan kuat arus listrik (ampere)\", \"Simbol dan alat ukur listrik\", \"Besaran pokok dalam SI\"]\n  },\n  {\n    \"nama\": \"ASEAN dan Negara Anggotanya\",\n    \"submateri\": [\"Negara pendiri ASEAN\", \"Tujuan ASEAN\", \"Kerja sama antarnegara ASEAN\"]\n  },\n  {\n    \"nama\": \"Bangun Datar Persegi\",\n    \"submateri\": [\"Ciri persegi\", \"Rumus keliling dan luas persegi\", \"Satuan panjang dalam cm\"]\n  },\n  {\n    \"nama\": \"Teks Informasi tentang Lingkungan\",\n    \"submateri\": [\"Isi teks deskriptif\", \"Informasi utama dalam teks\", \"Pelestarian lingkungan dan fauna endemik\"]\n  },\n  {\n    \"nama\": \"Interaksi Antar Makhluk Hidup\",\n    \"submateri\": [\"Simbiosis mutualisme, komensalisme, parasitisme\", \"Hubungan antar makhluk hidup\", \"Contoh hubungan saling menguntungkan\"]\n  },\n  {\n    \"nama\": \"Kebutuhan Pokok Manusia\",\n    \"submateri\": [\"Jenis kebutuhan (primer, sekunder, tersier)\", \"Contoh kebutuhan primer\", \"Faktor pemenuhan kebutuhan\"]\n  }\n]\n', 10, 3, 'pilihan_ganda'),
(2, 2, '[\n  {\n    \"nama\": \"Bilangan Bulat dan Eksponen\",\n    \"submateri\": [\"Operasi Hitung Bilangan Bulat\", \"Sifat-Sifat Operasi Bilangan\", \"Perpangkatan Bilangan Bulat\"]\n  },\n  {\n    \"nama\": \"Himpunan\",\n    \"submateri\": [\"Pengertian Himpunan\", \"Komplemen Himpunan\", \"Diagram Venn\"]\n  },\n  {\n    \"nama\": \"Perbandingan\",\n    \"submateri\": [\"Skala\", \"Perbandingan Senilai\", \"Satuan Ukuran (Lusin, Kodi, dll)\"]\n  },\n  {\n    \"nama\": \"Besaran dan Satuan\",\n    \"submateri\": [\"Besaran Pokok dan Turunan\", \"Satuan Internasional\", \"Alat Ukur Fisika\"]\n  },\n  {\n    \"nama\": \"Sistem Pernapasan Manusia\",\n    \"submateri\": [\"Organ Pernapasan\", \"Proses Respirasi\", \"Zat Sisa Metabolisme\"]\n  },\n  {\n    \"nama\": \"Geografi Indonesia\",\n    \"submateri\": [\"Kepadatan Penduduk\", \"Kondisi Geografis Pulau Jawa\", \"Organisasi Regional (ASEAN)\"]\n  },\n  {\n    \"nama\": \"Keanekaragaman Hayati\",\n    \"submateri\": [\"Fauna Tipe Asiatis, Australis, dan Peralihan\", \"Ciri-ciri Hewan Endemik\"]\n  },\n  {\n    \"nama\": \"Bahasa Indonesia – Makna Kata & Ungkapan\",\n    \"submateri\": [\"Kata Bermakna Konotatif\", \"Ungkapan Idiomatik\", \"Pemahaman Teks Naratif\"]\n  },\n  {\n    \"nama\": \"Iklan dan Teks Nonfiksi\",\n    \"submateri\": [\"Ciri-ciri Iklan\", \"Penafsiran Kalimat dalam Iklan\", \"Struktur Teks\"]\n  },\n  {\n    \"nama\": \"Tokoh dan Nilai Keteladanan\",\n    \"submateri\": [\"Biografi Tokoh Nasional\", \"Nilai Karakter dari Perjuangan Tokoh\"]\n  },\n  {\n    \"nama\": \"Rumah Adat dan Budaya Nusantara\",\n    \"submateri\": [\"Rumah Adat Sumatera Barat\", \"Kearifan Lokal\"]\n  },\n  {\n    \"nama\": \"Perubahan Wujud Zat\",\n    \"submateri\": [\"Menguap\", \"Mengembun\", \"Menyublim\", \"Membeku\"]\n  }\n]', 10, 5, 'pilihan_ganda');


-- =====================================
--            kisi-kisi LEVEL 3
-- =====================================
INSERT INTO `kisi_kisi` (`id_kisi`, `id_level`, `topik`, `jumlah_soal`, `waktu_menit`, `jenis_soal`) VALUES
(3, 3, '[
  {
    "nama": "Operasi Hitung Campuran dan Pecahan",
    "submateri": ["Operasi campuran bilangan bulat dan pecahan", "Penerapan sifat distributif", "Penyelesaian soal cerita aritmetika"]
  },
  {
    "nama": "Getaran dan Frekuensi",
    "submateri": ["Pengertian frekuensi dan periode", "Hubungan jumlah getaran dan waktu", "Satuan hertz (Hz)"]
  },
  {
    "nama": "Interaksi Antarwilayah",
    "submateri": ["Faktor saling melengkapi antarwilayah", "Pola distribusi sumber daya", "Keterkaitan ekonomi antar daerah"]
  },
  {
    "nama": "Ide Pokok dan Kalimat Utama Teks",
    "submateri": ["Menentukan ide pokok paragraf", "Kalimat utama dalam teks nonfiksi", "Ciri-ciri paragraf deduktif dan induktif"]
  },
  {
    "nama": "Skala dan Perhitungan Jarak pada Peta",
    "submateri": ["Pengertian skala peta", "Menghitung jarak sebenarnya", "Konversi satuan dari cm ke km"]
  },
  {
    "nama": "Gelombang Bunyi",
    "submateri": ["Jenis gelombang longitudinal dan transversal", "Arah rambat dan getar gelombang", "Contoh gelombang bunyi dalam kehidupan sehari-hari"]
  },
  {
    "nama": "Fungsi Linear Satu Variabel",
    "submateri": ["Bentuk umum f(x) = ax + b", "Menentukan nilai a dan b", "Menghitung nilai fungsi untuk x tertentu"]
  },
  {
    "nama": "Perubahan Sosial Budaya",
    "submateri": ["Jenis perubahan sosial", "Perbedaan evolusi dan revolusi", "Contoh perubahan sosial cepat dalam masyarakat"]
  },
  {
    "nama": "Gelombang dan Panjang Gelombang",
    "submateri": ["Hubungan antara kecepatan, frekuensi, dan panjang gelombang", "Rumus λ = v/f", "Satuan panjang gelombang"]
  },
  {
    "nama": "Produktivitas dan Perbandingan Kerja",
    "submateri": ["Hubungan antara jumlah pekerja, waktu, dan hasil", "Konsep perbandingan terbalik", "Penyelesaian masalah efisiensi kerja"]
  },
  {
    "nama": "Interaksi Sosial dalam Masyarakat",
    "submateri": ["Bentuk interaksi sosial asosiatif dan disosiatif", "Contoh interaksi berupa konflik", "Dampak sosial dari interaksi negatif"]
  },
  {
    "nama": "Teks Biografi Tokoh",
    "submateri": ["Ciri-ciri teks biografi", "Keistimewaan tokoh dalam teks", "Informasi penting dalam biografi"]
  },
  {
    "nama": "Indera Penglihatan dan Proses Pembentukan Bayangan",
    "submateri": ["Bagian-bagian mata dan fungsinya", "Urutan perjalanan cahaya dalam mata", "Peran retina dalam pembentukan bayangan"]
  },
  {
    "nama": "Bunga Tabungan dan Persentase",
    "submateri": ["Rumus bunga tunggal", "Menghitung bunga berdasarkan waktu (bulan/tahun)", "Hubungan antara suku bunga, modal, dan waktu"]
  },
  {
    "nama": "Ekosistem Hutan Mangrove",
    "submateri": ["Fungsi ekologis mangrove", "Habitat dan perlindungan biota laut", "Peranan hutan mangrove terhadap lingkungan pantai"]
  },
  {
    "nama": "Gradien dan Hubungan Antar Garis",
    "submateri": ["Menentukan gradien garis dari persamaan", "Konsep garis sejajar dan tegak lurus", "Hubungan m1 × m2 = -1"]
  },
  {
    "nama": "Cermin Cembung dan Sifat Bayangan",
    "submateri": ["Jenis cermin dan sifat bayangan", "Menggunakan rumus cermin (1/f = 1/s + 1/s’)", "Ciri bayangan maya, tegak, dan diperkecil"]
  },
  {
    "nama": "Konsep Lokasi Geografis",
    "submateri": ["Perbedaan lokasi absolut dan relatif", "Faktor yang memengaruhi lokasi", "Contoh penerapan lokasi relatif dalam kehidupan sehari-hari"]
  },
  {
    "nama": "Konjungsi dan Hubungan Antar Kalimat",
    "submateri": ["Jenis hubungan kalimat (pertentangan, sebab-akibat, waktu)", "Identifikasi kata penghubung pertentangan", "Makna hubungan antar kalimat"]
  },
  {
    "nama": "Bangun Datar Belah Ketupat",
    "submateri": ["Rumus keliling dan luas belah ketupat", "Hubungan antara sisi dan diagonal", "Penerapan teorema Pythagoras dalam belah ketupat"]
  }
]', 10, 5, 'pilihan_ganda');



-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id_level` int NOT NULL,
  `nomor_level` int NOT NULL,
  `tingkat_kesulitan` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id_level`, `nomor_level`, `tingkat_kesulitan`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);


-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_11_062527_add_google_id_to_users_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pencapaian`
--

CREATE TABLE `pencapaian` (
  `id_pencapaian` int NOT NULL,
  `nama_pencapaian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
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
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_pencapaian` int NOT NULL,
  `tanggal_didapat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
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
  `id_pengguna` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('student','teacher') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'student',
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_exp` int DEFAULT '0',
  `deskripsi_profil` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `avatar_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_registrasi` timestamp NULL DEFAULT CURRENT_TIMESTAMP
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
(8, 'brian', 'brian@gmail.com', 'student', '$2y$12$wRr5s9MFTKdYo7FTwhWFxOvhfq.HZO1UEru1q5Fkq6nbAu2MkcSMy', NULL, 0, NULL, NULL, '2025-10-26 05:40:50');



-- --------------------------------------------------------

--
-- Struktur dari tabel `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` int NOT NULL,
  `id_level` int DEFAULT NULL,
  `teks_pertanyaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `untuk_turnamen` tinyint(1) DEFAULT '0',
  `dibuat_oleh` int DEFAULT NULL
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
(25, 2, 'Makna kata eksotis dalam teks tersebut adalah...', 0, NULL),
(26, 2, 'Hasil dari 3^-2 × 3^5 adalah...', 0, NULL),
(27, 2, 'Oksigen yang kita hirup saat bernapas akan digunakan oleh tubuh untuk proses...', 0, NULL),
(28, 2, 'Organisasi negara-negara di kawasan Asia Tenggara adalah...', 0, NULL),
(29, 2, 'Makna ungkapan naik pitam pada kutipan teks tersebut adalah…', 0, NULL),
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
(40, 2, 'Hal yang dapat diteladani dari tokoh B.J. Habibie adalah…', 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesertaturnamen`
--

CREATE TABLE `pesertaturnamen` (
  `id_peserta` int NOT NULL,
  `id_turnamen` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `skor_akhir` int DEFAULT '0',
  `peringkat` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesertaturnamen`
--

INSERT INTO `pesertaturnamen` (`id_peserta`, `id_turnamen`, `id_pengguna`, `skor_akhir`, `peringkat`) VALUES
(1, 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pilihanjawaban`
--

CREATE TABLE `pilihanjawaban` (
  `id_jawaban` int NOT NULL,
  `id_pertanyaan` int NOT NULL,
  `teks_jawaban` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adalah_benar` tinyint(1) NOT NULL DEFAULT '0'
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
(160, 40, 'Melanjutkan SMP dan SMA di Bandung', 0);




-- =========================
-- INSERT UNTUK LEVEL 3
-- =========================
INSERT INTO `pertanyaan` (`id_pertanyaan`, `id_level`, `teks_pertanyaan`, `untuk_turnamen`, `dibuat_oleh`) VALUES
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
(60, 3, 'Luas sebuah belah ketupat yang kelilingnya 40 cm dan panjang salah satu diagonalnya 16 cm adalah...', 0, NULL);

-- =========================
-- PILIHAN JAWABAN LEVEL 3
-- =========================
INSERT INTO `pilihanjawaban` (`id_jawaban`, `id_pertanyaan`, `teks_jawaban`, `adalah_benar`) VALUES
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
(240, 60, '160 cm2', 0);





-- --------------------------------------------------------

--
-- Struktur dari tabel `progreslevelpengguna`
--

CREATE TABLE `progreslevelpengguna` (
  `id_progres` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_level` int NOT NULL,
  `exp` int DEFAULT '0',
  `bintang` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayatpertandingan`
--

CREATE TABLE `riwayatpertandingan` (
  `id_pertandingan` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_level` int DEFAULT NULL,
  `id_turnamen` int DEFAULT NULL,
  `exp_didapat` int NOT NULL,
  `bintang_didapat` int DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayatpertandingan`
--

INSERT INTO `riwayatpertandingan` (`id_pertandingan`, `id_pengguna`, `id_level`, `id_turnamen`, `exp_didapat`, `bintang_didapat`, `waktu_selesai`) VALUES
(1, 1, 1, NULL, 100, 5, '2025-10-09 09:28:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('iSPRWIFJjBLjNqsYBbCmTfhL2J2KTz54gqQ0BG2R', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoia0lpYXpCbnNLWTc5aVZjTXJRUGllTXlQYTJBd1U2cURGS2hPZmlRWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sZXZlbC8zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToicGVuZ2d1bmFfaWQiO2k6NztzOjE3OiJwZW5nZ3VuYV91c2VybmFtZSI7czo1OiJ0b3lpYiI7czoxMzoicGVuZ2d1bmFfcm9sZSI7czo3OiJzdHVkZW50Ijt9', 1761668626);

-- --------------------------------------------------------

--
-- Struktur dari tabel `turnamen`
--

CREATE TABLE `turnamen` (
  `id_turnamen` int NOT NULL,
  `nama_turnamen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_room` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dibuat_oleh` int DEFAULT NULL,
  `level_minimal` int DEFAULT '20',
  `status` enum('Menunggu','Berlangsung','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `turnamen`
--

INSERT INTO `turnamen` (`id_turnamen`, `nama_turnamen`, `kode_room`, `dibuat_oleh`, `level_minimal`, `status`) VALUES
(1, 'Kuis Kemerdekaan', 'MERDEKA', 2, 1, 'Menunggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kisi_kisi`
--
ALTER TABLE `kisi_kisi`
  MODIFY `id_kisi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pencapaian`
--
ALTER TABLE `pencapaian`
  MODIFY `id_pencapaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pencapaianpengguna`
--
ALTER TABLE `pencapaianpengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `pesertaturnamen`
--
ALTER TABLE `pesertaturnamen`
  MODIFY `id_peserta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pilihanjawaban`
--
ALTER TABLE `pilihanjawaban`
  MODIFY `id_jawaban` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT untuk tabel `progreslevelpengguna`
--
ALTER TABLE `progreslevelpengguna`
  MODIFY `id_progres` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `riwayatpertandingan`
--
ALTER TABLE `riwayatpertandingan`
  MODIFY `id_pertandingan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `turnamen`
--
ALTER TABLE `turnamen`
  MODIFY `id_turnamen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kisi_kisi`
--
ALTER TABLE `kisi_kisi`
  ADD CONSTRAINT `kisi_kisi_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
