# Sistem Informasi Inventaris Barang (PHP Murni + MySQL)

Fitur: CRUD, validasi & sanitasi form (POST), login berbasis `$_SESSION`, dual bahasa (ID/EN) tersimpan di `$_SESSION`.

## Cara Menjalankan
1. Install XAMPP/Laragon, aktifkan Apache + MySQL.
2. Salin folder proyek ke `htdocs` (XAMPP) atau `www` (Laragon).
3. Buka phpMyAdmin → Import `database.sql`.
4. Sesuaikan kredensial di `config/koneksi.php` bila perlu.
5. Buka `http://localhost/inventaris/login.php`
   - Username: `admin`
   - Password: `admin123`

## Struktur
- `login.php`, `logout.php` – autentikasi session
- `set_lang.php` – ganti bahasa (disimpan di `$_SESSION['lang']`)
- `index.php` – Read (tabel data + pencarian)
- `tambah.php` – Create
- `edit.php` – Update
- `hapus.php` – Delete
- `includes/` – init session, header/footer, validasi, form
- `lang/` – file terjemahan `id.php` & `en.php`
- `config/koneksi.php` – koneksi MySQL
