# Sistem Evaluasi Zona Integritas

Sistem evaluasi zona integritas berbasis web merupakan sistem yang dibangun untuk melakukan proses penilaian evaluasi, mulai dari pengajuan, penyusunan kertas kerja (self-assessment), penilaian pendahuluan, penilaian internal (desk-evaluation), dan monitoring evaluasi zona integritas. Sistem ini dibangun berdasarkan panduan yang telah diterbitkan oleh BPS yaitu "Pedoman Pembangunan dan Evaluasi Zona Integritas"

## Fitur

# Admin
- Fitur ```login ``` yang memungkinkan pengguna untuk melakukan login sebelum menggunakan fitur-fitur lain yang terdapat dalam sistem
- Fitur ```Mengelola Pengguna``` digunakan untuk melakukan pengelolaan data pengguna
- Fitur ```Mengelola Wilayah TPI``` digunakan untuk melakukan pengelolaan data TPI, dan wilayah tugas pengawasan dari anggota tim tersebut
- Fitur ```Mengelola Persyaratan``` digunakan untuk memilih satuan kerja yang dapat mengajukan WBK/WBBM
- Fitur ```Mengelola LKE``` digunakan untuk melakukan pengelolaan data LKE, dan upload rincian hasil pada LKE.
- Fitur ```Monitoring Progress``` digunakan untuk melakukan monitoring terhadap nilai self-assessment, status pengajuan, dokumen LHE dan catatan TPI.


## Repository structure

- Directory [Kode Program](https://git.stis.ac.id/ElisaImania/sistem-informasi-manajemen-risiko-berbasis-web/-/tree/main/Kode%20Program) berisi kode-kode program dari sistem yang dibangun
- Directory [Panduan Penggunaan Sistem](https://git.stis.ac.id/ElisaImania/sistem-informasi-manajemen-risiko-berbasis-web/-/tree/main/Panduan%20Penggunaan%20Sistem) berisi file tentang cara menggunakan sistem
- Directory [Rancangan Sistem](https://git.stis.ac.id/ElisaImania/sistem-informasi-manajemen-risiko-berbasis-web/-/tree/main/Rancangan%20Sistem) berisi gambar tentang proses bisnis serta beberapa use case diagram dari sistem yang diusulkan
- Directory [Referensi](https://git.stis.ac.id/ElisaImania/sistem-informasi-manajemen-risiko-berbasis-web/-/tree/main/Referensi) berisi referensi atau literatur yang digunakan dalam penelitian
- Directory [SQL Dump](https://git.stis.ac.id/ElisaImania/sistem-informasi-manajemen-risiko-berbasis-web/-/tree/main/SQL%20Dump) berisi syntax SQL yang digunakan dalam basis data sistem

## Instalasi

- Clone repository pada penyimpanan perangkat lokal menggunakan perintah ```git clone https://git.stis.ac.id/ElisaImania/sistem-informasi-manajemen-risiko-berbasis-web.git```
- Unduh dan install aplikasi XAMPP
- Buka aplikasi XAMPP serta hidupkan MySQL serta Apache pada aplikasi tersebut
- Buat database baru dengan nama sesuai dengan konfigurasi yang terdapat pada file ```.env```
- Akses sistem menggunakan localhost melalui browser
