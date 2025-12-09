<?php

class RequestInfo extends Dbh {

    // Fetch Distinct Projects for Dropdown
    public function getDistinctProjects($userId, $role) {
        $sql = "SELECT DISTINCT project_name FROM gift_requests WHERE 1=1";
        $params = [];

        if ($role == "RSC") {
            $sql .= " AND user_id = :uid";
            $params[':uid'] = $userId;
        }

        $sql .= " ORDER BY project_name";
        
        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            return [];
        }
    }

    // Fetch Distinct SIs for Dropdown
    public function getDistinctSIs($userId, $role) {
        $sql = "SELECT DISTINCT si_name FROM gift_requests WHERE 1=1";
        $params = [];

        if ($role == "RSC") {
            $sql .= " AND user_id = :uid";
            $params[':uid'] = $userId;
        }

        $sql .= " ORDER BY si_name";

        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            return [];
        }
    }

    // Fetch Filtered Requests
    public function getRequests($userId, $role, $filters) {
        $sql = "SELECT r.*, u.username as rsc_name 
                FROM gift_requests r
                JOIN users u ON r.user_id = u.id
                WHERE 1=1 ";
        $params = [];

        // Role Filter
        if ($role == "RSC") {
            $sql .= " AND r.user_id = :uid";
            $params[':uid'] = $userId;
        }

        // Apply Filters
        if (!empty($filters['year'])) {
            $sql .= " AND YEAR(r.created_at) = :year";
            $params[':year'] = $filters['year'];
        }

        if (!empty($filters['project'])) {
            $sql .= " AND r.project_name = :project";
            $params[':project'] = $filters['project'];
        }

        if (!empty($filters['si'])) {
            $sql .= " AND r.si_name = :si";
            $params[':si'] = $filters['si'];
        }

        if (!empty($filters['date'])) {
            $sql .= " AND DATE(r.created_at) = :date";
            $params[':date'] = $filters['date'];
        }

        $sql .= " ORDER BY r.created_at DESC";

        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}
