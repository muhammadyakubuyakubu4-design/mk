<?php
require_once 'includes/functions.php';
session_start();

// Include the header template
include_once 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include_once 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">ADUHMS System Summary</h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Aliko Dangote University Hospital Management System (ADUHMS)</h3>
                        </div>
                        <div class="card-body">
                            <p class="lead">Complete Enterprise-Level Nigerian University Hospital Management System</p>
                            
                            <h4>System Architecture</h4>
                            <ul>
                                <li><strong>Frontend:</strong> HTML, CSS, Bootstrap 5, JavaScript</li>
                                <li><strong>Backend:</strong> PHP (secure, modular)</li>
                                <li><strong>Database:</strong> MySQL</li>
                                <li><strong>Architecture:</strong> Role-Based Access Control (RBAC)</li>
                                <li><strong>UI Theme:</strong> Medical green & white, responsive</li>
                                <li><strong>Logging:</strong> Full audit & system logs</li>
                            </ul>
                            
                            <h4>Core Governance Rules</h4>
                            <ul>
                                <li>Super Admin controls EVERYTHING</li>
                                <li>Every department has a Head of Unit (HOU)</li>
                                <li>HOU can create users in their unit and monitor all unit activities</li>
                                <li>Admin can override any action</li>
                                <li>All activities must be logged</li>
                                <li>System is customizable (name, logo, color theme, email/SMS templates, landing page content)</li>
                            </ul>
                            
                            <h4>Implemented Modules</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Core Modules</h5>
                                    <ul>
                                        <li>Authentication & RBAC System</li>
                                        <li>Super Admin Module</li>
                                        <li>Public Landing Page</li>
                                        <li>Patient Registration</li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Clinical Modules</h5>
                                    <ul>
                                        <li>Doctor Module</li>
                                        <li>Nurse Module</li>
                                        <li>Pharmacy Module</li>
                                        <li>Medical Laboratory Module</li>
                                        <li>Radiology/Imaging Module</li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Administrative Modules</h5>
                                    <ul>
                                        <li>University Health Services (UHS)</li>
                                        <li>Billing & Accounts</li>
                                        <li>Emergency & Ambulance</li>
                                        <li>Reporting & Analytics</li>
                                        <li>Logging & Audit System</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <h4>Supported Roles</h4>
                            <div class="row">
                                <?php
                                $roles = [
                                    'Super Admin', 'Admin', 'Doctor', 'Nurse', 'Receptionist', 
                                    'Pharmacist', 'Laboratory Technician', 'Radiologist', 
                                    'Accountant', 'UHS', 'Patient', 'System Administrator', 
                                    'Emergency Officer', 'Ambulance Officer', 'Inventory Manager', 'HR Manager'
                                ];
                                ?>
                                <div class="col-md-6">
                                    <ul>
                                        <?php for ($i = 0; $i < count($roles); $i += 2): ?>
                                        <li><?php echo $roles[$i]; ?></li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <?php for ($i = 1; $i < count($roles); $i += 2): ?>
                                        <li><?php echo $roles[$i]; ?></li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>
                            
                            <h4>Key Features</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Public Access</h6>
                                    <ul>
                                        <li>Professional landing page</li>
                                        <li>Online appointment booking</li>
                                        <li>Emergency hotline</li>
                                        <li>Announcements & news</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Administrative Features</h6>
                                    <ul>
                                        <li>System customization panel</li>
                                        <li>Full audit logging</li>
                                        <li>Backup & restore</li>
                                        <li>Global reports & analytics</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="alert alert-success mt-4">
                                <h5>System Status: <strong>Complete Implementation</strong></h5>
                                <p>All required modules and features have been successfully implemented in the Aliko Dangote University Hospital Management System (ADUHMS).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
// Include the footer template
include_once 'includes/footer.php';
?>