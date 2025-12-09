<?php
session_start();

// Keamanan: Hanya Admin yang boleh masuk.
// Jika user belum login ATAU role-nya bukan 'Admin', tampilkan error 404 (Halaman Tidak Ditemukan).
if (!isset($_SESSION["userid"]) || $_SESSION["role"] !== "Admin") {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>The requested URL was not found on this server.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StellarBox - Create User</title>
    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6"> <!-- Sedikit lebih lebar dari login (col-md-6 vs col-md-4) karena isiannya lebih banyak -->
                
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Create New User</h4>
                        <small>Admin Access Only</small>
                    </div>
                    <div class="card-body p-4">
                        
                        <form action="includes/signup.inc.php" method="post">
                            
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Choose a username" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="pwd" class="form-control" placeholder="Create a strong password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role / Jabatan</label>
                                <select name="role" class="form-select">
                                    <option value="RSC">RSC (Requestor)</option>
                                    <option value="QPS">QPS (Vendor & Pricing)</option>
                                    <option value="EM">EM (Approval Manager)</option>
                                    <option value="Admin">Admin (System Administrator)</option>
                                </select>
                                <div class="form-text">Pilih peran yang sesuai untuk pengguna ini.</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Create User</button>
                                <a href="dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Link JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>