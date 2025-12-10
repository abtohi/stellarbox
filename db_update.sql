-- Modify master_projects table
ALTER TABLE master_projects DROP COLUMN id;
ALTER TABLE master_projects ADD COLUMN project_code VARCHAR(50) NOT NULL PRIMARY KEY FIRST;
ALTER TABLE master_projects CHANGE COLUMN wbs_code wbs_number VARCHAR(50);
ALTER TABLE master_projects ADD COLUMN status VARCHAR(20) DEFAULT 'Ongoing';
ALTER TABLE master_projects ADD COLUMN fw_start DATE;
ALTER TABLE master_projects ADD COLUMN fw_end DATE;

-- Modify master_surveyors to master_structure
RENAME TABLE master_surveyors TO master_structure;
ALTER TABLE master_structure CHANGE COLUMN id si_id INT AUTO_INCREMENT;
ALTER TABLE master_structure ADD COLUMN si_email VARCHAR(100);
ALTER TABLE master_structure ADD COLUMN si_phone_number VARCHAR(20);
ALTER TABLE master_structure ADD COLUMN si_status VARCHAR(20) DEFAULT 'Active';
ALTER TABLE master_structure ADD COLUMN rsc_id INT;
ALTER TABLE master_structure ADD COLUMN rsc_name VARCHAR(100);
ALTER TABLE master_structure ADD COLUMN rsc_email VARCHAR(100);
ALTER TABLE master_structure ADD COLUMN qps_name VARCHAR(100);
ALTER TABLE master_structure ADD COLUMN qps_email VARCHAR(100);

-- Modify users table
ALTER TABLE users DROP COLUMN username;
ALTER TABLE users ADD UNIQUE (email);
