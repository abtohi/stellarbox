# 02. Modul Autentikasi (Login & Signup)

Ini adalah pintu gerbang aplikasi. Kita akan belajar bagaimana cara memverifikasi user dan membedakan peran mereka (Role: Admin, RSC, dll).

---

## 1. Alur Kerja Login (Flowchart Cerita)

1.  **User** membuka `index.php` (Halaman Login).
2.  **User** isi username & password, lalu klik "Login".
3.  Form mengirim data ke `includes/login.inc.php` (**Controller**).
4.  **Controller** memanggil `Classes/Login.php` (**Model**).
5.  **Model** cek ke Database: "Ada gak user ini? Passwordnya cocok gak?".
6.  Jika **Cocok**: Buat Session (Pasang Gelang), lalu lempar ke `dashboard.php`.
7.  Jika **Gagal**: Kembalikan ke `index.php` dengan pesan error.

---

## 2. Bedah Kode: View (`index.php`)

Ini adalah tampilan luarnya. Fokus pada bagian `<form>`.

```html
<!-- action: Ke mana data dikirim? method: Bagaimana cara kirimnya? (POST = Rahasia) -->
<form action="includes/login.inc.php" method="post">
    
    <!-- Input Username -->
    <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username">
    </div>
    
    <!-- Input Password -->
    <div class="mb-3">
        <input type="password" name="pwd" class="form-control" placeholder="Password">
    </div>

    <!-- Tombol Submit -->
    <button type="submit" class="btn btn-primary">Login</button>
</form>
```

---

## 3. Bedah Kode: Controller (`includes/login.inc.php`)

Tugasnya: Menerima paket, mengecek kelengkapan, lalu oper ke Model.

```php
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Tangkap data dari form
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        // 2. Panggil file-file pendukung
        require_once "../Classes/Dbh.php";
        require_once "../Classes/Login.php";

        // 3. Siapkan Model Login
        $login = new Login($username, $pwd);
        
        // 4. Jalankan perintah loginUser()
        $login->loginUser();

        // 5. Jika sukses, pindah ke Dashboard
        header("Location: ../dashboard.php?login=success");
        exit();

    } catch (Exception $e) {
        // Error handling...
    }
}
```

---

## 4. Bedah Kode: Model (`Classes/Login.php`)

Ini adalah otak yang berpikir.

```php
class Login extends Dbh {
    // ... properti username & pwd ...

    public function loginUser() {
        // 1. Ambil data user dari DB berdasarkan username
        // (Lihat method getUser di bawah)
        $user = $this->getUser($this->username);

        // 2. Cek Password (Verifikasi Hash)
        // Password di DB itu ter-enkripsi (acak). Kita pakai password_verify untuk mencocokkan.
        $checkPwd = password_verify($this->pwd, $user["pwd"]);

        if ($checkPwd == false) {
            // Password Salah!
            header("Location: ../index.php?error=wrongpassword");
            exit();
        } else {
            // 3. Password Benar! MULAI SESSION
            session_start();
            $_SESSION["userid"] = $user["id"];      // Simpan ID di gelang
            $_SESSION["useruid"] = $user["username"]; // Simpan Nama di gelang
            $_SESSION["role"] = $user["role"];      // Simpan Role di gelang
        }
    }
}
```

### Konsep Penting: Hashing Password
Kita **TIDAK BOLEH** menyimpan password asli (misal: "rahasia123") di database.
Kita harus mengacaknya menjadi kode aneh (misal: `$2y$10$Kj8...`).
*   Saat Daftar: Pakai `password_hash()`.
*   Saat Login: Pakai `password_verify()`.

---

## 5. Logout (`includes/logout.inc.php`)

Sangat sederhana. Cukup hancurkan gelangnya.

```php
<?php
session_start();
session_unset(); // Hapus semua isi variabel $_SESSION
session_destroy(); // Hancurkan session ID
header("Location: ../index.php"); // Tendang balik ke halaman login
```
