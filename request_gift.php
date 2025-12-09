<?php
session_start();

// Security Check: Only RSC allowed
if (!isset($_SESSION["userid"]) || $_SESSION["role"] !== "RSC") {
    header("Location: dashboard.php");
    exit();
}

require_once 'Classes/Dbh.php';

// Fetch Master Data for Dropdowns
try {
    $dbh = new Dbh();
    $pdo = $dbh->connect();

    $projects = $pdo->query("SELECT * FROM master_projects")->fetchAll(PDO::FETCH_ASSOC);
    $surveyors = $pdo->query("SELECT * FROM master_surveyors")->fetchAll(PDO::FETCH_ASSOC);
    $items = $pdo->query("SELECT * FROM master_items")->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die("Error fetching master data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Gift - StellarBox</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS (For Searchable Dropdowns) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Navbar (Simplified) -->
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
            <span class="navbar-text text-white">Request Gift Form</span>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row">
            <!-- Form Section -->
            <div class="col-md-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-primary"><i class="bi bi-pencil-square"></i> Input Request Item</h5>
                    </div>
                    <div class="card-body">
                        <form id="requestForm">
                            <div class="row g-2"> <!-- Reduced gap from g-3 to g-2 -->
                                
                                <!-- Row 1 -->
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Nama Project</label>
                                    <select class="form-select form-select-sm select2" id="projectSelect" required>
                                        <option value="">Select Project...</option>
                                        <?php foreach($projects as $p): ?>
                                            <option value="<?php echo $p['id']; ?>" data-wbs="<?php echo $p['wbs_code']; ?>"><?php echo $p['project_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">WBS Code</label>
                                    <input type="text" class="form-control form-control-sm bg-light" id="wbsCode" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Nama Surveyor (SI)</label>
                                    <select class="form-select form-select-sm select2" id="siSelect" required>
                                        <option value="">Select SI...</option>
                                        <?php foreach($surveyors as $s): ?>
                                            <option value="<?php echo $s['id']; ?>" data-area="<?php echo $s['area_city']; ?>"><?php echo $s['si_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Kota / Area</label>
                                    <input type="text" class="form-control form-control-sm bg-light" id="areaCity" readonly>
                                </div>

                                <!-- Row 2 -->
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Nama Barang</label>
                                    <select class="form-select form-select-sm select2" id="itemSelect" required>
                                        <option value="">Select Item...</option>
                                        <?php foreach($items as $i): ?>
                                            <option value="<?php echo $i['id']; ?>" data-price="<?php echo $i['base_price']; ?>"><?php echo $i['item_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Harga Dasar</label>
                                    <input type="number" class="form-control form-control-sm bg-light" id="basePrice" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Harga Aktual</label>
                                    <input type="number" class="form-control form-control-sm bg-light" id="actualPrice" disabled placeholder="Pending QPS">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Kuota</label>
                                    <input type="number" class="form-control form-control-sm" id="quotaQty" required min="1">
                                </div>

                                <!-- Row 3 -->
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Jml Order</label>
                                    <input type="number" class="form-control form-control-sm" id="orderQty" required min="1">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Buffer (%)</label>
                                    <input type="number" class="form-control form-control-sm bg-light" id="bufferQty" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1 fw-bold">Total Rp</label>
                                    <input type="text" class="form-control form-control-sm fw-bold text-primary bg-light" id="totalRp" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Catatan RSC</label>
                                    <input type="text" class="form-control form-control-sm" id="rscNotes" placeholder="Optional notes...">
                                </div>

                                <!-- Add Button -->
                                <div class="col-12 text-end mt-3">
                                    <button type="button" class="btn btn-sm btn-success px-4" id="btnAddData">
                                        <i class="bi bi-plus-lg"></i> Add Data
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-secondary"><i class="bi bi-list-check"></i> Request List</h5>
                        <button class="btn btn-primary" id="btnSubmitRequest" disabled>
                            <i class="bi bi-send"></i> Submit Request
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0" id="requestTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Project</th>
                                        <th>SI</th>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Buffer</th>
                                        <th>Total (Est)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be added here via JS -->
                                    <tr id="emptyRow">
                                        <td colspan="7" class="text-center text-muted py-4">No items added yet.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // 1. Initialize Select2 (Searchable Dropdowns)
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            // 2. Auto-fill Logic
            $('#projectSelect').on('change', function() {
                const wbs = $(this).find(':selected').data('wbs');
                $('#wbsCode').val(wbs || '');
            });

            $('#siSelect').on('change', function() {
                const area = $(this).find(':selected').data('area');
                $('#areaCity').val(area || '');
            });

            $('#itemSelect').on('change', function() {
                const price = $(this).find(':selected').data('price');
                $('#basePrice').val(price || 0);
                calculateTotal();
            });

            // 3. Calculation Logic
            $('#quotaQty, #orderQty').on('input', function() {
                calculateBuffer();
                calculateTotal();
            });

            function calculateBuffer() {
                const quota = parseInt($('#quotaQty').val()) || 0;
                const order = parseInt($('#orderQty').val()) || 0;
                
                // Logic: Buffer = 10% of difference, rounded up. Or just difference?
                // User said: "persentasi dari selisih kuota dan jml_order"
                // Let's assume 10% for now.
                let diff = order - quota;
                if (diff < 0) diff = 0;
                
                const buffer = Math.ceil(diff / quota * 100); 
                $('#bufferQty').val(buffer);
            }

            function calculateTotal() {
                const order = parseInt($('#orderQty').val()) || 0;
                const basePrice = parseFloat($('#basePrice').val()) || 0;
                // Actual price logic (future proofing)
                const actualPrice = parseFloat($('#actualPrice').val()) || 0;
                
                const priceToUse = actualPrice > 0 ? actualPrice : basePrice;
                const total = order * priceToUse;

                // Format Currency
                $('#totalRp').val(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total));
            }

            // 4. Add Data to Table Logic
            let requestItems = [];

            $('#btnAddData').click(function() {
                // Validate
                if(!$('#projectSelect').val() || !$('#siSelect').val() || !$('#itemSelect').val() || !$('#orderQty').val()) {
                    alert("Please fill in all required fields.");
                    return;
                }

                // Collect Data
                const itemData = {
                    project_id: $('#projectSelect').val(),
                    project_name: $('#projectSelect option:selected').text(),
                    wbs: $('#wbsCode').val(),
                    si_id: $('#siSelect').val(),
                    si_name: $('#siSelect option:selected').text(),
                    area: $('#areaCity').val(),
                    item_id: $('#itemSelect').val(),
                    item_name: $('#itemSelect option:selected').text(),
                    base_price: $('#basePrice').val(),
                    quota: $('#quotaQty').val(),
                    order_qty: $('#orderQty').val(),
                    buffer: $('#bufferQty').val(),
                    notes: $('#rscNotes').val(),
                    total_display: $('#totalRp').val()
                };

                requestItems.push(itemData);
                renderTable();
                clearForm();
                $('#btnSubmitRequest').prop('disabled', false);
            });

            function renderTable() {
                const tbody = $('#requestTable tbody');
                tbody.empty();

                if (requestItems.length === 0) {
                    tbody.append('<tr id="emptyRow"><td colspan="7" class="text-center text-muted py-4">No items added yet.</td></tr>');
                    return;
                }

                requestItems.forEach((item, index) => {
                    const row = `
                        <tr>
                            <td>${item.project_name}<br><small class="text-muted">${item.wbs}</small></td>
                            <td>${item.si_name}<br><small class="text-muted">${item.area}</small></td>
                            <td>${item.item_name}</td>
                            <td>${item.order_qty}</td>
                            <td>${item.buffer}</td>
                            <td>${item.total_display}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="removeItem(${index})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }

            window.removeItem = function(index) {
                requestItems.splice(index, 1);
                renderTable();
                if (requestItems.length === 0) {
                    $('#btnSubmitRequest').prop('disabled', true);
                }
            };

            function clearForm() {
                // Reset Select2
                $('.select2').val(null).trigger('change');
                // Reset Inputs
                $('#requestForm')[0].reset();
            }

            // 5. Submit Request Logic
            $('#btnSubmitRequest').click(function() {
                if(!confirm("Are you sure you want to submit these requests? Email notification will be sent to QPS.")) return;

                const btn = $(this);
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

                $.ajax({
                    url: 'includes/request.inc.php',
                    method: 'POST',
                    data: { requests: JSON.stringify(requestItems) },
                    success: function(response) {
                        try {
                            const res = JSON.parse(response);
                            if(res.status === 'success') {
                                alert("Success! Requests submitted and email notification sent.");
                                window.location.href = 'dashboard.php';
                            } else {
                                alert("Error: " + res.message);
                                btn.prop('disabled', false).text('Submit Request');
                            }
                        } catch(e) {
                            console.error(response);
                            alert("Server error occurred.");
                            btn.prop('disabled', false).text('Submit Request');
                        }
                    },
                    error: function() {
                        alert("Connection failed.");
                        btn.prop('disabled', false).text('Submit Request');
                    }
                });
            });
        });
    </script>
</body>
</html>
