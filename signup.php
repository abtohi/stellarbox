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

$page_title = "Create User";
require_once 'layouts/header.php';
?>

    <div class="container-fluid">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-person-plus"></i> User Management</h4>
                <p class="text-muted mb-0">Create and manage system users.</p>
            </div>
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6"> 
                
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-primary">Create New User</h6>
                    </div>
                    <div class="card-body p-4">
                        
                        <form action="includes/signup.inc.php" method="post">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="pwd" class="form-control" placeholder="Create a strong password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Role / Jabatan</label>
                                <select name="role" class="form-select select2">
                                    <option value="RSC">RSC (Requestor)</option>
                                    <option value="QPS">QPS (Vendor & Pricing)</option>
                                    <option value="EM">EM (Approval Manager)</option>
                                    <option value="Admin">Admin (System Administrator)</option>
                                </select>
                                <div class="form-text">Pilih peran yang sesuai untuk pengguna ini.</div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Create User
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php require_once 'layouts/footer.php'; ?>
