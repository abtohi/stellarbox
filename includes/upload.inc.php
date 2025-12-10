<?php
require_once 'config_session.inc.php';
require_once '../Classes/Dbh.php';
require_once '../Classes/BulkUpload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["userid"]) && $_SESSION["role"] === 'Admin') {
    
    if (isset($_FILES['file']) && isset($_POST['type'])) {
        $file = $_FILES['file'];
        $type = $_POST['type'];
        
        // Basic validation
        $allowed = ['csv', 'txt'];
        $filename = $file['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (!in_array(strtolower($ext), $allowed)) {
            $_SESSION['error'] = "Invalid file type. Please upload a CSV file.";
            header("Location: ../admin_upload.php");
            exit();
        }
        
        try {
            $uploader = new BulkUpload();
            $handle = fopen($file['tmp_name'], "r");
            
            if ($handle === FALSE) {
                throw new Exception("Could not open file.");
            }
            
            switch ($type) {
                case 'projects':
                    $uploader->uploadProjects($handle);
                    break;
                case 'items':
                    $uploader->uploadItems($handle);
                    break;
                case 'structure':
                    $uploader->uploadStructure($handle);
                    break;
                default:
                    throw new Exception("Invalid upload type.");
            }
            
            fclose($handle);
            $_SESSION['success'] = "Data uploaded successfully!";
            
        } catch (Exception $e) {
            $_SESSION['error'] = "Upload failed: " . $e->getMessage();
        }
        
        header("Location: ../admin_upload.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
