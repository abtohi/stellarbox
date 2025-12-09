<?php
session_start();
require_once '../Classes/Dbh.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["userid"])) {
    
    if (!isset($_POST['requests'])) {
        echo json_encode(['status' => 'error', 'message' => 'No data received']);
        exit();
    }

    $requests = json_decode($_POST['requests'], true);
    $userId = $_SESSION["userid"];
    
    // Generate Request Code (Batch ID)
    $requestCode = "REQ-" . date("Ymd") . "-" . rand(100, 999);

    try {
        $dbh = new Dbh();
        $pdo = $dbh->connect();
        $pdo->beginTransaction();

        $sql = "INSERT INTO gift_requests 
                (request_code, user_id, project_name, wbs_code, si_name, area_city, quota, order_qty, buffer, item_name, base_price, total_amount, rsc_notes, status, email_status) 
                VALUES 
                (:code, :uid, :proj, :wbs, :si, :area, :quota, :order, :buffer, :item, :price, :total, :notes, 'Pending', 'Sent')";
        
        $stmt = $pdo->prepare($sql);

        foreach ($requests as $req) {
            // Clean currency string to number
            $totalClean = preg_replace("/[^0-9]/", "", $req['total_display']); // Remove Rp and dots

            $stmt->execute([
                ':code' => $requestCode,
                ':uid' => $userId,
                ':proj' => $req['project_name'],
                ':wbs' => $req['wbs'],
                ':si' => $req['si_name'],
                ':area' => $req['area'],
                ':quota' => $req['quota'],
                ':order' => $req['order_qty'],
                ':buffer' => $req['buffer'],
                ':item' => $req['item_name'],
                ':price' => $req['base_price'],
                ':total' => $totalClean,
                ':notes' => $req['notes']
            ]);
        }

        $pdo->commit();

        // Mock Email Notification
        // mail("qps@stellarbox.com", "New Gift Request", "New request $requestCode has been submitted.");

        echo json_encode(['status' => 'success', 'message' => 'Requests saved']);

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
}
