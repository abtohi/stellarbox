<?php
require_once 'includes/config_session.inc.php';

// Check if user is logged in and is Admin
if (!isset($_SESSION["userid"]) || $_SESSION["role"] !== 'Admin') {
    header("Location: index.php");
    exit();
}

$page_title = "Admin Bulk Upload";
require_once 'layouts/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Bulk Upload Data</h2>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Projects Upload -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-briefcase me-2"></i>Master Projects</h5>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">Upload project data including codes, names, and timelines.</p>
                    <a href="includes/download_template.php?type=projects" class="btn btn-outline-primary btn-sm mb-3 w-100">
                        <i class="bi bi-download me-2"></i> Download Template
                    </a>
                    <form action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="projects">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file" accept=".csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Upload Projects</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Items Upload -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-box-seam me-2"></i>Master Items</h5>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">Upload item catalog with base prices.</p>
                    <a href="includes/download_template.php?type=items" class="btn btn-outline-success btn-sm mb-3 w-100">
                        <i class="bi bi-download me-2"></i> Download Template
                    </a>
                    <form action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="items">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file" accept=".csv" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Upload Items</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Structure Upload -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-people me-2"></i>Master Structure</h5>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">Upload SI, RSC, and QPS structure data.</p>
                    <a href="includes/download_template.php?type=structure" class="btn btn-outline-info btn-sm mb-3 w-100">
                        <i class="bi bi-download me-2"></i> Download Template
                    </a>
                    <form action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="structure">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file" accept=".csv" required>
                        </div>
                        <button type="submit" class="btn btn-info text-white w-100">Upload Structure</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>
