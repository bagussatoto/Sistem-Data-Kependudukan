# [SISTEM DATA KEPENDUDUKAN DESA TAMANTIRTO]
**Sistem Data Kependudukan (SIDAK)** merupakan Sistem Administrasi Kependudukan yang dikelola oleh badan pemerintahan Desa Tamantirto

# Pembuat Aplikasi Website
**BAGUS BUDI SATOTO** Selaku Pembuat Aplikasi Web Sistem Data Kependudukan 
Dibuat Oleh https://github.com/bagussatoto Selaku Enginnering Web dan Mobile.



## Instalasi

Aplikasi ini membutuhkan sebuah komputer yang dijadikan sebagai server (spesifikasi rendah pun tidak masalah sama sekali) yang sudah terpasang Web Server, PHP, dan MySQL / MariaDB. Anda dapat menggunakan [XAMPP](https://www.apachefriends.org/download.html "XAMPP") untuk mempermudah instalasi dan pengembangan.
Note: XAMPP hanya digunakan untuk pengembangan, tidak direkomendasikan jika ingin digunakan untuk _production use_ atau di tingkat industri.

Pada langkah ini akan dijelaskan instalasi sistem menggunakan XAMPP:

1. Unduh rilis dari https://github.com/bagussatoto/Sistem-Data-Kependudukan.git (jangan unduh repo nya karena bukan versi stable).
2. Buat folder baru di dalam folder htdocs dari XAMPP.
3. Ekstrak file zip yang sudah diunduh tadi ke dalam folder yang baru dibuat.
4. Buat database baru, bisa gunakan **PHPMyAdmin** yang sudah disediakan XAMPP.
5. Impor database kedalam database yang baru saja dibuat, file impor berada di **/db_lowker**
6. Ubah pengaturan koneksi basis data pada file **/db_lowker** , sesuaikan dengan pengaturan XAMPP Anda (pengaturan default yang dibuat oleh Bagus Satoto adalah pengaturan default untuk XAMPP, Anda hanya perlu mengubah `$databaseName`menjadi nama basis data yang sudah Anda buat).
7. Ubah juga pengaturan koneksi basis data untuk melakukan absensi dari mesin pada file **/db_lowker** .



## Daftar Penggunaan

  - admin :
    - username : admin
    - password : admin
    
  - petugas
    - username : petugas
    - password : petugas
    
 ## Kritik Dan Saran 

| Email |
|----------|
|bagusbudi1308@gmail.com| 


## Request Fitur Baru dan Pelaporan Bug

Anda dapat meminta fitur baru maupun melaporkan bug melalui menu **issues** yang sudah disediakan oleh GitHub (lihat menu di atas), posting issues baru dan kita akan berdiskusi disana.

## Berkontribusi

Siapapun dapat berkontribusi pada proyek ini mulai dari pemrograman, pembuakan buku manual, sampai dengan mengenalkan produk ini kepada masyarakat Indonesia agar mengurangi kesenjangan pendidikan teknologi dengan cara membuat postingan issue di repository ini.

### Berdasarkan ketentuan berikut:

- **Atribusi** - Anda harus mencantumkan nama pencipta dan para kontributor serta mencantumkan tautan lisensi **CC BY-NC-SA** (tautan sudah ada di _footer_ pada aplikasi).
- **NonKomersial** - Anda tidak dapat menggunakan produk ini untuk kepentingan komersial (yaitu penggunaan yang ditujukan untuk memperoleh keuntungan komersial atau kompensasi dalam bentuk uang), kecuali jika Anda menjadikan produk ini untuk bahan ajar atau memberikan pelatihan penggunaan produk dan Anda menerima upah.
- **Berbagi Serupa** - Apabila Anda menggubah, mengubah, atau membuat turunan dari proyek ini, Anda harus menyebarluaskan kontribusi Anda dibawah lisensi yang sama dengan produk ini


