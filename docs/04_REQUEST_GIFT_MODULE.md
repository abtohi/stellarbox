# 04. Modul Request Gift (AJAX & jQuery)

Ini adalah modul paling rumit tapi paling keren. Kita membuat formulir yang bisa menambah baris item tanpa reload halaman, menghitung total otomatis, dan mengirim data secara diam-diam.

---

## 1. Konsep AJAX (Si Pelayan Restoran)

Bayangkan kamu di restoran:
1.  **Tanpa AJAX:** Kamu pesan makan -> Kamu harus jalan sendiri ke dapur -> Kasih pesanan -> Tunggu koki masak -> Bawa balik makanan ke meja. (Halaman Reload/Loading Putih).
2.  **Dengan AJAX:** Kamu panggil pelayan -> Pelayan lari ke dapur -> Kamu tetap duduk santai sambil ngobrol -> Pelayan balik bawa makanan. (Halaman Tidak Reload).

Di sini, **jQuery** adalah bahasa yang kita pakai untuk menyuruh si Pelayan (AJAX).

---

## 2. Bedah Kode: View (`request_gift.php`)

### Struktur HTML
Kita punya dua bagian utama:
1.  **Form Input:** Tempat user mengetik (Project, Item, Qty, dll).
2.  **Tabel Keranjang (`#requestTable`):** Tempat menampung item sementara sebelum disimpan ke database.

### Tombol "Add to List" (jQuery)
Saat tombol ini diklik, kita tidak kirim ke database dulu. Kita cuma pindahkan data dari Form ke Tabel Keranjang.

```javascript
// Saat tombol ID 'btnAddItem' diklik...
$('#btnAddItem').click(function() {
    // 1. Ambil nilai dari input
    const project = $('#projectSelect option:selected').text();
    const item = $('#itemSelect option:selected').text();
    const qty = $('#orderQty').val();
    
    // 2. Validasi (Cek kosong gak?)
    if(qty === '') { alert('Isi dulu qty nya!'); return; }

    // 3. Masukkan ke Array (Daftar Belanjaan di memori komputer)
    requestItems.push({
        project_name: project,
        item_name: item,
        order_qty: qty
        // ... data lainnya
    });

    // 4. Gambar ulang tabel HTML
    renderTable();
});
```

### Tombol "Submit Request" (AJAX)
Ini saatnya kita panggil pelayan untuk kirim semua data di Keranjang ke Dapur (Database).

```javascript
$('#btnSubmitRequest').click(function() {
    // Siapkan data yang mau dikirim
    const dataPaket = {
        requests: JSON.stringify(requestItems) // Ubah Array jadi Teks JSON
    };

    // Panggil AJAX
    $.ajax({
        url: 'includes/request.inc.php', // Alamat Dapur
        type: 'POST',                    // Cara kirim
        data: dataPaket,                 // Paketnya
        success: function(response) {    // Kalau sukses...
            if(response.status === 'success') {
                alert('Berhasil disimpan!');
                window.location.href = 'my_requests.php'; // Pindah halaman
            } else {
                alert('Gagal: ' + response.message);
            }
        }
    });
});
```

---

## 3. Bedah Kode: Controller (`includes/request.inc.php`)

Dapur yang menerima pesanan dari AJAX.

```php
<?php
// Terima data
$requests = json_decode($_POST['requests'], true); // Ubah Teks JSON balik jadi Array PHP

// Buat Kode Unik (Misal: REQ-20231209-123)
$requestCode = "REQ-" . date("Ymd") . "-" . rand(100, 999);

// Mulai Transaksi Database
// (Artinya: Kalau ada 10 item, semua harus sukses masuk. Kalau 1 gagal, batalkan semua)
$pdo->beginTransaction();

foreach ($requests as $req) {
    // Masukkan satu per satu ke tabel gift_requests
    $sql = "INSERT INTO gift_requests (...) VALUES (...)";
    $stmt->execute([ ... ]);
}

// Simpan Permanen
$pdo->commit();

// Kirim balasan ke AJAX
echo json_encode(['status' => 'success']);
```

---

## 4. Tips jQuery untuk Pemula

*   `$('#id')`: Cara memilih elemen HTML berdasarkan ID.
*   `.val()`: Mengambil nilai input (isi kotak teks).
*   `.text()`: Mengambil teks biasa (misal isi `<div>` atau `<option>`).
*   `.html()`: Mengambil isi HTML (termasuk tag-tag di dalamnya).
*   `.append()`: Menambahkan elemen baru di bagian bawah.
*   `.empty()`: Mengosongkan isi elemen.

---

## 5. Perubahan Penting (Update Terakhir)

Kita baru saja mengubah nama kolom `buffer_qty` menjadi `buffer`.
Pastikan di JavaScript kamu pakai `item.buffer`, dan di PHP kamu insert ke kolom `buffer`.
