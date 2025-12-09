# 03. Modul Dashboard & Layout (Bootstrap)

Setelah login, user masuk ke Dashboard. Di sini kita belajar tentang **Bootstrap** (Framework CSS) untuk membuat tampilan rapi tanpa pusing mikirin CSS dari nol.

---

## 1. Konsep Grid System Bootstrap

Bayangkan layar komputermu dibagi menjadi **12 Kolom** vertikal.
Setiap elemen bisa memakan lebar kolom tertentu.

*   `col-12`: Lebar penuh (1 baris full).
*   `col-6`: Setengah layar.
*   `col-4`: Sepertiga layar.
*   `col-3`: Seperempat layar.

**Contoh Kode:**
```html
<div class="row">
    <div class="col-md-4"> Kotak Kiri </div>
    <div class="col-md-4"> Kotak Tengah </div>
    <div class="col-md-4"> Kotak Kanan </div>
</div>
```
*Hasilnya: 3 kotak berjajar rapi ke samping.*

---

## 2. Bedah Kode: `dashboard.php`

### Bagian Atas: Cek Keamanan
```php
<?php
session_start();
// PENTING: Cek apakah user punya gelang (session)?
if (!isset($_SESSION["userid"])) {
    // Kalau tidak punya, usir ke halaman login
    header("Location: index.php");
    exit();
}
?>
```

### Bagian Tampilan: Navbar (Menu Atas)
Bootstrap menyediakan class `navbar`.
```html
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <!-- ... kode navbar ... -->
    
    <!-- Menu Dinamis Berdasarkan Role -->
    <?php if ($_SESSION["role"] == "RSC"): ?>
        <!-- Menu ini HANYA muncul kalau yang login adalah RSC -->
        <li class="nav-item"><a href="request_gift.php">Request Gift</a></li>
    <?php endif; ?>
    
</nav>
```
**Logika PHP di dalam HTML:** Kita bisa menyisipkan `if` PHP di tengah-tengah HTML untuk menyembunyikan/menampilkan menu tertentu.

### Bagian Kartu Menu (Cards)
Kita menggunakan komponen `card` dari Bootstrap untuk membuat kotak menu yang cantik.

```html
<div class="col-md-4">
    <div class="card text-center shadow-sm h-100">
        <div class="card-body">
            <!-- Ikon Besar -->
            <i class="bi bi-gift display-1 text-primary mb-3"></i>
            <h3 class="card-title">Request Gift</h3>
            <p>Buat permintaan hadiah baru.</p>
            <!-- Tombol -->
            <a href="request_gift.php" class="btn btn-primary">Buat Request</a>
        </div>
    </div>
</div>
```

---

## 3. Tips Bootstrap untuk Pemula

Jangan hafal semua class! Cukup ingat yang sering dipakai:

*   **Warna:** `bg-primary` (Biru), `bg-success` (Hijau), `bg-danger` (Merah), `bg-warning` (Kuning).
*   **Jarak (Spacing):**
    *   `m-3` (Margin/Jarak Luar level 3).
    *   `p-3` (Padding/Jarak Dalam level 3).
    *   `mb-3` (Margin Bottom/Bawah).
    *   `mt-3` (Margin Top/Atas).
*   **Teks:** `text-center`, `fw-bold` (Tebal), `text-muted` (Abu-abu).
*   **Flexbox:** `d-flex`, `justify-content-center`, `align-items-center` (Untuk menengahkan elemen).

Jika butuh desain, buka dokumentasi Bootstrap atau minta AI: *"Buatkan saya tombol warna merah bulat pakai Bootstrap 5"*.
