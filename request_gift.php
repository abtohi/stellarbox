<?php
session_start();

// Security Check: Only RSC allowed
if (!isset($_SESSION["userid"]) || $_SESSION["role"] !== "RSC") {
    header("Location: dashboard.php");
    exit();
}

require_once 'Classes/Dbh.php';
require_once 'Classes/MasterData.php';

// Fetch Master Data for Dropdowns
try {
    $masterData = new MasterData();
    $projects = $masterData->getAllProjects();
    
    // Filter Surveyors based on logged-in RSC email
    $rscEmail = $_SESSION['useruid']; // useruid now stores email
    $surveyors = $masterData->getAllSurveyors($rscEmail);
    
    $items = $masterData->getAllItems();

} catch (Exception $e) {
    die("Error fetching master data: " . $e->getMessage());
}

$page_title = "Request Gift";
require_once 'layouts/header.php';
?>

    <div class="container-fluid mb-5">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-gift"></i> Request Gift</h4>
                <p class="text-muted mb-0">Create a new gift request for your project.</p>
            </div>
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="row">
            <!-- Left Column: Input Form -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-primary">1. Input Details</h6>
                    </div>
                    <div class="card-body">
                        <form id="addRequestForm">
                            
                            <!-- Project Selection -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Project</label>
                                <select class="form-select select2" id="projectSelect" required>
                                    <option value="">Select Project...</option>
                                    <?php foreach ($projects as $p): ?>
                                        <option value="<?php echo $p['project_code']; ?>" data-wbs="<?php echo $p['wbs_number']; ?>">
                                            <?php echo $p['project_code'] . ' # ' . $p['project_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- WBS Code (Auto-filled) -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">WBS Number</label>
                                <input type="text" class="form-control bg-light" id="wbsCode" readonly>
                            </div>

                            <!-- Surveyor Selection -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Surveyor (SI)</label>
                                <select class="form-select select2" id="siSelect" required>
                                    <option value="">Select Surveyor...</option>
                                    <?php foreach ($surveyors as $s): ?>
                                        <option value="<?php echo $s['si_id']; ?>" data-area="<?php echo $s['area_city']; ?>">
                                            <?php echo $s['si_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Area/City (Auto-filled) -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Area / City</label>
                                <input type="text" class="form-control bg-light" id="areaCity" readonly>
                            </div>

                            <hr>

                            <!-- Item Selection -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Gift Item</label>
                                <select class="form-select select2" id="itemSelect" required>
                                    <option value="">Select Item...</option>
                                    <?php foreach ($items as $i): ?>
                                        <option value="<?php echo $i['id']; ?>" data-price="<?php echo $i['base_price']; ?>">
                                            <?php echo $i['item_name']; ?> (Rp <?php echo number_format($i['base_price'], 0, ',', '.'); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Hidden Price -->
                            <input type="hidden" id="basePrice">

                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label small fw-bold">Quota</label>
                                    <input type="number" class="form-control" id="quotaQty" placeholder="0">
                                </div>
                                <div class="col-4">
                                    <label class="form-label small fw-bold">Order</label>
                                    <input type="number" class="form-control" id="orderQty" placeholder="0" required>
                                </div>
                                <div class="col-4">
                                    <label class="form-label small fw-bold">Buffer</label>
                                    <input type="number" class="form-control" id="bufferQty" placeholder="0">
                                </div>
                            </div>

                            <!-- Total Calculation -->
                            <div class="mt-3 p-3 bg-light rounded border">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small fw-bold text-muted">Total Amount:</span>
                                    <h5 class="mb-0 text-primary fw-bold" id="totalDisplay">Rp 0</h5>
                                </div>
                                <input type="hidden" id="totalRp">
                            </div>

                            <!-- Notes -->
                            <div class="mt-3">
                                <label class="form-label small fw-bold">Notes (Optional)</label>
                                <textarea class="form-control" id="rscNotes" rows="2"></textarea>
                            </div>

                            <!-- Add Button -->
                            <div class="d-grid mt-4">
                                <button type="button" class="btn btn-primary" id="btnAddItem">
                                    <i class="bi bi-plus-lg"></i> Add to List
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Table List -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-primary">2. Request List</h6>
                        <span class="badge bg-secondary" id="itemCount">0 Items</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="requestTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Project</th>
                                        <th>Surveyor</th>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Buffer</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="emptyRow">
                                        <td colspan="7" class="text-center text-muted py-5">
                                            <i class="bi bi-basket display-4 d-block mb-3"></i>
                                            No items added yet. Fill the form to add items.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white p-3">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-danger" onclick="clearAll()">Clear All</button>
                            <button type="button" class="btn btn-success px-4" id="btnSubmitRequest" disabled>
                                <i class="bi bi-send"></i> Submit Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once 'layouts/footer.php'; ?>

    <!-- Page Specific Scripts -->
    <script>
        let requestItems = [];

        $(document).ready(function() {
            // Auto-fill WBS when Project selected
            $('#projectSelect').change(function() {
                const wbs = $(this).find(':selected').data('wbs');
                $('#wbsCode').val(wbs || '');
            });

            // Auto-fill Area when SI selected
            $('#siSelect').change(function() {
                const area = $(this).find(':selected').data('area');
                $('#areaCity').val(area || '');
            });

            // Auto-fill Price & Calculate Total
            $('#itemSelect, #orderQty').change(calculateTotal);
            $('#itemSelect, #orderQty').keyup(calculateTotal);

            function calculateTotal() {
                const price = $('#itemSelect').find(':selected').data('price') || 0;
                const qty = $('#orderQty').val() || 0;
                const total = price * qty;

                $('#basePrice').val(price);
                $('#totalRp').val(total);
                $('#totalDisplay').text('Rp ' + total.toLocaleString('id-ID'));
            }

            // Add Item to List
            $('#btnAddItem').click(function() {
                // Validation
                if (!$('#projectSelect').val() || !$('#siSelect').val() || !$('#itemSelect').val() || !$('#orderQty').val()) {
                    alert('Please fill all required fields!');
                    return;
                }

                // Collect Data
                const itemData = {
                    project_id: $('#projectSelect').val(), // Now project_code
                    project_name: $('#projectSelect option:selected').text().trim(), // Now "Code # Name"
                    wbs: $('#wbsCode').val(),
                    si_id: $('#siSelect').val(),
                    si_name: $('#siSelect option:selected').text().trim(),
                    area: $('#areaCity').val(),
                    item_id: $('#itemSelect').val(),
                    item_name: $('#itemSelect option:selected').text().split('(')[0].trim(),
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
                            <td>Rp ${parseInt(item.total_display).toLocaleString('id-ID')}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="removeItem(${index})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });
                
                $('#itemCount').text(requestItems.length + ' Items');
            }

            window.removeItem = function(index) {
                requestItems.splice(index, 1);
                renderTable();
                if (requestItems.length === 0) {
                    $('#btnSubmitRequest').prop('disabled', true);
                }
            };

            window.clearAll = function() {
                if(confirm('Are you sure you want to clear all items?')) {
                    requestItems = [];
                    renderTable();
                    $('#btnSubmitRequest').prop('disabled', true);
                }
            };

            function clearForm() {
                // Reset inputs but keep Project/SI if user wants to add multiple items for same project
                // For now, let's reset Item and Qty only for better UX
                $('#itemSelect').val('').trigger('change');
                $('#orderQty').val('');
                $('#bufferQty').val('');
                $('#quotaQty').val('');
                $('#rscNotes').val('');
                $('#totalDisplay').text('Rp 0');
            }

            // Submit to Server
            $('#btnSubmitRequest').click(function() {
                if (requestItems.length === 0) return;

                if(!confirm('Submit ' + requestItems.length + ' request items?')) return;

                $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Sending...');

                $.ajax({
                    url: 'includes/request.inc.php',
                    type: 'POST',
                    data: { requests: JSON.stringify(requestItems) },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Request submitted successfully!');
                            window.location.href = 'my_requests.php';
                        } else {
                            alert('Error: ' + response.message);
                            $('#btnSubmitRequest').prop('disabled', false).html('<i class="bi bi-send"></i> Submit Request');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('System Error: ' + error);
                        console.error(xhr.responseText);
                        $('#btnSubmitRequest').prop('disabled', false).html('<i class="bi bi-send"></i> Submit Request');
                    }
                });
            });
        });
    </script>
