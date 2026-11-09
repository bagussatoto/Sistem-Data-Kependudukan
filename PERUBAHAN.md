# Dokumentasi Perubahan Sistem Data Kependudukan (SIDAK)
**Sebelum dan Sesudah Perbaikan Kode**

Dokumen ini mencatat seluruh perbaikan bug, pengamanan sistem, dan penyempurnaan fitur yang telah diterapkan pada aplikasi **Sistem Data Kependudukan (SIDAK) Desa Tamantirto**.

---

## 📊 Tabel Perbandingan Singkat (Sebelum vs Sesudah)

| Kategori | Sebelum Perbaikan | Sesudah Perbaikan |
| :--- | :--- | :--- |
| **Hapus Data Kematian** | Menghapus penduduk dari tabel `tb_pdd` secara permanen (beserta data keluarga via *cascade delete*). | Hanya menghapus record kematian dari `tb_mendu` dan mengembalikan status warga di `tb_pdd` menjadi `'Ada'`. |
| **Hapus Data Pindah** | Menghapus orang dari tabel `tb_pdd` secara permanen. | Hanya menghapus record kepindahan dari `tb_pindah` dan mengembalikan status warga menjadi `'Ada'`. |
| **Dashboard Kartu Statistik** | Link mengarah ke halaman yang tidak ada (`data-izin` & `log-izin`) sehingga memicu layar `ERROR !`. | Semua link kartu statistik mengarah ke rute halaman data yang sesuai (`data-pend`, `data-lahir`, dll.). |
| **Navigasi Kaur Pemerintah** | Menu sidebar **Kelola Surat** bernilai `href="#"` (tidak bisa diklik). | Seluruh submenu surat aktif dan terhubung ke formulir pembuatan surat masing-masing. |
| **Menu Kelola Laporan** | Seluruh 6 submenu laporan bernilai `href="#"`. | Aktif dan terhubung langsung ke tabel data terkait. |
| **Login & Sesi** | `session_start()` dipanggil setelah output HTML terkirim, memicu warning *headers already sent*. | `session_start()` dipanggil di baris paling awal file `login.php`. Ditambahkan auto-redirect jika sudah login. |
| **Penyimpanan Password** | Password pengguna disimpan dalam bentuk teks biasa (plaintext) tanpa enkripsi. | Dienkripsi menggunakan algoritma modern **Bcrypt** (`password_hash()`) dengan mekanisme *auto-upgrade* saat akun lama login. |
| **Celah SQL Injection** | Nilai input `$_POST` langsung dimasukkan ke dalam query SQL tanpa sanitasi. | Seluruh parameter input `$_POST` dan `$_GET` disanitasi menggunakan `mysqli_real_escape_string()` dan `trim()`. |
| **Panjang Kolom Password** | Kolom `password` di `tb_pengguna` hanya berukuran `VARCHAR(20)` (hash bcrypt akan terpotong). | Skema di `data_penduduk.sql` diperluas menjadi `VARCHAR(255)`. |
| **Koneksi Database** | `mysqli_close($koneksi)` dipanggil di tengah file subhalaman, memutus koneksi secara prematur. | Pemanggilan `mysqli_close()` prematur dibersihkan dari 15 file formulir. |
| **Form Cetak Surat** | Atribut `target="_blank"` salah tempat (di tag `<input>`), dropdown tanpa `value=""`. | Atribut `target="_blank"` dipasang pada tag `<form>`, dropdown dilengkapi `value=""`. |
| **Redaksi & Tampilan** | Banyak typo seperti `Jenis Kelain`, `Tamntirot`, `Kabupuaten`, `bahawa`, dan tag rusak `</>`. | Tag rusak dibersihkan, seluruh label form dan redaksi surat diperbaiki menjadi bahasa baku Indonesia. |
| **Pengabaian File Sampos (Git)** | Tidak ada file `.gitignore`. | Ditambahkan file `.gitignore` standar proyek PHP untuk menjaga kebersihan repositori. |

---

## 🔍 Rincian Perubahan per Modul

### 1. Modul Kematian (`admin/mendu/`)
* **File:** `admin/mendu/data_mendu.php`
  * **Sebelum:** Tombol hapus mengirim `kode=<?php echo $data['id_pend']; ?>` dan terdapat tag penutup rusak `</>`.
  * **Sesudah:** Mengirim `kode=<?php echo $data['id_mendu']; ?>` dan tag rusak dibersihkan.
* **File:** `admin/mendu/del_mendu.php`
  * **Sebelum:**
    ```php
    $sql_hapus = "DELETE FROM tb_pdd WHERE id_pend='".$_GET['kode']."'";
    ```
  * **Sesudah:**
    ```php
    $kode = mysqli_real_escape_string($koneksi, $_GET['kode']);
    $sql_cek = "SELECT id_pdd FROM tb_mendu WHERE id_mendu='$kode'";
    // ... Mengambil id_pdd
    $sql_hapus = "DELETE FROM tb_mendu WHERE id_mendu='$kode'";
    // ... Mengembalikan status penduduk:
    mysqli_query($koneksi, "UPDATE tb_pdd SET status='Ada' WHERE id_pend='$id_pdd'");
    ```

---

### 2. Modul Pindah (`admin/pindah/`)
* **File:** `admin/pindah/data_pindah.php`
  * **Sebelum:** Tombol hapus mengirim `kode=<?php echo $data['id_pend']; ?>` dan terdapat tag penutup rusak `</>`.
  * **Sesudah:** Mengirim `kode=<?php echo $data['id_pindah']; ?>` dan tag rusak dibersihkan.
* **File:** `admin/pindah/del_pindah.php`
  * **Sebelum:**
    ```php
    $sql_hapus = "DELETE FROM tb_pdd WHERE id_pend='".$_GET['kode']."'";
    ```
  * **Sesudah:**
    ```php
    $kode = mysqli_real_escape_string($koneksi, $_GET['kode']);
    $sql_cek = "SELECT id_pdd FROM tb_pindah WHERE id_pindah='$kode'";
    // ... Mengambil id_pdd
    $sql_hapus = "DELETE FROM tb_pindah WHERE id_pindah='$kode'";
    // ... Mengembalikan status penduduk:
    mysqli_query($koneksi, "UPDATE tb_pdd SET status='Ada' WHERE id_pend='$id_pdd'");
    ```

---

### 3. Dashboard Admin & Kaur (`home/admin.php` & `home/kaur.php`)
* **Sebelum:**
  * Kartu Laki-laki mengarah ke `?page=data-izin` *(halaman tidak ada)*
  * Kartu Perempuan mengarah ke `?page=log-izin` *(halaman tidak ada)*
  * Kartu Lahir mengarah ke `?page=data-pend` *(salah tujuan)*
  * Kartu Meninggal mengarah ke `?page=data-kartu` *(salah tujuan)*
  * Kartu Pendatang mengarah ke `?page=data-izin` *(halaman tidak ada)*
  * Kartu Pindah mengarah ke `?page=log-izin` *(halaman tidak ada)*
* **Sesudah:**
  * Laki-laki & Perempuan ➔ `?page=data-pend`
  * Lahir ➔ `?page=data-lahir`
  * Meninggal ➔ `?page=data-mendu`
  * Pendatang ➔ `?page=data-datang`
  * Pindah ➔ `?page=data-pindah`

---

### 4. Navigasi & Sesi Utama (`index.php`)
* **Pemeriksaan Sesi Pengguna:**
  * **Sebelum:** `if (isset($_SESSION["ses_username"])==""){` (loose comparison rawan bug di PHP 8).
  * **Sesudah:** `if (!isset($_SESSION["ses_username"]) || empty($_SESSION["ses_username"])){`
* **Menu Kelola Surat (Kaur Pemerintah):**
  * **Sebelum:** Seluruh sub-menu bernilai `href="#"`.
  * **Sesudah:** Dihubungkan ke `?page=suket-domisili`, `?page=suket-lahir`, `?page=suket-mati`, `?page=suket-datang`, `?page=suket-pindah`.
* **Menu Kelola Laporan (Semua Akun):**
  * **Sebelum:** Seluruh sub-menu bernilai `href="#"`.
  * **Sesudah:** Dihubungkan langsung ke data kependudukan masing-masing.

---

### 5. Keamanan & Autentikasi (`login.php`, `admin/pengguna/`, `data_penduduk.sql`)
* **Urutan Eksekusi `login.php`:**
  * **Sebelum:** Tag HTML dirender terlebih dahulu sebelum proses POST dieksekusi di bawah file, menyebabkan cookie sesi ditolak karena *headers already sent*.
  * **Sesudah:** Pemrosesan login dan `session_start()` ditaruh di baris 1-34 sebelum tag HTML pertama, dengan pop-up SweetAlert dipicu di footer.
* **Verifikasi Password Hybrid (Auto-Upgrade):**
  * Menggunakan `password_verify()` untuk hash modern.
  * Jika ditemukan password plaintext lama yang cocok, akun otomatis di-upgrade ke hash **Bcrypt** (`password_hash()`) saat login tanpa mengunci pengguna.
* **Manajemen Pengguna:**
  * `add_pengguna.php` & `edit_pengguna.php` mengenkripsi password dengan Bcrypt.
* **Skema SQL:**
  * Panjang kolom `tb_pengguna.password` diubah dari `VARCHAR(20)` menjadi `VARCHAR(255)`.

---

### 6. Sanitasi Database & Anti-SQL Injection
Seluruh parameter input form di-escape menggunakan `mysqli_real_escape_string()` dan `trim()`:
* **Modul Penduduk:** `add_pend.php`, `edit_pend.php`, `del_pend.php`, `view_pend.php`.
* **Modul Kartu Keluarga:** `add_kartu.php`, `edit_kartu.php`, `del_kartu.php`, `anggota.php`, `del_anggota.php`.
* **Modul Kelahiran:** `add_lahir.php`, `edit_lahir.php`, `del_lahir.php`.
* **Modul Kematian:** `add_mendu.php`, `edit_mendu.php`, `del_mendu.php`.
* **Modul Pendatang:** `add_datang.php`, `edit_datang.php`, `del_datang.php`.
* **Modul Pindah:** `add_pindah.php`, `edit_pindah.php`, `del_pindah.php`.
* **Modul Pengguna:** `add_pengguna.php`, `edit_pengguna.php`, `del_pengguna.php`.
* **Modul Laporan/Surat:** Seluruh file pada `report/cetak_*.php`.

---

### 7. Form Surat & Typo Redaksi
* **Atribut Target Cetak:**
  * **Sebelum:** `<input target="_blank" type="submit" ...>` (tidak valid menurut standar HTML, surat terbuka di tab yang sama).
  * **Sesudah:** `<form action="./report/..." method="post" target="_blank">` (surat otomatis terbuka di tab baru).
* **Typo Label & Redaksi:**
  * `Jenis Kelain` ➔ `Jenis Kelamin` (pada `add_pend.php`, `add_lahir.php`, `add_datang.php`).
  * `id="prlapor"` ➔ `id="pelapor"` (pada `edit_datang.php`).
  * `SURAT KETARANGAN` ➔ `SURAT KETERANGAN` (pada semua template surat `report/`).
  * `Tamntirot` ➔ `Tamantirto`, `Kabupuaten` ➔ `Kabupaten`, `bahawa` ➔ `bahwa`.

---

### 8. Dokumentasi & Git
* **`README.md`:** Memperbaiki petunjuk instalasi basis data yang sebelumnya salah menyebut `/db_lowker` menjadi `/Database/data_penduduk.sql` dan database `data_penduduk`.
* **`.gitignore`:** Menambahkan file pengabaian sampah sistem operasi, editor (VSCode/PHPStorm), dan log file.

