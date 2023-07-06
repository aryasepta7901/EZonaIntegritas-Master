-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 06, 2023 at 10:51 AM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_221910940`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota_tpi`
--

CREATE TABLE `anggota_tpi` (
  `id` bigint(19) NOT NULL,
  `tpi_id` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_id` bigint(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota_tpi`
--

INSERT INTO `anggota_tpi` (`id`, `tpi_id`, `anggota_id`, `created_at`, `updated_at`) VALUES
(1232132121452023, 'TIM12023WIL3', 123213212145, '2023-07-03 06:56:15', '2023-07-03 06:56:15'),
(1992092620171042023, 'TIM12023WIL2', 199209262017104, '2023-07-03 07:36:57', '2023-07-03 07:36:57'),
(1992092620171122023, 'TIM12023WIL2', 199209262017112, '2023-07-03 07:36:57', '2023-07-03 07:36:57');

-- --------------------------------------------------------

--
-- Table structure for table `desk_evaluation`
--

CREATE TABLE `desk_evaluation` (
  `id` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rekapitulasi_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban_at` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_at` text COLLATE utf8mb4_unicode_ci,
  `nilai_at` double(6,2) DEFAULT NULL,
  `jawaban_kt` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_kt` text COLLATE utf8mb4_unicode_ci,
  `nilai_kt` double(6,2) DEFAULT NULL,
  `jawaban_dl` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_dl` text COLLATE utf8mb4_unicode_ci,
  `nilai_dl` double(6,2) DEFAULT NULL,
  `pengawasan_id` bigint(19) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_kt` int(11) NOT NULL DEFAULT '0',
  `updated_dl` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokumenlke`
--

CREATE TABLE `dokumenlke` (
  `id` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan_id` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumenlke`
--

INSERT INTO `dokumenlke` (`id`, `dokumen`, `pertanyaan_id`, `created_at`, `updated_at`) VALUES
('PPA1A1', 'SK Tim Kerja Pembangunan ZI menuju WBK/WBBM;', 'PPA1A', '2023-06-20 00:51:53', '2023-06-20 00:51:53'),
('PPA1A2', 'Undangan dan daftar hadir rapat pembentukan Tim Kerja;', 'PPA1A', '2023-06-20 00:51:53', '2023-06-20 00:51:53'),
('PPA1A3', 'Notulen/laporan pelaksanaan rapat pembentukan Tim Kerja', 'PPA1A', '2023-06-20 00:51:53', '2023-06-20 00:51:53'),
('PPA1B1', ' Notulen/laporan pelaksanaan rapat pembentukan Tim Kerja;', 'PPA1B', NULL, NULL),
('PPA1B2', ' Mekanisme yang menjelaskan tata cara pemilihan anggota Tim', 'PPA1B', NULL, NULL),
('PPA1B3', ' Kertas kerja penentuan anggota Tim Kerja', 'PPA1B', NULL, NULL),
('PPA2A1', ' Undangan, daftar hadir, dan dokumentasi rapat penyusunan dokumen rencana pembangunan ZI;', 'PPA2A', NULL, NULL),
('PPA2A2', ' Notulen/laporan pelaksanaan penyusunan rencana pembangunan ZI;', 'PPA2A', NULL, NULL),
('PPA2A3', ' Dokumen perencanaan, pembangunan, dan pengembangan ZI;', 'PPA2A', NULL, NULL),
('PPA2A4', ' Dokumen rencana aksi yang memuat target prioritas', 'PPA2A', NULL, NULL),
('PPA2B1', ' Laporan pelaksanaan penyusunan target prioritas ZI;', 'PPA2B', NULL, NULL),
('PPA2B2', ' Dokumen rencana aksi yang memuat target prioritas;', 'PPA2B', NULL, NULL),
('PPA2B3', ' SK tentang rencana pembangunan ZI dan target prioritas', 'PPA2B', NULL, NULL),
('PPA2C1', ' Screen Capture website, media sosial, ataupun foto kegiatan terkait;', 'PPA2C', NULL, NULL),
('PPA2C2', ' Laporan pelaksanaan sosialisasi', 'PPA2C', NULL, NULL),
('PPA3A1', ' Laporan pelaksanaan rencana aksi oleh Tim Kerja;', 'PPA3A', NULL, NULL),
('PPA3A2', ' Undangan, daftar hadir, dan notulen rapat evaluasi;', 'PPA3A', NULL, NULL),
('PPA3A3', ' Dokumentasi pelaksanaan rencana aksi', 'PPA3A', NULL, NULL),
('PPA3B1', ' Laporan monitoring dan evaluasi pelaksanaan kegiatan;', 'PPA3B', NULL, NULL),
('PPA3B2', ' Undangan, daftar hadir, dan notulen pelaksanaan rapat evaluasi', 'PPA3B', NULL, NULL),
('PPA3C1', ' Notulen/laporan monitoring dan evaluasi yang memuat rekomendasi;', 'PPA3C', NULL, NULL),
('PPA3C2', ' Laporan hasil tindak lanjut rekomendasi;', 'PPA3C', NULL, NULL),
('PPA3C3', ' Dokumentasi pelaksanaan tindak lanjut', 'PPA3C', NULL, NULL),
('PPA4A1', ' Absensi pimpinan satker/pejabat struktural;', 'PPA4A', NULL, NULL),
('PPA4A2', ' Dokumentasi kegiatan kerja sama, pelayanan & pegabdian kepada masyarakat, ataupun press release terkait pembangunan ZI yang dilakukan oleh pimpinan satker/pejabat struktural', 'PPA4A', NULL, NULL),
('PPA4B1', ' SK Agen Perubahan', 'PPA4B', NULL, NULL),
('PPA4B2', ' Undangan, daftar hadir, dan notulen pelaksanaan rapat pembentukan agen perubahan', 'PPA4B', NULL, NULL),
('PPA4C1', ' Notulen/laporan pelaksanaan kegiatan penerapan budaya kerja (mis. program reward & punishment);', 'PPA4C', NULL, NULL),
('PPA4C2', ' dokumentasi pelaksanaan kegiatan;', 'PPA4C', NULL, NULL),
('PPA4C3', ' Absensi pegawai', 'PPA4C', NULL, NULL),
('PPA4D1', ' Dokumen pakta integritas;', 'PPA4D', NULL, NULL),
('PPA4D2', ' Laporan pelaksanaan kegiatan Pembangunan ZI;', 'PPA4D', NULL, NULL),
('PPA4D3', ' Dokumentasi pelaksanaan kegiatan', 'PPA4D', NULL, NULL),
('PPB1A1', ' Peta proses bisnis utama instansi (BPS Pusat)', 'PPB1A', NULL, NULL),
('PPB1A2', ' SOP yang mengacu pada proses bisnis instansi, SOP yang ada pada tiap bidang/bagian, selain itu mengacu pada pengawasan dan pelayanan', 'PPB1A', NULL, NULL),
('PPB1A3', ' SOP Inovasi unit kerja', 'PPB1A', NULL, NULL),
('PPB1B1', ' Memorandum pelaksanaan tugas sesuai SOP pada tiap penugasan', 'PPB1B', NULL, NULL),
('PPB1B2', ' Laporan kegiatan-kegiatan dicantumkan bahwa pelaksanaan sesuai SOP', 'PPB1B', NULL, NULL),
('PPB1B3', ' Bukti rapat evaluasi suatu kegiatan sekaligus membahas penerapan SOP-nya (disebut dalam notulen)', 'PPB1B', NULL, NULL),
('PPB1B4', ' Bukti dukung yang disebutkan dalam SOP terkait', 'PPB1B', NULL, NULL),
('PPB1C1', ' Bukti pelaksanaan rapat evaluasi atas SOP, misalnya undangan, daftar hadir, notulen', 'PPB1C', NULL, NULL),
('PPB1C2', ' Bukti tindak lanjut atas hasil evaluasi rapat, misal progres perbaikan SOP', 'PPB1C', NULL, NULL),
('PPB1C3', ' Laporan evaluasi pelaksanaan SOP, dapat dibuat secara periodik sebagai hasil pelaksanaan rapat evaluasi SOP', 'PPB1C', NULL, NULL),
('PPB1C4', ' Dokumen SOP awal dan SOP perbaikan', 'PPB1C', NULL, NULL),
('PPB2A1', ' Aplikasi terkait pengukuran kinerja dan sudah berjalan', 'PPB2A', NULL, NULL),
('PPB2B1', ' Aplikasi terkait manajemen SDM dan sudah berjalan', 'PPB2B', NULL, NULL),
('PPB2C1', ' Aplikasi terkait pelayanan publik dan sudah berjalan', 'PPB2C', NULL, NULL),
('PPB2C2', ' memuat panduan kejelasan prosedur,waktu dan biaya serta mekanisme pengaduan', 'PPB2C', NULL, NULL),
('PPB2C3', ' Screen capture website, media sosial, ataupun aplikasi.', 'PPB2C', NULL, NULL),
('PPB2D1', ' Bukti pelaksanaan rapat evaluasi penggunaan TI, misalnya undangan, daftar hadir, notulen', 'PPB2D', NULL, NULL),
('PPB2D2', ' Bukti tindak lanjut atas hasil evaluasi rapat tersebut, misal progres perbaikan TI', 'PPB2D', NULL, NULL),
('PPB2D3', ' Laporan monitoring dan evaluasi pemanfaatan TI, dapat dibuat secara periodik', 'PPB2D', NULL, NULL),
('PPB3A1', ' Kebijakan KIP, yang memuat minimal: - apa saja yang perlu diketahui masyarakat, baik berupa produk BPS atau transparansi pelaksanaan kepemerintahan,- kapan hal-hal di atas di-update dan siapa yang berwenang,- hal terkait pengaduan apabila ada keluhan dal', 'PPB3A', NULL, NULL),
('PPB3A2', ' Bukti foto/gambar/screenshot atas pelaksanaan KIP yang telah berjalan', 'PPB3A', NULL, NULL),
('PPB3A3', ' SK/ST/SOP yang menunjukkan penanggung jawab kegiatan dan uraian tugas ', 'PPB3A', NULL, NULL),
('PPB3B1', ' Bukti rapat evaluasi pelaksanaan KIP, misalnya undangan, daftar hadir, notulen', 'PPB3B', NULL, NULL),
('PPB3B2', ' Bukti tindak lanjut atas hasil evaluasi rapat tersebut, misal progres perbaikan yang dilakukan, dll', 'PPB3B', NULL, NULL),
('PPB3B3', ' Laporan monitoring dan evaluasi pelaksanaan KIP, dapat dibuat secara periodik', 'PPB3B', NULL, NULL),
('PPB3B4', ' Screenshot website atas pengumuman layanan informasi tahunan', 'PPB3B', NULL, NULL),
('PPC1A1', ' Dokumen Rencana Kebutuhan Pegawai yang berbasis pada peta jabatan dan hasil analisis beban kerjanya', 'PPC1A', NULL, NULL),
('PPC1A2', ' Undangan, notula, daftar hadir, dan dokumentasi rapat penentuan kebutuhan pegawai ', 'PPC1A', NULL, NULL),
('PPC1A3', ' Surat usulan kebutuhan pegawai', 'PPC1A', NULL, NULL),
('PPC1B1', ' Bukti rotasi pegawai, dapat berupa SK', 'PPC1B', NULL, NULL),
('PPC1B2', ' Bukti usulan pengajuan pegawai baru', 'PPC1B', NULL, NULL),
('PPC1B3', ' Perka BPS tentang ABK', 'PPC1B', NULL, NULL),
('PPC1B4', ' SK kolektif atas penempatan pegawai hasil rekrutmen', 'PPC1B', NULL, NULL),
('PPC1B5', ' Surat pengantar penempatan pegawai dari BPS Provinsi ke BPS Kab/Kota', 'PPC1B', NULL, NULL),
('PPC1B6', ' Surat perintah melaksanakn tugas dari kepala unit kerja', 'PPC1B', NULL, NULL),
('PPC1C1', ' Laporan monitoring dan evaluasi penempatan pegawai (dievaluasi juga peningkatan kinerjany;', 'PPC1C', NULL, NULL),
('PPC1C2', ' Undangan, daftar hadir, dan notulen pelaksanaan rapat evaluasi', 'PPC1C', NULL, NULL),
('PPC1C3', ' Dokumen monev kinerja pegawai baru terhadap kinerja unit', 'PPC1C', NULL, NULL),
('PPC2A1', ' Undangan, notula, daftar hadir, dan foto rapat mutasi internal', 'PPC2A', NULL, NULL),
('PPC2A2', ' Surat usulan mutasi;', 'PPC2A', NULL, NULL),
('PPC2A3', ' SK mutasi/rotasi internal;', 'PPC2A', NULL, NULL),
('PPC2A4', ' DRH (Daftar Riwayat Hidup) yang memuat riwayat pendidikan/diklat/bimtek/Pengembangan karir lainnya milik pegawai yang dilakukan mutasi.', 'PPC2A', NULL, NULL),
('PPC2B1', ' Dokumen mutasi pegawai (SK)', 'PPC2B', NULL, NULL),
('PPC2B2', ' Dokumen pola dasar untuk mutasi', 'PPC2B', NULL, NULL),
('PPC2B3', ' Daftar pegawai dengan kompetensinya masing-masing', 'PPC2B', NULL, NULL),
('PPC2B4', ' Undangan, notula, daftar hadir, dan dokumentasi pelaksanaan rapat mutasi internal', 'PPC2B', NULL, NULL),
('PPC2B5', ' SK dan surat usulan mutasi internal', 'PPC2B', NULL, NULL),
('PPC2B6', ' Riwayat pendidikan/diklat/bimtek pegawai yang akan atau telah dimutasi', 'PPC2B', NULL, NULL),
('PPC2B7', ' Kertas kerja/laporan yang memuat pertimbangan unit kerja untuk melakukan mutasi internal', 'PPC2B', NULL, NULL),
('PPC2C1', ' Laporan monitoring dan evaluasi mutasi pegawai(dievaluasi juga peningkatan kinerjany;', 'PPC2C', NULL, NULL),
('PPC2C2', ' Undangan, daftar hadir, dan notulen pelaksanaan rapat evaluasi', 'PPC2C', NULL, NULL),
('PPC3A1', ' Undangan, notula, daftar hadir, dan dokumentasi rapat penyusunan training need analysis pegawai', 'PPC3A', NULL, NULL),
('PPC3A2', ' Dokumen Analisa kebutuha diklat/bimtek/ pengembangan pegawai (Training Need Analysis).', 'PPC3A', NULL, NULL),
('PPC3B1', ' Dokumen Rencana Pengembangan Kompetensi Pegawai yang berbasis pada hasil pengelolaan kinerja pegawai', 'PPC3B', NULL, NULL),
('PPC3B2', ' Undangan, notula, daftar hadir, dan dokumentasi penyusunan rencana pengembangan kompetensi pegawai', 'PPC3B', NULL, NULL),
('PPC3C1', ' Laporan mengenai kesenjangan kompetensi pegawai dengan standar kompetensi yang ditetapkan', 'PPC3C', NULL, NULL),
('PPC3D1', ' Dokumen Kebijakan pengembangan kompetensi pegawai', 'PPC3D', NULL, NULL),
('PPC3D2', ' Undangan diklat/pelatihan yang lain dan usulan pengajuannya (pada tahun yang relevan)', 'PPC3D', NULL, NULL),
('PPC3D3', ' surat kepada pegawai perihal kesempatan mengikuti diklat/pengembangan kompetensi lainnya.', 'PPC3D', NULL, NULL),
('PPC3E1', ' Dokumen Kebijakan pengembangan kompetensi pegawai', 'PPC3E', NULL, NULL),
('PPC3E2', ' Undangan diklat/pelatihan yang lain dan usulan pengajuannya (pada tahun yang relevan)', 'PPC3E', NULL, NULL),
('PPC3E3', ' Laporan pelaksanaan kegiatan training yang diselenggarakan oleh unit kerja dan POK terkait', 'PPC3E', NULL, NULL),
('PPC3E4', ' Sertifikat atau bukti keikutsertaan pengembangan kompetensi lainnya oleh pegawai ybs jika tidak menggunakan dana unit kerja', 'PPC3E', NULL, NULL),
('PPC3F1', ' Laporan monitoring dan evaluasi hasil pengembangan kompetensi pegawai (dievaluasi juga peningkatan kinerjany;', 'PPC3F', NULL, NULL),
('PPC3F2', ' Undangan, daftar hadir, dan notulen pelaksanaan rapat evaluasi', 'PPC3F', NULL, NULL),
('PPC4A1', ' SKP Semester 2 2021 dan Semester 1 2022 pegawai yang disetujui dan ditandatangani oleh atasan langsungnya', 'PPC4A', NULL, NULL),
('PPC4A2', ' IKI', 'PPC4A', NULL, NULL),
('PPC4A3', ' PK yang disetujui dan ditandatangani oleh atasan', 'PPC4A', NULL, NULL),
('PPC4A4', ' RENSTRA', 'PPC4A', NULL, NULL),
('PPC4B1', ' SKP pegawai secara berjenjang', 'PPC4B', NULL, NULL),
('PPC4C1', ' Dokumen pengukuran kinerja setiap level per bulan', 'PPC4C', NULL, NULL),
('PPC4D1', ' Undangan, daftar hadir, notulen, dan dokumentasi rapat penentuan pemberian reward pada pegawai', 'PPC4D', NULL, NULL),
('PPC4D2', ' Dokumen reward pegawai, dapat berupa pengembangan karir, pemberian penghargaan, dll', 'PPC4D', NULL, NULL),
('PPC4D3', ' SK pemberian reward pegawai', 'PPC4D', NULL, NULL),
('PPC5A1', ' Peraturan disiplin/kode etik, dll (internal)', 'PPC5A', NULL, NULL),
('PPC5A2', ' Laporan pelaksanaan penerapan peraturan di atas', 'PPC5A', NULL, NULL),
('PPC5A3', ' Laporan/dokumentasi pelaksanaan sosialisasi aturan disiplin/kode etik/kode perilaku', 'PPC5A', NULL, NULL),
('PPC5A4', ' Laporan /dokumentasi penerapan dan penegakan hukuman atas pelanggaran aturan disiplin/kode etik/kode perilaku', 'PPC5A', NULL, NULL),
('PPC6A1', ' Laporan pemutakhiran data informasi kepegawaian (bulanan) melalui aplikasi SIMPEG', 'PPC6A', NULL, NULL),
('PPC6A2', ' Screenshot pelaksanaan update data secara mandiri oleh masing-masing pegawai melalui aplikasi SIMPEG', 'PPC6A', NULL, NULL),
('PPD1A1', ' Undangan, notula, daftar hadir, foto rapat perencanaan kegiatan dan anggaran;', 'PPD1A', NULL, NULL),
('PPD1A2', ' Dokumen perencanaan kegiatan dan anggaran.', 'PPD1A', NULL, NULL),
('PPD1B1', ' Undangan, notula, daftar hadir, foto rapat penyusunan penetapan kinerja;', 'PPD1B', NULL, NULL),
('PPD1B2', ' Dokumen Perjanjian Kinerja (PK).', 'PPD1B', NULL, NULL),
('PPD1C1', ' Undangan, notula, daftar hadir, foto rapat monitoring capaian kinerja;', 'PPD1C', NULL, NULL),
('PPD1C2', ' Dokumen FRA.', 'PPD1C', NULL, NULL),
('PPD2A1', ' Rencana Strategis (Renstra)', 'PPD2A', NULL, NULL),
('PPD2A2', ' Penetapan Kinerja (Perjanjian Kinerja)', 'PPD2A', NULL, NULL),
('PPD2B1', ' Dokumen PK (Perjanjian Kinerj', 'PPD2B', NULL, NULL),
('PPD2C1', ' Dokumen IKU', 'PPD2C', NULL, NULL),
('PPD2D1', ' Dokumen IKU', 'PPD2D', NULL, NULL),
('PPD2E1', ' Dokumen LAKIN yang disahkan pimpinan secara tepat waktu dan screenshoot bukti unggah ke SiMonev secara tepat waktu.', 'PPD2E', NULL, NULL),
('PPD2F1', ' Laporan Kinerja Instansi Pemerintah (LKIP) yang memuat infomasi kinerja', 'PPD2F', NULL, NULL),
('PPD2G1', ' SK Tim pengumpulan data kinerja', 'PPD2G', NULL, NULL),
('PPD2G2', ' Sertifikat diklat/ laporan pelaksanaan diklat/workshop', 'PPD2G', NULL, NULL),
('PPD2H1', ' Dokumen Laporan bimtek/diklat/sosialisasi penyusunan LAKIN.', 'PPD2H', NULL, NULL),
('PPE1A1', ' Dokumentasi atau screenshoot banner/spanduk/media public campaign lainnya', 'PPE1A', NULL, NULL),
('PPE1A2', ' Dokumen sosialisai larangan gratifikasi dalam rapat internal maupun eksternal (undangan, notulen, daftar hadir)', 'PPE1A', NULL, NULL),
('PPE1B1', ' SK terkait unit pengendalian gratifikasi (UPG)', 'PPE1B', NULL, NULL),
('PPE1B2', ' Mekanisme atau rencana aksi pengendalian', 'PPE1B', NULL, NULL),
('PPE1B3', ' Laporan kegiatan dari tim UPG', 'PPE1B', NULL, NULL),
('PPE2A1', ' Dokumen sosialisasi SPIP', 'PPE2A', NULL, NULL),
('PPE2A2', ' SK tim SPIP', 'PPE2A', NULL, NULL),
('PPE2A3', ' Dokumen laporan penyelenggaraan SPIP', 'PPE2A', NULL, NULL),
('PPE2B1', ' Dokumen identifikasi risiko dan dokumen penilaian risiko', 'PPE2B', NULL, NULL),
('PPE2C1', ' Dokumen laporan atau rencana aksi kegiatan pengendalian risiko', 'PPE2C', NULL, NULL),
('PPE2D1', ' Dokumentasi pelaksanaan internaliasi baik secara daring maupun luring (undangan, daftar hadir, notulen, dan naskah paparan)', 'PPE2D', NULL, NULL),
('PPE3A1', ' SK petugas Pengaduan Masyarakat;', 'PPE3A', NULL, NULL),
('PPE3A2', ' Dokumentasi kotak khusus Pengaduan Masyarakat;', 'PPE3A', NULL, NULL),
('PPE3A3', ' Dokumentasi spanduk/banner/flyer informasi sarana penyampaian pengaduan.', 'PPE3A', NULL, NULL),
('PPE3A4', ' Screenshot pengelolaan pengaduan melalui berbagai media', 'PPE3A', NULL, NULL),
('PPE3B1', ' Dokumentasi respon pengaduan masyarakat', 'PPE3B', NULL, NULL),
('PPE3B2', ' Dokumentasi penyampaian pengaduan masyarakat kepada bagian terkait', 'PPE3B', NULL, NULL),
('PPE3B3', ' Laporan pengaduan secara berkala.', 'PPE3B', NULL, NULL),
('PPE3C1', ' Dokumentasi pelaksanaan rapat evaluasi dan monitoring (undangan, daftar hadir, notulen);', 'PPE3C', NULL, NULL),
('PPE3C2', ' Laporan monitoring dan evaluasi laporan pengaduan', 'PPE3C', NULL, NULL),
('PPE3D1', ' Dokumen pelaksanaan rencana aksi tindak lanjut atas monitoring dan evaluasi laporan pengaduan', 'PPE3D', NULL, NULL),
('PPE4A1', ' Screenshoot aplikasi Whistle Blowing System', 'PPE4A', NULL, NULL),
('PPE4A2', ' Dokumentasi spanduk/banner/flyer informasi sarana penyampaian WBS', 'PPE4A', NULL, NULL),
('PPE4B1', 'Dokumen laporan hasil evaluasi atas penerapan Whistle Blowing System dari Inspektorat Utama', 'PPE4B', NULL, NULL),
('PPE4C1', ' Dokumen laporan tindak lanjut hasil evaluasi atas penerapan Whistle Blowing System dari Inspektorat Utama', 'PPE4C', NULL, NULL),
('PPE5A1', ' Dokumen identifikasi/pemetaan benturan kepentingan dalam tugas fungsi Utama;', 'PPE5A', NULL, NULL),
('PPE5A2', ' Perka BPS Nomor 6 Tahun 2015 tentang Pedoman Penanganan Benturan Kepentingan di Lingkungan Badan Pusat Statistik', 'PPE5A', NULL, NULL),
('PPE5B1', ' Dokumentasi dan capture internalisasi penanganan benturan kepentingan, antara lain:- rapat (undangan, daftar hadir, notulen, foto),- bimtek (laporan, foto),- apel pagi/sore (foto, teks arahan pimpinan)', 'PPE5B', NULL, NULL),
('PPE5C1', ' Dokumen surat pernyataan bebas dari benturan kepentingan', 'PPE5C', NULL, NULL),
('PPE5D1', ' Dokumen laporan evaluasi atas penanganan benturan kepentingan', 'PPE5D', NULL, NULL),
('PPE5E1', ' Dokumen laporan tindak lanjut atas penanganan benturan kepentingan', 'PPE5E', NULL, NULL),
('PPF1A1', ' Dokumen standar pelayanan', 'PPF1A', NULL, NULL),
('PPF1B1', ' Dokumen maklumat standar pelayanan', 'PPF1B', NULL, NULL),
('PPF1B2', ' Capture/foto maklumat standar pelayanan di tempat pelayanan, website, dan media lainnya', 'PPF1B', NULL, NULL),
('PPF1C1', ' Dokumen reviu standar pelayanan yang dilakukan dengan melibatkan stakeholders serta memanfaatkan masukan hasil SKM dan pengaduan masyarakat', 'PPF1C', NULL, NULL),
('PPF1C2', ' Dokumen tindak lanjut atas reviu berupa perbaikan standar pelayanan ', 'PPF1C', NULL, NULL),
('PPF1D1', ' Dokumen maklumat standar pelayanan', 'PPF1D', NULL, NULL),
('PPF1D2', ' Capture/foto maklumat standar pelayanan di tempat pelayanan, website, dan media lainnya', 'PPF1D', NULL, NULL),
('PPF2A1', ' Dokumen sosialisasi/pelatihan pelayanan prima kepada pegawai, antara lain:- rapat (undangan, daftar hadir, notulen),- sosialisasi/pelatihan/bimtek (laporan dan materi),dll', 'PPF2A', NULL, NULL),
('PPF2A2', ' Dokumen yang menunjukkan bahwa sosialisasi/pelatihan diakukan secara berkelanjutan dan terjadwal', 'PPF2A', NULL, NULL),
('PPF2B1', ' Capture sarana informasi tentang pelayanan yang disediakan pada berbagai media termasuk pada SIPPN', 'PPF2B', NULL, NULL),
('PPF2C1', ' Dokumen sistem reward and punishment yang minimal memenuhi unsur penilaian disiplin, kinerja, dan hasil penilaian pengguna layanan', 'PPF2C', NULL, NULL),
('PPF2C2', ' Dokumen penghargaan atas pelaksanaan pelayanan yang baik dan punishment untuk sebaliknya', 'PPF2C', NULL, NULL),
('PPF2D1', ' Dokumen sistem pemberian kompensasi', 'PPF2D', NULL, NULL),
('PPF2D2', ' Dokumen kompensasi kepada penerima layanan', 'PPF2D', NULL, NULL),
('PPF2E1', ' Dokumentasi/screenshoot aplikasi layanan PST.', 'PPF2E', NULL, NULL),
('PPF2F1', ' Dokumentasi/screenshot inovasi pada pelayanan.', 'PPF2F', NULL, NULL),
('PPF3A1', ' Screenshoot profil instansi BPS pada lapor.go.id', 'PPF3A', NULL, NULL),
('PPF3A2', ' Dokumentasi akses admin SP4N-LAPOR!', 'PPF3A', NULL, NULL),
('PPF3A3', ' Dokumentasi laporan dari kotak pengaduan ataupun media lainnya', 'PPF3A', NULL, NULL),
('PPF3B1', ' Dokumentasi akses admin SP4N-LAPOR!', 'PPF3B', NULL, NULL),
('PPF3B2', ' Surat Keputusan pengelola SP4N-LAPOR! di level unit kerja', 'PPF3B', NULL, NULL),
('PPF3B3', ' Surat penugasan pengelola SP4N-LAPOR! di level unit kerja', 'PPF3B', NULL, NULL),
('PPF3C1', ' Dokumen laporan evaluasi atas penanganan keluhan/masukan dan konsultasi', 'PPF3C', NULL, NULL),
('PPF4A1', ' Dokumen laporan survei kepuasan masyarakat terhadap pelayanan', 'PPF4A', NULL, NULL),
('PPF4A2', ' Hasil penilaian Three Color Survey/Rating Survey', 'PPF4A', NULL, NULL),
('PPF4B1', ' Screenshot dan foto/dokumentasi media informasi pengumuman hasil survei kepuasan masyarakat', 'PPF4B', NULL, NULL),
('PPF4C1', ' Dokumen laporan perbaikan pelayanan sebagai tindak lanjut dari hasil survei kepuasan masyarakat', 'PPF4C', NULL, NULL),
('PPF5A1', ' Aplikasi terkait pelayanan publik dan sudah berjalan', 'PPF5A', NULL, NULL),
('PPF5A2', ' Memuat panduan kejelasan prosedur,waktu dan biaya serta mekanisme pengaduan', 'PPF5A', NULL, NULL),
('PPF5A3', ' Screen capture website, media sosial, ataupun aplikasi.', 'PPF5A', NULL, NULL),
('PPF5A4', ' Laporan penerapan teknologi informasi terhadap layanan publik yang diterbikan oleh kepala satuan kerja dan berisi informasi penerapan teknologi informasi terhadap seluruh layanan yang diselenggarakan oleh satuan kerja.', 'PPF5A', NULL, NULL),
('PPF5B1', ' Dokumentasi/screenshot aplikasi layanan publik yang terintegrasi', 'PPF5B', NULL, NULL),
('PPF5C1', ' Dokumen/Laporan evaluasi penerapan teknologi informasi pada pelayanan publik dan ditandatangani oleh kepala satuan kerja yang berisi informasi terkait dengan perbaikan atau pengembangan aplikasi yang dilakukan secara berkala.', 'PPF5C', NULL, NULL),
('PRA1A1', ' SK Agen Perubahan', 'PRA1A', NULL, NULL),
('PRA1A2', ' KAK', 'PRA1A', NULL, NULL),
('PRA1B1', ' Notulen/laporan/evaluasi', 'PRA1B', NULL, NULL),
('PRA1B2', ' Dokumen proyek perubahan', 'PRA1B', NULL, NULL),
('PRA1B3', ' Dokumentasi penerapan proyek perubahan dalam sistem manajemen', 'PRA1B', NULL, NULL),
('PRA2A1', ' Dokumen pelaksanaan pembangunan ZI', 'PRA2A', NULL, NULL),
('PRA2A2', ' Dokumen rencana aksi', 'PRA2A', NULL, NULL),
('PRA2A3', ' Dokumen Penghargaan', 'PRA2A', NULL, NULL),
('PRA3A1', ' undangan, daftar hadir, dan dokumentasi internalisasi', 'PRA3A', NULL, NULL),
('PRA3A2', ' SOP', 'PRA3A', NULL, NULL),
('PRB1A1', ' Peta proses bisnis utama instansi (BPS Pusat)', 'PRB1A', NULL, NULL),
('PRB1A2', ' SOP yang mengacu pada proses bisnis instansi, SOP yang ada pada tiap bidang/bagian, selain itu mengacu pada pengawasan dan pelayanan', 'PRB1A', NULL, NULL),
('PRB2A1', ' Dokumen implementasi SPBE', 'PRB2A', NULL, NULL),
('PRB2A2', ' Dokumen monitoring dan evaluasi SPBE', 'PRB2A', NULL, NULL),
('PRB2B1', ' Dokumen implementasi SPBE', 'PRB2B', NULL, NULL),
('PRB2B2', ' Dokumen monitoring dan evaluasi SPBE', 'PRB2B', NULL, NULL),
('PRB3A1', ' Screen shoot aplikasi atau inovasi satuan kerja', 'PRB3A', NULL, NULL),
('PRB3A2', ' Dokumen monitoring dan evaluasi', 'PRB3A', NULL, NULL),
('PRB3B1', ' Screen shoot aplikasi atau inovasi satuan kerja', 'PRB3B', NULL, NULL),
('PRB3B2', ' Dokumen monitoring dan evaluasi', 'PRB3B', NULL, NULL),
('PRB3C1', ' Screen shoot aplikasi atau inovasi satuan kerja', 'PRB3C', NULL, NULL),
('PRB3C2', ' Dokumen monitoring dan evaluasi', 'PRB3C', NULL, NULL),
('PRC1A1', ' SK Indikator Kinerja Individu (IKI),', 'PRC1A', NULL, NULL),
('PRC1A2', ' SKP 2021 (format baru)', 'PRC1A', NULL, NULL),
('PRC2A1', ' laporan Hasil Assessment', 'PRC2A', NULL, NULL),
('PRC3A1', ' SK Hukuman Disiplin', 'PRC3A', NULL, NULL),
('PRC3A2', ' Laporan Penanganan Pelanggaran Disiplin Pegawai', 'PRC3A', NULL, NULL),
('PRD1A1', ' Dokumen LAKIN 2021', 'PRD1A', NULL, NULL),
('PRD2A1', 'Dokumen Perjanjian Kinerja (PK);', 'PRD2A', NULL, NULL),
('PRD2A2', ' Dokumen Indikator Kinerja Individu;', 'PRD2A', NULL, NULL),
('PRD2A3', ' Dokumen FRA;', 'PRD2A', NULL, NULL),
('PRD2A4', ' Kertas Kerja Penilaian Kinerja;', 'PRD2A', NULL, NULL),
('PRD2A5', ' Bukti dukung dokumentasi pemberian reward and punishment (Sertifikat, SK, dan/atau dokumentasi penyerahan).', 'PRD2A', NULL, NULL),
('PRD3A1', ' IKU;', 'PRD3A', NULL, NULL),
('PRD3A2', ' PK;', 'PRD3A', NULL, NULL),
('PRD3A3', ' IKI.', 'PRD3A', NULL, NULL),
('PRE1A1', ' Dokumen/Formulir pelaksanaan manajemen risiko;', 'PRE1A', NULL, NULL),
('PRE1A2', ' Dokumen/Formulir pelaksanaan SPIP;', 'PRE1A', NULL, NULL),
('PRE2A1', ' Dokumen laporan Jumlah pengaduan masyarakat yang harus ditindaklanjuti;', 'PRE2A', NULL, NULL),
('PRE2A2', ' Dokumen laporan Jumlah pengaduan masyarakat yang sedang diproses;', 'PRE2A', NULL, NULL),
('PRE2A3', ' Dokumen laporan Jumlah pengaduan masyarakat yang selesai ditindaklanjuti.', 'PRE2A', NULL, NULL),
('PRE3A1', 'Laporan monitoring LHKPN dari Inspektorat Utama', 'PRE3A', NULL, NULL),
('PRE3B1', 'Laporan monitoring LHKASN dari Inspektorat Utama', 'PRE3B', NULL, NULL),
('PRF1A1', 'Laporan penerapan inovasi layanan publik pada seluruh jenis layanan yang diselenggarakan satker;', 'PRF1A', NULL, NULL),
('PRF1A2', 'Inovasi layanan atau pengembangan layanan terhadap seluruh jenis layanan yang diselenggarakan seluruh satker;', 'PRF1A', NULL, NULL),
('PRF1A3', 'Impact dari penerapan inovasi tersebut berupa layanan lebih mudah dan cepat (before/after) serta mampu mencegah isu strategis, mencegah terjadinya risiko fraud, mendorong capaian kinerja utama, penguatan integritas, dan sesuai dengan kebutuhan pengguna la', 'PRF1A', NULL, NULL),
('PRF1B1', ' Jumlah perijinan/pelayanan yang terdata/terdaftar sesuai dengan Standar Pelayanan Publik;', 'PRF1B', NULL, NULL),
('PRF1B2', ' Hasil analisis survei kebutuhan data/survei kepuasan masyarakat.', 'PRF1B', NULL, NULL),
('PRF2A1', ' SK tim pengelola pengaduan', 'PRF2A', NULL, NULL),
('PRF2A2', ' Capture media layanan pengaduan seperti sarana pengaduan offline, WA, media sosial, atau email pengaduan', 'PRF2A', NULL, NULL),
('PRF2A3', ' Laporan monitoring, evaluasi, dan tindak lanjut penanganan pengaduan', 'PRF2A', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inputfield`
--

CREATE TABLE `inputfield` (
  `id` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_sa` double(6,2) DEFAULT NULL,
  `input_at` double(6,2) DEFAULT NULL,
  `input_kt` double(6,2) DEFAULT NULL,
  `input_dl` double(6,2) DEFAULT NULL,
  `opsi_id` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selfassessment_id` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `name`) VALUES
('A', 'admin'),
('AT', 'Anggota Tim'),
('DL', 'Pengendali Teknis'),
('EP', 'Evaluator Provinsi'),
('KT', 'Ketua Tim'),
('PP', 'pimpinan'),
('PT', 'PIC Satker'),
('SA', 'super admin');

-- --------------------------------------------------------

--
-- Table structure for table `lhe`
--

CREATE TABLE `lhe` (
  `id` int(11) UNSIGNED NOT NULL,
  `rekapitulasi_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_pengantar_kabkota` text COLLATE utf8mb4_unicode_ci,
  `surat_pengantar_prov` text COLLATE utf8mb4_unicode_ci,
  `LHE_1` text COLLATE utf8mb4_unicode_ci,
  `LHE_2` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(157, '2023_02_07_200246_add_column_google_id_to_users_table', 1),
(185, '2014_10_12_000000_create_users_table', 2),
(186, '2014_10_12_100000_create_password_resets_table', 2),
(187, '2019_08_19_000000_create_failed_jobs_table', 2),
(188, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(189, '2023_01_13_103057_satker', 2),
(190, '2023_01_23_011052_level', 2),
(194, '2023_01_30_131935_persyaratan', 2),
(202, '2023_02_09_043543_rekapitulasi', 2),
(206, '2023_02_16_185412_rekaphasil', 2),
(210, '2023_02_11_024347_self_assessment', 5),
(212, '2023_02_13_014935_upload_dokumen', 7),
(220, '2023_02_19_134214_status_rekap', 8),
(226, '2023_02_22_135038_desk_evaluation', 13),
(227, '2023_02_13_063943_rekappilar', 14),
(236, '2023_03_09_083607_input_field', 16),
(237, '2023_02_13_063943_rekappengungkit', 17),
(238, '2023_01_31_094606_rincian', 18),
(239, '2023_01_31_100030_sub_rincian', 19),
(240, '2023_01_31_103305_pilar', 20),
(241, '2023_02_01_040654_sub_pilar', 21),
(242, '2023_02_01_134215_pertanyaan', 22),
(243, '2023_02_02_033818_opsi', 23),
(245, '2023_02_01_141737_dokumen_lke', 24),
(255, '2023_01_24_025217_tpi', 27),
(259, '2023_01_25_012215_anggota_tpi', 29),
(260, '2023_01_29_073108_pengawasan_satker', 30),
(262, '2023_06_01_053704_l_h_e', 31);

-- --------------------------------------------------------

--
-- Table structure for table `opsi`
--

CREATE TABLE `opsi` (
  `id` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rincian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` double(6,2) NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan_id` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opsi`
--

INSERT INTO `opsi` (`id`, `rincian`, `bobot`, `type`, `pertanyaan_id`, `created_at`, `updated_at`) VALUES
('HBA1', 'Indeks Persepsi Anti Korupsi / IPAK  : Nilai 4', 1.00, 'checkbox', 'HBA', NULL, NULL),
('HBA2', 'Indeks Persepsi Anti Korupsi / IPAK  : Nilai 3', 0.67, 'checkbox', 'HBA', NULL, NULL),
('HBA3', 'Indeks Persepsi Anti Korupsi / IPAK  : Nilai 2', 0.33, 'checkbox', 'HBA', NULL, NULL),
('HBA4', 'Indeks Persepsi Anti Korupsi / IPAK  : Nilai 1', 0.00, 'checkbox', 'HBA', NULL, NULL),
('HBB1', 'A.Target kinerja utama tercapai lebih dari 100% dan lebih baik dari capaian kinerja utama tahun sebelumnya serta lebih baik dari capaian kinerja nasional/rata-rata capaian kinerja unit yang sejenis;', 1.00, 'checkbox', 'HBB', NULL, NULL),
('HBB2', 'B.Target kinerja utama tercapai 100% dan lebih baik dari capaian kinerja utama tahun sebelumnya;', 0.75, 'checkbox', 'HBB', NULL, NULL),
('HBB3', 'C.Target kinerja utama tercapai 100% atau lebih, namun tidak lebih baik dari capaian kinerja utama tahun sebelumnya;', 0.50, 'checkbox', 'HBB', NULL, NULL),
('HBB4', 'D. Kinerja utama sudah orientasi hasil akan tetapi masih terdapat target kinerja utama yang tidak tercapai;', 0.25, 'checkbox', 'HBB', NULL, NULL),
('HBB5', 'E. Kinerja utama tidak berorientasi hasil', 0.00, 'checkbox', 'HBB', NULL, NULL),
('HPA1', 'Indeks Persepsi Kualitas Pelayanan Publik / IPKP : Nilai 4', 1.00, 'checkbox', 'HPA', NULL, NULL),
('HPA2', 'Indeks Persepsi Kualitas Pelayanan Publik / IPKP : Nilai 3', 0.67, 'checkbox', 'HPA', NULL, NULL),
('HPA3', 'Indeks Persepsi Kualitas Pelayanan Publik / IPKP : Nilai 2', 0.33, 'checkbox', 'HPA', NULL, NULL),
('HPA4', 'Indeks Persepsi Kualitas Pelayanan Publik / IPKP : Nilai 1', 0.00, 'checkbox', 'HPA', NULL, NULL),
('PPA1A1', 'Ya, jika Tim telah dibentuk di dalam unit kerja.', 1.00, 'checkbox', 'PPA1A', '2023-06-20 00:51:53', '2023-06-20 00:51:53'),
('PPA1A2', 'Tidak', 0.00, 'checkbox', 'PPA1A', '2023-06-20 00:51:53', '2023-06-20 00:51:53'),
('PPA1B1', 'A. Jika dengan prosedur/mekanisme yang jelas dan mewakili seluruh unsur dalam unit kerja', 1.00, 'checkbox', 'PPA1B', NULL, NULL),
('PPA1B2', 'B. Jika sebagian menggunakan prosedur yang mewakili sebagian besar unsur dalam unit kerja', 0.50, 'checkbox', 'PPA1B', NULL, NULL),
('PPA1B3', 'C. Jika tidak di seleksi.', 0.00, 'checkbox', 'PPA1B', NULL, NULL),
('PPA2A1', 'Ya, jika memiliki  rencana kerja pembangunan Zona Integritas.', 1.00, 'checkbox', 'PPA2A', NULL, NULL),
('PPA2A2', 'Tidak', 0.00, 'checkbox', 'PPA2A', NULL, NULL),
('PPA2B1', 'A. Jika semua target-target prioritas relevan dengan tujuanpembangunan WBK/WBBM', 1.00, 'checkbox', 'PPA2B', NULL, NULL),
('PPA2B2', 'B. Jika sebagian target-target prioritas relevan dengan tujuan pembangunan WBK/WBBM', 0.50, 'checkbox', 'PPA2B', NULL, NULL),
('PPA2B3', 'C. Jika tidak ada target-target prioritas yang relevan dengan tujuan pembangunan WBK/WBBM', 0.00, 'checkbox', 'PPA2B', NULL, NULL),
('PPA2C1', 'A. Jika telah dilakukan pengelolaan media/aktivitas interaktif yang efektif untuk menginformasikan pembangunan ZI kepada internal dan stakeholder secara berkala', 1.00, 'checkbox', 'PPA2C', NULL, NULL),
('PPA2C2', 'B. Jika pengelolaan media/aktivitas interaktif dilakukan secara terbatas dan tidak secara berkala', 0.50, 'checkbox', 'PPA2C', NULL, NULL),
('PPA2C3', 'C. Jika pengelolaan media/aktivitas interaktif belum dilakukan', 0.00, 'checkbox', 'PPA2C', NULL, NULL),
('PPA3A1', 'A. Jika semua kegiatan pembangunan telah dilaksanakan sesuai dengan rencana', 1.00, 'checkbox', 'PPA3A', NULL, NULL),
('PPA3A2', 'B. Jika sebagian besar kegiatan pembangunan telah dilaksanakan sesuai dengan rencana', 0.67, 'checkbox', 'PPA3A', NULL, NULL),
('PPA3A3', 'C. Jika sebagian kecil kegiatan pembangunan telah dilaksanakan sesuai dengan rencana', 0.33, 'checkbox', 'PPA3A', NULL, NULL),
('PPA3A4', 'D. Jika belum ada kegiatan pembangunan yang dilakukan sesuai dengan rencana', 0.00, 'checkbox', 'PPA3A', NULL, NULL),
('PPA3B1', 'A. Jika monitoring dan evaluasi melibatkan pimpinan dan dilakukan secara berkala', 1.00, 'checkbox', 'PPA3B', NULL, NULL),
('PPA3B2', 'B. Jika monitoring dan evaluasi melibatkan pimpinan tetapi tidak secara berkala', 0.67, 'checkbox', 'PPA3B', NULL, NULL),
('PPA3B3', 'C. Jika monitoring dan evaluasi tidak melibatkan pimpinan dan tidak secara berkala', 0.33, 'checkbox', 'PPA3B', NULL, NULL),
('PPA3B4', 'D. Jika tidak terdapat monitoring dan evaluasi terhadap pembangunan zona integritas', 0.00, 'checkbox', 'PPA3B', NULL, NULL),
('PPA3C1', 'A. Jika semua catatan/rekomendasi hasil  monitoring dan evaluasi tim internal atas persiapan dan pelaksanaan kegiatan Unit WBK/WBBM telah ditindaklanjuti', 1.00, 'checkbox', 'PPA3C', NULL, NULL),
('PPA3C2', 'B. Jika sebagian besar catatan/rekomendasi hasil monitoring danevaluasi tim internal atas persiapan dan pelaksanaan kegiatanUnit WBK/WBBM telah ditindaklanjuti', 0.67, 'checkbox', 'PPA3C', NULL, NULL),
('PPA3C3', 'C. Jika sebagian kecil catatan/rekomendasi hasil monitoring dan evaluasi tim internal atas persiapan dan pelaksanaan kegiatan Unit WBK/WBBM telah ditindaklanjuti', 0.33, 'checkbox', 'PPA3C', NULL, NULL),
('PPA3C4', 'D. Jika catatan/rekomendasi hasil monitoring dan evaluasi tim internal atas persiapan dan pelaksanaan kegiatan Unit WBK/WBBM belum ditindaklanjuti', 0.00, 'checkbox', 'PPA3C', NULL, NULL),
('PPA4A1', 'Ya, jika pimpinan menjadi contoh pelaksanaan nilai-nilai organisasi.', 1.00, 'checkbox', 'PPA4A', NULL, NULL),
('PPA4A2', 'tidak', 0.00, 'checkbox', 'PPA4A', NULL, NULL),
('PPA4B1', 'A. Jika agen perubahan telah ditetapkan dan  berkontribusi terhadap perubahan pada unit kerjanya', 1.00, 'checkbox', 'PPA4B', NULL, NULL),
('PPA4B2', 'B. Jika agen perubahan telah ditetapkan namun belum berkontribusi terhadap perubahan pada unit kerjanya', 0.50, 'checkbox', 'PPA4B', NULL, NULL),
('PPA4B3', 'C. Jika belum terdapat agen perubahan', 0.00, 'checkbox', 'PPA4B', NULL, NULL),
('PPA4C1', 'A. Jika telah dilakukan upaya pembangunan budaya kerja dan pola pikir dan mampu mengurangi resistensi atas perubahan', 1.00, 'checkbox', 'PPA4C', NULL, NULL),
('PPA4C2', 'B. Jika telah dilakukan upaya pembangunan budaya kerja dan pola pikir tapi masih terdapat resistensi atas perubahan', 0.50, 'checkbox', 'PPA4C', NULL, NULL),
('PPA4C3', 'C. Jika belum terdapat upaya pembangunan budaya kerja dan pola pikir', 0.00, 'checkbox', 'PPA4C', NULL, NULL),
('PPA4D1', 'A. Jika semua anggota terlibat dalam pembangunan Zona Integritas menuju WBK/WBBM dan usulan-usulan dari anggota diakomodasikan dalam keputusan', 1.00, 'checkbox', 'PPA4D', NULL, NULL),
('PPA4D2', 'B. Jika sebagian besar anggota terlibat dalam pembangunan Zona Integritas menuju WBK/WBBM', 0.67, 'checkbox', 'PPA4D', NULL, NULL),
('PPA4D3', 'C. Jika sebagian kecil anggota terlibat dalam pembangunan Zona Integritas menuju WBK/WBBM', 0.33, 'checkbox', 'PPA4D', NULL, NULL),
('PPA4D4', 'D. Jika belum ada anggota terlibat dalam pembangunan Zona Integritas menuju WBK/WBBM', 0.00, 'checkbox', 'PPA4D', NULL, NULL),
('PPB1A1', 'A. Jika semua SOP unit telah mengacu peta proses bisnis dan juga melakukan inovasi yang selaras', 1.00, 'checkbox', 'PPB1A', NULL, NULL),
('PPB1A2', 'B. Jika semua SOP unit telah mengacu peta proses bisnis', 0.67, 'checkbox', 'PPB1A', NULL, NULL),
('PPB1A3', 'C. Jika sebagian SOP unit telah mengacu peta proses bisnis', 0.33, 'checkbox', 'PPB1A', NULL, NULL),
('PPB1A4', 'D. Jika belum terdapat SOP unit yang mengacu peta proses bisnis', 0.00, 'checkbox', 'PPB1A', NULL, NULL),
('PPB1B1', 'A. Jika unit telah menerapkan seluruh SOP yang ditetapkan organisasi dan juga melakukan inovasi pada SOP yang diterapkan', 1.00, 'checkbox', 'PPB1B', NULL, NULL),
('PPB1B2', 'B. Jika unit telah menerapkan seluruh SOP yang ditetapkan organisasi', 0.75, 'checkbox', 'PPB1B', NULL, NULL),
('PPB1B3', 'C. Jika unit telah menerapkan sebagian besar SOP yang ditetapkan organisasi', 0.50, 'checkbox', 'PPB1B', NULL, NULL),
('PPB1B4', 'D. Jika unit telah menerapkan sebagian kecil SOP yang ditetapkan organisasi', 0.25, 'checkbox', 'PPB1B', NULL, NULL),
('PPB1B5', 'E. Jika unit belum menerapkan SOP yang telah ditetapkan organisasi', 0.00, 'checkbox', 'PPB1B', NULL, NULL),
('PPB1C1', 'A. Jika seluruh SOP utama telah dievaluasi dan telah ditindaklanjuti berupa perbaikan SOP atau usulan perbaikan SOP', 1.00, 'checkbox', 'PPB1C', NULL, NULL),
('PPB1C2', 'B. Jika sebagian besar SOP utama telah dievaluasi dan telah ditindaklanjuti berupa perbaikan SOP atau usulan perbaikan SOP', 0.75, 'checkbox', 'PPB1C', NULL, NULL),
('PPB1C3', 'C. Jika sebagian besar SOP utama telah dievaluasi tetapi belum ditindaklanjuti', 0.50, 'checkbox', 'PPB1C', NULL, NULL),
('PPB1C4', 'D. Jika sebagian kecil SOP utama telah dievaluasi', 0.25, 'checkbox', 'PPB1C', NULL, NULL),
('PPB1C5', 'E. Jika SOP belum pernah dievaluasi', 0.00, 'checkbox', 'PPB1C', NULL, NULL),
('PPB2A1', 'A. Jika unit memiliki sistem pengukuran kinerja (e-performance/e-sakip) yang menggunakan teknologi informasi dan juga melakukan inovasi', 1.00, 'checkbox', 'PPB2A', NULL, NULL),
('PPB2A2', 'B. Jika unit memiliki sistem pengukuran kinerja (e-performance/e-sakip) yang menggunakan teknologi informasi', 0.50, 'checkbox', 'PPB2A', NULL, NULL),
('PPB2A3', 'C. Jika belum memiliki sistem pengukuran kinerja (e-performance/e-sakip) yang menggunakan teknologi informasi', 0.00, 'checkbox', 'PPB2A', NULL, NULL),
('PPB2B1', 'A. Jika unit memiliki operasionalisasi manajemen SDM yang menggunakan teknologi informasi dan juga melakukan inovasi', 1.00, 'checkbox', 'PPB2B', NULL, NULL),
('PPB2B2', 'B. Jika unit memiliki operasionalisasi manajemen SDM yang menggunakan teknologi informasi secara terpusat', 0.50, 'checkbox', 'PPB2B', NULL, NULL),
('PPB2B3', 'C. Jika belum menggunakan teknologi informasi dalam operasionalisasi manajemen SDM', 0.00, 'checkbox', 'PPB2B', NULL, NULL),
('PPB2C1', 'A. Jika unit memberikan pelayanan kepada publik dengan menggunakan teknologi informasi terpusat/unit sendiri dan terdapat inovasi', 1.00, 'checkbox', 'PPB2C', NULL, NULL),
('PPB2C2', 'B. Jika unit memberikan pelayanan kepada publik dengan menggunakan teknologi informasi secara terpusat', 0.50, 'checkbox', 'PPB2C', NULL, NULL),
('PPB2C3', 'C. Jika belum memberikan pelayanan kepada publik dengan menggunakan teknologi informasi', 0.00, 'checkbox', 'PPB2C', NULL, NULL),
('PPB2D1', 'A. Jika laporan monitoring dan evaluasi terhadap pemanfaatan teknologi informasi dalam pengukuran kinerja unit, operasionalisasi SDM, dan pemberian layanan kepada publik sudah dilakukan secara berkala', 1.00, 'checkbox', 'PPB2D', NULL, NULL),
('PPB2D2', 'B. Jika laporan monitoring dan evaluasi terhadap pemanfaatan teknologi informasi dalam pengukuran kinerja unit, operasionalisasi SDM, dan pemberian layanan kepada publik sudah dilakukan tetapi tidak secara berkala', 0.50, 'checkbox', 'PPB2D', NULL, NULL),
('PPB2D3', 'C. Jika tidak terdapat monitoring dan evaluasi terhadap pemanfaatan teknologi informasi dalam pengukuran kinerja unit, operasionalisasi SDM, dan pemberian layanan kepada publik', 0.00, 'checkbox', 'PPB2D', NULL, NULL),
('PPB3A1', 'A. Jika sudah terdapat Pejabat Pengelola Informasi Publik (PPID) yang menyebarkan seluruh informasi yang dapat diakses secara mutakhir dan lengkap', 1.00, 'checkbox', 'PPB3A', NULL, NULL),
('PPB3A2', 'B. Jika sudah terdapat PPID yang menyebarkan sebagian informasi yang dapat diakses secara mutakhir dan lengkap', 0.50, 'checkbox', 'PPB3A', NULL, NULL),
('PPB3A3', 'C. Jika belum ada PPID dan belum melakukan penyebaran informasi publik', 0.00, 'checkbox', 'PPB3A', NULL, NULL),
('PPB3B1', 'A. Jika dilakukan monitoring dan evaluasi pelaksanaan kebijakan keterbukaan informasi publik dan telah ditindaklanjuti', 1.00, 'checkbox', 'PPB3B', NULL, NULL),
('PPB3B2', 'B. Jika monitoring dan evaluasi pelaksanaan kebijakan keterbukaan informasi publik telah dilakukan tetapi belum ditindaklanjuti', 0.50, 'checkbox', 'PPB3B', NULL, NULL),
('PPB3B3', 'C. Jika monitoring dan evaluasi pelaksanaan kebijakan keterbukaan informasi publik belum dilakukan', 0.00, 'checkbox', 'PPB3B', NULL, NULL),
('PPC1A1', 'Ya, jika kebutuhan pegawai yang disusun oleh unit kerja mengacu kepada peta jabatan dan hasil analisis beban kerja untuk masing-masing jabatan.', 1.00, 'checkbox', 'PPC1A', NULL, NULL),
('PPC1A2', 'Tidak', 0.00, 'checkbox', 'PPC1A', NULL, NULL),
('PPC1B1', 'A. Jika semua penempatan pegawai hasil rekrutmen murni mengacu kepada kebutuhan pegawai yang telah disusun per jabatan', 1.00, 'checkbox', 'PPC1B', NULL, NULL),
('PPC1B2', 'B. Jika sebagian besar penempatan pegawai hasil rekrutmen murni mengacu kepada kebutuhan pegawai yang telah disusun per jabatan', 0.67, 'checkbox', 'PPC1B', NULL, NULL),
('PPC1B3', 'C. Jika sebagian kecil penempatan pegawai hasil rekrutmen murni mengacu kepada kebutuhan pegawai yang telah disusun per jabatan', 0.33, 'checkbox', 'PPC1B', NULL, NULL),
('PPC1B4', 'D. Jika penempatan pegawai hasil rekrutmen murni tidak mengacu kepada kebutuhan pegawai yang telah disusun per jabatan', 0.00, 'checkbox', 'PPC1B', NULL, NULL),
('PPC1C1', 'Ya, jika sudah dilakukan monitoring dan evaluasi terhadap penempatan pegawai hasil rekrutmen untuk memenuhi kebutuhan jabatan dalam organisasi telah memberikan perbaikan terhadap kinerja unit kerjA.', 1.00, 'checkbox', 'PPC1C', NULL, NULL),
('PPC1C2', 'Tidak', 0.00, 'checkbox', 'PPC1C', NULL, NULL),
('PPC2A1', 'Ya, jika dilakukan mutasi pegawai antar jabatan sebagai wujud dari pengembangan karier pegawai.', 1.00, 'checkbox', 'PPC2A', NULL, NULL),
('PPC2A2', 'Tidak', 0.00, 'checkbox', 'PPC2A', NULL, NULL),
('PPC2B1', 'A. Jika semua mutasi pegawai antar jabatan telah memperhatikan kompetensi jabatan dan mengikuti pola mutasi yang telah ditetapkan organisasi dan juga unit kerja memberikan pertimbangan terkait hal ini', 1.00, 'checkbox', 'PPC2B', NULL, NULL),
('PPC2B2', 'B. Jika semua mutasi pegawai antar jabatan telah memperhatikan kompetensi jabatan dan mengikuti pola mutasi yang telah ditetapkan organisasi', 0.75, 'checkbox', 'PPC2B', NULL, NULL),
('PPC2B3', 'C. Jika sebagian besar mutasi pegawai antar jabatan telah memperhatikan kompetensi jabatan dan mengikuti pola mutasi yang telah ditetapkan organisasi', 0.50, 'checkbox', 'PPC2B', NULL, NULL),
('PPC2B4', 'D. Jika sebagian kecil semua mutasi pegawai antar jabatan telah memperhatikan kompetensi jabatan dan mengikuti pola mutasi yang telah ditetapkan organisasi', 0.25, 'checkbox', 'PPC2B', NULL, NULL),
('PPC2B5', 'E. Jika mutasi pegawai antar jabatan belum memperhatikan kompetensi jabatan dan mengikuti pola mutasi yang telah ditetapkan organisasi', 0.00, 'checkbox', 'PPC2B', NULL, NULL),
('PPC2C1', 'Ya, jika sudah dilakukan monitoring dan evaluasi terhadap kegiatan mutasi yang telah dilakukan dalam kaitannya dengan perbaikan kinerjA.', 1.00, 'checkbox', 'PPC2C', NULL, NULL),
('PPC2C2', 'Tidak', 0.00, 'checkbox', 'PPC2C', NULL, NULL),
('PPC3A1', 'Ya, jika sudah dilakukan Training Need Analysis Untuk pengembangan kompetensi.', 1.00, 'checkbox', 'PPC3A', NULL, NULL),
('PPC3A2', 'Tidak', 0.00, 'checkbox', 'PPC3A', NULL, NULL),
('PPC3B1', 'A. Jika semua rencana pengembangan kompetensi pegawai mempertimbangkan hasil pengelolaan kinerja pegawai', 1.00, 'checkbox', 'PPC3B', NULL, NULL),
('PPC3B2', 'B. Jika sebagian besar rencana pengembangan kompetensi pegawai mempertimbangkan hasil pengelolaan kinerja pegawai', 0.67, 'checkbox', 'PPC3B', NULL, NULL),
('PPC3B3', 'C. Jika sebagian kecil rencana pengembangan kompetensi pegawai mempertimbangkan hasil pengelolaan kinerja pegawai', 0.33, 'checkbox', 'PPC3B', NULL, NULL),
('PPC3B4', 'D. Jika belum ada rencana pengembangan kompetensi pegawai yang mempertimbangkan hasil pengelolaan kinerja pegawai', 0.00, 'checkbox', 'PPC3B', NULL, NULL),
('PPC3C1', 'A. Jika persentase kesenjangan kompetensi pegawai dengan standar kompetensi yang ditetapkan sebesar <25%', 1.00, 'checkbox', 'PPC3C', NULL, NULL),
('PPC3C2', 'B. Jika persentase kesenjangan kompetensi pegawai dengan standar kompetensi yang ditetapkan sebesar >25%-50%', 0.67, 'checkbox', 'PPC3C', NULL, NULL),
('PPC3C3', 'C. Jika  sebagian besar kompetensi pegawai dengan standar kompetensi yang ditetapkan untuk masing-masing jabatan >50% -75%', 0.33, 'checkbox', 'PPC3C', NULL, NULL),
('PPC3C4', 'D. Jika persentase kesenjangan kompetensi pegawai dengan standar kompetensi yang ditetapkan sebesar >75%-100%', 0.00, 'checkbox', 'PPC3C', NULL, NULL),
('PPC3D1', 'A. Jika seluruh pegawai di Unit Kerja telah memperoleh kesempatan/hak untuk mengikuti diklat maupun pengembangan kompetensi lainnya', 1.00, 'checkbox', 'PPC3D', NULL, NULL),
('PPC3D2', 'B. Jika sebagian besar pegawai di Unit Kerja telah memperoleh kesempatan/hak untuk mengikuti diklat maupun pengembangan kompetensi lainnya', 0.67, 'checkbox', 'PPC3D', NULL, NULL),
('PPC3D3', 'C. Jika sebagian kecil pegawai di Unit Kerja telah memperoleh kesempatan/hak untuk mengikuti diklat maupun pengembangan kompetensi lainnya', 0.33, 'checkbox', 'PPC3D', NULL, NULL),
('PPC3D4', 'D. Jika belum ada pegawai di Unit Kerja telah memperoleh kesempatan/hak untuk mengikuti diklat maupun pengembangan kompetensi lainnya', 0.00, 'checkbox', 'PPC3D', NULL, NULL),
('PPC3E1', 'A. Jika unit kerja melakukan upaya pengembangan kompetensi kepada seluruh pegawai', 1.00, 'checkbox', 'PPC3E', NULL, NULL),
('PPC3E2', 'B. Jika unit kerja melakukan upaya pengembangan kompetensi kepada sebagian besar pegawai', 0.67, 'checkbox', 'PPC3E', NULL, NULL),
('PPC3E3', 'C. Jika unit kerja melakukan upaya pengembangan kompetensi kepada sebagian kecil pegawai', 0.33, 'checkbox', 'PPC3E', NULL, NULL),
('PPC3E4', 'D. Jika unit kerja belum melakukan upaya pengembangan kompetensi kepada pegawai', 0.00, 'checkbox', 'PPC3E', NULL, NULL),
('PPC3F1', 'A. Jika monitoring dan evaluasi terhadap hasil pengembangan kompetensi dalam kaitannya dengan perbaikan kinerja telah dilakukan secara berkala', 1.00, 'checkbox', 'PPC3F', NULL, NULL),
('PPC3F2', 'B. Jika monitoring dan evaluasi terhadap hasil pengembangan kompetensi dalam kaitannya dengan perbaikan kinerja telah dilakukan namun tidak secara berkala', 0.50, 'checkbox', 'PPC3F', NULL, NULL),
('PPC3F3', 'C. Jika monitoring dan evaluasi terhadap hasil pengembangan kompetensi dalam kaitannya dengan perbaikan kinerja belum dilakukan', 0.00, 'checkbox', 'PPC3F', NULL, NULL),
('PPC4A1', 'A. Jika seluruh penetapan kinerja individu terkait dengan kinerja organisasi serta perjanjian kinerja selaras dengan sasaran kinerja pegawai (SKP)', 1.00, 'checkbox', 'PPC4A', NULL, NULL),
('PPC4A2', 'B. Jika sebagian besar penetapan kinerja individu terkait dengan kinerja organisasi', 0.67, 'checkbox', 'PPC4A', NULL, NULL),
('PPC4A3', 'C. Jika sebagian kecil penetapan kinerja individu terkait dengan kinerja organisasi', 0.33, 'checkbox', 'PPC4A', NULL, NULL),
('PPC4A4', 'D. Jika belum ada penetapan kinerja individu terkait dengan kinerja organisasi', 0.00, 'checkbox', 'PPC4A', NULL, NULL),
('PPC4B1', 'A. Jika seluruh ukuran kinerja individu telah memiliki kesesuaian dengan indikator kinerja individu level diatasnya serta menggambarkan logic model', 1.00, 'checkbox', 'PPC4B', NULL, NULL),
('PPC4B2', 'B. Jika sebagian besar ukuran kinerja individu telah memiliki kesesuaian dengan indikator kinerja individu level diatasnya', 0.67, 'checkbox', 'PPC4B', NULL, NULL),
('PPC4B3', 'C. Jika sebagian kecil ukuran kinerja individu telah memiliki kesesuaian dengan indikator kinerja individu level diatasnya', 0.33, 'checkbox', 'PPC4B', NULL, NULL),
('PPC4B4', 'D. Jika ukuran kinerja individu belum memiliki kesesuaian dengan indikator kinerja individu level diatasnya', 0.00, 'checkbox', 'PPC4B', NULL, NULL),
('PPC4C1', 'A. Jika pengukuran kinerja individu dilakukan secara bulanan', 1.00, 'checkbox', 'PPC4C', NULL, NULL),
('PPC4C2', 'B. Jika pengukuran kinerja individu dilakukan secara triwulanan', 0.75, 'checkbox', 'PPC4C', NULL, NULL),
('PPC4C3', 'C. Jika pengukuran kinerja individu dilakukan secara semesteran', 0.50, 'checkbox', 'PPC4C', NULL, NULL),
('PPC4C4', 'D. Jika pengukuran kinerja individu dilakukan secara tahunan', 0.25, 'checkbox', 'PPC4C', NULL, NULL),
('PPC4C5', 'E. Jika pengukuran kinerja individu belum dilakukan', 0.00, 'checkbox', 'PPC4C', NULL, NULL),
('PPC4D1', 'Ya, jika hasil hasil penilaian kinerja individu telah dijadikan dasar untuk pemberian reward (Seperti: pengembangan karir individu, atau penghargaan)', 1.00, 'checkbox', 'PPC4D', NULL, NULL),
('PPC4D2', 'Tidak', 0.00, 'checkbox', 'PPC4D', NULL, NULL),
('PPC5A1', 'A. Jika unit kerja telah mengimplementasikan seluruh aturan disiplin/kode etik/kode perilaku yang ditetapkan organisasi dan juga membuat inovasi terkait aturan disiplin/kode etik/kode perilaku yang sesuai dengan karakteristik unit kerja', 1.00, 'checkbox', 'PPC5A', NULL, NULL),
('PPC5A2', 'B. Jika unit kerja telah mengimplementasikan seluruh aturan disiplin/kode etik/kode perilaku yang ditetapkan organisasi', 0.67, 'checkbox', 'PPC5A', NULL, NULL),
('PPC5A3', 'C. Jika unit kerja telah mengimplementasikan sebagian aturan disiplin/kode etik/kode perilaku yang ditetapkan organisasi', 0.33, 'checkbox', 'PPC5A', NULL, NULL),
('PPC5A4', 'D. Jika unit kerja belum mengimplementasikan aturan disiplin/kode etik/kode perilaku yang ditetapkan organisasi', 0.00, 'checkbox', 'PPC5A', NULL, NULL),
('PPC6A1', 'A. Jika data informasi kepegawaian unit kerja dapat diakses oleh pegawai dan dimutakhirkan setiap ada perubahan data pegawai', 1.00, 'checkbox', 'PPC6A', NULL, NULL),
('PPC6A2', 'B. Jika data informasi kepegawaian unit kerja dapat diakses oleh pegawai dan  dimutakhirkan namun secara berkala', 0.50, 'checkbox', 'PPC6A', NULL, NULL),
('PPC6A3', 'C. Jika data informasi kepegawaian unit kerja belum dimutakhirkan', 0.00, 'checkbox', 'PPC6A', NULL, NULL),
('PPD1A1', 'A. Jika pimpinan selalu terlibat dalam seluruh tahapan penyusunan perencanaan', 1.00, 'checkbox', 'PPD1A', NULL, NULL),
('PPD1A2', 'B. Jika pimpinan ikut terlibat dalam sebagian tahapan penyusunan perencanaan', 0.50, 'checkbox', 'PPD1A', NULL, NULL),
('PPD1A3', 'C. Jika tidak ada keterlibatan pimpinan dalam penyusunan perencanaan (hanya menandatangani)', 0.00, 'checkbox', 'PPD1A', NULL, NULL),
('PPD1B1', 'A. Jika pimpinan selalu terlibat dalam seluruh tahapan penyusunan perjanjian kinerja', 1.00, 'checkbox', 'PPD1B', NULL, NULL),
('PPD1B2', 'B. Jika pimpinan terlibat dalam sebagian tahapan penyusunan perjanjian kinerja', 0.50, 'checkbox', 'PPD1B', NULL, NULL),
('PPD1B3', 'C. Jika tidak ada keterlibatan pimpinan dalam penyusunan perjanjian kinerja', 0.00, 'checkbox', 'PPD1B', NULL, NULL),
('PPD1C1', 'A. Jika pimpinan selalu terlibat dalam seluruh pemantauan pencapaian kinerja dan menindaklanjuti hasil pemantauan', 1.00, 'checkbox', 'PPD1C', NULL, NULL),
('PPD1C2', 'B. Jika pimpinan unit kerja terlibat dalam seluruh pemantauan pencapaian kinerja tetapi tidak ada tindak lanjut hasil pemantauan', 0.67, 'checkbox', 'PPD1C', NULL, NULL),
('PPD1C3', 'C. Jika pimpinan unit kerja terlibat dalam sebagian pemantauan pencapaian kinerja', 0.33, 'checkbox', 'PPD1C', NULL, NULL),
('PPD1C4', 'D. Jika tidak ada keterlibatan pimpinan dalam pemantauan pencapaian kinerja', 0.00, 'checkbox', 'PPD1C', NULL, NULL),
('PPD2A1', 'Ya, jika unit kerja memiliki dokumen perencanaan kinerja lengkap', 1.00, 'checkbox', 'PPD2A', NULL, NULL),
('PPD2A2', 'Tidak', 0.00, 'checkbox', 'PPD2A', NULL, NULL),
('PPD2B1', 'Ya, jika perencanaan kinerja telah berorientasi hasil', 1.00, 'checkbox', 'PPD2B', NULL, NULL),
('PPD2B2', 'Tidak', 0.00, 'checkbox', 'PPD2B', NULL, NULL),
('PPD2C1', 'Ya, jika unit kerja memiliki IKU', 1.00, 'checkbox', 'PPD2C', NULL, NULL),
('PPD2C2', 'Tidak', 0.00, 'checkbox', 'PPD2C', NULL, NULL),
('PPD2D1', 'A. Jika seluruh indikator kinerja telah SMART', 1.00, 'checkbox', 'PPD2D', NULL, NULL),
('PPD2D2', 'B. Jika sebagian besar indikator kinerja telah SMART', 0.67, 'checkbox', 'PPD2D', NULL, NULL),
('PPD2D3', 'C. Jika sebagian kecil indikator kinerja telah SMART', 0.33, 'checkbox', 'PPD2D', NULL, NULL),
('PPD2D4', 'D. Jika belum ada indikator kinerja yang SMART', 0.00, 'checkbox', 'PPD2D', NULL, NULL),
('PPD2E1', 'Ya, jika unit kerja telah menyusun laporan kinerja tepat waktu', 1.00, 'checkbox', 'PPD2E', NULL, NULL),
('PPD2E2', 'Tidak', 0.00, 'checkbox', 'PPD2E', NULL, NULL),
('PPD2F1', 'A. Jika seluruh pelaporan kinerja telah memberikan informasi tentang kinerja', 1.00, 'checkbox', 'PPD2F', NULL, NULL),
('PPD2F2', 'B. Jika sebagian pelaporan kinerja belum memberikan informasi tentang kinerja', 0.50, 'checkbox', 'PPD2F', NULL, NULL),
('PPD2F3', 'C. Jika seluruh pelaporan kinerja belum memberikan informasi tentang kinerja', 0.00, 'checkbox', 'PPD2F', NULL, NULL),
('PPD2G1', 'Ya, jika terdapat upaya peningkatan kapasitas SDM yang menangani akuntabilitas kinerja', 1.00, 'checkbox', 'PPD2G', NULL, NULL),
('PPD2G2', 'Tidak', 0.00, 'checkbox', 'PPD2G', NULL, NULL),
('PPD2H1', 'A. Jika seluruh SDM pengelola akuntabilitas kinerja kompeten', 1.00, 'checkbox', 'PPD2H', NULL, NULL),
('PPD2H2', 'B. Jika sebagian SDM pengelola akuntabilitas kinerja kompeten', 0.50, 'checkbox', 'PPD2H', NULL, NULL),
('PPD2H3', 'C. Jika seluruh SDM pengelola akuntabilitas kinerja belum ada yang kompeten', 0.00, 'checkbox', 'PPD2H', NULL, NULL),
('PPE1A1', 'A. Jika public campaign telah dilakukan secara berkala', 1.00, 'checkbox', 'PPE1A', NULL, NULL),
('PPE1A2', 'B. Jika public campaign dilakukan tidak secara berkala', 0.50, 'checkbox', 'PPE1A', NULL, NULL),
('PPE1A3', 'C. Jika belum dilakukan public campaign', 0.00, 'checkbox', 'PPE1A', NULL, NULL),
('PPE1B1', 'A. Jika Unit Pengendalian Gratifikasi, pengendalian gratifikasi telahmenjadi bagian dari prosedur', 1.00, 'checkbox', 'PPE1B', NULL, NULL),
('PPE1B2', 'B. Jika Unit Pengendalian Gratifikasi, upaya pengendalian gratifikasi telah mulai dilakukan', 0.67, 'checkbox', 'PPE1B', NULL, NULL),
('PPE1B3', 'C. Jika telah membentuk Unit Pengendalian Gratifikasi tetapi belum terdapat prosedur pengendalian', 0.33, 'checkbox', 'PPE1B', NULL, NULL),
('PPE1B4', 'D. Jika belum memiliki Unit Pengendalian Gratifikasi', 0.00, 'checkbox', 'PPE1B', NULL, NULL),
('PPE2A1', 'A. Jika unit kerja membangun seluruh lingkungan pengendalian sesuai dengan yang ditetapkan organisasi dan juga membuat inovasi terkait lingkungan pengendalian yang sesuai dengan karakteristik unit kerja', 1.00, 'checkbox', 'PPE2A', NULL, NULL),
('PPE2A2', 'B. Jika unit kerja membangun seluruh lingkungan pengendalian sesuai dengan yang ditetapkan organisasi', 0.75, 'checkbox', 'PPE2A', NULL, NULL),
('PPE2A3', 'C. Jika unit kerja membangun sebagian besar lingkungan pengendalian sesuai dengan yang ditetapkan organisasi', 0.50, 'checkbox', 'PPE2A', NULL, NULL),
('PPE2A4', 'D. Jika unit kerja membangun sebagian kecil lingkungan pengendalian sesuai dengan yang ditetapkan organisasi', 0.25, 'checkbox', 'PPE2A', NULL, NULL),
('PPE2A5', 'E. Jika unit kerja belum membangun lingkungan pengendalian', 0.00, 'checkbox', 'PPE2A', NULL, NULL),
('PPE2B1', 'A. Jika unit kerja melakukan penilaian risiko atas seluruh pelaksanaan kebijakan sesuai dengan yang ditetapkan organisasi dan juga membuat inovasi terkait lingkungan pengendalian yang sesuai dengan karakteristik unit kerja; ', 1.00, 'checkbox', 'PPE2B', NULL, NULL),
('PPE2B2', 'B. Jika unit kerja melakukan penilaian risiko atas seluruh pelaksanaan kebijakan sesuai dengan yang ditetapkan organisasi', 0.75, 'checkbox', 'PPE2B', NULL, NULL),
('PPE2B3', 'C. Jika melakukan penilaian risiko atas sebagian besar pelaksanaan kebijakan sesuai dengan yang ditetapkan organisasi', 0.50, 'checkbox', 'PPE2B', NULL, NULL),
('PPE2B4', 'D. Jika melakukan penilaian risiko atas sebagian kecil pelaksanaan kebijakan sesuai dengan yang ditetapkan organisasi', 0.25, 'checkbox', 'PPE2B', NULL, NULL),
('PPE2B5', 'E. Jika unit kerja belum melakukan penilaian resiko', 0.00, 'checkbox', 'PPE2B', NULL, NULL),
('PPE2C1', 'A. Jika unit kerja melakukan kegiatan pengendalian untuk meminimalisir resiko sesuai dengan yang ditetapkan organisasi dan juga membuat inovasi terkait kegiatan pengendalian untuk meminimalisir resiko yang sesuai dengan karakteristik unit kerja', 1.00, 'checkbox', 'PPE2C', NULL, NULL),
('PPE2C2', 'B. Jika unit kerja melakukan kegiatan pengendalian untuk meminimalisir resiko sesuai dengan yang ditetapkan organisasi', 0.50, 'checkbox', 'PPE2C', NULL, NULL),
('PPE2C3', 'C. Jika unit kerja belum melakukan kegiatan pengendalian untuk meminimalisir resiko', 0.00, 'checkbox', 'PPE2C', NULL, NULL),
('PPE2D1', 'A. Jika SPI telah diinformasikan dan dikomunikasikan kepada seluruh pihak terkait', 1.00, 'checkbox', 'PPE2D', NULL, NULL),
('PPE2D2', 'B. Jika SPI telah diinformasikan dan dikomunikasikan kepada sebagian pihak terkait', 0.50, 'checkbox', 'PPE2D', NULL, NULL),
('PPE2D3', 'C. Jika SPI belum diinformasikan dan dikomunikasikan kepada pihak terkait', 0.00, 'checkbox', 'PPE2D', NULL, NULL),
('PPE3A1', 'A. Jika unit kerja mengimplementasikan seluruh kebijakan pengaduan masyarakat sesuai dengan yang ditetapkan organisasi dan juga membuat inovasi terkait pengaduan masyarakat yang sesuai dengan karakteristik unit kerja', 1.00, 'checkbox', 'PPE3A', NULL, NULL),
('PPE3A2', 'B. Jika unit kerja telah mengimplementasikan seluruh kebijakan pengaduan masyarakat sesuai dengan yang ditetapkan organisasi ', 0.50, 'checkbox', 'PPE3A', NULL, NULL),
('PPE3A3', 'C. Jika unit kerja belum mengimplementasikan kebijakan pengaduan masyarakat', 0.00, 'checkbox', 'PPE3A', NULL, NULL),
('PPE3B1', 'Ya,pengaduan masyaakat ditindaklanjuti', 1.00, 'checkbox', 'PPE3B', NULL, NULL),
('PPE3B2', 'Tidak', 0.00, 'checkbox', 'PPE3B', NULL, NULL),
('PPE3C1', 'A. Jika penanganan pengaduan masyarakat dimonitoring dan evaluasi secara berkala', 1.00, 'checkbox', 'PPE3C', NULL, NULL),
('PPE3C2', 'B. Jika penanganan pengaduan masyarakat dimonitoring dan evaluasi tetapi tidak secara berkala', 0.50, 'checkbox', 'PPE3C', NULL, NULL),
('PPE3C3', 'C. Jika penanganan pengaduan masyarakat belum di monitoring dan evaluasi', 0.00, 'checkbox', 'PPE3C', NULL, NULL),
('PPE3D1', 'A. Jika seluruh hasil evaluasi atas penanganan pengaduan telah ditindaklanjuti oleh unit kerja', 1.00, 'checkbox', 'PPE3D', NULL, NULL),
('PPE3D2', 'B. Jika sebagian hasil evaluasi atas penanganan pengaduan telah ditindaklanjuti oleh unit kerja', 0.50, 'checkbox', 'PPE3D', NULL, NULL),
('PPE3D3', 'C. Jika hasil evaluasi atas penanganan pengaduan belum ditindaklanjuti', 0.00, 'checkbox', 'PPE3D', NULL, NULL),
('PPE4A1', 'A. Jika unit kerja menerapkan seluruh kebijakan Whistle Blowing System sesuai dengan yang ditetapkan organisasi dan juga membuat inovasi terkait pelaksanaan Whistle Blowing System yang sesuai dengan karakteristik unit kerja', 1.00, 'checkbox', 'PPE4A', NULL, NULL),
('PPE4A2', 'B. Jika unit kerja menerapkan kebijakan Whistle Blowing System sesuai dengan yang ditetapkan organisasi', 0.50, 'checkbox', 'PPE4A', NULL, NULL),
('PPE4A3', 'C. Jika unit kerja belum menerapkan kebijakan Whistle Blowing System', 0.00, 'checkbox', 'PPE4A', NULL, NULL),
('PPE4B1', 'A. Jika penerapan Whistle Blowing System dimonitoring dan evaluasi secara berkala', 1.00, 'checkbox', 'PPE4B', NULL, NULL),
('PPE4B2', 'B. Jika penerapan Whistle Blowing System dimonitoring dan evaluasi tidak secara berkala', 0.50, 'checkbox', 'PPE4B', NULL, NULL),
('PPE4B3', 'C. Jika penerapan Whistle Blowing System belum di monitoring dan evaluasi', 0.00, 'checkbox', 'PPE4B', NULL, NULL),
('PPE4C1', 'A. Jika seluruh hasil evaluasi atas penerapan Whistle Blowing System telah ditindaklanjuti oleh unit kerja', 1.00, 'checkbox', 'PPE4C', NULL, NULL),
('PPE4C2', 'B. Jika sebagian hasil evaluasi atas penerapan Whistle Blowing System telah ditindaklanjuti oleh unit kerja', 0.50, 'checkbox', 'PPE4C', NULL, NULL),
('PPE4C3', 'C. Jika hasil evaluasi atas penerapan Whistle Blowing System belum ditindaklanjuti', 0.00, 'checkbox', 'PPE4C', NULL, NULL),
('PPE5A1', 'A. Jika terdapat  identifikasi/pemetaan benturan kepentingan pada seluruh tugas fungsi utama', 1.00, 'checkbox', 'PPE5A', NULL, NULL),
('PPE5A2', 'B. Jika terdapat  identifikasi/pemetaan benturan kepentingan tetapi pada sebagian besar tugas fungsi utama', 0.67, 'checkbox', 'PPE5A', NULL, NULL),
('PPE5A3', 'C. Jika terdapat  identifikasi/pemetaan benturan kepentingan tetapi pada sebagian kecil tugas fungsi utama', 0.33, 'checkbox', 'PPE5A', NULL, NULL),
('PPE5A4', 'D. Jika belum terdapat  identifikasi/pemetaan benturan kepentingan dalam tugas fungsi utama', 0.00, 'checkbox', 'PPE5A', NULL, NULL),
('PPE5B1', 'A. Jika penanganan Benturan Kepentingan disosialiasikan/diinternalisasikan ke seluruh layanan', 1.00, 'checkbox', 'PPE5B', NULL, NULL),
('PPE5B2', 'B. Jika penanganan Benturan Kepentingan disosialiasikan/diinternalisasikan ke sebagian besar layanan', 0.67, 'checkbox', 'PPE5B', NULL, NULL),
('PPE5B3', 'C.  Jika penanganan Benturan Kepentingan disosialiasikan/diinternalisasikan ke sebagian kecil layanan', 0.33, 'checkbox', 'PPE5B', NULL, NULL),
('PPE5B4', 'D.  Jika penanganan Benturan Kepentingan belum disosialiasikan/diinternalisasikan ke seluruh layanan', 0.00, 'checkbox', 'PPE5B', NULL, NULL),
('PPE5C1', 'A. Jika penanganan Benturan Kepentingan diimplementasikan ke seluruh layanan', 1.00, 'checkbox', 'PPE5C', NULL, NULL),
('PPE5C2', 'B. Jika penanganan Benturan Kepentingan diimplementasikan ke sebagian besar layanan', 0.67, 'checkbox', 'PPE5C', NULL, NULL),
('PPE5C3', 'C. Jika penanganan Benturan Kepentingan diimplementasikan ke sebagian kecil layanan', 0.33, 'checkbox', 'PPE5C', NULL, NULL),
('PPE5C4', 'D. Jika penanganan Benturan Kepentingan belum diimplementasikan ke seluruh layanan', 0.00, 'checkbox', 'PPE5C', NULL, NULL),
('PPE5D1', 'A. Jika penanganan Benturan Kepentingan dievaluasi secara berkala oleh unit kerja', 1.00, 'checkbox', 'PPE5D', NULL, NULL),
('PPE5D2', 'B. Jika penanganan Benturan Kepentingan dievaluasi tetapi tidak secara berkala oleh unit kerja', 0.50, 'checkbox', 'PPE5D', NULL, NULL),
('PPE5D3', 'C. Jika penanganan Benturan Kepentingan belum dievaluasi oleh unit kerja', 0.00, 'checkbox', 'PPE5D', NULL, NULL),
('PPE5E1', 'A. Jika seluruh hasil evaluasi atas Penanganan Benturan Kepentingan telah ditindaklanjuti oleh unit kerja', 1.00, 'checkbox', 'PPE5E', NULL, NULL),
('PPE5E2', 'B. Jika sebagian hasil evaluasi atas Penanganan Benturan Kepentingan telah ditindaklanjuti oleh unit kerja', 0.50, 'checkbox', 'PPE5E', NULL, NULL),
('PPE5E3', 'C. Jika belum ada hasil evaluasi atas Penanganan Benturan Kepentingan yang ditindaklanjuti unit kerja', 0.00, 'checkbox', 'PPE5E', NULL, NULL),
('PPF1A1', 'A. Terdapat penetapan Standar Pelayanan terhadap seluruh jenis pelayanan, dan sesuai asas serta komponen standar pelayanan publik yang berlaku', 1.00, 'checkbox', 'PPF1A', NULL, NULL),
('PPF1A2', 'B. Terdapat penetapan Standar Pelayanan terhadap sebagian jenis pelayanan, dan sesuai asas serta komponen standar pelayanan publik yang berlaku', 0.75, 'checkbox', 'PPF1A', NULL, NULL),
('PPF1A3', 'C. Terdapat penetapan Standar Pelayanan terhadap seluruh jenis pelayanan, namun tidak sesuai asas serta komponen standar pelayanan publik yang berlaku', 0.50, 'checkbox', 'PPF1A', NULL, NULL),
('PPF1A4', 'D. Terdapat penetapan Standar Pelayanan terhadap sebagian jenis pelayanan, namun tidak sesuai asas serta komponen standar pelayanan publik yang berlaku', 0.25, 'checkbox', 'PPF1A', NULL, NULL),
('PPF1A5', 'E. Standar Pelayanan belum ditetapkan', 0.00, 'checkbox', 'PPF1A', NULL, NULL),
('PPF1B1', 'A. Standar pelayanan telah dimaklumatkan pada seluruh jenis pelayanan dan dipublikasikan di website dan media lainnya', 1.00, 'checkbox', 'PPF1B', NULL, NULL),
('PPF1B2', 'B. Standar pelayanan telah dimaklumatkan pada sebagian besar jenis pelayanan dan dipublikasikan minimal di website', 0.67, 'checkbox', 'PPF1B', NULL, NULL),
('PPF1B3', 'C. Standar pelayanan telah dimaklumatkan pada sebagian kecil  jenis pelayanan dan belum dipublikasikan', 0.33, 'checkbox', 'PPF1B', NULL, NULL),
('PPF1B4', 'D. Standar pelayanan belum dimaklumatkan pada seluruh jenis pelayanan dan belum dipublikasikan', 0.00, 'checkbox', 'PPF1B', NULL, NULL),
('PPF1C1', 'A. Dilakukan reviu dan perbaikan atas standar pelayanan dan dilakukan dengan melibatkan stakeholders (antara lain : tokoh masyarakat,  akademisi, dunia usaha, dan lembaga swadaya masyarakat), serta memanfaatkan masukan hasil SKM dan pengaduan masyarakat', 1.00, 'checkbox', 'PPF1C', NULL, NULL),
('PPF1C2', 'B. Dilakukan reviu dan perbaikan atas standar pelayanan dan dilakukan dengan memanfaatkan masukan hasil SKM dan pengaduan masyarakat, namun tanpa melibatkan stakeholders', 0.67, 'checkbox', 'PPF1C', NULL, NULL),
('PPF1C3', 'C. Dilakukan reviu dan perbaikan atas standar pelayanan, namun  dilakukan tanpa memanfaatkan masukan hasil SKM dan pengaduan masyarakat, serta tanpa melibatkan stakeholders', 0.33, 'checkbox', 'PPF1C', NULL, NULL),
('PPF1C4', 'D. Belum dilakukan reviu dan perbaikan atas standar pelayanan', 0.00, 'checkbox', 'PPF1C', NULL, NULL),
('PPF1D1', 'Ya,telah melakukan publikasi atas tandar pelayanan dan maklumat pelayanan', 1.00, 'checkbox', 'PPF1D', NULL, NULL),
('PPF1D2', 'Tidak', 0.00, 'checkbox', 'PPF1D', NULL, NULL),
('PPF2A1', 'A. Telah dilakukan pelatihan/sosialisasi pelayanan prima secara berkelanjutan dan terjadwal, sehingga seluruh petugas/pelaksana layanan memiliki kompetensi sesuai kebutuhan jenis layanan serta telah dan terdapat monev yang melihat kemampuan/kecakapan petu', 1.00, 'checkbox', 'PPF2A', NULL, NULL),
('PPF2A2', 'B. Telah dilakukan pelatihan/sosialisasi pelayanan prima, dan  seluruh petugas/pelaksana layanan memiliki kompetensi sesuai kebutuhan jenis layanan', 0.75, 'checkbox', 'PPF2A', NULL, NULL),
('PPF2A3', 'C. Telah dilakukan pelatihan/sosialisasi pelayanan prima, akan tetapi baru sebagian besar petugas/pelaksana layanan memiliki kompetensi sesuai kebutuhan jenis layanan ', 0.50, 'checkbox', 'PPF2A', NULL, NULL),
('PPF2A4', 'D. Telah dilakukan pelatihan/sosialisasi pelayanan prima namun secara terbatas, sehingga hanya sebagian kecil petugas/pelaksana layanan yang memiliki kompetensi sesuai kebutuhan jenis layanan ', 0.25, 'checkbox', 'PPF2A', NULL, NULL),
('PPF2A5', 'E. Belum dilakukan pelatihan/sosialisasi pelayanan prima, dan seluruh petugas/pelaksana layanan belum memiliki kompetensi sesuai kebutuhan jenis layanan', 0.00, 'checkbox', 'PPF2A', NULL, NULL),
('PPF2B1', 'A. Seluruh Informasi tentang pelayanan dapat diakses secara online (website/media sosial) dan terhubung dengan sistem informasi pelayanan publik nasional', 1.00, 'checkbox', 'PPF2B', NULL, NULL),
('PPF2B2', 'B. Seluruh Informasi tentang pelayanan dapat diakses secara online (website/media sosial), namun belum terhubung dengan sistem informasi pelayanan publik nasional', 0.67, 'checkbox', 'PPF2B', NULL, NULL),
('PPF2B3', 'C. Seluruh Informasi tentang pelayanan belum online, hanya dapat diakses di tempat layanan (intranet dan non elektronik)', 0.33, 'checkbox', 'PPF2B', NULL, NULL),
('PPF2B4', 'D. Informasi tentang pelayanan sulit diakses', 0.00, 'checkbox', 'PPF2B', NULL, NULL),
('PPF2C1', 'A. Telah terdapat kebijakan pemberian penghargaan dan sanksi yang minimal memenuhi unsur penilaian: disiplin, kinerja, dan hasil penilaian pengguna layanan, dan telah diterapkan secara rutin/berkelanjutan', 1.00, 'checkbox', 'PPF2C', NULL, NULL),
('PPF2C2', 'B. Telah terdapat kebijakan pemberian penghargaan dan sanksi yang minimal memenuhi unsur penilaian: disiplin, kinerja, dan hasil penilaian pengguna layanan, namun belum diterapkan secara rutin/berkelanjutan', 0.67, 'checkbox', 'PPF2C', NULL, NULL),
('PPF2C3', 'C. Telah terdapat kebijakan pemberian penghargaan dan sanksi, namun belum memenuhi unsur penilaian minimal : disiplin, kinerja, dan hasil penilaian pengguna layanan', 0.33, 'checkbox', 'PPF2C', NULL, NULL),
('PPF2C4', 'D. Belum terdapat kebijakan pemberian penghargaan dan sanksi', 0.00, 'checkbox', 'PPF2C', NULL, NULL),
('PPF2D1', 'A. Telah terdapat sistem pemberian kompensasi bila layanan tidak sesuai standar bagi penerima layanan di seluruh jenis layanan', 1.00, 'checkbox', 'PPF2D', NULL, NULL),
('PPF2D2', 'B. Telah terdapat sistem pemberian kompensasi bila layanan tidak sesuai standar bagi penerima layanan di sebagian besar jenis layanan ', 0.67, 'checkbox', 'PPF2D', NULL, NULL),
('PPF2D3', 'C. Telah terdapat sistem pemberian kompensasi bila layanan tidak sesuai standar bagi penerima layanan di sebagian kecil jenis layanan ', 0.33, 'checkbox', 'PPF2D', NULL, NULL),
('PPF2D4', 'D. Belum terdapat sistem pemberian kompensasi bila layanan tidak sesuai standar', 0.00, 'checkbox', 'PPF2D', NULL, NULL),
('PPF2E1', 'A. Jika seluruh pelayanan sudah dilakukan secara terpadu/terintegrasi', 1.00, 'checkbox', 'PPF2E', NULL, NULL),
('PPF2E2', 'B. Jika sebagian besar pelayanan sudah dilakukan secara terpadu/terintegrasi', 0.67, 'checkbox', 'PPF2E', NULL, NULL),
('PPF2E3', 'C. Jika sebagian kecil pelayanan sudah dilakukan secara terpadu/terintegrasi', 0.33, 'checkbox', 'PPF2E', NULL, NULL),
('PPF2E4', 'D. Jika tidak ada pelayanan yang dilakukan secara terpadu/terintegrasi', 0.00, 'checkbox', 'PPF2E', NULL, NULL),
('PPF2F1', 'A. Jika unit kerja telah memiliki inovasi pelayanan yang  berbeda dengan unit kerja lain dan mendekatkan pelayanan dengan masyarakat serta telah direplikasi', 1.00, 'checkbox', 'PPF2F', NULL, NULL),
('PPF2F2', 'B. Jika unit kerja telah memiliki inovasi pelayanan yang  berbeda dengan unit kerja lain dan mendekatkan pelayanan dengan masyarakat', 0.75, 'checkbox', 'PPF2F', NULL, NULL),
('PPF2F3', 'C. Jika unit kerja memiliki inovasi yang merupakan replikasi dan pengembangan dari inovasi yang sudah ada ', 0.50, 'checkbox', 'PPF2F', NULL, NULL),
('PPF2F4', 'D. Jika unit kerja telah memiliki inovasi akan tetapi merupakan pelaksanaan inovasi dari instansi pemerintah ', 0.25, 'checkbox', 'PPF2F', NULL, NULL),
('PPF2F5', 'E. Jika  unit kerja belum memiliki inovasi pelayanan', 0.00, 'checkbox', 'PPF2F', NULL, NULL),
('PPF3A1', 'A. Terdapat media konsultasi dan pengaduan secara offline dan online, tersedia petugas khusus yang menangani, dan terintegrasi dengan SP4N-LAPOR!', 1.00, 'checkbox', 'PPF3A', NULL, NULL),
('PPF3A2', 'B. Terdapat media konsultasi dan pengaduan secara offline dan online, tersedia petugas khusus yang menangani namun belum terintegrasi dengan SP4N-LAPOR!', 0.75, 'checkbox', 'PPF3A', NULL, NULL),
('PPF3A3', 'C. Terdapat media konsultasi dan pengaduan secara offline dan online, namun belum tersedia petugas khusus yang menangani', 0.50, 'checkbox', 'PPF3A', NULL, NULL),
('PPF3A4', 'D. Hanya terdapat media konsultasi dan pengaduan secara offline', 0.25, 'checkbox', 'PPF3A', NULL, NULL),
('PPF3A5', 'E. Tidak terdapat media konsultasi dan pengaduan', 0.00, 'checkbox', 'PPF3A', NULL, NULL),
('PPF3B1', 'A. Terdapat unit pengelola khusus untuk konsultasi dan pengaduan, serta surat penugasan pengelola SP4N-LAPOR! di level unit kerja', 1.00, 'checkbox', 'PPF3B', NULL, NULL),
('PPF3B2', 'B. Terdapat SK pengelola SP4N-LAPOR! di level instansi dan/atau surat penugasan pengelola SP4N-LAPOR! di level unit kerja, namun unit pengelola khusus untuk konsultasi dan pengaduan belum ada', 0.50, 'checkbox', 'PPF3B', NULL, NULL),
('PPF3B3', 'C. Belum terdapat unit pengelola khusus untuk konsultasi dan pengaduan, serta belum terdapat SK pengelola SP4N-LAPOR! di level instansi dan/atau surat penugasan pengelola SP4N-LAPOR! di level unit kerja', 0.00, 'checkbox', 'PPF3B', NULL, NULL),
('PPF3C1', 'A. Evaluasi atas penanganan keluhan/masukan dan konsultasi dilakukan secara berkala', 1.00, 'checkbox', 'PPF3C', NULL, NULL),
('PPF3C2', 'B. Evaluasi  atas penanganan keluhan/masukan dan konsultasi dilakukan  tidak berkala', 0.50, 'checkbox', 'PPF3C', NULL, NULL),
('PPF3C3', 'C. Belum dilakukan evaluasi penanganan keluhan/masukan dan konsultasi', 0.00, 'checkbox', 'PPF3C', NULL, NULL),
('PPF4A1', 'A. Survei kepuasan masyarakat terhadap pelayanan dilakukan minimal 4 kali dalam setahun', 1.00, 'checkbox', 'PPF4A', NULL, NULL),
('PPF4A2', 'B. Survei kepuasan masyarakat terhadap pelayanan dilakukan minimal 3 kali dalam setahun', 0.75, 'checkbox', 'PPF4A', NULL, NULL),
('PPF4A3', 'C. Survei kepuasan masyarakat terhadap pelayanan dilakukan minimal 2 kali dalam setahun', 0.50, 'checkbox', 'PPF4A', NULL, NULL),
('PPF4A4', 'D. Survei kepuasan masyarakat terhadap pelayanan dilakukan minimal 1 kali dalam setahun', 0.25, 'checkbox', 'PPF4A', NULL, NULL),
('PPF4A5', 'E. Belum dilakukan survei kepuasan masyarakat terhadap pelayanan', 0.00, 'checkbox', 'PPF4A', NULL, NULL),
('PPF4B1', 'A. Hasil survei kepuasan masyarakat dapat diakses secara  online (website, media sosial, dll) dan offline', 1.00, 'checkbox', 'PPF4B', NULL, NULL),
('PPF4B2', 'B. Hasil survei kepuasan masyarakat hanya dapat diakses secara offline di tempat layanan', 0.50, 'checkbox', 'PPF4B', NULL, NULL),
('PPF4B3', 'C. Hasil survei kepuasan masyarakat tidak dipublikasi', 0.00, 'checkbox', 'PPF4B', NULL, NULL),
('PPF4C1', 'A. Jika dilakukan tindak lanjut atas seluruh hasil survei kepuasan masyarakat', 1.00, 'checkbox', 'PPF4C', NULL, NULL),
('PPF4C2', 'B. Jika dilakukan tindak lanjut atas sebagian besar hasil survei kepuasan masyarakat', 0.67, 'checkbox', 'PPF4C', NULL, NULL),
('PPF4C3', 'C. Jika dilakukan tindak lanjut atas sebagian kecil hasil survei kepuasan masyarakat', 0.33, 'checkbox', 'PPF4C', NULL, NULL),
('PPF4C4', 'D. Jika belum dilakukan tindak lanjut atas hasil survei kepuasan masyarakat', 0.00, 'checkbox', 'PPF4C', NULL, NULL),
('PPF5A1', 'A. Terdapat pelayanan yang menggunakan teknologi informasi pada seluruh proses pemberian layanan', 1.00, 'checkbox', 'PPF5A', NULL, NULL),
('PPF5A2', 'B. Terdapat pelayanan yang menggunakan teknologi informasi pada sebagian besar proses pemberian layanan', 0.67, 'checkbox', 'PPF5A', NULL, NULL),
('PPF5A3', 'C. Terdapat pelayanan yang menggunakan teknologi informasi pada sebagian kecil proses pemberian layanan', 0.33, 'checkbox', 'PPF5A', NULL, NULL),
('PPF5A4', 'D. Terdapat pelayanan yang belum menggunakan teknologi informasi pada proses pemberian pelayanan', 0.00, 'checkbox', 'PPF5A', NULL, NULL),
('PPF5B1', 'Ya,jika tela membangun database pelayanan yang terintegrasi', 1.00, 'checkbox', 'PPF5B', NULL, NULL),
('PPF5B2', 'Tidak', 0.00, 'checkbox', 'PPF5B', NULL, NULL),
('PPF5C1', 'A. Perbaikan dilakukan secara terus-menerus', 1.00, 'checkbox', 'PPF5C', NULL, NULL),
('PPF5C2', 'B. Perbaikan dilakukan tidak secara terus menerus', 0.50, 'checkbox', 'PPF5C', NULL, NULL),
('PPF5C3', 'C. Belum dilakukan perbaikan ', 0.00, 'checkbox', 'PPF5C', NULL, NULL),
('PRA1A1', 'Jumlah Agen Perubahan', 1.00, 'input', 'PRA1A', NULL, NULL),
('PRA1A2', 'Jumlah Perubahan yang dibuat', 1.00, 'input', 'PRA1A', NULL, NULL),
('PRA1B1', 'Jumlah Perubahan yang dibuat', 1.00, 'input', 'PRA1B', NULL, NULL),
('PRA1B2', 'Jumlah Perubahan yang telah diintegrasikan dalam sistem manajemen', 1.00, 'input', 'PRA1B', NULL, NULL),
('PRA2A1', 'A. Target capaian zona integritas sudah ada di dokumen perencanaan unit kerja dan sebagian besar (diatas 80%) sudah tercapai', 1.00, 'checkbox', 'PRA2A', NULL, NULL),
('PRA2A2', 'B. Target capaian zona integritas sudah ada di dokumen perencanaan unit kerja dan sebagian (diatas 50%) sudah tercapai', 0.75, 'checkbox', 'PRA2A', NULL, NULL),
('PRA2A3', 'C. Target capaian zona integritas sudah ada di dokumen perencanaan unit kerja dan sebagian kecil (dibawah 50%) sudah tercapai', 0.50, 'checkbox', 'PRA2A', NULL, NULL),
('PRA2A4', 'D. Target capaian zona integritassudah ada di dokumen perencanaan unit kerja, namun belum ada yang tercapai (masih dalam tahap pembangunan)', 0.25, 'checkbox', 'PRA2A', NULL, NULL),
('PRA2A5', 'E. Tidak ada target capaian zona integritasdi dokumen perencanaan unit kerja', 0.00, 'checkbox', 'PRA2A', NULL, NULL),
('PRA3A1', 'A. Budaya kerja dan nilai-nilai organisasi telah dinternalisasi ke seluruh anggota organisasi, dan penerapannya dituangkan dalam standar operasional pelaksanaan kegiatan/tugas ', 1.00, 'checkbox', 'PRA3A', NULL, NULL),
('PRA3A2', 'B. Budaya kerja dan nilai-nilai organisasi telah dinternalisasi ke seluruh anggota organisasi, namun belum dituangkan dalam standar operasional pelaksanaan kegiatan/tugas', 0.67, 'checkbox', 'PRA3A', NULL, NULL),
('PRA3A3', 'C. Budaya kerja dan nilai-nilai organisasi telah disusun, namun belum dinternalisasi ke seluruh anggota organisasi', 0.33, 'checkbox', 'PRA3A', NULL, NULL),
('PRA3A4', 'D. Belum menyusun budaya kerja dan nilai-nilai organisasi', 0.00, 'checkbox', 'PRA3A', NULL, NULL),
('PRB1A1', 'A. Peta proses bisnis telah disusun dan mempengaruhi penyederhanaan seluruh jabatan', 1.00, 'checkbox', 'PRB1A', NULL, NULL),
('PRB1A2', 'B. Peta proses bisnis telah disusun dan mempengaruhi penyederhanaan sebagian besar (lebih dari 50%) jabatan', 0.67, 'checkbox', 'PRB1A', NULL, NULL),
('PRB1A3', 'C. Peta proses bisnis telah disusun dan mempengaruhi penyederhanaan sebagian kecil (kurang dari 50%)  jabatan', 0.33, 'checkbox', 'PRB1A', NULL, NULL),
('PRB1A4', 'D. Peta proses bisnis telah disusun dan belum mempengaruhi penyederhanaan jabatan', 0.00, 'checkbox', 'PRB1A', NULL, NULL),
('PRB2A1', 'A. Implementasi SPBE telah terintegrasi dan mampu mendorong pelaksanaan pelayanan publik yang lebih cepat dan efisien ', 1.00, 'checkbox', 'PRB2A', NULL, NULL),
('PRB2A2', 'B. Implementasi SPBE telah mampu mendorong pelaksanaan pelayanan publik yang lebih cepat dan efisien, namun belum terintegrasi (parsial)', 0.50, 'checkbox', 'PRB2A', NULL, NULL),
('PRB2A3', 'C. Implementasi SPBE belum mendorong pelaksanaan pelayanan publik yang lebih cepat dan efisien', 0.00, 'checkbox', 'PRB2A', NULL, NULL),
('PRB2B1', 'A. Implementasi SPBE telah terintegrasi dan mampu mendorong pelaksanaan pelayanan internal unit kerja yang lebih cepat dan efisien ', 1.00, 'checkbox', 'PRB2B', NULL, NULL),
('PRB2B2', 'B. Implementasi SPBE telah mampu mendorong pelaksanaan pelayanan internal unit kerja yang lebih cepat dan efisien, namun belum terintegrasi (parsial)', 0.50, 'checkbox', 'PRB2B', NULL, NULL),
('PRB2B3', 'C. Implementasi SPBE belum mendorong pelaksanaan pelayanan internal unit kerja yang lebih cepat dan efisien', 0.00, 'checkbox', 'PRB2B', NULL, NULL),
('PRB3A1', 'A. Kriteria huruf b telah terpenuhi dan penerapan atau penggunaan dari manfaat/dampak dari transformasi digital pada bidang proses bisnis utama bagi unit kerja telah dilakukan validasi dan evaluasi serta ditindaklanjuti secara berkelanjutan', 1.00, 'checkbox', 'PRB3A', NULL, NULL),
('PRB3A2', 'B. Kriteria huruf c telah terpenuhi dan manfaat/dampak dari transformasi digital pada bidang proses bisnis utama telah diterapkan/digunakan oleh unit kerja sesuai dengan sasaran dan target manfaat/dampak', 0.75, 'checkbox', 'PRB3A', NULL, NULL);
INSERT INTO `opsi` (`id`, `rincian`, `bobot`, `type`, `pertanyaan_id`, `created_at`, `updated_at`) VALUES
('PRB3A3', 'C. Kriteria huruf d telah terpenuhi dan manfaat/dampak dari transformasi digital pada bidang proses bisnis utama telah mampu direalisasikan pada unit kerja sesuai dengan sasaran dan target manfaat/dampak', 0.50, 'checkbox', 'PRB3A', NULL, NULL),
('PRB3A4', 'D. Kriteria huruf e telah terpenuhi dan kapabilitas prakiraan dan pelacakan terhadap sasaran dan target manfaat/dampak dari transformasi digital pada bidang proses bisnis utama', 0.25, 'checkbox', 'PRB3A', NULL, NULL),
('PRB3A5', 'E. Sasaran dan target manfaat/dampak dari transformasi digital pada bidang proses bisnis utama telah direncanakan, didefinisikan, dan ditetapkan', 0.00, 'checkbox', 'PRB3A', NULL, NULL),
('PRB3B1', 'A. Kriteria huruf b telah terpenuhi dan penerapan atau penggunaan dari manfaat/dampak dari transformasi digital pada bidang administrasi pemerintahan bagi unit kerja telah dilakukan validasi dan evaluasi serta ditindaklanjuti secara berkelanjutan', 1.00, 'checkbox', 'PRB3B', NULL, NULL),
('PRB3B2', 'B. Kriteria huruf c telah terpenuhi dan manfaat/dampak dari transformasi digital pada bidang administrasi pemerintahan telah diterapkan/digunakan oleh unit kerja sesuai dengan sasaran dan target manfaat/dampak', 0.75, 'checkbox', 'PRB3B', NULL, NULL),
('PRB3B3', 'C. Kriteria huruf d telah terpenuhi dan manfaat/dampak dari transformasi digital pada bidang administrasi pemerintahan telah mampu direalisasikan pada unit kerja sesuai dengan sasaran dan target manfaat/dampak', 0.50, 'checkbox', 'PRB3B', NULL, NULL),
('PRB3B4', 'D. Kriteria huruf e telah terpenuhi dan kapabilitas prakiraan dan pelacakan terhadap sasaran dan target manfaat/dampak dari transformasi digital pada bidang administrasi pemerintahan', 0.25, 'checkbox', 'PRB3B', NULL, NULL),
('PRB3B5', 'E. Sasaran dan target manfaat/dampak dari transformasi digital pada bidang administrasi pemerintahan telah direncanakan, didefinisikan, dan ditetapkan', 0.00, 'checkbox', 'PRB3B', NULL, NULL),
('PRB3C1', 'A. Kriteria huruf b telah terpenuhi dan penerapan atau penggunaan dari manfaat/dampak dari transformasi digital pada bidang pelayanan publik bagi unit kerja telah dilakukan validasi dan evaluasi serta ditindaklanjuti secara berkelanjutan', 1.00, 'checkbox', 'PRB3C', NULL, NULL),
('PRB3C2', 'B. Kriteria huruf c telah terpenuhi dan manfaat/dampak dari transformasi digital pada bidang pelayanan publik telah diterapkan/digunakan oleh unit kerja sesuai dengan sasaran dan target manfaat/dampak', 0.75, 'checkbox', 'PRB3C', NULL, NULL),
('PRB3C3', 'C. Kriteria huruf d telah terpenuhi dan manfaat/dampak dari transformasi digital pada bidang pelayanan publik telah mampu direalisasikan pada unit kerja sesuai dengan sasaran dan target manfaat/dampak', 0.50, 'checkbox', 'PRB3C', NULL, NULL),
('PRB3C4', 'D. Kriteria huruf e telah terpenuhi dan kapabilitas prakiraan dan pelacakan terhadap sasaran dan target manfaat/dampak dari transformasi digital pada bidang pelayanan publik', 0.25, 'checkbox', 'PRB3C', NULL, NULL),
('PRB3C5', 'E. Sasaran dan target manfaat/dampak dari transformasi digital pada bidang pelayanan publik telah direncanakan, didefinisikan, dan ditetapkan', 0.00, 'checkbox', 'PRB3C', NULL, NULL),
('PRC1A1', 'A. Seluruh ukuran kinerja individu telah berorientasi hasil (outcome) sesuai pada levelnya', 1.00, 'checkbox', 'PRC1A', NULL, NULL),
('PRC1A2', 'B. Sebagian ukuran kinerja individu telah berorientasi hasil (outcome) sesuai pada levelnya', 0.50, 'checkbox', 'PRC1A', NULL, NULL),
('PRC1A3', 'C. Tidak ada ukuran kinerja individu yang berorientasi hasil (outcome)', 0.00, 'checkbox', 'PRC1A', NULL, NULL),
('PRC2A1', 'A. Seluruh hasil assessment dijadikan dasar mutasi internal dan pengembangan kompetensi pegawai', 1.00, 'checkbox', 'PRC2A', NULL, NULL),
('PRC2A2', 'B. Hasil assessment belum seluruhnya dijadikan mutasi internal dan pengembangan kompetensi pegawai', 0.50, 'checkbox', 'PRC2A', NULL, NULL),
('PRC2A3', 'C. Hasil assessment belum dijadikan dasar mutasi internal dan pengembangan kompetensi pegawai', 0.00, 'checkbox', 'PRC2A', NULL, NULL),
('PRC3A1', 'Jumlah pelanggaran tahun sebelumnya', 1.00, 'input', 'PRC3A', NULL, NULL),
('PRC3A2', 'Jumlah pelanggaran tahun ini', 1.00, 'input', 'PRC3A', NULL, NULL),
('PRC3A3', 'Jumlah pelanggaran yang telah diberikan sanksi/hukuman', 1.00, 'input', 'PRC3A', NULL, NULL),
('PRD1A1', 'Jumlah Sasaran Kinerja ', 1.00, 'input', 'PRD1A', NULL, NULL),
('PRD1A2', 'Jumlah Sasaran Kinerja yang tercapai 100% atau lebih ', 1.00, 'input', 'PRD1A', NULL, NULL),
('PRD2A1', 'A. Seluruh capaian kinerja (Perjanjian Kinerja) merupakan unsur dalam pemberian reward and punishment', 1.00, 'checkbox', 'PRD2A', NULL, NULL),
('PRD2A2', 'B. Sebagian besar Capaian Kinerja (lebih dari 50% Perjanjian kinerja) merupakan unsur dalam pemberian reward and punishment', 0.67, 'checkbox', 'PRD2A', NULL, NULL),
('PRD2A3', 'C. Sebagian kecil Capaian Kinerja (kurang dari 50% Perjanjian kinerja) merupakan unsur dalam pemberian reward and punishment', 0.33, 'checkbox', 'PRD2A', NULL, NULL),
('PRD2A4', 'D. Capaian Kinerja (Perjanjian kinerja) belum menjadi unsur dalam pemberian reward and punishment', 0.00, 'checkbox', 'PRD2A', NULL, NULL),
('PRD3A1', 'A. terdapat Kerangka Logis kinerja yang mengacu pada kinerja utama organisasi  dan digunakan dalam penjabaran kinerja seluruh pegawai', 1.00, 'checkbox', 'PRD3A', NULL, NULL),
('PRD3A2', 'B. terdapat  Kerangka Logis kinerja yang mengacu pada kinerja utama organisasi namun belum digunakan dalam penjabaran kinerja seluruh pegawai', 0.67, 'checkbox', 'PRD3A', NULL, NULL),
('PRD3A3', 'C. Kerangka Logis kinerja ada namun belum mengacu pada kinerja utama organisasi dan belum digunakan dalam penjabaran kinerja seluruh pegawai', 0.33, 'checkbox', 'PRD3A', NULL, NULL),
('PRD3A4', 'D. Kerangka Logis kinerja belum ada', 0.00, 'checkbox', 'PRD3A', NULL, NULL),
('PRE1A1', 'A. Terdapat pengendalian aktivitas utama organisasi yang tersistem mulai dari perencanaan, penilaian risiko, pelaksanaan, monitoring, dan pelaporan oleh penanggung jawab aktivitas serta pimpinan unit kerja dan telah menghasilkan peningkatan kinerja, mekan', 1.00, 'checkbox', 'PRE1A', NULL, NULL),
('PRE1A2', 'B. Terdapat pengendalian aktivitas utama organisasi yang tersistem mulai dari perencanaan, penilaian risiko, pelaksanaan, monitoring, dan pelaporan oleh penanggung jawab aktivitas serta pimpinan unit kerja namun belum berdampak pada peningkatan kinerja un', 0.75, 'checkbox', 'PRE1A', NULL, NULL),
('PRE1A3', 'C.Terdapat pengendalian aktivitas utama organisasi yang tersistem mulai dari perencanaan, penilaian risiko, pelaksanaan, monitoring, dan pelaporan oleh penanggung jawab aktivitas', 0.50, 'checkbox', 'PRE1A', NULL, NULL),
('PRE1A4', 'D. Terdapat pengendalian aktivitas utama organisasi tetapi tidak tersistem', 0.25, 'checkbox', 'PRE1A', NULL, NULL),
('PRE1A5', 'E. Tidak terdapat pengendalian atas aktivitas utama organisasi', 0.00, 'checkbox', 'PRE1A', NULL, NULL),
('PRE2A1', 'Jumlah pengaduan masyarakat yang harus ditindaklanjuti', 1.00, 'input', 'PRE2A', NULL, NULL),
('PRE2A2', 'Jumlah pengaduan masyarakat yang sedang diproses', 1.00, 'input', 'PRE2A', NULL, NULL),
('PRE2A3', 'Jumlah pengaduan masyarakat yang  selesai ditindaklanjuti', 1.00, 'input', 'PRE2A', NULL, NULL),
('PRE3A1', 'Persentase penyampaian LHKPN', 1.00, 'input', 'PRE3A', NULL, NULL),
('PRE3A2', 'Jumlah yang harus melaporkan - Kepala Satuan Kerja', 1.00, 'input', 'PRE3A', NULL, NULL),
('PRE3A3', 'Jumlah yang harus melaporkan - Pejabat yang diwajibkan menyampaikan LHKPN', 1.00, 'input', 'PRE3A', NULL, NULL),
('PRE3A4', 'Jumlah yang harus melaporkan - Lainnya', 1.00, 'input', 'PRE3A', NULL, NULL),
('PRE3A5', 'Jumlah yang sudah melaporkan', 1.00, 'input', 'PRE3A', NULL, NULL),
('PRE3B1', 'Persentase penyampaian LHKASN', 1.00, 'input', 'PRE3B', NULL, NULL),
('PRE3B2', 'Jumlah yang harus melaporkan (ASN tidak wajib LHKPN) - Pejabat administrator (eselon III)', 1.00, 'input', 'PRE3B', NULL, NULL),
('PRE3B3', 'Jumlah yang harus melaporkan (ASN tidak wajib LHKPN) - Pejabat Penawas (eselon IV)', 1.00, 'input', 'PRE3B', NULL, NULL),
('PRE3B4', 'Jumlah yang harus melaporkan (ASN tidak wajib LHKPN) - Jumlah Fungsional dan Pelaksana', 1.00, 'input', 'PRE3B', NULL, NULL),
('PRE3B5', 'Jumlah yang sudah melaporkan', 1.00, 'input', 'PRE3B', NULL, NULL),
('PRF1A1', 'A. Upaya dan/atau inovasi yang dilakukan telah mendorong perbaikan seluruh pelayanan publik yang prima (lebih Cepat dan mudah) ', 1.00, 'checkbox', 'PRF1A', NULL, NULL),
('PRF1A2', 'B. Upaya dan/atau inovasi yang dilakukan belum seluruhnya memberikan dampak pada perbaikan pelayanan public yang prima (Cepat dan mudah) ', 0.67, 'checkbox', 'PRF1A', NULL, NULL),
('PRF1A3', 'C. Upaya dan/atau inovasi yang dilakukan belum sesuai kebutuhan ', 0.33, 'checkbox', 'PRF1A', NULL, NULL),
('PRF1A4', 'D. Belum ada inovasi', 0.00, 'checkbox', 'PRF1A', NULL, NULL),
('PRF1B1', 'Jumlah perijinan/pelayanan yang terdata/terdaftar', 1.00, 'input', 'PRF1B', NULL, NULL),
('PRF1B2', 'Jumlah perijinan/pelayanan yang telah dipermudah ', 1.00, 'input', 'PRF1B', NULL, NULL),
('PRF2A1', 'A. Pengaduan pelayanan  dan konsultasi telah direspon dengan cepat melalui berbagai kanal/media', 1.00, 'checkbox', 'PRF2A', NULL, NULL),
('PRF2A2', 'B. Pengaduan pelayanan dan konsultasi telah direspon dengan cepat melalui kanal/media yang terbatas', 0.67, 'checkbox', 'PRF2A', NULL, NULL),
('PRF2A3', 'C. Pengaduan pelayanan dan konsultasi direspon lambat melalui berbagai kanal/media', 0.33, 'checkbox', 'PRF2A', NULL, NULL),
('PRF2A4', 'D. Pengaduan pelayanan dan konsultasi direspon lambat dan kanal/media terbatas', 0.00, 'checkbox', 'PRF2A', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengawasan_satker`
--

CREATE TABLE `pengawasan_satker` (
  `id` bigint(19) NOT NULL,
  `satker_id` int(4) NOT NULL,
  `anggota_id` bigint(19) NOT NULL,
  `tahap` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpi_id` char(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengawasan_satker`
--

INSERT INTO `pengawasan_satker` (`id`, `satker_id`, `anggota_id`, `tahap`, `status`, `tpi_id`, `created_at`, `updated_at`) VALUES
(1232132121451600, 1600, 123213212145, '1', '0', 'TIM12023WIL3', '2023-07-03 07:13:04', '2023-07-03 07:13:04'),
(1232132121451603, 1603, 123213212145, '1', '0', 'TIM12023WIL3', '2023-07-03 07:12:51', '2023-07-03 07:12:51'),
(1992092620171041100, 1100, 199209262017104, '1', '0', 'TIM12023WIL2', '2023-07-03 07:38:17', '2023-07-03 07:38:17'),
(1992092620171041104, 1104, 199209262017104, '1', '0', 'TIM12023WIL2', '2023-07-03 07:38:17', '2023-07-03 07:38:17'),
(1992092620171121115, 1115, 199209262017112, '1', '0', 'TIM12023WIL2', '2023-07-03 07:38:26', '2023-07-03 07:38:26'),
(1992092620171121118, 1118, 199209262017112, '1', '0', 'TIM12023WIL2', '2023-07-03 07:38:26', '2023-07-03 07:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persyaratan`
--

CREATE TABLE `persyaratan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `satker_id` int(4) NOT NULL,
  `wbk` int(1) NOT NULL DEFAULT '0',
  `wbbm` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persyaratan`
--

INSERT INTO `persyaratan` (`id`, `tahun`, `satker_id`, `wbk`, `wbbm`) VALUES
(16002023, 2023, 1600, 1, 1),
(16032023, 2023, 1603, 1, 0),
(31702023, 2023, 3170, 1, 1),
(31712023, 2023, 3171, 1, 0),
(31722023, 2023, 3172, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` double(6,2) NOT NULL,
  `subpilar_id` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pertanyaan`
--

INSERT INTO `pertanyaan` (`id`, `pertanyaan`, `info`, `bobot`, `subpilar_id`, `created_at`, `updated_at`) VALUES
('PPA1A', 'Unit kerja telah membentuk tim untuk melakukan pembangunan Zona Integritas ', 'http://s.bps.go.id/TimKerja_A', 1.00, 'PPA1', NULL, '2023-06-20 00:51:53'),
('PPA1B', 'Penentuan anggota Tim dipilih melalui prosedur/mekanisme yang jelas', 'http://s.bps.go.id/TimKerja_B ', 1.00, 'PPA1', NULL, NULL),
('PPA2A', 'Terdapat dokumen rencana kerja pembangunan Zona Integritas menuju WBK/WBBM', 'http://s.bps.go.id/DokumenZI_A', 1.00, 'PPA2', NULL, NULL),
('PPA2B', 'Dalam dokumen pembangunan terdapat target-target prioritas yang relevan dengan tujuan pembangunan WBK/WBBM', 'http://s.bps.go.id/DokumenZI_B', 1.00, 'PPA2', NULL, NULL),
('PPA2C', 'Terdapat mekanisme atau media untuk mensosialisasikan pembangunan WBK/WBBM', 'http://s.bps.go.id/DokumenZI_C', 1.00, 'PPA2', NULL, NULL),
('PPA3A', 'Seluruh kegiatan pembangunan sudah dilaksanakan sesuai dengan rencana', 'http://s.bps.go.id/Pemantauan_A', 1.00, 'PPA3', NULL, NULL),
('PPA3B', 'Terdapat monitoring dan evaluasi terhadap pembangunan Zona Integritas', 'http://s.bps.go.id/Pemantauan_B', 1.00, 'PPA3', NULL, NULL),
('PPA3C', 'Hasil Monitoring dan Evaluasi telah ditindaklanjuti', 'http://s.bps.go.id/Pemantauan_C', 1.00, 'PPA3', NULL, NULL),
('PPA4A', 'Pimpinan berperan sebagai role model dalam pelaksanaan Pembangunan WBK/WBBM', 'http://s.bps.go.id/PolaPikir_A', 1.00, 'PPA4', NULL, NULL),
('PPA4B', 'Sudah ditetapkan agen perubahan', 'http://s.bps.go.id/PolaPikir_B', 1.00, 'PPA4', NULL, NULL),
('PPA4C', 'Telah dibangun budaya kerja dan pola pikir di lingkungan organisasi', 'http://s.bps.go.id/PolaPikir_C', 1.00, 'PPA4', NULL, NULL),
('PPA4D', 'Anggota organisasi terlibat dalam pembangunan Zona Integritas menuju WBK/WBBM', 'http://s.bps.go.id/PolaPikir_D', 1.00, 'PPA4', NULL, NULL),
('PPB1A', 'SOP mengacu pada peta proses bisnis instansi', 'http://s.bps.go.id/SOP_A', 1.00, 'PPB1', NULL, NULL),
('PPB1B', 'Prosedur operasional tetap (SOP) telah diterapkan', 'http://s.bps.go.id/SOP_B', 1.00, 'PPB1', NULL, NULL),
('PPB1C', 'Prosedur operasional tetap (SOP) telah dievaluasi', 'http://s.bps.go.id/SOP_C', 1.00, 'PPB1', NULL, NULL),
('PPB2A', 'Sistem pengukuran kinerja unit sudah menggunakan teknologi informasi', 'http://s.bps.go.id/EOffice_A', 1.00, 'PPB2', NULL, NULL),
('PPB2B', 'Operasionalisasi manajemen SDM sudah menggunakan teknologi informasi', 'http://s.bps.go.id/EOffice_B', 1.00, 'PPB2', NULL, NULL),
('PPB2C', 'Pemberian pelayanan kepada publik sudah menggunakan teknologi informasi', 'http://s.bps.go.id/EOffice_C', 1.00, 'PPB2', NULL, NULL),
('PPB2D', 'Telah dilakukan monitoring dan dan evaluasi terhadap pemanfaatan teknologi informasi dalam pengukuran kinerja unit, operasionalisasi SDM, dan pemberian layanan kepada publik', 'http://s.bps.go.id/EOffice_D', 1.00, 'PPB2', NULL, NULL),
('PPB3A', 'Kebijakan tentang  keterbukaan informasi publik telah diterapkan', 'http://s.bps.go.id/KIP_A', 1.00, 'PPB3', NULL, NULL),
('PPB3B', 'Telah dilakukan monitoring dan evaluasi pelaksanaan kebijakan keterbukaan informasi publik', 'http://s.bps.go.id/KIP_B', 1.00, 'PPB3', NULL, NULL),
('PPC1A', 'Kebutuhan pegawai yang disusun oleh unit kerja mengacu kepada peta jabatan dan hasil analisis beban kerja untuk masing-masing jabatan', 'http://s.bps.go.id/SDMPerencanaan_A', 1.00, 'PPC1', NULL, NULL),
('PPC1B', 'Penempatan pegawai hasil rekrutmen murni mengacu kepada kebutuhan pegawai yang telah disusun per jabatan', 'http://s.bps.go.id/SDMPerencanaan_B', 1.00, 'PPC1', NULL, NULL),
('PPC1C', 'Telah dilakukan monitoring dan dan evaluasi terhadap penempatan pegawai rekrutmen untuk memenuhi kebutuhan jabatan dalam organisasi telah memberikan perbaikan terhadap kinerja unit kerja', 'http://s.bps.go.id/SDMPerencanaan_C', 1.00, 'PPC1', NULL, NULL),
('PPC2A', 'Dalam melakukan pengembangan karier pegawai, telah dilakukan mutasi pegawai antar jabatan', 'http://s.bps.go.id/Mutasi_A', 1.00, 'PPC2', NULL, NULL),
('PPC2B', 'Dalam melakukan mutasi pegawai antar jabatan telah memperhatikan kompetensi jabatan dan mengikuti pola mutasi yang telah ditetapkan', 'http://s.bps.go.id/Mutasi_B', 1.00, 'PPC2', NULL, NULL),
('PPC2C', 'Telah dilakukan monitoring dan evaluasi terhadap kegiatan mutasi yang telah dilakukan dalam kaitannya dengan perbaikan kinerja', 'http://s.bps.go.id/Mutasi_C', 1.00, 'PPC2', NULL, NULL),
('PPC3A', 'Unit Kerja melakukan Training Need Analysis Untuk pengembangan kompetensi', 'http://s.bps.go.id/Kompetensi_A', 1.00, 'PPC3', NULL, NULL),
('PPC3B', 'Dalam menyusun rencana pengembangan kompetensi pegawai, telah mempertimbangkan hasil pengelolaan kinerja pegawai', 'http://s.bps.go.id/Kompetensi_B', 1.00, 'PPC3', NULL, NULL),
('PPC3C', ' Tingkat kesenjangan kompetensi pegawai yang ada dengan standar kompetensi yang ditetapkan untuk masing-masing jabatan', 'http://s.bps.go.id/Kompetensi_C', 1.00, 'PPC3', NULL, NULL),
('PPC3D', 'Pegawai di Unit Kerja telah memperoleh kesempatan/hak untuk mengikuti diklat maupun pengembangan kompetensi lainnya', 'http://s.bps.go.id/Kompetensi_D', 1.00, 'PPC3', NULL, NULL),
('PPC3E', 'Dalam pelaksanaan pengembangan kompetensi, unit kerja melakukan upaya pengembangan kompetensi kepada pegawai (seperti pengikutsertaan pada lembaga pelatihan, in-house training, coaching, atau mentoring)', 'http://s.bps.go.id/Kompetensi_E', 1.00, 'PPC3', NULL, NULL),
('PPC3F', 'Telah dilakukan monitoring dan evaluasi terhadap hasil pengembangan kompetensi dalam kaitannya dengan perbaikan kinerja', 'http://s.bps.go.id/Kompetensi_F', 1.00, 'PPC3', NULL, NULL),
('PPC4A', 'Terdapat penetapan kinerja individu yang terkait dengan perjanjian kinerja organisasi', 'http://s.bps.go.id/IKI_A', 1.00, 'PPC4', NULL, NULL),
('PPC4B', 'Ukuran kinerja individu telah memiliki kesesuaian dengan indikator kinerja individu level diatasnya', 'http://s.bps.go.id/IKI_B', 1.00, 'PPC4', NULL, NULL),
('PPC4C', 'Pengukuran kinerja individu dilakukan secara periodik', 'http://s.bps.go.id/IKI_C', 1.00, 'PPC4', NULL, NULL),
('PPC4D', 'Hasil penilaian kinerja individu telah dijadikan dasar untuk pemberian reward', 'http://s.bps.go.id/IKI_D', 1.00, 'PPC4', NULL, NULL),
('PPC5A', 'Aturan disiplin/kode etik/kode perilaku telah dilaksanakan/diimplementasikan', 'http://s.bps.go.id/Disiplin_A', 1.00, 'PPC5', NULL, NULL),
('PPC6A', 'Data informasi kepegawaian unit kerja telah dimutakhirkan secara berkala', 'http://s.bps.go.id/SIK_A', 1.00, 'PPC6', NULL, NULL),
('PPD1A', 'Unit kerja telah melibatkan pimpinan secara langsung pada saat penyusunan perencanaan', 'http://s.bps.go.id/Pimpinan_A', 1.00, 'PPD1', NULL, NULL),
('PPD1B', 'Unit kerja telah melibatkan secara langsung pimpinan saat penyusunan penetapan kinerja', 'http://s.bps.go.id/Pimpinan_B', 1.00, 'PPD1', NULL, NULL),
('PPD1C', 'Pimpinan memantau pencapaian kinerja secara berkala', 'http://s.bps.go.id/Pimpinan_C', 1.00, 'PPD1', NULL, NULL),
('PPD2A', 'Dokumen perencanaan kinerja sudah ada', 'http://s.bps.go.id/Pengelolaan_A', 1.00, 'PPD2', NULL, NULL),
('PPD2B', 'Perencanaan kinerja telah berorientasi hasil', 'http://s.bps.go.id/Pengelolaan_B', 1.00, 'PPD2', NULL, NULL),
('PPD2C', 'Terdapat penetapan Indikator Kinerja Utama (IKU)', 'http://s.bps.go.id/Pengelolaan_C', 1.00, 'PPD2', NULL, NULL),
('PPD2D', 'Indikator kinerja telah telah memenuhi kriteria SMART', 'http://s.bps.go.id/Pengelolaan_D', 1.00, 'PPD2', NULL, NULL),
('PPD2E', 'Laporan kinerja telah disusun tepat waktu', 'http://s.bps.go.id/Pengelolaan_E', 1.00, 'PPD2', NULL, NULL),
('PPD2F', 'Laporan kinerja telah memberikan informasi tentang kinerja', 'http://s.bps.go.id/Pengelolaan_E', 1.00, 'PPD2', NULL, NULL),
('PPD2G', 'Terdapat sistem informasi/mekanisme informasi kinerja', 'http://s.bps.go.id/Pengelolaan_G1', 1.00, 'PPD2', NULL, NULL),
('PPD2H', 'Unit kerja telah berupaya meningkatkan kapasitas SDM yang menangangi akuntabilitas kinerja', 'http://s.bps.go.id/Pengelolaan_H1', 1.00, 'PPD2', NULL, NULL),
('PPE1A', 'Telah dilakukan public campaign tentang pengendalian gratifikasi', 'http://s.bps.go.id/Gratifikasi_A', 1.00, 'PPE1', NULL, NULL),
('PPE1B', 'Pengendalian gratifikasi telah diimplementasikan', 'http://s.bps.go.id/Gratifikasi_B', 1.00, 'PPE1', NULL, NULL),
('PPE2A', 'Telah dibangun lingkungan pengendalian', 'http://s.bps.go.id/SPIP_A', 1.00, 'PPE2', NULL, NULL),
('PPE2B', 'Telah dilakukan penilaian risiko atas pelaksanaan kebijakan', 'http://s.bps.go.id/SPIP_B', 1.00, 'PPE2', NULL, NULL),
('PPE2C', 'Telah dilakukan kegiatan pengendalian untuk meminimalisir risiko yang telah diidentifikasi', 'http://s.bps.go.id/SPIP_C', 1.00, 'PPE2', NULL, NULL),
('PPE2D', 'SPI telah diinformasikan dan dikomunikasikan kepada seluruh pihak terkait', 'http://s.bps.go.id/SPIP_D', 1.00, 'PPE2', NULL, NULL),
('PPE3A', 'Kebijakan Pengaduan masyarakat telah diimplementasikan', 'http://s.bps.go.id/Pengaduan_A', 1.00, 'PPE3', NULL, NULL),
('PPE3B', 'pengaduan masyarakat dtindaklanjuti', 'http://s.bps.go.id/Pengaduan_B', 1.00, 'PPE3', NULL, NULL),
('PPE3C', 'Telah dilakukan monitoring dan evaluasi atas penanganan pengaduan masyarakat', 'http://s.bps.go.id/Pengaduan_C', 1.00, 'PPE3', NULL, NULL),
('PPE3D', 'Hasil evaluasi atas penanganan pengaduan masyarakat telah ditindaklanjuti', 'http://s.bps.go.id/Pengaduan_D', 1.00, 'PPE3', NULL, NULL),
('PPE4A', 'Whistle Blowing System telah diterapkan', 'http://s.bps.go.id/WBS_B', 1.00, 'PPE4', NULL, NULL),
('PPE4B', 'Telah dilakukan evaluasi atas penerapan Whistle Blowing System', 'http://s.bps.go.id/WBS_C', 1.00, 'PPE4', NULL, NULL),
('PPE4C', 'Hasil evaluasi atas penerapan Whistle Blowing System telah ditindaklanjuti', 'http://s.bps.go.id/WBS_D', 1.00, 'PPE4', NULL, NULL),
('PPE5A', 'Telah terdapat identifikasi/pemetaan benturan kepentingan dalam tugas fungsi utama', 'http://s.bps.go.id/COI_A', 1.00, 'PPE5', NULL, NULL),
('PPE5B', 'Penanganan Benturan Kepentingan telah disosialisasikan/internalisasi', 'http://s.bps.go.id/COI_B', 1.00, 'PPE5', NULL, NULL),
('PPE5C', 'Penanganan Benturan Kepentingan telah diimplementasikan', 'http://s.bps.go.id/COI_C', 1.00, 'PPE5', NULL, NULL),
('PPE5D', 'Telah dilakukan evaluasi atas Penanganan Benturan Kepentingan', 'http://s.bps.go.id/COI_D', 1.00, 'PPE5', NULL, NULL),
('PPE5E', 'Hasil evaluasi atas Penanganan Benturan Kepentingan telah ditindaklanjuti', 'http://s.bps.go.id/COI_E', 1.00, 'PPE5', NULL, NULL),
('PPF1A', 'Terdapat kebijakan standar pelayanan', 'http://s.bps.go.id/Standar_A', 1.00, 'PPF1', NULL, NULL),
('PPF1B', 'Standar pelayanan telah dimaklumatkan', 'http://s.bps.go.id/Standar_B', 1.00, 'PPF1', NULL, NULL),
('PPF1C', 'Dilakukan reviu dan perbaikan atas standar pelayanan', 'http://s.bps.go.id/Standar_C', 1.00, 'PPF1', NULL, NULL),
('PPF1D', 'telah melakukan publikasi atas standar pelayanan dan maklumat pelayanan', 'http://s.bps.go.id/Standar_D', 1.00, 'PPF1', NULL, NULL),
('PPF2A', 'Telah dilakukan berbagai upaya peningkatan kemampuan dan/atau kompetensi tentang penerapan budaya pelayanan prima', 'http://s.bps.go.id/Budaya_A', 1.00, 'PPF2', NULL, NULL),
('PPF2B', 'Informasi tentang pelayanan mudah diakses melalui berbagai media', 'http://s.bps.go.id/Budaya_B', 1.00, 'PPF2', NULL, NULL),
('PPF2C', 'Telah terdapat sistem pemberian penghargaan dan sanksi bagi petugas pemberi pelayanan', 'http://s.bps.go.id/Budaya_C', 1.00, 'PPF2', NULL, NULL),
('PPF2D', 'Telah terdapat sistem pemberian kompensasi kepada penerima layanan bila layanan tidak sesuai standar', 'http://s.bps.go.id/Budaya_D', 1.00, 'PPF2', NULL, NULL),
('PPF2E', 'Terdapat sarana layanan terpadu/terintegrasi', 'http://s.bps.go.id/Budaya_E', 1.00, 'PPF2', NULL, NULL),
('PPF2F', 'Terdapat inovasi pelayanan', 'http://s.bps.go.id/Budaya_F', 1.00, 'PPF2', NULL, NULL),
('PPF3A', 'Terdapat media pengaduan dan konsultasi pelayanan yang terintegrasi dengan SP4N-Lapor!', 'http://s.bps.go.id/PengelolaanPengaduan_A', 1.00, 'PPF3', NULL, NULL),
('PPF3B', 'Terdapat unit yang mengelola pengaduan dan konsultasi pelayanan', 'http://s.bps.go.id/PengelolaanPengaduan_B', 1.00, 'PPF3', NULL, NULL),
('PPF3C', 'Telah dilakukan evaluasi atas penanganan keluhan/masukan dan konsultasi', 'http://s.bps.go.id/PengelolaanPengaduan_C', 1.00, 'PPF3', NULL, NULL),
('PPF4A', 'Telah dilakukan survey kepuasan masyarakat terhadap pelayanan', 'http://s.bps.go.id/Kepuasan_A', 1.00, 'PPF4', NULL, NULL),
('PPF4B', 'Hasil survei kepuasan masyarakat dapat diakses secara terbuka', 'http://s.bps.go.id/Kepuasan_B', 1.00, 'PPF4', NULL, NULL),
('PPF4C', 'Dilakukan tindak lanjut atas hasil survei kepuasan masyarakat', 'http://s.bps.go.id/Kepuasan_C', 1.00, 'PPF4', NULL, NULL),
('PPF5A', 'Telah menerapkan teknologi informasi dalam memberikan pelayanan', 'http://s.bps.go.id/PemanfaatanTI_A', 1.00, 'PPF5', NULL, NULL),
('PPF5B', 'Telah membangun database pelayanan yang terintegrasi', 'http://s.bps.go.id/PemanfaatanTI_B', 1.00, 'PPF5', NULL, NULL),
('PPF5C', 'Telah dilakukan perbaikan secara terus menerus', 'http://s.bps.go.id/PemanfaatanTI_C', 1.00, 'PPF5', NULL, NULL),
('PRA1A', 'Agen perubahan telah membuat perubahan yang konkret di Instansi (dalam 1 tahun) ', 'http://s.bps.go.id/KomitmenPerubahan_A', 1.00, 'PRA1', NULL, NULL),
('PRA1B', 'Perubahan yang dibuat Agen Perubahan telah terintegrasi dalam sistem manajemen', 'http://s.bps.go.id/KomitmenPerubahan_B', 1.00, 'PRA1', NULL, NULL),
('PRA2A', 'Pimpinan memiliki komitmen terhadap pelaksanaan reformasi birokrasi, dengan adanya target capaian reformasi yang jelas di dokumen perencanaan', 'http://s.bps.go.id/KomitmenPimpinan', 1.00, 'PRA2', NULL, NULL),
('PRA3A', 'Instansi membangun budaya kerja positif dan menerapkan nilai-nilai organisasi dalam pelaksanaan tugas sehari-hari', 'http://s.bps.go.id/Budaya_Kerja?', 1.00, 'PRA3', NULL, NULL),
('PRB1A', 'Telah disusun peta proses bisnis dengan adanya penyederhanaan jabatan \n ', 'http://s.bps.go.id/PetaProsesBisnis_A', 1.00, 'PRB1', NULL, NULL),
('PRB2A', 'Implementasi SPBE telah terintegrasi dan mampu mendorong pelaksanaan pelayanan publik yang lebih cepat dan efisien', 'http://s.bps.go.id/SPBEPublik', 1.00, 'PRB2', NULL, NULL),
('PRB2B', 'Implementasi SPBE telah terintegrasi dan mampu mendorong pelaksanaan pelayanan internal organisasi yang lebih cepat dan efisien', 'http://s.bps.go.id/SPBEInternal', 1.00, 'PRB2', NULL, NULL),
('PRB3A', 'Transformasi digital pada bidang proses bisnis utama telah mampu memberikan nilai manfaat bagi unit kerja secara optimal ', 'http://s.bps.go.id/TD_Probis', 1.00, 'PRB3', NULL, NULL),
('PRB3B', 'Transformasi digital pada bidang administrasi pemerintahan telah mampu memberikan nilai manfaat bagi unit kerja secara optimal', 'http://s.bps.go.id/TD_AdmPemerintah', 1.00, 'PRB4', NULL, NULL),
('PRB3C', 'Transformasi digital pada bidang pelayanan publik telah mampu memberikan nilai manfaat bagi unit kerja secara optimal', 'http://s.bps.go.id/TD_YanLik', 1.00, 'PRB5', NULL, NULL),
('PRC1A', 'Ukuran kinerja individu telah berorientasi hasil (outcome) sesuai pada levelnya', 'http://s.bps.go.id/KI_A', 1.00, 'PRC1', NULL, NULL),
('PRC2A', 'Hasil assement telah dijadikan pertimbangan untuk mutasi dan pengembangan karir pegawai', 'http://s.bps.go.id/KI_A', 1.00, 'PRC2', NULL, NULL),
('PRC3A', 'Penurunan pelanggaran disiplin pegawai', 'http://s.bps.go.id/KI_A', 1.00, 'PRC3', NULL, NULL),
('PRD1A', 'Persentase Sasaran dengan capaian 100% atau lebih ', 'http://s.bps.go.id/Reform_4a', 1.00, 'PRD1', NULL, NULL),
('PRD2A', 'Hasil Capaian/Monitoring Perjanjian Kinerja telah dijadikan dasar sebagai pemberian reward and punishment bagi organisasi', 'http://s.bps.go.id/Reform_4b', 1.00, 'PRD2', NULL, NULL),
('PRD3A', 'Apakah terdapat penjenjangan kinerja ((Kerangka Logis Kinerja) yang mengacu pada kinerja utama  organisasi dan dijadikan dalam penentuan kinerja seluruh pegawai? ', 'http://s.bps.go.id/Reform_4c', 1.00, 'PRD3', NULL, NULL),
('PRE1A', 'Telah dilakukan mekanisme pengendalian aktivitas secara berjenjang', 'http://s.bps.go.id/Reform_Pengendalian', 1.00, 'PRE1', NULL, NULL),
('PRE2A', 'Persentase penanganan pengaduan masyarakat', 'http://s.bps.go.id/Reform_Pengaduan', 1.00, 'PRE2', NULL, NULL),
('PRE3A', 'Penyampaian Laporan Harta Kekayaan Pejabat Negara (LHKPN)', 'http://s.bps.go.id/Reform_LHKPN', 1.00, 'PRE3', NULL, NULL),
('PRE3B', 'Penyampaian Laporan Harta Kekayaan Aparatur Sipil Negara (LHKASN)', 'http://s.bps.go.id/Reform_LHASN', 1.00, 'PRE3', NULL, NULL),
('PRF1A', 'Upaya dan/atau inovasi telah mendorong perbaikan pelayanan publik pada:\n1. Kesesuaian Persyaratan\n2. Kemudahan Sistem, Mekanisme, dan Prosedur\n3. Kecepatan Waktu Penyelesaian\n4. Kejelasan Biaya/Tarif, Gratis\n5. Kualitas Produk Spesifikasi Jenis Pelayanan\n', 'http://s.bps.go.id/InovasiYanLik_A', 1.00, 'PRF1', NULL, NULL),
('PRF1B', 'Upaya dan/atau inovasi pada perijinan/pelayanan telah dipermudah:\n1. Waktu lebih cepat\n2. Pelayanan Publik yang terpadu\n3. Alur lebih pendek/singkat\n4 Terintegrasi dengan aplikasi', 'http://s.bps.go.id/InovasiYanLik_B', 1.00, 'PRF1', NULL, NULL),
('PRF2A', 'Penanganan pengaduan pelayanan dilakukan melalui berbagai kanal/media secara responsive dan bertanggung jawab', 'https://s.bps.go.id/PenangananPengaduan', 1.00, 'PRF2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pilar`
--

CREATE TABLE `pilar` (
  `id` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` double(6,2) NOT NULL,
  `min_wbk` double(6,2) NOT NULL,
  `min_wbbm` double(6,2) NOT NULL,
  `subrincian_id` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pilar`
--

INSERT INTO `pilar` (`id`, `pilar`, `bobot`, `min_wbk`, `min_wbbm`, `subrincian_id`, `created_at`, `updated_at`) VALUES
('HBA', 'Nilai Survey Persepsi Korupsi (Survei Eksternal : Indeks Persepsi Anti Korupsi/ IPAK)  ', 17.50, 15.75, 15.75, 'HB', NULL, NULL),
('HBB', 'Capaian Kinerja Lebih Baik dari pada Capaian Kinerja Sebelumnya		', 5.00, 2.50, 3.75, 'HB', NULL, NULL),
('HPA', 'Nilai Persepsi Kualitas Pelayanan (Survei Eksternal : Indeks Persepsi Kualitas Pelayanan Publik / IPKP)', 17.50, 14.00, 15.75, 'HP', NULL, NULL),
('PPA', 'Manajemen perubahan', 4.00, 2.40, 3.00, 'PP', NULL, NULL),
('PPB', 'Penataan tatalaksana', 3.50, 2.10, 2.60, 'PP', NULL, NULL),
('PPC', 'Penataan sistem manajemen sdm aparatur', 5.00, 3.00, 3.75, 'PP', NULL, NULL),
('PPD', 'Penguatan akuntabilitas', 5.00, 3.00, 3.75, 'PP', NULL, NULL),
('PPE', 'Penguatan pengawasan', 7.50, 4.50, 5.60, 'PP', NULL, NULL),
('PPF', 'Peningkatan kualitas pelayanan publik', 5.00, 3.00, 1.50, 'PP', NULL, NULL),
('PRA', 'Manajemen perubahan', 4.00, 2.40, 3.00, 'PR', NULL, NULL),
('PRB', 'Penataan tatalaksana', 3.50, 2.10, 2.60, 'PR', NULL, NULL),
('PRC', 'Penataan sistem manajemen sdm aparatur', 5.00, 3.00, 3.75, 'PR', NULL, NULL),
('PRD', 'Penguatan akuntabilitas', 5.00, 3.00, 3.75, 'PR', NULL, NULL),
('PRE', 'Penguatan pengawasan', 7.50, 4.50, 5.60, 'PR', NULL, NULL),
('PRF', 'Peningkatan kualitas pelayanan publik', 5.00, 3.00, 1.50, 'PR', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rekaphasil`
--

CREATE TABLE `rekaphasil` (
  `id` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year(4) NOT NULL,
  `opsi_id` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` double(6,2) NOT NULL,
  `pilar_id` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satker_id` int(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rekaphasil`
--

INSERT INTO `rekaphasil` (`id`, `tahun`, `opsi_id`, `nilai`, `pilar_id`, `satker_id`, `created_at`, `updated_at`) VALUES
('20231600HBA', 2023, 'HBA1', 17.50, 'HBA', 1600, '2023-06-19 01:32:53', '2023-07-03 04:08:18'),
('20231600HBB', 2023, 'HBB1', 5.00, 'HBB', 1600, '2023-06-19 01:32:53', '2023-07-03 04:08:18'),
('20231600HPA', 2023, 'HPA1', 17.50, 'HPA', 1600, '2023-06-19 01:32:53', '2023-07-03 04:08:18'),
('20231603HBA', 2023, 'HBA1', 17.50, 'HBA', 1603, '2023-06-18 11:17:56', '2023-06-18 11:17:56'),
('20231603HBB', 2023, 'HBB1', 5.00, 'HBB', 1603, '2023-06-18 11:17:56', '2023-06-18 11:17:56'),
('20231603HPA', 2023, 'HPA1', 17.50, 'HPA', 1603, '2023-06-18 11:17:56', '2023-06-18 11:17:56'),
('20233170HBA', 2023, 'HBA1', 17.50, 'HBA', 3170, '2023-06-13 16:11:30', '2023-06-13 16:11:30'),
('20233170HBB', 2023, 'HBB1', 5.00, 'HBB', 3170, '2023-06-13 16:11:30', '2023-06-13 16:11:30'),
('20233170HPA', 2023, 'HPA1', 17.50, 'HPA', 3170, '2023-06-13 16:11:30', '2023-06-13 16:11:30'),
('20233171HBA', 2023, 'HBA1', 17.50, 'HBA', 3171, '2023-06-13 16:11:30', '2023-06-13 16:11:30'),
('20233171HBB', 2023, 'HBB2', 3.75, 'HBB', 3171, '2023-06-13 16:11:30', '2023-06-14 03:47:56'),
('20233171HPA', 2023, 'HPA2', 11.72, 'HPA', 3171, '2023-06-13 16:11:30', '2023-06-14 03:47:56'),
('20233172HBA', 2023, 'HBA1', 17.50, 'HBA', 3172, '2023-06-13 16:11:30', '2023-06-13 16:11:30'),
('20233172HBB', 2023, 'HBB1', 5.00, 'HBB', 3172, '2023-06-13 16:11:30', '2023-06-13 16:11:30'),
('20233172HPA', 2023, 'HPA2', 11.72, 'HPA', 3172, '2023-06-13 16:11:30', '2023-06-14 03:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `rekapitulasi`
--

CREATE TABLE `rekapitulasi` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year(4) NOT NULL,
  `predikat` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `satker_id` int(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekappengungkit`
--

CREATE TABLE `rekappengungkit` (
  `id` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_sa` double(6,3) NOT NULL,
  `nilai_at` double(6,3) DEFAULT NULL,
  `nilai_kt` double(6,3) DEFAULT NULL,
  `nilai_dl` double(6,3) DEFAULT NULL,
  `rekapitulasi_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilar_id` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rincian`
--

CREATE TABLE `rincian` (
  `id` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rincian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` double(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rincian`
--

INSERT INTO `rincian` (`id`, `rincian`, `bobot`, `created_at`, `updated_at`) VALUES
('H', 'Hasil', 40.00, NULL, NULL),
('P', 'Pengungkit', 60.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `satker`
--

CREATE TABLE `satker` (
  `id` int(4) NOT NULL,
  `nama_satker` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wilayah` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satker`
--

INSERT INTO `satker` (`id`, `nama_satker`, `wilayah`, `created_at`, `updated_at`) VALUES
(1000, 'Inspektorat Utama', '2', NULL, NULL),
(1100, 'BPS Provinsi Aceh', '3', NULL, NULL),
(1104, 'BPS Kabupaten Aceh Tenggara', '3', NULL, NULL),
(1111, 'BPS Kabupaten Aceh Utara', '3', NULL, NULL),
(1114, 'BPS KABUPATEN ACEH TAMIANG', '3', NULL, NULL),
(1115, 'BPS Kabupaten Nagan Raya', '3', NULL, NULL),
(1118, 'BPS Kabupaten Pidie Jaya', '3', NULL, NULL),
(1171, 'BPS KOTA BANDA ACEH', '3', NULL, NULL),
(1173, 'BPS Kota Langsa', '3', NULL, NULL),
(1175, 'BPS Kota Subulussalam', '3', NULL, NULL),
(1600, 'BPS Provinsi Sumatera Selatan', '1', NULL, NULL),
(1601, 'BPS Kabupaten Ogan Komering Ulu', '1', NULL, NULL),
(1602, 'BPS Kabupaten Ogan Komering Ilir', '1', NULL, NULL),
(1603, 'BPS Kabupaten Muara Enim', '1', NULL, NULL),
(1604, 'BPS Kabupaten Lahat', '1', NULL, NULL),
(1605, 'BPS Kabupaten Musi Rawas', '1', NULL, NULL),
(1606, 'BPS Kabupaten Musi Banyuasin', '1', NULL, NULL),
(1607, 'BPS Kabupaten Banyuasin', '1', NULL, NULL),
(1608, 'BPS Kabupaten Ogan Komering Ulu Selatan', '1', NULL, NULL),
(1609, 'BPS Kabupaten OKU Timur', '1', NULL, NULL),
(1610, 'BPS Kabupaten Ogan Ilir', '1', NULL, NULL),
(1611, 'BPS Kabupaten Empat Lawang', '1', NULL, NULL),
(1671, 'BPS Kota Palembang', '1', NULL, NULL),
(1672, 'BPS Kota Prabumulih', '1', NULL, NULL),
(1673, 'BPS Kota Pagar Alam', '1', NULL, NULL),
(1674, 'BPS Kota Lubuklinggau', '1', NULL, NULL),
(3170, 'BPS Provinsi DKI Jakarta', '1', NULL, NULL),
(3171, 'BPS Kota Jakarta Selatan', '1', NULL, NULL),
(3172, 'BPS Kota Jakarta Timur', '1', NULL, NULL),
(3326, 'BPS Kabupaten Pekalongan', '3', NULL, NULL),
(3328, 'BPS Kabupaten Tegal', '3', NULL, NULL),
(3329, 'BPS Kabupaten Brebes', '3', NULL, NULL),
(3373, 'BPS Kota Salatiga', '3', NULL, NULL),
(6200, 'BPS Provinsi Kalimantan Tengah', '2', NULL, NULL),
(6202, 'BPS Kabupaten Kotawaringin Timur', '2', NULL, NULL),
(6203, 'BPS Kabupaten Kapuas', '2', NULL, NULL),
(6204, 'BPS Kabupaten Barito Selatan', '2', NULL, NULL),
(6205, 'BPS Kabupaten Barito Utara', '2', NULL, NULL),
(6206, 'BPS Kabupaten Sukamara', '2', NULL, NULL),
(6207, 'BPS Kabupaten Lamandau', '2', NULL, NULL),
(6209, 'BPS Kabupaten Katingan', '2', NULL, NULL),
(6210, 'BPS Kabupaten Pulang Pisau', '2', NULL, NULL),
(6211, 'BPS Kabupaten Gunung Mas', '2', NULL, NULL),
(6212, 'BPS Kabupaten Barito Timur', '2', NULL, NULL),
(6271, 'BPS Kota palangka Raya', '2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `self_assessment`
--

CREATE TABLE `self_assessment` (
  `id` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year(4) NOT NULL,
  `opsi_id` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` double(6,2) NOT NULL,
  `rekapitulasi_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satker_id` int(4) NOT NULL,
  `pertanyaan_id` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_rekap`
--

CREATE TABLE `status_rekap` (
  `id` int(1) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_rekap`
--

INSERT INTO `status_rekap` (`id`, `status`, `start_time`, `end_time`) VALUES
(0, 'Penilaian Mandiri', '2023-06-07 23:59:23', '2023-06-08 00:39:29'),
(1, 'Proses Penilaian BPS Prov', '2023-06-09 23:59:43', '2023-06-10 23:59:47'),
(2, 'Tindak Lanjut BPS Prov ', '2023-06-12 00:04:36', '2023-06-13 00:04:48'),
(3, 'Tidak Diusulkan BPS Provinsi', NULL, NULL),
(4, 'Proses Penilaian TPI', '2023-06-13 00:04:56', '2023-06-17 00:04:59'),
(5, 'Tindak Lanjut TPI ', '2023-06-18 00:05:02', '2023-06-24 00:05:05'),
(6, 'Diusulkan BPS Pusat', NULL, NULL),
(7, 'Tidak Diusulkan BPS Pusat', NULL, NULL),
(8, 'Cetak Surat Pengantar Provinsi', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subpilar`
--

CREATE TABLE `subpilar` (
  `id` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subPilar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` double(6,2) NOT NULL,
  `pilar_id` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subpilar`
--

INSERT INTO `subpilar` (`id`, `subPilar`, `bobot`, `pilar_id`, `created_at`, `updated_at`) VALUES
('PPA1', 'Penyusunan Tim Kerja', 0.50, 'PPA', NULL, NULL),
('PPA2', 'Rencana Pembangunan Zona Integritas', 1.00, 'PPA', NULL, NULL),
('PPA3', 'Pemantauan dan Evaluasi Pembangunan WBK/WBBM', 1.00, 'PPA', NULL, NULL),
('PPA4', 'Perubahan pola pikir dan budaya kerja', 1.50, 'PPA', NULL, NULL),
('PPB1', 'Prosedur Operasional Tetap (SOP) Kegiatan Utama', 1.00, 'PPB', NULL, NULL),
('PPB2', 'Sistem Pemerintahan Berbasis Elektronik (SPBE)', 2.00, 'PPB', NULL, NULL),
('PPB3', 'Keterbukaan Informasi Publik', 0.50, 'PPB', NULL, NULL),
('PPC1', 'Perencanaan Kebutuhan Pegawai sesuai dengan Kebutuhan Organisasi', 0.25, 'PPC', NULL, NULL),
('PPC2', 'Pola Mutasi Internal', 0.50, 'PPC', NULL, NULL),
('PPC3', 'Pengembangan Pegawai Berbasis Kompetensi', 1.25, 'PPC', NULL, NULL),
('PPC4', 'Penetapan Kinerja Individu', 2.00, 'PPC', NULL, NULL),
('PPC5', 'Penegakan Aturan Disiplin/Kode Etik/Kode Perilaku Pegawai', 0.75, 'PPC', NULL, NULL),
('PPC6', 'Sistem Informasi Kepegawaian', 0.25, 'PPC', NULL, NULL),
('PPD1', 'Keterlibatan Pimpinan', 2.50, 'PPD', NULL, NULL),
('PPD2', 'Pengelolaan Akuntabilitas Kinerja', 2.50, 'PPD', NULL, NULL),
('PPE1', 'Pengendalian Gratifikasi', 1.50, 'PPE', NULL, NULL),
('PPE2', 'Penerapan Sistem Pengendalian Intern Pemerintah (SPIP)', 1.50, 'PPE', NULL, NULL),
('PPE3', 'Pengaduan Masyarakat', 1.50, 'PPE', NULL, NULL),
('PPE4', 'Whistle-Blowing System', 1.50, 'PPE', NULL, NULL),
('PPE5', 'Penanganan Benturan Kepentingan', 1.50, 'PPE', NULL, NULL),
('PPF1', 'Standar Pelayanan', 1.00, 'PPF', NULL, NULL),
('PPF2', 'Budaya Pelayanan Prima', 1.00, 'PPF', NULL, NULL),
('PPF3', 'Pengelolaan Pengaduan', 1.00, 'PPF', NULL, NULL),
('PPF4', 'Penilaian Kepuasan terhadap Pelayanan', 1.00, 'PPF', NULL, NULL),
('PPF5', 'Pemanfaatan Teknologi Informasi', 1.00, 'PPF', NULL, NULL),
('PRA1', 'Komitmen dalam Perubahan', 2.00, 'PRA', NULL, NULL),
('PRA2', 'Komitmen Pimpinan', 1.00, 'PRA', NULL, NULL),
('PRA3', 'Membangun Budaya Kerja', 1.00, 'PRA', NULL, NULL),
('PRB1', 'Peta Proses Bisnis Mempengaruhi Penyederhanaan Jabatan', 0.50, 'PRB', NULL, NULL),
('PRB2', 'Sistem Pemerintahan Berbasis Elektronik (SPBE) yang Terintegrasi', 1.00, 'PRB', NULL, NULL),
('PRB3', 'Transformasi Digital Memberikan Nilai Manfaat', 2.00, 'PRB', NULL, NULL),
('PRC1', 'Kinerja Individu', 1.50, 'PRC', NULL, NULL),
('PRC2', 'Assessment Pegawai', 1.50, 'PRC', NULL, NULL),
('PRC3', 'Pelanggaran Disiplin Pegawai', 2.00, 'PRC', NULL, NULL),
('PRD1', 'Meningkatnya capaian kinerja unit kerja', 2.00, 'PRD', NULL, NULL),
('PRD2', 'Pemberian Reward and Punishment', 1.50, 'PRD', NULL, NULL),
('PRD3', 'Kerangka Logis Kinerja', 1.50, 'PRD', NULL, NULL),
('PRE1', 'Mekanisme Pengendalian', 2.50, 'PRE', NULL, NULL),
('PRE2', 'Penanganan Pengaduan Masyarakat', 3.00, 'PRE', NULL, NULL),
('PRE3', 'Penyampaian Laporan Harta Kekayaan', 2.00, 'PRE', NULL, NULL),
('PRF1', 'Upaya dan/atau Inovasi Pelayanan Publik', 2.50, 'PRF', NULL, NULL),
('PRF2', 'Penanganan Pengaduan Pelayanan dan Konsultasi', 2.50, 'PRF', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subrincian`
--

CREATE TABLE `subrincian` (
  `id` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subRincian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` double(6,2) NOT NULL,
  `rincian_id` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subrincian`
--

INSERT INTO `subrincian` (`id`, `subRincian`, `bobot`, `rincian_id`, `created_at`, `updated_at`) VALUES
('HB', 'Birokrasi yang bersih dan akuntabel', 22.50, 'H', NULL, NULL),
('HP', 'Pelayanan Publik yang Prima', 17.50, 'H', NULL, NULL),
('PP', 'Pemenuhan', 30.00, 'P', NULL, '2023-06-28 04:54:30'),
('PR', 'Reform', 30.00, 'P', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `TPI`
--

CREATE TABLE `TPI` (
  `id` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year(4) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dalnis` bigint(20) NOT NULL,
  `ketua_tim` bigint(20) NOT NULL,
  `wilayah` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `TPI`
--

INSERT INTO `TPI` (`id`, `tahun`, `nama`, `dalnis`, `ketua_tim`, `wilayah`, `created_at`, `updated_at`) VALUES
('TIM12023WIL2', 2023, 'Tim 1', 199209262017101, 199209262017105, '2', '2023-07-03 07:35:26', '2023-07-03 07:36:57'),
('TIM12023WIL3', 2023, 'Tim 1', 123213212147, 123213212146, '3', '2023-07-03 06:56:15', '2023-07-03 06:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `upload_dokumen`
--

CREATE TABLE `upload_dokumen` (
  `id` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumenlke_id` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selfassessment_id` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satker_id` int(4) NOT NULL,
  `level_id` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `no_telp`, `satker_id`, `level_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(12321321213, '199209262017113', 'vony.bps4@gmail.com', '082831831212', 1000, 'A', NULL, '2023-06-15 02:41:47', '2023-06-15 02:41:47'),
(12321321214, 'Putu Jati', 'putuhadi2808@gmail.com', '0812313123111', 1000, 'A', NULL, '2023-06-17 11:55:33', '2023-06-17 11:55:33'),
(123213212145, 'Arumi Nasha Razeta', 'aryasepta0709@gmail.com', '085310633394', 1000, 'AT', NULL, '2023-07-01 09:48:32', '2023-07-01 09:48:32'),
(123213212146, 'Bahiyya Atiqa Faiha', 'aryasepta79@gmail.com', '085310633394', 1000, 'KT', NULL, '2023-07-01 09:49:20', '2023-07-01 09:49:20'),
(123213212147, 'Chayra Ainin Qulaibah ', 'argunthurbisnis@gmail.com', '085310633394', 1000, 'DL', NULL, '2023-07-01 09:49:48', '2023-07-03 06:49:21'),
(199209262017051, 'Reza Rezki Pulungan. SST', 'pulungan@bps.go.id', '6282279157892', 1100, 'PT', NULL, NULL, NULL),
(199209262017052, 'Muhammad Rizqi. S.Tr.Stat.', 'rizqi.muhammad@bps.go.id', '6282279157893', 1104, 'PT', NULL, NULL, NULL),
(199209262017053, 'Andi Sanjaya SE. M.Si.', 'andi.sanjaya@bps.go.id', '6282279157894', 1111, 'PT', NULL, NULL, NULL),
(199209262017054, 'Isabella Ratna Putri S.Tr.Stat.', 'isabella.putri@bps.go.id', '6282279157895', 1114, 'PT', NULL, NULL, NULL),
(199209262017055, 'M. Nigel Biaggi S.Tr.Stat', 'nigel.biaggi@bps.go.id', '6282279157896', 1115, 'PT', NULL, NULL, NULL),
(199209262017056, 'Jufri. SE', 'jufriPS@bps.go.id', '6282279157897', 1118, 'PT', NULL, NULL, NULL),
(199209262017057, 'Kusni Rohani Rumahorbo. SST. M.Si', 'kusni@bps.go.id', '6282279157898', 1171, 'PT', NULL, NULL, NULL),
(199209262017058, 'Teuku Ariansyah. SE', 'ariansyah@bps.go.id', '6282279157899', 1173, 'PT', NULL, NULL, NULL),
(199209262017059, 'Mustafa. SE', 'mustafa@bps.go.id', '6282279157900', 1175, 'PT', NULL, NULL, NULL),
(199209262017060, 'Rizal Rahmad. SST. M.Stat', 'rrahmad@bps.go.id', '6282279157901', 6200, 'PT', NULL, NULL, NULL),
(199209262017061, 'Sari Yunus. S.Si', 'sariyunus.aw@bps.go.id', '6282279157902', 6202, 'PT', NULL, NULL, NULL),
(199209262017062, 'Fikri SE. M.S.M', 'fikriPS@bps.go.id', '6282279157903', 6203, 'PT', NULL, NULL, NULL),
(199209262017063, 'Tomi Agusardi. SP', 'tomi@bps.go.id', '6282279157904', 6204, 'PT', NULL, NULL, NULL),
(199209262017064, 'Armida Dewi. SST', 'armida.dewi@bps.go.id', '6282279157905', 6205, 'PT', NULL, NULL, NULL),
(199209262017065, 'Nurul Aviva Purnamawanti. SST', 'nurulaviva@bps.go.id', '6282279157906', 6206, 'PT', NULL, NULL, NULL),
(199209262017066, 'Muhammad Hafid Nasution. S.Tr.Stat.', 'hafid.nasution@bps.go.id', '6282279157907', 6207, 'PT', NULL, NULL, NULL),
(199209262017067, 'Kanasha Humaira. SST', 'kanasha.humaira@bps.go.id', '6282279157908', 6209, 'PT', NULL, NULL, NULL),
(199209262017068, 'Ainun Mardhiah. S.Stat.', 'ainun.mardhiah@bps.go.id', '6282279157909', 6210, 'PT', NULL, NULL, NULL),
(199209262017069, 'Agussalim. S.Si', 'agussalimPS@bps.go.id', '6282279157910', 6211, 'PT', NULL, NULL, NULL),
(199209262017070, 'Ditalia Trisnawati. SST', 'ditalia@bps.go.id', '6282279157911', 6212, 'PT', NULL, NULL, NULL),
(199209262017071, 'Yasmin. S.Tr.Stat.', 'yasmin@bps.go.id', '6282279157912', 6271, 'PT', NULL, NULL, NULL),
(199209262017072, 'Puguh Prananto', 'titopp67@gmail.com', '6282279157913', 1000, 'DL', NULL, NULL, NULL),
(199209262017073, 'Kelik Yunandar', 'kelik.yunandar@gmail.com', '6282279157914', 1000, 'KT', NULL, NULL, NULL),
(199209262017074, 'Eko Prasetyo', 'ekoprasetyodanish@gmail.com', '6282279157915', 1000, 'AT', NULL, NULL, NULL),
(199209262017075, 'Siti Nur Laelatul Badriyah', 'ratuakuntan@gmail.com', '6282279157916', 1000, 'AT', NULL, NULL, NULL),
(199209262017076, 'Alfidiansyah Ardief', 'alfidbps8PT@gmail.com', '6282279157917', 1000, 'KT', NULL, NULL, NULL),
(199209262017077, 'Andy Hasan Fadhillah', 'andyhafPS0PS0@gmail.com', '6282279157918', 1000, 'AT', NULL, NULL, NULL),
(199209262017079, 'Eko Libri Ardi', 'libriardi259@gmail.com', '6282279157920', 1000, 'DL', NULL, NULL, '2023-06-20 00:50:44'),
(199209262017080, 'Eneng  Lisnawati', 'eneng.lisnawati@gmail.com', '6282279157921', 1000, 'KT', NULL, NULL, NULL),
(199209262017081, 'Boy Gidion Ginting', 'bgg.for.webinar@gmail.com', '6282279157922', 1000, 'KT', NULL, NULL, NULL),
(199209262017082, 'Dedi Natalia', 'dedinatalia@gmail.com', '6282279157923', 1000, 'KT', NULL, NULL, NULL),
(199209262017083, 'Kartika Meliana Sinaga', 'kartikams1@gmail.com', '6282279157924', 1000, 'AT', NULL, NULL, NULL),
(199209262017084, 'Wira Wahyuni', 'wirawahyuni22@gmail.com', '6282279157925', 1000, 'AT', NULL, NULL, NULL),
(199209262017085, 'Ratu Fani Rizqiani', 'rtfanir@gmail.com', '6282279157926', 1000, 'AT', NULL, NULL, NULL),
(199209262017086, 'Herry Purdiyanto', 'olatbiru@gmail.com', '6282279157927', 1000, 'AT', NULL, NULL, NULL),
(199209262017087, 'Lukas Haryo', 'lukasharyo56@gmail.com', '6282279157928', 1000, 'AT', NULL, NULL, NULL),
(199209262017088, 'Muhammad Arya Septa K', 'aryasepta7901@gmail.com', '6282279157895', 1000, 'A', NULL, NULL, NULL),
(199209262017089, 'Eko Sutrisno', '221910940@stis.ac.id', '6282279157895', 1600, 'PT', NULL, '2023-02-19 02:28:13', '2023-07-01 10:03:04'),
(199209262017090, 'Yudhistira Ardhana', 'aryasepta1234@gmail.com', '6282279157822', 1603, 'PT', NULL, '2023-02-19 05:40:57', '2023-02-19 05:42:15'),
(199209262017091, 'Bella Pradiana', 'aryasepta3@gmail.com', '6282279157812', 1600, 'EP', NULL, '2023-02-19 05:42:02', '2023-02-19 05:42:10'),
(199209262017101, 'Arbaatun Kurniasari SE, M.Si', 'sarisumaila.75@gmail.com', '6282279157101', 1000, 'DL', NULL, '2023-06-13 16:04:41', '2023-06-13 16:04:41'),
(199209262017102, 'Risma Febrianti Mangiwa, SE', 'risma862@gmail.com', '6282279157102', 3172, 'PT', NULL, '2023-06-13 16:04:41', '2023-06-15 01:47:55'),
(199209262017103, 'Rina Allycia Christin SST', 'dek.rina91@gmail.com', '6282279157103', 3171, 'PT', NULL, '2023-06-13 16:04:41', '2023-06-13 16:04:41'),
(199209262017104, 'Albert Krisman Harefa SST', 'albertkrisman.harefa@gmail.com', '6282279157104', 1000, 'AT', NULL, '2023-06-13 16:04:41', '2023-06-13 16:04:41'),
(199209262017105, 'Wasistha Dyahapsari SST', 'sistha.wd@gmail.com', '6282279157105', 1000, 'KT', NULL, '2023-06-13 16:04:41', '2023-06-13 16:04:41'),
(199209262017106, 'Mohammad Hilman SST', 'mohammad23hilman@gmail.com', '6282279157106', 3170, 'EP', NULL, '2023-06-13 16:04:41', '2023-06-13 16:04:41'),
(199209262017107, 'Afra Nur Haerani Haeba A.Md.Ak.', 'afranurhaeranihaeba@gmail.com', '6282279157107', 1000, 'AT', NULL, '2023-06-13 16:04:41', '2023-06-15 01:48:56'),
(199209262017109, 'Nurjanah', 'nurjannahf64@gmail.com', '6282279157109', 1000, 'AT', NULL, '2023-06-13 16:04:41', '2023-06-13 16:04:41'),
(199209262017110, 'Ezra Doni', 'ezradoni@gmail.com', '082279157801', 3170, 'EP', NULL, '2023-06-14 11:44:14', '2023-06-28 02:46:51'),
(199209262017111, 'Zakia Fadila', 'ummikyky@gmail.com', '08123123142', 1000, 'KT', NULL, '2023-06-15 02:11:30', '2023-06-15 02:11:30'),
(199209262017112, 'Edmidio Ar', 'edmidio.ar@gmail.com', '08123123123', 1000, 'AT', NULL, '2023-06-15 02:12:09', '2023-06-15 02:12:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota_tpi`
--
ALTER TABLE `anggota_tpi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_tpi_tpi_id_foreign` (`tpi_id`),
  ADD KEY `anggota_tpi_anggota_id_foreign` (`anggota_id`);

--
-- Indexes for table `desk_evaluation`
--
ALTER TABLE `desk_evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `desk_evaluation_pengawasan_id_foreign` (`pengawasan_id`),
  ADD KEY `desk_evaluation_rekapitulasi_id_foreign` (`rekapitulasi_id`);

--
-- Indexes for table `dokumenlke`
--
ALTER TABLE `dokumenlke`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumenlke_pertanyaan_id_foreign` (`pertanyaan_id`);

--
-- Indexes for table `inputfield`
--
ALTER TABLE `inputfield`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inputfield_selfassessment_id_foreign` (`selfassessment_id`),
  ADD KEY `inputfield_opsi_id_foreign` (`opsi_id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lhe`
--
ALTER TABLE `lhe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lhe_rekapitulasi_id_foreign` (`rekapitulasi_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opsi`
--
ALTER TABLE `opsi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opsi_pertanyaan_id_foreign` (`pertanyaan_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `pengawasan_satker`
--
ALTER TABLE `pengawasan_satker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengawasan_satker_satker_id_foreign` (`satker_id`),
  ADD KEY `pengawasan_satker_tpi_id_foreign` (`tpi_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`(191),`tokenable_id`);

--
-- Indexes for table `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persyaratan_satker_id_foreign` (`satker_id`);

--
-- Indexes for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pertanyaan_subpilar_id_foreign` (`subpilar_id`);

--
-- Indexes for table `pilar`
--
ALTER TABLE `pilar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pilar_subrincian_id_foreign` (`subrincian_id`);

--
-- Indexes for table `rekaphasil`
--
ALTER TABLE `rekaphasil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekaphasil_satker_id_foreign` (`satker_id`),
  ADD KEY `rekaphasil_opsi_id_foreign` (`opsi_id`),
  ADD KEY `self_assessment_pilar_id_foreign` (`pilar_id`);

--
-- Indexes for table `rekapitulasi`
--
ALTER TABLE `rekapitulasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekapitulasi_satker_id_foreign` (`satker_id`);

--
-- Indexes for table `rekappengungkit`
--
ALTER TABLE `rekappengungkit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekappengungkit_rekapitulasi_id_foreign` (`rekapitulasi_id`),
  ADD KEY `rekappengungkit_pilar_id_foreign` (`pilar_id`);

--
-- Indexes for table `rincian`
--
ALTER TABLE `rincian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satker`
--
ALTER TABLE `satker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `self_assessment`
--
ALTER TABLE `self_assessment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `self_assessment_rekapitulasi_id_foreign` (`rekapitulasi_id`),
  ADD KEY `self_assessment_satker_id_foreign` (`satker_id`),
  ADD KEY `self_assessment_pertanyaan_id_foreign` (`pertanyaan_id`);

--
-- Indexes for table `status_rekap`
--
ALTER TABLE `status_rekap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subpilar`
--
ALTER TABLE `subpilar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subpilar_pilar_id_foreign` (`pilar_id`);

--
-- Indexes for table `subrincian`
--
ALTER TABLE `subrincian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subrincian_rincian_id_foreign` (`rincian_id`);

--
-- Indexes for table `TPI`
--
ALTER TABLE `TPI`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_dokumen`
--
ALTER TABLE `upload_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `upload_dokumen_selfassessment_id_foreign` (`selfassessment_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_satker_id_foreign` (`satker_id`),
  ADD KEY `user_level_id_foreign` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lhe`
--
ALTER TABLE `lhe`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `persyaratan`
--
ALTER TABLE `persyaratan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62712024;

--
-- AUTO_INCREMENT for table `satker`
--
ALTER TABLE `satker`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6272;

--
-- AUTO_INCREMENT for table `status_rekap`
--
ALTER TABLE `status_rekap`
  MODIFY `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota_tpi`
--
ALTER TABLE `anggota_tpi`
  ADD CONSTRAINT `anggota_tpi_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `anggota_tpi_tpi_id_foreign` FOREIGN KEY (`tpi_id`) REFERENCES `TPI` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `desk_evaluation`
--
ALTER TABLE `desk_evaluation`
  ADD CONSTRAINT `desk_evaluation_pengawasan_id_foreign` FOREIGN KEY (`pengawasan_id`) REFERENCES `pengawasan_satker` (`id`),
  ADD CONSTRAINT `desk_evaluation_rekapitulasi_id_foreign` FOREIGN KEY (`rekapitulasi_id`) REFERENCES `rekapitulasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dokumenlke`
--
ALTER TABLE `dokumenlke`
  ADD CONSTRAINT `dokumenlke_pertanyaan_id_foreign` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inputfield`
--
ALTER TABLE `inputfield`
  ADD CONSTRAINT `inputfield_opsi_id_foreign` FOREIGN KEY (`opsi_id`) REFERENCES `opsi` (`id`),
  ADD CONSTRAINT `inputfield_selfassessment_id_foreign` FOREIGN KEY (`selfassessment_id`) REFERENCES `self_assessment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lhe`
--
ALTER TABLE `lhe`
  ADD CONSTRAINT `lhe_rekapitulasi_id_foreign` FOREIGN KEY (`rekapitulasi_id`) REFERENCES `rekapitulasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `opsi`
--
ALTER TABLE `opsi`
  ADD CONSTRAINT `opsi_pertanyaan_id_foreign` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengawasan_satker`
--
ALTER TABLE `pengawasan_satker`
  ADD CONSTRAINT `pengawasan_satker_satker_id_foreign` FOREIGN KEY (`satker_id`) REFERENCES `satker` (`id`),
  ADD CONSTRAINT `pengawasan_satker_tpi_id_foreign` FOREIGN KEY (`tpi_id`) REFERENCES `TPI` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD CONSTRAINT `persyaratan_satker_id_foreign` FOREIGN KEY (`satker_id`) REFERENCES `satker` (`id`);

--
-- Constraints for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD CONSTRAINT `pertanyaan_subpilar_id_foreign` FOREIGN KEY (`subpilar_id`) REFERENCES `subpilar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pilar`
--
ALTER TABLE `pilar`
  ADD CONSTRAINT `pilar_subrincian_id_foreign` FOREIGN KEY (`subrincian_id`) REFERENCES `subrincian` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rekaphasil`
--
ALTER TABLE `rekaphasil`
  ADD CONSTRAINT `rekaphasil_opsi_id_foreign` FOREIGN KEY (`opsi_id`) REFERENCES `opsi` (`id`),
  ADD CONSTRAINT `rekaphasil_satker_id_foreign` FOREIGN KEY (`satker_id`) REFERENCES `satker` (`id`),
  ADD CONSTRAINT `self_assessment_pilar_id_foreign` FOREIGN KEY (`pilar_id`) REFERENCES `pilar` (`id`);

--
-- Constraints for table `rekapitulasi`
--
ALTER TABLE `rekapitulasi`
  ADD CONSTRAINT `rekapitulasi_satker_id_foreign` FOREIGN KEY (`satker_id`) REFERENCES `satker` (`id`);

--
-- Constraints for table `rekappengungkit`
--
ALTER TABLE `rekappengungkit`
  ADD CONSTRAINT `rekappengungkit_pilar_id_foreign` FOREIGN KEY (`pilar_id`) REFERENCES `pilar` (`id`),
  ADD CONSTRAINT `rekappengungkit_rekapitulasi_id_foreign` FOREIGN KEY (`rekapitulasi_id`) REFERENCES `rekapitulasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `self_assessment`
--
ALTER TABLE `self_assessment`
  ADD CONSTRAINT `self_assessment_pertanyaan_id_foreign` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan` (`id`),
  ADD CONSTRAINT `self_assessment_rekapitulasi_id_foreign` FOREIGN KEY (`rekapitulasi_id`) REFERENCES `rekapitulasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `self_assessment_satker_id_foreign` FOREIGN KEY (`satker_id`) REFERENCES `satker` (`id`);

--
-- Constraints for table `subpilar`
--
ALTER TABLE `subpilar`
  ADD CONSTRAINT `subpilar_pilar_id_foreign` FOREIGN KEY (`pilar_id`) REFERENCES `pilar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subrincian`
--
ALTER TABLE `subrincian`
  ADD CONSTRAINT `subrincian_rincian_id_foreign` FOREIGN KEY (`rincian_id`) REFERENCES `rincian` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `upload_dokumen`
--
ALTER TABLE `upload_dokumen`
  ADD CONSTRAINT `upload_dokumen_selfassessment_id_foreign` FOREIGN KEY (`selfassessment_id`) REFERENCES `self_assessment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`),
  ADD CONSTRAINT `user_satker_id_foreign` FOREIGN KEY (`satker_id`) REFERENCES `satker` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
