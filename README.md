# PBKK 1001 - Sistem Informasi Akademik

Proyek ini dibuat untuk memenuhi Tugas Mingguan Pertemuan 10 mata kuliah **Pemrograman Berbasis Kerangka Kerja (PBKK)**.

Aplikasi ini mengimplementasikan **Admin Dashboard**, **Role-Based Access Control (RBAC)**, dan **Sistem Penilaian Mahasiswa** menggunakan framework Laravel.

## Fitur Utama

### 1. Autentikasi dan Otorisasi
- Menggunakan Laravel Breeze untuk autentikasi pengguna.
- Mengimplementasikan Role-Based Access Control (RBAC) menggunakan `spatie/laravel-permission`.
- Pengaturan hak akses berdasarkan Role dan Permission.

### 2. Multi-Role Dashboard

Setiap pengguna mendapatkan tampilan dashboard dan hak akses sesuai dengan perannya.

- **Admin:** Melihat statistik global (Mahasiswa, Dosen, dan Asisten Dosen) serta memiliki akses penuh untuk mengelola dan menghapus data.
- **Dosen:** Melihat daftar nilai mahasiswa yang diampu serta statistik rata-rata kelas.
- **Asisten Dosen:** Melihat daftar nilai mahasiswa yang dibantu, termasuk informasi Dosen pengampu.
- **Mahasiswa:** Melihat transkrip nilai pribadi dan Indeks Prestasi Kumulatif (IPK).

### 3. Filter dan Pencarian Dinamis
- Menggunakan Query Builder `when()` untuk menerapkan filter pencarian secara dinamis.
- Menggunakan `withQueryString()` agar parameter filter tetap dipertahankan saat berpindah halaman melalui pagination.

### 4. UI/UX
- Menggunakan tema warna Cokelat-Beige.
- Tampilan responsif, bersih, dan minim distraksi.
- Dashboard disesuaikan dengan masing-masing role pengguna.

### 5. Keamanan
- Menyembunyikan tombol hapus berdasarkan hak akses menggunakan Blade Directive `@can`.
- Melindungi route menggunakan middleware di sisi server.
- Mencegah pengguna mengakses fitur yang tidak diizinkan melalui manipulasi URL (*URL bypass*).

---

## Cara Menjalankan di Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal.

### 1. Clone Repositori

```bash
git clone https://github.com/Akahazu/Pbkk-1001.git
cd Pbkk-1001
```

### 2. Instal Dependensi

Instal dependensi PHP dan Node.js.

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

```bash
cp .env.example .env
```

Generate application key.

```bash
php artisan key:generate
```

Selanjutnya, sesuaikan konfigurasi database pada file `.env`. Database yang dapat digunakan antara lain MySQL atau SQLite.

### 4. Migrasi dan Seeding Database

Jalankan perintah berikut untuk membuat tabel sekaligus mengisi database dengan data dummy, meliputi Admin, Dosen, Asisten Dosen, Mahasiswa, dan Nilai.

```bash
php artisan migrate:fresh --seed
```

**Catatan:** Perintah tersebut akan menghapus seluruh tabel dan data yang sudah ada sebelum menjalankan migrasi ulang.

### 5. Build Asset dan Jalankan Server

Build asset frontend terlebih dahulu.

```bash
npm run build
```

Kemudian jalankan Laravel development server.

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## Akun Uji Coba (Demo)

Untuk mempermudah proses pengujian, tersedia fitur **Auto-Login** melalui tombol yang disediakan pada halaman login.

Pengguna juga dapat melakukan login secara manual menggunakan akun berikut.

| Role | Email | Password |
|---|---|---|
| Admin | `admin@test.com` | `password` |
| Dosen | `dosen1@test.com` | `password` |
| Asisten Dosen | `asdos1@test.com` | `password` |
| Mahasiswa | `mhs1@test.com` | `password` |

---

## Tabel Penilaian dan Lokasi File

Berikut merupakan pemetaan kriteria penilaian beserta lokasi file utama yang berkaitan dengan implementasinya.

| Kriteria Penilaian | Bobot | Lokasi File Utama |
|---|---:|---|
| Integrasi UI Dashboard dan Widgets | 30% | `resources/views/layouts/admin.blade.php` dan `resources/views/admin/dashboard/` |
| Keamanan Otorisasi Spatie RBAC | 30% | `database/seeders/RoleAndPermissionSeeder.php`, `routes/web.php`, `app/Models/User.php` |
| Modul Pencarian dan Filter `when()` | 20% | `app/Http/Controllers/Admin/MahasiswaController.php`, `resources/views/admin/mahasiswa/index.blade.php` |
| Kerapian Kode Standar PSR-12 | 10% | Folder `app/`, `database/`, `routes/`, dan `tests/` |
| Keterampilan Demo dan Presentasi | 10% | Dilakukan secara langsung di depan kelas |

Kode telah dirapikan menggunakan **Laravel Pint** untuk menyesuaikan standar penulisan kode PSR-12.

---

## Fitur Tambahan (Challenge)

Selain fitur utama, proyek ini juga mengimplementasikan beberapa fitur tambahan:

- **Filter Pencarian Dinamis:** Menggunakan `when()` pada `app/Http/Controllers/Admin/MahasiswaController.php`.
- **Pagination dengan Query String:** Menggunakan `withQueryString()` pada `MahasiswaController.php`, `DosenController.php`, dan `AsistenDosenController.php`.
- **Dummy Data Generator:** Menggunakan Faker untuk menghasilkan data pengguna dan nilai melalui `DummyUserSeeder.php` dan `NilaiSeeder.php`.
- **Auto-Login Test Accounts:** Menyediakan route `/demo-login/{role}` pada `routes/web.php` beserta tombol Auto-Login pada `resources/views/auth/login.blade.php`.

---

**Framework:** Laravel  
**Authentication:** Laravel Breeze  
**Authorization:** Spatie Laravel Permission  
**Frontend:** Blade, CSS, JavaScript  
**Database:** MySQL / SQLite