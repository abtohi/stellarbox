<?php
// Determine active page for sidebar highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - StellarBox' : 'StellarBox'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Select2 CSS (Included globally as it's used in multiple pages) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php require_once 'sidebar.php'; ?>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="main-content">
        
        <!-- TOP HEADER (User Profile) -->
        <div class="d-flex justify-content-end align-items-center mb-4 p-3 bg-white shadow-sm rounded">
            <div class="me-3 text-end">
                <small class="d-block text-muted" style="line-height: 1;">Signed in as</small>
                <span class="fw-bold text-primary"><?php echo htmlspecialchars($_SESSION["useruid"]); ?></span>
                <span class="badge bg-primary ms-1"><?php echo $_SESSION["role"]; ?></span>
            </div>
            <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                <i class="bi bi-person-fill text-secondary h5 mb-0"></i>
            </div>
        </div>

        <!-- Page Content Starts Here -->
