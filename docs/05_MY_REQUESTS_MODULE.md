# 05. Modul My Requests (Laporan & MVC)

Halaman ini menampilkan daftar request yang sudah dibuat. Di sini kita belajar tentang **Menampilkan Data**, **Filter**, dan **Select2**.

---

## 1. Konsep MVC yang Lebih Rapi

Di modul ini, kita sudah menerapkan pola MVC yang benar (setelah perbaikan terakhir).

*   **Model (`Classes/RequestInfo.php`):** Tukang ambil data dari gudang.
*   **View (`my_requests.php`):** Tukang pajang data di etalase.

### Kenapa dipisah?
Supaya kalau mau ganti desain tampilan, kita tidak perlu mengacak-acak kode database. Dan sebaliknya.

---

## 2. Bedah Kode: Model (`Classes/RequestInfo.php`)

Class ini punya fungsi-fungsi spesifik:

1.  `getDistinctProjects($userId, $role)`:
    *   Mencari nama-nama project yang unik (tidak kembar) dari database.
    *   Gunanya untuk isi Dropdown Filter.
    *   *Logic:* Kalau Role = RSC, cuma ambil project milik dia sendiri.

2.  `getRequests($userId, $role, $filters)`:
    *   Mengambil data utama untuk tabel.
    *   Menerima parameter `$filters` (Tahun, Project, SI, Tanggal).
    *   Menyusun query SQL secara dinamis.

```php
// Contoh Logic Filter Dinamis
if (!empty($filters['project'])) {
    // Kalau user milih project tertentu, tambahkan syarat ini ke SQL
    $sql .= " AND r.project_name = :project";
}
```

---

## 3. Bedah Kode: View (`my_requests.php`)

### Bagian Atas (Controller Mini)
```php
// Panggil Model
$requestInfo = new RequestInfo();

// Minta data ke Model
$filter_projects_options = $requestInfo->getDistinctProjects(...);
$requests = $requestInfo->getRequests(..., $filters);
```

### Bagian Tabel (Looping PHP)
Kita menggunakan `foreach` untuk mengulang baris tabel (`<tr>`) sebanyak jumlah data.

```php
<tbody>
    <?php foreach ($requests as $row): ?>
        <tr>
            <td><?php echo $row['request_code']; ?></td>
            <td><?php echo $row['project_name']; ?></td>
            <!-- ... kolom lainnya ... -->
            
            <!-- Logika Warna Status -->
            <?php 
                $warna = 'bg-secondary';
                if($row['status'] == 'Approved') $warna = 'bg-success';
            ?>
            <td><span class="badge <?php echo $warna; ?>"><?php echo $row['status']; ?></span></td>
        </tr>
    <?php endforeach; ?>
</tbody>
```

---

## 4. Fitur Keren: Select2 (Dropdown Bisa Search)

Dropdown bawaan HTML itu jelek dan tidak bisa dicari (search). Kita pakai library **Select2**.

### Cara Pakai:
1.  Pasang CSS & JS Select2 di `<head>` dan sebelum `</body>`.
2.  Kasih class `select2` di elemen `<select>`.
3.  Aktifkan dengan jQuery:

```javascript
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5', // Biar gayanya mirip Bootstrap
        placeholder: 'Pilih Salah Satu'
    });
});
```

Sekarang dropdown "Nama Project" dan "Nama SI" kamu bisa diketik untuk mencari!

---

## 5. Tips Debugging (Kalau Error)

Jika data tidak muncul:
1.  Cek Database: Apakah tabel `gift_requests` ada isinya?
2.  Cek Query: Apakah filter yang kamu pilih terlalu ketat? (Misal: Project A tapi SI B, padahal Project A pasangannya SI A).
3.  Cek `var_dump($requests)`: Taruh kode ini di PHP untuk mengintip isi data mentah dari database.
