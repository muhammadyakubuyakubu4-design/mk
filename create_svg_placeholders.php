<?php
// Create SVG placeholder images for the ADUSTECH Hospital landing page

function createSvgPlaceholder($filename, $width, $height, $text, $bgColor = '#28a745', $textColor = '#ffffff') {
    $svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg width="'.$width.'" height="'.$height.'" xmlns="http://www.w3.org/2000/svg">
  <rect width="'.$width.'" height="'.$height.'" fill="'.$bgColor.'"/>
  <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" 
        font-family="Arial, sans-serif" font-size="'.min(24, intval($width/15)).'" fill="'.$textColor.'">'.$text.'</text>
</svg>';

    file_put_contents($filename, $svg);
    echo "Created: $filename\n";
}

// Create directories if they don't exist
if (!is_dir('assets/images/services')) {
    mkdir('assets/images/services', 0777, true);
}
if (!is_dir('assets/images/doctors')) {
    mkdir('assets/images/doctors', 0777, true);
}
if (!is_dir('assets/images')) {
    mkdir('assets/images', 0777, true);
}

// Create main images
createSvgPlaceholder('assets/images/logo.png', 200, 200, 'ADUSTECH LOGO', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/hero.jpg', 1200, 600, 'HERO SECTION - Hospital Front View', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/about.jpg', 600, 400, 'ABOUT HOSPITAL - Professional Medical Care', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/appointment-bg.jpg', 1200, 800, 'APPOINTMENT BACKGROUND', '#28a745', '#ffffff');

// Create service images
createSvgPlaceholder('assets/images/services/consultation.jpg', 400, 200, 'CONSULTATION SERVICE', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/services/laboratory.jpg', 400, 200, 'LABORATORY SERVICE', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/services/pharmacy.jpg', 400, 200, 'PHARMACY SERVICE', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/services/radiology.jpg', 400, 200, 'RADIOLOGY SERVICE', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/services/emergency.jpg', 400, 200, 'EMERGENCY SERVICE', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/services/uhs.jpg', 400, 200, 'UHS SERVICE', '#28a745', '#ffffff');

// Create doctor images
createSvgPlaceholder('assets/images/doctors/doctor1.jpg', 300, 300, 'DR. SARAH JOHNSON', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/doctors/doctor2.jpg', 300, 300, 'DR. MICHAEL CHEN', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/doctors/doctor3.jpg', 300, 300, 'DR. EMILY RODRIGUEZ', '#28a745', '#ffffff');
createSvgPlaceholder('assets/images/doctors/doctor4.jpg', 300, 300, 'DR. JAMES WILSON', '#28a745', '#ffffff');

echo "All SVG placeholder images have been created successfully!\n";
?>