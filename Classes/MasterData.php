<?php

class MasterData extends Dbh {

    public function getAllProjects() {
        $sql = "SELECT project_code, project_name, wbs_number, status, fw_start, fw_end FROM master_projects ORDER BY project_name ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSI($rscEmail = null) {
        $sql = "SELECT * FROM master_structure";
        $params = [];

        if ($rscEmail) {
            $sql .= " WHERE rsc_email = :email";
            $params[':email'] = $rscEmail;
        }

        $sql .= " ORDER BY si_name ASC";
        
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllItems() {
        $sql = "SELECT * FROM master_items ORDER BY item_name ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
