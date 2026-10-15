<?php
// ADUHMS Landing Page
require_once 'config.php';
require_once 'includes/db.php';

// Fetch dynamic content from database if needed
$announcements = [];
$stmt = $db->query("SELECT * FROM system_logs WHERE action LIKE '%ANNOUNCEMENT%' ORDER BY timestamp DESC LIMIT 3");
if($stmt) {
    while($row = $stmt->fetch_assoc()) {
        $announcements[] = $row;
    }
}

// If no announcements from DB, use defaults
if(empty($announcements)) {
    $announcements = [
        ['description' => 'New Cardiology Unit now open with advanced diagnostic equipment.', 'timestamp' => '2026-01-01'],
        ['description' => 'Join our blood donation drive on Jan 15, 2026. Every donation saves lives.', 'timestamp' => '2025-12-28'],
        ['description' => 'Free vaccination program for students and staff starting Feb 1, 2026.', 'timestamp' => '2025-12-25']
    ];
}

// Get stats for the dashboard
$stats = [];
$stats['doctors'] = $db->query("SELECT COUNT(*) as count FROM users WHERE role IN ('Doctor', 'Consultant', 'Specialist', 'Surgeon')")->fetch_assoc()['count'];
$stats['patients'] = $db->query("SELECT COUNT(*) as count FROM patients")->fetch_assoc()['count'];
$stats['appointments_today'] = $db->query("SELECT COUNT(*) as count FROM appointments WHERE appointment_date = CURDATE()")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SYSTEM_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root {
            --primary-color: <?php echo PRIMARY_COLOR; ?>;
            --secondary-color: <?php echo SECONDARY_COLOR; ?>;
            --accent-color: <?php echo ACCENT_COLOR; ?>;
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --box-shadow-hover: 0 12px 30px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
        }
        
        .navbar {
            background-color: var(--primary-color);
            border-radius: var(--border-radius);
            margin: 10px;
            box-shadow: var(--box-shadow);
        }
        
        .btn {
            border-radius: var(--border-radius);
            transition: var(--transition);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: var(--box-shadow-hover);
        }
        
        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
        }
        
        .btn-outline-light:hover {
            background-color: white;
            color: var(--primary-color);
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            height: 85vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle, transparent 20%, rgba(0, 0, 0, 0.3) 80%);
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .service-card {
            transition: var(--transition);
            height: 100%;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: none;
            box-shadow: var(--box-shadow);
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--box-shadow-hover);
        }
        
        .service-card .card-body {
            padding: 1.5rem;
        }
        
        .doctor-card {
            transition: var(--transition);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: none;
            box-shadow: var(--box-shadow);
            height: 100%;
        }
        
        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-hover);
        }
        
        .doctor-card .card-body {
            padding: 1.5rem;
        }
        
        .emergency-banner {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            font-weight: 500;
        }
        
        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
        
        .form-control {
            border-radius: var(--border-radius);
        }
        
        .rounded-4 {
            border-radius: var(--border-radius) !important;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary-color);
            border-radius: 2px;
        }
        
        .hover-lift {
            transition: var(--transition);
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-hover);
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
        }
        
        .py-5 {
            padding-top: 4rem !important;
            padding-bottom: 4rem !important;
        }
        
        .text-center h2 {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hospital me-2"></i><?php echo SYSTEM_SHORT_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#doctors">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-sm btn-outline-light ms-2" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Emergency Banner -->
    <div class="emergency-banner text-center py-2">
        <div class="container">
            <i class="fas fa-phone-alt me-2"></i>
            Emergency Hotline: <?php echo EMERGENCY_NUMBER; ?> | 
            <i class="fas fa-clock me-2"></i>
            Open: <?php echo HOSPITAL_OPEN_TIME; ?> - <?php echo HOSPITAL_CLOSE_TIME; ?>
        </div>
    </div>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold text-white mb-3">Welcome to <?php echo SYSTEM_NAME; ?></h1>
                        <p class="lead text-white mb-4">Comprehensive healthcare services for students, staff, and the general public</p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="#appointment" class="btn btn-light btn-lg px-4 py-2">
                            <i class="fas fa-calendar-check me-2"></i>
                            Book Appointment
                        </a>
                        <a href="login.php" class="btn btn-outline-light btn-lg px-4 py-2">
                            <i class="fas fa-user me-2"></i>
                            Patient Login
                        </a>
                        <a href="register.php" class="btn btn-success btn-lg px-4 py-2">
                            <i class="fas fa-user-plus me-2"></i>
                            Register Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>About Our Hospital</h2>
                    <p><?php echo SYSTEM_NAME; ?> is a state-of-the-art teaching hospital affiliated with Aliko Dangote University. We provide comprehensive healthcare services to students, staff, and the general public.</p>
                    <p>Our facility is equipped with modern medical equipment and staffed by highly qualified healthcare professionals committed to delivering excellent patient care.</p>
                            
                    <div class="row mt-4">
                        <div class="col-md-4 text-center">
                            <i class="fas fa-user-md fa-3x text-success mb-3"></i>
                            <h4><?php echo $stats['doctors']; ?>+ Doctors</h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-procedures fa-3x text-success mb-3"></i>
                            <h4><?php echo $stats['patients']; ?>+ Patients</h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-graduation-cap fa-3x text-success mb-3"></i>
                            <h4><?php echo $stats['appointments_today']; ?>+ Appointments Today</h4>
                        </div>
                    </div>
                            
                    <div class="mt-4">
                        <h5>Our Core Values</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Compassionate Care</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Excellence in Service</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Integrity & Ethics</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Continuous Improvement</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <img src="assets/images/hospital.jpg" alt="Hospital" class="img-fluid rounded">
                        <div class="card-body">
                            <h5 class="card-title">Advanced Medical Facilities</h5>
                            <p class="card-text">Our hospital features state-of-the-art medical equipment and modern facilities designed to provide the highest quality of care.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Our Services</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-stethoscope fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Consultation</h5>
                            <p class="card-text">Comprehensive medical consultations with our experienced doctors and specialists.</p>
                            <a href="#appointment" class="btn btn-outline-success btn-sm mt-2">Book Consultation</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-flask fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Laboratory</h5>
                            <p class="card-text">Advanced diagnostic testing with quick and accurate results.</p>
                            <a href="#contact" class="btn btn-outline-success btn-sm mt-2">Lab Services</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-pills fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Pharmacy</h5>
                            <p class="card-text">Full-service pharmacy with prescription and over-the-counter medications.</p>
                            <a href="#contact" class="btn btn-outline-success btn-sm mt-2">Pharmacy Info</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-x-ray fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Radiology</h5>
                            <p class="card-text">Advanced imaging services including X-ray, CT, MRI, and ultrasound.</p>
                            <a href="#contact" class="btn btn-outline-success btn-sm mt-2">Imaging Services</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-ambulance fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Emergency</h5>
                            <p class="card-text">24/7 emergency services for critical medical situations.</p>
                            <a href="tel:<?php echo str_replace('-', '', str_replace(' ', '', EMERGENCY_NUMBER)); ?>" class="btn btn-danger btn-sm mt-2">Call Emergency</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-user-graduate fa-3x text-success mb-3"></i>
                            <h5 class="card-title">University Health Services</h5>
                            <p class="card-text">Specialized services for students including medical clearance.</p>
                            <a href="#contact" class="btn btn-outline-success btn-sm mt-2">Student Health</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Doctors Section -->
    <section id="doctors" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Our Specialist Doctors</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card doctor-card h-100">
                        <img src="assets/images/doctor1.jpg" class="card-img-top" alt="Doctor">
                        <div class="card-body text-center">
                            <h5 class="card-title">Dr. Aisha Mohammed</h5>
                            <p class="card-text">Consultant Physician</p>
                            <p class="text-muted">15 years experience</p>
                            <div class="mt-2">
                                <a href="#appointment" class="btn btn-outline-success btn-sm">Book Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card doctor-card h-100">
                        <img src="assets/images/doctor2.jpg" class="card-img-top" alt="Doctor">
                        <div class="card-body text-center">
                            <h5 class="card-title">Dr. Emeka Johnson</h5>
                            <p class="card-text">Chief Surgeon</p>
                            <p class="text-muted">18 years experience</p>
                            <div class="mt-2">
                                <a href="#appointment" class="btn btn-outline-success btn-sm">Book Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card doctor-card h-100">
                        <img src="assets/images/doctor3.jpg" class="card-img-top" alt="Doctor">
                        <div class="card-body text-center">
                            <h5 class="card-title">Dr. Fatima Bello</h5>
                            <p class="card-text">Pediatric Specialist</p>
                            <p class="text-muted">12 years experience</p>
                            <div class="mt-2">
                                <a href="#appointment" class="btn btn-outline-success btn-sm">Book Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
// Handle appointment booking form submission
$appointment_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_appointment'])) {
    $full_name = sanitize_input($_POST['full_name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $department = sanitize_input($_POST['department'] ?? '');
    $date = sanitize_input($_POST['date'] ?? '');
    $time = sanitize_input($_POST['time'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    
    // Validate required fields
    if (empty($full_name) || empty($email) || empty($phone) || empty($department) || empty($date) || empty($time)) {
        $appointment_message = '<div class="alert alert-danger">Please fill in all required fields.</div>';
    } elseif (!validate_email($email)) {
        $appointment_message = '<div class="alert alert-danger">Please enter a valid email address.</div>';
    } elseif (!validate_nigerian_phone($phone)) {
        $appointment_message = '<div class="alert alert-danger">Please enter a valid Nigerian phone number.</div>';
    } else {
        // Check if patient already exists
        $stmt = $db->prepare("SELECT id FROM patients WHERE email = ? OR phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Patient exists, get their ID
            $patient = $result->fetch_assoc();
            $patient_id = $patient['id'];
        } else {
            // Create new patient
            $stmt = $db->prepare("INSERT INTO patients (first_name, last_name, email, phone, created_by) VALUES (?, '', ?, ?, 0)");
            $name_parts = explode(' ', $full_name, 2);
            $first_name = $name_parts[0];
            $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
            $stmt->bind_param("sss", $first_name, $email, $phone);
            
            if ($stmt->execute()) {
                $patient_id = $stmt->insert_id;
            } else {
                $appointment_message = '<div class="alert alert-danger">Error creating patient record. Please try again.</div>';
            }
        }
        
        if (isset($patient_id) && !$appointment_message) {
            // Create appointment
            $appointment_id = generate_unique_id('APT');
            $stmt = $db->prepare("INSERT INTO appointments (appointment_id, patient_id, doctor_id, department, appointment_date, appointment_time, reason, status, created_by) VALUES (?, ?, 0, ?, ?, ?, ?, 'scheduled', 0)");
            $stmt->bind_param("sissss", $appointment_id, $patient_id, $department, $date, $time, $message);
            
            if ($stmt->execute()) {
                $appointment_message = '<div class="alert alert-success">Appointment booked successfully! We will contact you shortly to confirm.</div>';
                
                // Log the appointment booking
                log_activity(0, 'Public', 'BOOK_APPOINTMENT', "Public appointment booked: $full_name, $email, $phone, $department, $date $time");
            } else {
                $appointment_message = '<div class="alert alert-danger">Error booking appointment. Please try again.</div>';
            }
        }
    }
}
?>

<!-- Appointment Section -->
    <section id="appointment" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Book an Appointment</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php echo $appointment_message; ?>
                    <form method="POST">
                        <input type="hidden" name="book_appointment" value="1">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="full_name" required>
                                <div class="form-text">Enter your full legal name</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                                <div class="form-text">We'll never share your email</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone *</label>
                                <input type="tel" class="form-control" name="phone" required>
                                <div class="form-text">Include country code (e.g., +234)</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department/Service *</label>
                                <select class="form-control" name="department" required>
                                    <option value="General Consultation">General Consultation</option>
                                    <option value="Cardiology">Cardiology</option>
                                    <option value="Pediatrics">Pediatrics</option>
                                    <option value="Orthopedics">Orthopedics</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="UHS">University Health Services</option>
                                    <option value="Dermatology">Dermatology</option>
                                    <option value="Gynecology">Gynecology</option>
                                    <option value="Surgery">Surgery</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Preferred Date *</label>
                                <input type="date" class="form-control" name="date" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Preferred Time *</label>
                                <select class="form-control" name="time" required>
                                    <option value="08:00">08:00 AM</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" name="message" rows="4" placeholder="Please describe your symptoms or reason for visit"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success w-100 py-3">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Book Your Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Announcements Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Latest Announcements</h2>
            <div class="row">
                <?php foreach($announcements as $idx => $announcement): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <i class="fas fa-bullhorn text-success me-2"></i>
                                Announcement <?php echo $idx+1; ?>
                            </h5>
                            <p class="card-text flex-grow-1"><?php echo htmlspecialchars($announcement['description'] ?? $announcement['description']); ?></p>
                            <small class="text-muted">Posted: <?php echo htmlspecialchars($announcement['timestamp'] ?? $announcement['timestamp']); ?></small>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 section-title">What Our Patients Say</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-quote-left text-success"></i>
                            </div>
                            <p class="card-text">"The care I received at ADUHMS was exceptional. The staff was attentive and the facilities are top-notch."</p>
                            <div class="mt-3">
                                <h6 class="mb-0">John Okafor</h6>
                                <small class="text-muted">Patient</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-quote-left text-success"></i>
                            </div>
                            <p class="card-text">"As a student, I appreciate the comprehensive health services provided by the UHS department. Very professional and caring staff."</p>
                            <div class="mt-3">
                                <h6 class="mb-0">Aisha Yusuf</h6>
                                <small class="text-muted">Student</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-quote-left text-success"></i>
                            </div>
                            <p class="card-text">"The emergency services saved my father's life. Quick response and excellent medical care. Thank you ADUHMS!"</p>
                            <div class="mt-3">
                                <h6 class="mb-0">Emeka Okonkwo</h6>
                                <small class="text-muted">Family Member</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Medical Specialties Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Medical Specialties</h2>
            <div class="row">
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-heartbeat fa-3x text-success mb-3"></i>
                        <h6>Cardiology</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-baby fa-3x text-success mb-3"></i>
                        <h6>Pediatrics</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-bone fa-3x text-success mb-3"></i>
                        <h6>Orthopedics</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-brain fa-3x text-success mb-3"></i>
                        <h6>Neurology</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-eye fa-3x text-success mb-3"></i>
                        <h6>Ophthalmology</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-lungs fa-3x text-success mb-3"></i>
                        <h6>Pulmonology</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-kidneys fa-3x text-success mb-3"></i>
                        <h6>Nephrology</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-user-md fa-3x text-success mb-3"></i>
                        <h6>General Surgery</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Contact Us</h2>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-map-marker-alt fa-2x text-success mb-3"></i>
                            <h5>Address</h5>
                            <p>Km 10, Lagos-Ibadan Expressway, <br> Aliko Dangote University, <br> Ibadan, Oyo State, Nigeria</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-phone-alt fa-2x text-success mb-3"></i>
                            <h5>Phone</h5>
                            <p>+234 800 000 0000 <br> <?php echo EMERGENCY_NUMBER; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-envelope fa-2x text-success mb-3"></i>
                            <h5>Email</h5>
                            <p>info@aduhms.edu.ng <br> support@aduhms.edu.ng</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.829872259029!2d3.386931314770671!3d6.452139995361402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMjcnMDcuNyJOIDPCsDIzJzEzLjAiRQ!5e0!3m2!1sen!2sng!4v1234567890123" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><?php echo SYSTEM_SHORT_NAME; ?></h5>
                    <p>Providing quality healthcare services for the university community and the general public since 2026.</p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="mt-3">
                        <h6>Accreditations</h6>
                        <p class="text-light small">NABH Certified | JCI Accredited | Tertiary Healthcare Center</p>
                    </div>
                </div>
                <div class="col-lg-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-light">Home</a></li>
                        <li><a href="#about" class="text-light">About Us</a></li>
                        <li><a href="#services" class="text-light">Services</a></li>
                        <li><a href="#doctors" class="text-light">Our Doctors</a></li>
                        <li><a href="login.php" class="text-light">Login</a></li>
                        <li><a href="register.php" class="text-light">Register</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Medical Services</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">Consultation</a></li>
                        <li><a href="#" class="text-light">Laboratory</a></li>
                        <li><a href="#" class="text-light">Pharmacy</a></li>
                        <li><a href="#" class="text-light">Emergency</a></li>
                        <li><a href="#" class="text-light">University Health</a></li>
                        <li><a href="#" class="text-light">Surgery</a></li>
                        <li><a href="#" class="text-light">Radiology</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Newsletter</h5>
                    <p>Subscribe to our newsletter for health tips and hospital updates.</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your Email">
                        <button class="btn btn-success" type="button">Subscribe</button>
                    </div>
                    <div class="mt-3">
                        <h6>Operating Hours</h6>
                        <p class="text-light small mb-1">Mon-Fri: 8:00 AM - 8:00 PM</p>
                        <p class="text-light small mb-1">Sat: 9:00 AM - 6:00 PM</p>
                        <p class="text-light small mb-0">Emergency: 24/7</p>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2026 Aliko Dangote University Hospital Management System. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light me-3">Privacy Policy</a>
                    <a href="#" class="text-light me-3">Terms of Service</a>
                    <a href="#" class="text-light me-3">Patient Rights</a>
                    <a href="#" class="text-light">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>