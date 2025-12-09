# 00. Mulai Dari Sini: Peta Jalan & Konsep Dasar

Halo! Selamat datang di dokumentasi pembelajaran **StellarBox**.

Dokumen ini dibuat khusus untuk kamu yang baru belajar (Beginner). Kita akan membedah website ini seolah-olah kita sedang membedah sebuah **Rumah**. Jangan khawatir dengan istilah teknis yang rumit, kita akan sederhanakan semuanya.

---

## 1. Filosofi Membuat Website (Langkah demi Langkah)

Jika kamu bingung "Apa yang harus saya buat pertama kali?", ikuti urutan ini. Ini adalah standar umum programmer:

### Langkah 1: Desain & Database (Pondasi Rumah)
Sebelum coding, kamu harus tahu data apa yang mau disimpan.
*   **Apa yang dilakukan:** Membuat skema database (Tabel User, Tabel Request, dll).
*   **Di StellarBox:** Kita membuat file `db.sql`.

### Langkah 2: Koneksi (Pipa Air & Listrik)
Website butuh jalan untuk bicara dengan database.
*   **Apa yang dilakukan:** Membuat script koneksi database.
*   **Di StellarBox:** File `Classes/Dbh.php`.

### Langkah 3: Autentikasi (Pintu Gerbang & Kunci)
Siapa yang boleh masuk?
*   **Apa yang dilakukan:** Membuat Login, Register, dan Logout.
*   **Di StellarBox:** `index.php`, `signup.php`, dan folder `Classes/Login.php`.

### Langkah 4: Struktur Utama (Ruang Tamu)
Halaman pertama setelah login.
*   **Apa yang dilakukan:** Membuat Dashboard dan Navigasi (Menu).
*   **Di StellarBox:** `dashboard.php`.

### Langkah 5: Fitur Inti (Perabotan & Fungsi)
Apa kegunaan utama website ini?
*   **Apa yang dilakukan:** Membuat form input dan tabel laporan.
*   **Di StellarBox:** `request_gift.php` (Input) dan `my_requests.php` (Laporan).

---

## 2. Peta Folder Proyek Kita

Agar tidak tersesat, mari kita lihat peta folder kita:

```text
Stellar Box/
├── Classes/            <-- (OTAK) Berisi logika berat & urusan database (OOP).
│   ├── Dbh.php         <-- Kunci koneksi database.
│   ├── Login.php       <-- Logika login.
│   └── RequestInfo.php <-- Logika mengambil data request.
├── includes/           <-- (PELAYAN) Penghubung antara Form (HTML) dan Class (Otak).
│   ├── login.inc.php   <-- Menerima data dari form login.
│   └── request.inc.php <-- Menerima data request gift.
├── docs/               <-- (BUKU PANDUAN) Tempat kamu membaca ini.
├── dashboard.php       <-- (WAJAH) Halaman utama setelah login.
├── index.php           <-- (WAJAH) Halaman Login.
├── my_requests.php     <-- (WAJAH) Halaman Laporan.
├── request_gift.php    <-- (WAJAH) Halaman Form Request.
└── style.css           <-- (BAJU) File styling (jika ada custom CSS).
```

---

## 3. Konsep MVC (Model - View - Controller) Sederhana

Kamu akan sering mendengar ini. Di StellarBox, kita menggunakan versi sederhananya:

1.  **VIEW (Tampilan/Wajah):**
    *   File yang dilihat user. Isinya HTML, CSS, Bootstrap.
    *   Contoh: `index.php`, `dashboard.php`.
2.  **CONTROLLER (Pengatur/Pelayan):**
    *   File yang menerima input dari user, lalu menyuruh Model bekerja.
    *   Contoh: `includes/login.inc.php`.
3.  **MODEL (Otak/Data):**
    *   File yang bicara langsung dengan Database.
    *   Contoh: `Classes/Login.php`, `Classes/Dbh.php`.

**Alur Cerita:**
> User klik tombol Login di **View** -> Data dikirim ke **Controller** -> Controller menyuruh **Model** cek database -> Model bilang "Oke" -> Controller menyuruh View pindah ke Dashboard.

---

## 4. Apa yang Harus Kamu Pelajari Selanjutnya?

Bacalah file dokumentasi ini secara berurutan:

1.  `01_DATABASE_AND_CONFIG.md`: Memahami cara website hidup.
2.  `02_AUTH_MODULE.md`: Memahami Login & Session.
3.  `03_DASHBOARD_MODULE.md`: Memahami Layout & Bootstrap.
4.  `04_REQUEST_GIFT_MODULE.md`: Memahami Form Canggih (AJAX & jQuery).
5.  `05_MY_REQUESTS_MODULE.md`: Memahami Menampilkan Data & Filter.
6.  `06_TECH_STACK_EXPLAINED.md`: Kamus istilah (Bootstrap, jQuery, dll).
