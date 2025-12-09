# 06. Kamus Teknologi (Cheat Sheet)

Bingung dengan istilah-istilah aneh? Ini contekan cepatnya.

---

## 1. PHP (Hypertext Preprocessor)
Bahasa pemrograman yang berjalan di **Server** (Dapur).
*   `<?php ... ?>`: Tanda mulai dan selesai kode PHP.
*   `$variabel`: Cara bikin variabel (harus pakai dollar).
*   `echo`: Perintah untuk menampilkan tulisan ke layar.
*   `foreach`: Perintah untuk mengulang data (looping).
*   `$_POST`: Kotak surat untuk menerima data dari Form.
*   `$_SESSION`: Gelang tangan untuk mengingat user login.

---

## 2. HTML (HyperText Markup Language)
Kerangka dasar halaman web.
*   `<div>`: Kotak pembungkus (paling sering dipakai).
*   `<input>`: Kotak isian.
*   `<select>`: Dropdown menu.
*   `<table>`: Tabel data.
*   `<form>`: Formulir pengiriman data.

---

## 3. CSS & Bootstrap
Baju dan Make-up untuk HTML.
*   **Bootstrap:** Kumpulan CSS siap pakai buatan Twitter.
*   `container`: Kotak pembungkus utama (biar ada jarak kiri-kanan).
*   `row` & `col`: Sistem tata letak (Grid).
*   `btn btn-primary`: Tombol warna biru.
*   `form-control`: Kotak inputan gaya modern.
*   `d-none`: Menyembunyikan elemen (Display None).

---

## 4. JavaScript & jQuery
Otak yang berjalan di **Browser** (Meja Makan User). Membuat web jadi interaktif.
*   **jQuery:** Versi ringkas dari JavaScript. Tandanya pakai `$`.
*   `$(document).ready(...)`: "Tunggu sampai halaman selesai dimuat, baru jalankan kode ini".
*   `.click(...)`: "Kalau diklik, lakukan ini".
*   `.change(...)`: "Kalau isinya berubah, lakukan ini".
*   `.val()`: Ambil nilai.

---

## 5. AJAX (Asynchronous JavaScript and XML)
Teknik kirim data tanpa reload.
*   Bayangkan seperti kirim pesan WhatsApp. Kamu kirim pesan, tapi kamu tidak perlu keluar dari aplikasi WA untuk pesan itu sampai.
*   Di kode kita: `$.ajax({...})`.

---

## 6. SQL (Structured Query Language)
Bahasa untuk bicara dengan Database.
*   `SELECT * FROM tabel`: Ambil semua data.
*   `WHERE id = 1`: ...tapi cuma yang ID-nya 1.
*   `INSERT INTO tabel VALUES (...)`: Masukkan data baru.
*   `UPDATE tabel SET ...`: Ubah data.
*   `DELETE FROM tabel`: Hapus data.

---

## Tips Belajar untuk Beginner

1.  **Jangan Copy-Paste Buta:** Kalau copy kode, baca baris per baris. Tanya "Baris ini gunanya apa?".
2.  **Error itu Teman:** Kalau ada error merah, baca pesannya. Biasanya dia kasih tahu baris ke berapa yang salah.
3.  **Gunakan `console.log()`:** Di JavaScript, pakai ini untuk mengintip nilai variabel di Console Browser (Tekan F12 -> Console).
4.  **Gunakan `var_dump()`:** Di PHP, pakai ini untuk mengintip isi variabel/array di layar.

Semangat belajar! Kamu sudah melangkah jauh dengan membangun StellarBox ini. 🚀
