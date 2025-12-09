# 01. Database & Konfigurasi (Pondasi)

Sebelum kita bisa membangun dinding dan atap, kita butuh pondasi yang kuat. Di website dinamis (website yang datanya bisa berubah-ubah), pondasinya adalah **Database** dan **Koneksi**.

---

## 1. Database (`db.sql`)

Bayangkan Database seperti sebuah **Gudang Arsip Raksasa**. Di dalamnya ada lemari-lemari besi yang disebut **Tabel**.

Di proyek ini, kita punya 2 lemari (Tabel):
1.  **`users`**: Menyimpan data karyawan (Username, Password, Role).
2.  **`gift_requests`**: Menyimpan formulir permintaan hadiah yang diisi user.

### Kunci Penting Database:
*   **Primary Key (`id`):** Nomor unik untuk setiap baris data. Tidak boleh ada yang sama.
*   **Foreign Key (`user_id`):** Cara kita menghubungkan tabel `gift_requests` dengan `users`. Artinya: "Request ini milik User ID sekian".

---

## 2. Koneksi Database (`Classes/Dbh.php`)

File ini adalah **Jembatan** antara kode PHP kita dengan Gudang Arsip (MySQL). Tanpa file ini, website tidak bisa mengambil atau menyimpan data.

Mari kita bedah kodingannya baris per baris:

```php
<?php
class Dbh { // Dbh singkatan dari Database Handler
    
    // Fungsi ini tugasnya cuma satu: Buka Pintu Gudang
    public function connect() {
        try {
            // Data rahasia untuk masuk ke database
            $username = "root";
            $password = "root";
            
            // Membuat koneksi baru (PDO)
            // host=localhost: Alamat gudang (komputer ini sendiri)
            // dbname=stellarbox_db: Nama gudang spesifik yang mau dibuka
            $dbh = new PDO('mysql:host=localhost;dbname=stellarbox_db', $username, $password);
            
            // Pengaturan tambahan:
            // Kalau ada error, tolong teriak (Tampilkan Error), jangan diam saja.
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $dbh; // Mengembalikan kunci koneksi agar bisa dipakai file lain
            
        } catch (PDOException $e) {
            // Kalau gagal konek, tampilkan pesan error dan matikan proses
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
```

### Kenapa pakai PDO?
Kita menggunakan **PDO** (PHP Data Objects), bukan `mysqli`.
*   **Alasan:** PDO lebih aman dan fleksibel. Dia bisa mencegah serangan hacker yang disebut *SQL Injection*.

---

## 3. Konfigurasi Session (`includes/config_session.inc.php`)

Bayangkan kamu masuk ke sebuah wahana bermain (Dufan/Disney). Setelah bayar tiket, kamu diberi **Gelang Tangan**. Selama kamu pakai gelang itu, kamu boleh naik wahana apa saja tanpa bayar lagi.

Di website, gelang itu disebut **SESSION**.

File ini mengatur keamanan "Gelang Tangan" tersebut.

```php
<?php
// Pengaturan agar Session (Gelang) lebih aman
ini_set('session.use_only_cookies', 1); // Session hanya boleh lewat cookies
ini_set('session.use_strict_mode', 1);  // Mode ketat, hacker susah nebak ID session

session_set_cookie_params([
    'lifetime' => 1800, // Gelang berlaku 30 menit (1800 detik)
    'domain' => 'localhost', // Hanya berlaku di website ini
    'path' => '/',
    'secure' => true, // Hanya lewat HTTPS (aman)
    'httponly' => true // JavaScript tidak boleh baca session (anti-hack XSS)
]);

session_start(); // MULAI SESI! (Pasang gelang ke user)
```

### Poin Penting untuk Diingat:
1.  Setiap kali kamu butuh tahu "Siapa yang sedang login?", kamu wajib tulis `session_start();` di paling atas file PHP.
2.  Data user yang login disimpan di variabel spesial bernama `$_SESSION`.
