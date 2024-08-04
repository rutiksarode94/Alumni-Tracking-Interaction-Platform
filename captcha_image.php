<?php
// Start the session
session_start();

// Function to generate random CAPTCHA code
function generateCaptcha($length = 6) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

// Generate CAPTCHA code and store it in session
$_SESSION['captcha'] = generateCaptcha(6);

// Set the content type header
header('Content-type: image/png');

// Create a blank image with width 120 and height 30
$image = imagecreatetruecolor(120, 30);

// Allocate white color
$bg_color = imagecolorallocate($image, 255, 255, 255);

// Fill the image background with white color
imagefill($image, 0, 0, $bg_color);

// Allocate black color for text
$text_color = imagecolorallocate($image, 0, 0, 0);

// Draw the text on the image using a random CAPTCHA code
imagettftext($image, 15, 0, 10, 22, $text_color, 'arial.ttf', $_SESSION['captcha']);

// Output the image as PNG
imagepng($image);

// Free up memory
imagedestroy($image);
?>
