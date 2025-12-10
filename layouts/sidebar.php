<!-- SIDEBAR MENU -->
<div class="sidebar">
    <!-- Logo -->
    <div class="brand-logo">
        <i class="bi bi-box-seam"></i>
        <span class="sidebar-text">StellarBox</span>
    </div>

    <!-- Menu Items -->
    <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="bi bi-house-door"></i>
        <span class="sidebar-text">Home</span>
    </a>

    <?php if ($_SESSION["role"] == "RSC"): ?>
        <a href="request_gift.php" class="<?php echo ($current_page == 'request_gift.php') ? 'active' : ''; ?>">
            <i class="bi bi-gift"></i>
            <span class="sidebar-text">Request Gift</span>
        </a>
        <a href="my_requests.php" class="<?php echo ($current_page == 'my_requests.php') ? 'active' : ''; ?>">
            <i class="bi bi-list-check"></i>
            <span class="sidebar-text">My Requests</span>
        </a>
    <?php endif; ?>

    <?php if ($_SESSION["role"] == "QPS"): ?>
        <a href="#" class="<?php echo ($current_page == 'review_requests.php') ? 'active' : ''; ?>">
            <i class="bi bi-search"></i>
            <span class="sidebar-text">Review Requests</span>
        </a>
    <?php endif; ?>

    <?php if ($_SESSION["role"] == "EM"): ?>
        <a href="#" class="<?php echo ($current_page == 'approve_requests.php') ? 'active' : ''; ?>">
            <i class="bi bi-check-circle"></i>
            <span class="sidebar-text">Approve Requests</span>
        </a>
    <?php endif; ?>

    <?php if ($_SESSION["role"] == "Admin"): ?>
        <a href="signup.php" class="<?php echo ($current_page == 'signup.php') ? 'active' : ''; ?>">
            <i class="bi bi-person-plus"></i>
            <span class="sidebar-text">Create User</span>
        </a>
        <a href="admin_upload.php" class="<?php echo ($current_page == 'admin_upload.php') ? 'active' : ''; ?>">
            <i class="bi bi-upload"></i>
            <span class="sidebar-text">Bulk Upload</span>
        </a>
    <?php endif; ?>

    <!-- Divider -->
    <div style="height: 1px; background: rgba(255,255,255,0.2); margin: 20px 0;"></div>

    <a href="includes/logout.inc.php" class="text-danger-emphasis">
        <i class="bi bi-box-arrow-right"></i>
        <span class="sidebar-text">Logout</span>
    </a>
</div>
