<?php
// Generate placeholder images for the ADUSTECH Hospital landing page

function createPlaceholderImage($filename, $width, $height, $text, $bgColor = '#28a745', $textColor = '#ffffff') {
    // Create image
    $image = imagecreate($width, $height);
    
    // Allocate colors
    $bg = imagecolorallocate($image, 
        hexdec(substr($bgColor, 1, 2)), 
        hexdec(substr($bgColor, 3, 2)), 
        hexdec(substr($bgColor, 5, 2))
    );
    
    $textCol = imagecolorallocate($image, 
        hexdec(substr($textColor, 1, 2)), 
        hexdec(substr($textColor, 3, 2)), 
        hexdec(substr($textColor, 5, 2))
    );
    
    // Fill background
    imagefilledrectangle($image, 0, 0, $width, $height, $bg);
    
    // Add text
    $font_size = 5;
    $text_width = imagefontwidth($font_size) * strlen($text);
    $text_height = imagefontheight($font_size);
    $x = ($width - $text_width) / 2;
    $y = ($height - $text_height) / 2;
    
    imagestring($image, $font_size, $x, $y, $text, $textCol);
    
    // Save image
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
    
    echo "Created: $filename\n";
}

// Create main images
createPlaceholderImage('assets/images/logo.png', 200, 200, 'ADUSTECH LOGO', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/hero.jpg', 1200, 600, 'HERO SECTION - Hospital Front View', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/about.jpg', 600, 400, 'ABOUT HOSPITAL - Professional Medical Care', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/appointment-bg.jpg', 1200, 800, 'APPOINTMENT BACKGROUND', '#28a745', '#ffffff');

// Create service images
createPlaceholderImage('assets/images/services/consultation.jpg', 400, 200, 'CONSULTATION SERVICE', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/services/laboratory.jpg', 400, 200, 'LABORATORY SERVICE', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/services/pharmacy.jpg', 400, 200, 'PHARMACY SERVICE', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/services/radiology.jpg', 400, 200, 'RADIOLOGY SERVICE', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/services/emergency.jpg', 400, 200, 'EMERGENCY SERVICE', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/services/uhs.jpg', 400, 200, 'UHS SERVICE', '#28a745', '#ffffff');

// Create doctor images
createPlaceholderImage('assets/images/doctors/doctor1.jpg', 300, 300, 'DR. SARAH JOHNSON', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/doctors/doctor2.jpg', 300, 300, 'DR. MICHAEL CHEN', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/doctors/doctor3.jpg', 300, 300, 'DR. EMILY RODRIGUEZ', '#28a745', '#ffffff');
createPlaceholderImage('assets/images/doctors/doctor4.jpg', 300, 300, 'DR. JAMES WILSON', '#28a745', '#ffffff');

echo "All placeholder images have been created successfully!\n";
?>