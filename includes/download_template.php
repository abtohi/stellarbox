<?php
require_once 'config_session.inc.php';

if (!isset($_SESSION["userid"]) || $_SESSION["role"] !== 'Admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $filename = "template_" . $type . ".csv";
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    switch ($type) {
        case 'projects':
            fputcsv($output, ['project_code', 'project_name', 'wbs_number', 'status', 'fw_start', 'fw_end']);
            fputcsv($output, ['P001', 'Sample Project', 'WBS-123', 'Active', '2023-01-01', '2023-12-31']); // Example row
            break;
            
        case 'items':
            fputcsv($output, ['item_name', 'base_price']);
            fputcsv($output, ['Sample Item', '100000']); // Example row
            break;
            
        case 'structure':
            fputcsv($output, ['si_id', 'si_name', 'area_city', 'si_email', 'si_phone_number', 'si_status', 'rsc_name', 'rsc_email', 'qps_name', 'qps_email']);
            fputcsv($output, ['1', 'John Doe', 'Jakarta', 'john@example.com', '08123456789', 'Active', 'Jane Smith', 'jane@example.com', 'Bob Wilson', 'bob@example.com']); // Example row
            break;
    }
    
    fclose($output);
    exit();
}
