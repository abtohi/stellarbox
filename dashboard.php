<?php
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: index.php");
    exit();
}

$page_title = "Dashboard";
require_once 'layouts/header.php';
?>

        <!-- Dashboard Cards -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 bg-white">
                        <div class="card-body p-5 text-center">
                            <h1 class="display-5 text-primary mb-3 fw-bold">Welcome back, <?php echo htmlspecialchars($_SESSION["useruid"]); ?>!</h1>
                            <p class="lead text-muted">
                                You are logged in as <strong><?php echo $_SESSION["role"]; ?></strong>. 
                                <br>Arahkan kursor ke sisi kiri layar untuk membuka menu.
                            </p>
                            <hr class="my-4 w-50 mx-auto">
                            
                            <!-- Quick Actions -->
                            <div class="d-flex justify-content-center gap-3">
                                <?php if ($_SESSION["role"] == "RSC"): ?>
                                    <a href="request_gift.php" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                                        <i class="bi bi-plus-circle me-2"></i> New Request
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($_SESSION["role"] == "Admin"): ?>
                                    <a href="signup.php" class="btn btn-outline-primary btn-lg px-4 rounded-pill">
                                        <i class="bi bi-person-plus me-2"></i> Add User
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Info Cards (Contoh Tambahan agar dashboard tidak sepi) -->
            <div class="row mt-4 g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-calendar-check text-primary h4 mb-0"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Today's Date</h6>
                                <h5 class="mb-0 fw-bold"><?php echo date('d M Y'); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bisa ditambah card lain di sini -->
            </div>

        </div>

<?php require_once 'layouts/footer.php'; ?>

