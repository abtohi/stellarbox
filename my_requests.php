<?php
session_start();

// Security Check
if (!isset($_SESSION["userid"])) {
    header("Location: index.php");
    exit();
}

require_once 'Classes/Dbh.php';
require_once 'Classes/RequestInfo.php';

// Initialize Filters
$filters = [
    'year' => isset($_GET['year']) ? $_GET['year'] : date('Y'),
    'project' => isset($_GET['project']) ? $_GET['project'] : '',
    'si' => isset($_GET['si']) ? $_GET['si'] : '',
    'date' => isset($_GET['date']) ? $_GET['date'] : ''
];

// Instantiate Model
$requestInfo = new RequestInfo();

// 1. Fetch Filter Options
$filter_projects_options = $requestInfo->getDistinctProjects($_SESSION["userid"], $_SESSION["role"]);
$filter_si_options = $requestInfo->getDistinctSIs($_SESSION["userid"], $_SESSION["role"]);

// 2. Fetch Data
$requests = $requestInfo->getRequests($_SESSION["userid"], $_SESSION["role"], $filters);

// For View Variables
$filter_year = $filters['year'];
$filter_project = $filters['project'];
$filter_si = $filters['si'];
$filter_date = $filters['date'];

$page_title = "My Requests";
require_once 'layouts/header.php';
?>

    <div class="container-fluid mb-5">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-list-check"></i> My Requests</h4>
                <p class="text-muted mb-0">View and track your gift requests.</p>
            </div>
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Filter Section -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-funnel"></i> Filter Requests</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="my_requests.php" class="row g-3">
                    
                    <!-- Filter: Year -->
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Tahun</label>
                        <input type="number" name="year" class="form-control" value="<?php echo htmlspecialchars($filter_year); ?>" placeholder="YYYY">
                    </div>

                    <!-- Filter: Project Name (Dropdown) -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Project</label>
                        <select name="project" class="form-select select2">
                            <option value="">All Projects</option>
                            <?php foreach($filter_projects_options as $opt): ?>
                                <option value="<?php echo htmlspecialchars($opt); ?>" <?php if($filter_project == $opt) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($opt); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Filter: SI Name (Dropdown) -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Nama SI</label>
                        <select name="si" class="form-select select2">
                            <option value="">All Surveyors</option>
                            <?php foreach($filter_si_options as $opt): ?>
                                <option value="<?php echo htmlspecialchars($opt); ?>" <?php if($filter_si == $opt) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($opt); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Filter: Date -->
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Tanggal Request</label>
                        <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($filter_date); ?>">
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="my_requests.php" class="btn btn-outline-secondary btn-sm px-4">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-search"></i> Apply Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-table"></i> Request Data</h6>
                <span class="badge bg-primary rounded-pill"><?php echo count($requests); ?> Records Found</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th>Req Code</th>
                                <th>Date</th>
                                <th>Project / WBS</th>
                                <th>RSC / SI</th>
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total (Rp)</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($requests) > 0): ?>
                                <?php foreach ($requests as $row): ?>
                                    <tr>
                                        <td class="fw-bold text-primary" style="font-size: 0.9rem;">
                                            <?php echo htmlspecialchars($row['request_code']); ?>
                                        </td>
                                        <td style="font-size: 0.85rem;">
                                            <?php echo date('d M Y', strtotime($row['created_at'])); ?><br>
                                            <span class="text-muted"><?php echo date('H:i', strtotime($row['created_at'])); ?></span>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?php echo htmlspecialchars($row['project_name']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($row['wbs_code']); ?></small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-person-circle text-secondary me-2"></i>
                                                <div>
                                                    <div class="fw-bold" style="font-size: 0.9rem;"><?php echo htmlspecialchars($row['rsc_name']); ?></div>
                                                    <small class="text-muted">SI: <?php echo htmlspecialchars($row['si_name']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['item_name']); ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">Order: <?php echo $row['order_qty']; ?></span>
                                            <br>
                                            <small class="text-muted">Buffer: <?php echo $row['buffer']; ?></small>
                                        </td>
                                        <td class="text-end fw-bold text-success">
                                            <?php echo number_format($row['total_amount'], 0, ',', '.'); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                                $statusClass = 'bg-secondary';
                                                if($row['status'] == 'Approved') $statusClass = 'bg-success';
                                                if($row['status'] == 'Rejected') $statusClass = 'bg-danger';
                                                if($row['status'] == 'Pending') $statusClass = 'bg-warning text-dark';
                                            ?>
                                            <span class="badge <?php echo $statusClass; ?> status-badge rounded-pill">
                                                <?php echo $row['status']; ?>
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-muted" style="font-size: 0.7rem;">
                                                    <i class="bi bi-envelope<?php echo ($row['email_status'] == 'Sent') ? '-check-fill text-success' : ''; ?>"></i> 
                                                    <?php echo $row['email_status']; ?>
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                        No requests found matching your filters.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <small class="text-muted">Showing all records for the selected period.</small>
            </div>
        </div>
    </div>

<?php require_once 'layouts/footer.php'; ?>
