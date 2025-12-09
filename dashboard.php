<?php
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - StellarBox</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-box-seam"></i> StellarBox
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Home</a>
                    </li>
                    
                    <?php if ($_SESSION["role"] == "RSC"): ?>
                        <li class="nav-item"><a class="nav-link" href="request_gift.php">Request Gift</a></li>
                        <li class="nav-item"><a class="nav-link" href="my_requests.php">My Requests</a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION["role"] == "QPS"): ?>
                        <li class="nav-item"><a class="nav-link" href="#">Review Requests</a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION["role"] == "EM"): ?>
                        <li class="nav-item"><a class="nav-link" href="#">Approve Requests</a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION["role"] == "Admin"): ?>
                        <li class="nav-item"><a class="nav-link" href="signup.php">Create User</a></li>
                    <?php endif; ?>
                </ul>
                
                <div class="d-flex align-items-center text-white">
                    <div class="me-3 text-end d-none d-lg-block">
                        <small class="d-block text-white-50" style="line-height: 1;">Signed in as</small>
                        <span class="fw-bold"><?php echo htmlspecialchars($_SESSION["useruid"]); ?></span>
                        <span class="badge bg-light text-primary ms-1"><?php echo $_SESSION["role"]; ?></span>
                    </div>
                    <a href="includes/logout.inc.php" class="btn btn-danger btn-sm ms-2">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5 text-center">
                        <h1 class="display-4 text-primary mb-3">Welcome back, <?php echo htmlspecialchars($_SESSION["useruid"]); ?>!</h1>
                        <p class="lead text-muted">
                            You are logged in as <strong><?php echo $_SESSION["role"]; ?></strong>. 
                            Select an option from the menu to get started.
                        </p>
                        <hr class="my-4">
                        
                        <!-- Quick Actions based on Role -->
                        <div class="d-flex justify-content-center gap-3">
                            <?php if ($_SESSION["role"] == "RSC"): ?>
                                <a href="request_gift.php" class="btn btn-primary btn-lg"><i class="bi bi-plus-circle"></i> New Request</a>
                            <?php endif; ?>
                            
                            <?php if ($_SESSION["role"] == "Admin"): ?>
                                <a href="signup.php" class="btn btn-outline-primary btn-lg"><i class="bi bi-person-plus"></i> Add User</a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
