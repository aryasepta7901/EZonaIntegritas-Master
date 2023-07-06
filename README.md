# Sistem Evaluasi Zona Integritas

Sistem evaluasi zona integritas berbasis web merupakan sistem yang dibangun untuk melakukan proses penilaian evaluasi, mulai dari pengajuan, penyusunan kertas kerja (self-assessment), penilaian pendahuluan, penilaian internal (desk-evaluation), dan monitoring evaluasi zona integritas. Sistem ini dibangun berdasarkan panduan yang telah diterbitkan oleh BPS yaitu "Pedoman Pembangunan dan Evaluasi Zona Integritas"

## Fitur

### Admin
- Fitur ```login ``` yang memungkinkan pengguna untuk melakukan login sebelum menggunakan fitur-fitur lain yang terdapat dalam sistem
- Fitur ```Mengelola Pengguna``` digunakan untuk melakukan pengelolaan data pengguna
- Fitur ```Mengelola Wilayah TPI``` digunakan untuk melakukan pengelolaan data TPI, dan wilayah tugas pengawasan dari anggota tim tersebut
- Fitur ```Mengelola Persyaratan``` digunakan untuk memilih satuan kerja yang dapat mengajukan WBK/WBBM
- Fitur ```Mengelola LKE``` digunakan untuk melakukan pengelolaan data LKE, dan upload rincian hasil pada LKE.
- Fitur ```Monitoring Progress``` digunakan untuk melakukan monitoring terhadap nilai self-assessment, status pengajuan, dokumen LHE dan catatan TPI.

### PIC Satker
Terdapat fitur  ```Self-Assessment ``` dan ```Digitalisasi Surat Pengantar BPS Kab/Kota```.
Satuan kerja dapat melakukan pengajuan dan penilaian mandiri (self-assessment) dengan cara menjawab pertanyaan pada LKE, serta mutiple upload bukti dukung, Jika levelnya adalah BPS Kabupaten/Kota maka PIC satker harus melakukan unggah surat pengantar dari Kepala BPS Kabupaten/Kota berdasarkan template yang telah disediakan

### Evaluator Provinsi
Terdapat fitur  ```Penilaian Pendahuluan ``` dan ```Digitalisasi Surat Pengantar BPS Provinsi```.
Evaluator Provinsi akan melakukan penilaian pendahuluan, meliputi setuju, revisi, dan tolak LKE. Jika LKE disetujui maka evaluator provinsi harus melakukan unggah surat pengantar dari Kepala BPS Provinsi berdasarkan template yang telah disediakan

### TPI
Terdapat fitur  ```Desk-Evaluation ``` dan ```Digitalisasi LHE```.
Tim Penilai internal (TPI) akan melakukan penilaian evaluasi (desk-evaluation) yang dilakukan secara bertahap dan berjenjang mulai dari anggota tim, ketua tim, dan pengendali teknis(dalnis). Jika Tahapan evaluasi masih dalam tahap pertama, maka dalnis akan mengembalikan LKE kepada satuan kerja dengan tambahan Laporan Hasil Evaluasi (LHE), jika tahap evaluasi sudah tahap kedua, maka dalnis akan menentukan apakah menyetujui atau tolak LKE. Jika LKE disetujui maka satker tersebut akan diajukan kepada KemenPANRB beserta LHE, jika tidak maka satker tersebut akan dilakukan pembinaan


## Repository structure

- Directory [Kode Program](https://git.stis.ac.id/AryaSepta/E-Zona-Integritas/-/tree/master/Code) berisi kode-kode program dari sistem yang dibangun
- Directory [Panduan Penggunaan Sistem](https://git.stis.ac.id/AryaSepta/E-Zona-Integritas/-/tree/master/Panduan%20Penggunaan%20Sistem) berisi file tentang cara menggunakan sistem
- Directory [Rancangan Sistem](https://git.stis.ac.id/AryaSepta/E-Zona-Integritas/-/tree/master/Rancangan%20Sistem) berisi Product Requirement Document (PRD), dan Functional Specification Document (FSD) yang telah disepakati oleh subject matter.
- Directory [SQL Dump](https://git.stis.ac.id/AryaSepta/E-Zona-Integritas/-/tree/master/SQL) berisi syntax SQL yang digunakan dalam basis data sistem
- Directory [Buku](https://git.stis.ac.id/AryaSepta/E-Zona-Integritas/-/tree/master/Buku) berisi buku skripsi dan makalah sidang

## Instalasi

- Clone repository pada penyimpanan perangkat lokal menggunakan perintah ```git clone https://git.stis.ac.id/AryaSepta/E-Zona-Integritas.git``` 
- Unduh dan install aplikasi XAMPP
- Buka aplikasi XAMPP serta hidupkan MySQL serta Apache pada aplikasi tersebut
- Buat database baru dengan nama sesuai dengan konfigurasi yang terdapat pada file ```.env```
- Akses sistem menggunakan localhost melalui browser
