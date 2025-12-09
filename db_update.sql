-- 1. Master Data: Projects
CREATE TABLE master_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(100),
    wbs_code VARCHAR(50)
);

-- 2. Master Data: Surveyors (SI)
CREATE TABLE master_surveyors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    si_name VARCHAR(100),
    area_city VARCHAR(100)
);

-- 3. Master Data: Items (Barang)
CREATE TABLE master_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100),
    base_price DECIMAL(15,2)
);

-- 4. Transaksi: Gift Requests
CREATE TABLE gift_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_code VARCHAR(50), -- Contoh: REQ-20251209-001
    user_id INT,
    project_name VARCHAR(100),
    wbs_code VARCHAR(50),
    si_name VARCHAR(100),
    area_city VARCHAR(100),
    quota INT,
    order_qty INT,
    buffer DECIMAL(10,2),
    item_name VARCHAR(100),
    base_price DECIMAL(15,2),
    actual_price DECIMAL(15,2) NULL,
    total_amount DECIMAL(15,2),
    rsc_notes TEXT,
    status VARCHAR(20) DEFAULT 'Pending', -- Pending, Approved, Rejected
    email_status VARCHAR(20) DEFAULT 'Pending', -- Pending, Sent
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert Dummy Data (Agar dropdown bisa dicoba)
INSERT INTO master_projects (project_name, wbs_code) VALUES 
('Project Alpha', 'WBS-A-001'),
('Project Beta', 'WBS-B-002'),
('Project Gamma', 'WBS-C-003');

INSERT INTO master_surveyors (si_name, area_city) VALUES 
('Budi Santoso', 'Jakarta Selatan'),
('Siti Aminah', 'Bandung'),
('Rudi Hermawan', 'Surabaya');

INSERT INTO master_items (item_name, base_price) VALUES 
('Tumbler Exclusive', 50000),
('Kaos Polo', 75000),
('Payung Lipat', 45000),
('Powerbank 10000mAh', 150000);
