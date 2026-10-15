-- ADUHMS Database Schema
-- Aliko Dangote University Hospital Management System

-- Create database
CREATE DATABASE IF NOT EXISTS aduhms;
USE aduhms;

-- Users table - for all system users (doctors, nurses, admin, etc.)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM(
        'Super Admin', 'Admin', 'Doctor', 'Nurse', 'Receptionist', 
        'Pharmacist', 'Laboratory Technician', 'Radiologist', 
        'Accountant', 'UHS', 'Patient', 'System Administrator', 
        'Emergency Officer', 'Ambulance Officer', 'Inventory Manager', 
        'HR Manager'
    ) NOT NULL,
    department VARCHAR(100),
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    is_hod TINYINT(1) DEFAULT 0, -- Head of Department
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Patients table
CREATE TABLE patients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id VARCHAR(20) UNIQUE NOT NULL, -- Generated patient ID
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    other_names VARCHAR(100),
    date_of_birth DATE,
    age INT,
    gender ENUM('Male', 'Female', 'Other'),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
    genotype ENUM('AA', 'AS', 'AC', 'SS', 'SC'),
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    emergency_contact_relationship VARCHAR(50),
    occupation VARCHAR(100),
    employer VARCHAR(100),
    insurance_provider VARCHAR(100),
    insurance_number VARCHAR(100),
    next_of_kin_name VARCHAR(100),
    next_of_kin_phone VARCHAR(20),
    next_of_kin_relationship VARCHAR(50),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Students table (for UHS module)
CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    other_names VARCHAR(100),
    date_of_birth DATE,
    age INT,
    gender ENUM('Male', 'Female', 'Other'),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    department VARCHAR(100),
    level ENUM('100', '200', '300', '400', '500', '600', 'Postgraduate'),
    program VARCHAR(100),
    admission_year YEAR,
    status ENUM('active', 'graduated', 'suspended', 'transferred') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Appointments table
CREATE TABLE appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    appointment_id VARCHAR(20) UNIQUE NOT NULL,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    department VARCHAR(100),
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('scheduled', 'completed', 'cancelled', 'no-show', 'in-progress') DEFAULT 'scheduled',
    reason TEXT,
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Medical records table
CREATE TABLE medical_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_id INT,
    diagnosis TEXT,
    symptoms TEXT,
    treatment TEXT,
    prescription TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id)
);

-- Prescriptions table
CREATE TABLE prescriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    prescription_id VARCHAR(20) UNIQUE NOT NULL,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_id INT,
    medication_name VARCHAR(200) NOT NULL,
    dosage VARCHAR(100),
    frequency VARCHAR(100),
    duration VARCHAR(50),
    quantity INT,
    instructions TEXT,
    status ENUM('pending', 'dispensed', 'partially_dispensed', 'cancelled') DEFAULT 'pending',
    prescribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dispensed_at TIMESTAMP NULL,
    dispensed_by INT,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (dispensed_by) REFERENCES users(id)
);

-- Laboratory tests table
CREATE TABLE lab_tests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    test_id VARCHAR(20) UNIQUE NOT NULL,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_id INT,
    test_type VARCHAR(100) NOT NULL,
    test_category VARCHAR(100),
    requested_by INT NOT NULL,
    sample_collected TINYINT(1) DEFAULT 0,
    sample_collected_at TIMESTAMP NULL,
    sample_collector_id INT,
    test_status ENUM('requested', 'in-progress', 'completed', 'cancelled') DEFAULT 'requested',
    results TEXT,
    notes TEXT,
    validated_by INT,
    validated_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (requested_by) REFERENCES users(id),
    FOREIGN KEY (sample_collector_id) REFERENCES users(id),
    FOREIGN KEY (validated_by) REFERENCES users(id)
);

-- Imaging/Radiology requests table
CREATE TABLE imaging_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    request_id VARCHAR(20) UNIQUE NOT NULL,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_id INT,
    imaging_type VARCHAR(100) NOT NULL,
    body_part VARCHAR(100),
    clinical_indication TEXT,
    requested_by INT NOT NULL,
    imaging_status ENUM('requested', 'in-progress', 'completed', 'cancelled') DEFAULT 'requested',
    images_path TEXT,
    radiologist_id INT,
    report TEXT,
    validated_by INT,
    validated_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (requested_by) REFERENCES users(id),
    FOREIGN KEY (radiologist_id) REFERENCES users(id),
    FOREIGN KEY (validated_by) REFERENCES users(id)
);

-- Pharmacy inventory table
CREATE TABLE pharmacy_inventory (
    id INT PRIMARY KEY AUTO_INCREMENT,
    drug_id VARCHAR(20) UNIQUE NOT NULL,
    drug_name VARCHAR(200) NOT NULL,
    generic_name VARCHAR(200),
    drug_category VARCHAR(100),
    drug_type ENUM('Tablet', 'Capsule', 'Syrup', 'Injection', 'Cream', 'Ointment', 'Other'),
    manufacturer VARCHAR(100),
    batch_number VARCHAR(50),
    expiry_date DATE,
    quantity_available INT DEFAULT 0,
    unit_price DECIMAL(10, 2),
    reorder_level INT DEFAULT 10,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Pharmacy dispensing table
CREATE TABLE pharmacy_dispensing (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dispensing_id VARCHAR(20) UNIQUE NOT NULL,
    prescription_id INT NOT NULL,
    patient_id INT NOT NULL,
    drug_id INT NOT NULL,
    quantity_dispensed INT NOT NULL,
    dispensed_by INT NOT NULL,
    dispensing_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    FOREIGN KEY (prescription_id) REFERENCES prescriptions(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (drug_id) REFERENCES pharmacy_inventory(id),
    FOREIGN KEY (dispensed_by) REFERENCES users(id)
);

-- Billing table
CREATE TABLE billing (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bill_id VARCHAR(20) UNIQUE NOT NULL,
    patient_id INT NOT NULL,
    appointment_id INT,
    service_type VARCHAR(100),
    service_description TEXT,
    amount DECIMAL(10, 2) NOT NULL,
    amount_paid DECIMAL(10, 2) DEFAULT 0,
    payment_status ENUM('pending', 'partial', 'paid', 'cancelled') DEFAULT 'pending',
    discount DECIMAL(10, 2) DEFAULT 0,
    tax DECIMAL(10, 2) DEFAULT 0,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Payments table
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    payment_id VARCHAR(20) UNIQUE NOT NULL,
    bill_id INT NOT NULL,
    patient_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method ENUM('cash', 'bank_transfer', 'credit_card', 'mobile_money', 'insurance'),
    payment_status ENUM('successful', 'failed', 'pending') DEFAULT 'pending',
    transaction_reference VARCHAR(100),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_by INT NOT NULL,
    notes TEXT,
    FOREIGN KEY (bill_id) REFERENCES billing(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (processed_by) REFERENCES users(id)
);

-- Wards table
CREATE TABLE wards (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ward_name VARCHAR(100) NOT NULL,
    ward_type ENUM('Male', 'Female', 'Pediatric', 'ICU', 'Maternity', 'Surgical', 'Medical', 'Emergency') NOT NULL,
    total_beds INT DEFAULT 0,
    available_beds INT DEFAULT 0,
    charge_per_day DECIMAL(10, 2),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Beds table
CREATE TABLE beds (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bed_number VARCHAR(20) NOT NULL,
    ward_id INT NOT NULL,
    bed_status ENUM('available', 'occupied', 'maintenance') DEFAULT 'available',
    room_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ward_id) REFERENCES wards(id)
);

-- Admissions table
CREATE TABLE admissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admission_id VARCHAR(20) UNIQUE NOT NULL,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    ward_id INT NOT NULL,
    bed_id INT NOT NULL,
    admission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    discharge_date TIMESTAMP NULL,
    reason_for_admission TEXT,
    attending_doctor_id INT,
    discharge_notes TEXT,
    created_by INT NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (ward_id) REFERENCES wards(id),
    FOREIGN KEY (bed_id) REFERENCES beds(id),
    FOREIGN KEY (attending_doctor_id) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- System logs table
CREATE TABLE system_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    role VARCHAR(50),
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- UHS Clearances table
CREATE TABLE uhs_clearances (
    id INT PRIMARY KEY AUTO_INCREMENT,
    clearance_id VARCHAR(20) UNIQUE NOT NULL,
    student_id INT NOT NULL,
    clearance_status ENUM('pending', 'cleared', 'not-cleared') DEFAULT 'pending',
    clearance_date TIMESTAMP NULL,
    cleared_by INT,
    medical_officer_id INT,
    medical_certificate_path VARCHAR(255),
    next_of_kin_cleared TINYINT(1) DEFAULT 0,
    next_of_kin_verified_by INT,
    next_of_kin_verified_at TIMESTAMP NULL,
    health_status ENUM('fit', 'conditionally-fit', 'not-fit', 'pending') DEFAULT 'pending',
    restrictions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (cleared_by) REFERENCES users(id),
    FOREIGN KEY (medical_officer_id) REFERENCES users(id),
    FOREIGN KEY (next_of_kin_verified_by) REFERENCES users(id)
);

-- Emergency cases table
CREATE TABLE emergency_cases (
    id INT PRIMARY KEY AUTO_INCREMENT,
    emergency_id VARCHAR(20) UNIQUE NOT NULL,
    patient_id INT,
    triage_level ENUM('immediate', 'urgent', 'non-urgent') NOT NULL,
    chief_complaint TEXT,
    vital_signs TEXT,
    initial_assessment TEXT,
    doctor_assigned_id INT,
    status ENUM('active', 'transferred', 'discharged', 'admitted') DEFAULT 'active',
    arrival_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    seen_time TIMESTAMP NULL,
    disposition TEXT,
    created_by INT NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_assigned_id) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Ambulance services table
CREATE TABLE ambulance_services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    service_id VARCHAR(20) UNIQUE NOT NULL,
    patient_id INT,
    pickup_location TEXT NOT NULL,
    destination TEXT NOT NULL,
    reason TEXT,
    dispatch_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    arrival_time TIMESTAMP NULL,
    completion_time TIMESTAMP NULL,
    status ENUM('requested', 'dispatched', 'in-transit', 'completed', 'cancelled') DEFAULT 'requested',
    driver_id INT NOT NULL,
    paramedic_id INT,
    vehicle_number VARCHAR(50),
    notes TEXT,
    created_by INT NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (driver_id) REFERENCES users(id),
    FOREIGN KEY (paramedic_id) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Inventory management table
CREATE TABLE inventory (
    id INT PRIMARY KEY AUTO_INCREMENT,
    item_id VARCHAR(20) UNIQUE NOT NULL,
    item_name VARCHAR(200) NOT NULL,
    category VARCHAR(100),
    description TEXT,
    quantity_available INT DEFAULT 0,
    reorder_level INT DEFAULT 10,
    unit_price DECIMAL(10, 2),
    supplier VARCHAR(100),
    expiry_date DATE,
    location VARCHAR(100),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Insert default Super Admin user
INSERT INTO users (username, email, password, role, department, first_name, last_name, phone, status, is_hod) 
VALUES (
    'superadmin', 
    'superadmin@aduhms.edu.ng', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password
    'Super Admin', 
    'Administration', 
    'System', 
    'Administrator', 
    '+2348000000000', 
    'active', 
    1
);

-- Insert a default patient for testing
INSERT INTO patients (patient_id, first_name, last_name, email, phone, created_by) 
VALUES (
    'PAT001', 
    'Test', 
    'Patient', 
    'test.patient@aduhms.edu.ng', 
    '+2348000000001', 
    1
);

-- Insert a default doctor for testing
INSERT INTO users (username, email, password, role, department, first_name, last_name, phone, status) 
VALUES (
    'doctor1', 
    'doctor1@aduhms.edu.ng', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password
    'Doctor', 
    'Medicine', 
    'First', 
    'Doctor', 
    '+2348000000002', 
    'active'
);

-- Insert default departments
INSERT INTO wards (ward_name, ward_type, total_beds, available_beds, charge_per_day) VALUES
('Male Ward A', 'Male', 20, 20, 5000.00),
('Female Ward A', 'Female', 20, 20, 5000.00),
('Pediatric Ward', 'Pediatric', 15, 15, 7000.00),
('ICU', 'ICU', 10, 10, 20000.00),
('Maternity Ward', 'Maternity', 25, 25, 8000.00),
('Surgical Ward', 'Surgical', 20, 20, 10000.00),
('Medical Ward', 'Medical', 25, 25, 6000.00),
('Emergency Ward', 'Emergency', 15, 15, 5000.00);

-- Insert default lab test types (now with valid patient and doctor IDs)
INSERT INTO lab_tests (test_id, patient_id, doctor_id, test_type, test_category, requested_by) 
SELECT 'LAB001', p.id, d.id, 'Complete Blood Count', 'Hematology', d.id
FROM patients p, users d
WHERE p.patient_id = 'PAT001' AND d.username = 'doctor1';

-- Insert default imaging types (now with valid patient and doctor IDs)
INSERT INTO imaging_requests (request_id, patient_id, doctor_id, imaging_type, requested_by) 
SELECT 'IMG001', p.id, d.id, 'X-Ray', d.id
FROM patients p, users d
WHERE p.patient_id = 'PAT001' AND d.username = 'doctor1';

-- Insert default pharmacy items
INSERT INTO pharmacy_inventory (drug_id, drug_name, generic_name, drug_category, drug_type, unit_price) 
VALUES 
('DRG001', 'Paracetamol 500mg', 'Acetaminophen', 'Analgesics', 'Tablet', 10.00),
('DRG002', 'Amoxicillin 500mg', 'Amoxicillin', 'Antibiotics', 'Capsule', 15.00),
('DRG003', 'Ibuprofen 400mg', 'Ibuprofen', 'NSAIDs', 'Tablet', 12.00);