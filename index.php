<?php
session_start();
if (isset($_SESSION["userid"])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StellarBox - Login</title>
    <!-- 1. Link CSS Bootstrap (Baju Seragam) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light"> <!-- bg-light: Memberi warna latar abu-abu muda -->

    <!-- 2. Container: Wadah Utama -->
    <div class="container mt-5">
        
        <!-- 3. Row & Col: Sistem Grid (Tata Letak) -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                
                <!-- 4. Card: Kotak Putih -->
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">StellarBox Login</h3>
                        
                        <form action="includes/login.inc.php" method="post">
                            <!-- 5. Form Group: Pengelompokan Input -->
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <!-- form-control: Bikin input jadi cantik & lebar 100% -->
                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="pwd" class="form-control" placeholder="Enter password" required>
                            </div>
                            
                            <!-- 6. Button: Tombol Biru -->
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Link JS Bootstrap (Untuk fitur interaktif seperti dropdown/modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>