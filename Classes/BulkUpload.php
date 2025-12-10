<?php

class BulkUpload extends Dbh {

    private function cleanData($str) {
        if ($str === null || $str === '') return '';

        // Convert to UTF-8 if needed
        if (!mb_check_encoding($str, 'UTF-8')) {
            // Fallback to Windows-1252 (common for Excel) instead of auto
            $str = mb_convert_encoding($str, 'UTF-8', 'Windows-1252');
        }
        
        // Remove non-breaking spaces (UTF-8 NBSP is 0xC2 0xA0)
        $str = str_replace("\xC2\xA0", ' ', $str);
        return trim($str);
    }

    public function uploadProjects($fileHandle) {
        $pdo = $this->connect();
        
        try {
            // Disable foreign key checks to allow delete
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
            $pdo->beginTransaction();
            
            // Clear existing data
            $pdo->exec("DELETE FROM master_projects");
            
            // Skip header row
            fgetcsv($fileHandle);
            
            $sql = "INSERT INTO master_projects (project_code, project_name, wbs_number, status, fw_start, fw_end) VALUES ";
            $values = [];
            $params = [];
            $count = 0;
            $batchSize = 100; // Insert 100 rows at a time
            $seen = []; // Array to track duplicates
            
            while (($data = fgetcsv($fileHandle, 1000, ",")) !== FALSE) {
                if (count($data) < 6) continue;
                
                $code = $this->cleanData($data[0]);
                
                // Skip if duplicate project_code found in this file
                if (isset($seen[$code])) continue;
                $seen[$code] = true;
                
                $values[] = "(?, ?, ?, ?, ?, ?)";
                $params[] = $code;
                $params[] = $this->cleanData($data[1]);
                $params[] = $this->cleanData($data[2]);
                $params[] = $this->cleanData($data[3]);
                $params[] = !empty($data[4]) ? date('Y-m-d', strtotime($this->cleanData($data[4]))) : null;
                $params[] = !empty($data[5]) ? date('Y-m-d', strtotime($this->cleanData($data[5]))) : null;
                
                $count++;
                
                if ($count >= $batchSize) {
                    $stmt = $pdo->prepare($sql . implode(", ", $values));
                    $stmt->execute($params);
                    $values = [];
                    $params = [];
                    $count = 0;
                }
            }
            
            // Insert remaining rows
            if ($count > 0) {
                $stmt = $pdo->prepare($sql . implode(", ", $values));
                $stmt->execute($params);
            }
            
            $pdo->commit();
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            throw $e;
        }
    }

    public function uploadItems($fileHandle) {
        $pdo = $this->connect();
        
        try {
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
            $pdo->beginTransaction();
            
            $pdo->exec("DELETE FROM master_items");
            
            fgetcsv($fileHandle); // Skip header
            
            $sql = "INSERT INTO master_items (item_name, base_price) VALUES ";
            $values = [];
            $params = [];
            $count = 0;
            $batchSize = 100;
            $seen = [];
            
            while (($data = fgetcsv($fileHandle, 1000, ",")) !== FALSE) {
                if (count($data) < 2) continue;
                
                $name = $this->cleanData($data[0]);
                
                // Skip if duplicate item_name found
                if (isset($seen[$name])) continue;
                $seen[$name] = true;
                
                $values[] = "(?, ?)";
                $params[] = $name;
                $params[] = preg_replace("/[^0-9]/", "", $this->cleanData($data[1]));
                
                $count++;
                
                if ($count >= $batchSize) {
                    $stmt = $pdo->prepare($sql . implode(", ", $values));
                    $stmt->execute($params);
                    $values = [];
                    $params = [];
                    $count = 0;
                }
            }
            
            if ($count > 0) {
                $stmt = $pdo->prepare($sql . implode(", ", $values));
                $stmt->execute($params);
            }
            
            $pdo->commit();
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            throw $e;
        }
    }

    public function uploadStructure($fileHandle) {
        $pdo = $this->connect();
        
        try {
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
            $pdo->beginTransaction();
            
            $pdo->exec("DELETE FROM master_structure");
            
            fgetcsv($fileHandle); // Skip header
            
            $sql = "INSERT INTO master_structure 
                    (si_id, si_name, area_city, si_email, si_phone_number, si_status, rsc_name, rsc_email, qps_name, qps_email) 
                    VALUES ";
            $values = [];
            $params = [];
            $count = 0;
            $batchSize = 100;
            $seen = [];
            
            while (($data = fgetcsv($fileHandle, 1000, ",")) !== FALSE) {
                if (count($data) < 10) continue;
                
                // Use si_id as unique key if present, otherwise email
                $key = !empty($data[0]) ? $this->cleanData($data[0]) : $this->cleanData($data[3]);
                
                if (isset($seen[$key])) continue;
                $seen[$key] = true;
                
                $values[] = "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $params[] = $this->cleanData($data[0]); // si_id
                $params[] = $this->cleanData($data[1]); // si_name
                $params[] = $this->cleanData($data[2]); // area_city
                $params[] = $this->cleanData($data[3]); // si_email
                $params[] = $this->cleanData($data[4]); // si_phone_number
                $params[] = $this->cleanData($data[5]); // si_status
                $params[] = $this->cleanData($data[6]); // rsc_name
                $params[] = $this->cleanData($data[7]); // rsc_email
                $params[] = $this->cleanData($data[8]); // qps_name
                $params[] = $this->cleanData($data[9]); // qps_email
                
                $count++;
                
                if ($count >= $batchSize) {
                    $stmt = $pdo->prepare($sql . implode(", ", $values));
                    $stmt->execute($params);
                    $values = [];
                    $params = [];
                    $count = 0;
                }
            }
            
            if ($count > 0) {
                $stmt = $pdo->prepare($sql . implode(", ", $values));
                $stmt->execute($params);
            }
            
            $pdo->commit();
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            throw $e;
        }
    }
}
