<?php

function generateRandomString($length,$characters) {
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $random_string;
}

function gaussianBlur($image, $num = 1) {
    $gaussian = array(array(1.0, 2.0, 1.0), array(2.0, -1.0, 2.0), array(1.0, 2.0, 1.0));
    for ($i = 0; $i < $num; $i++) {
        imageconvolution($image, $gaussian, 12, 0);  
    }
    return $image;
}

function makeCaptcha($text) {
    if ($text != null) {
        $image_height = 70;
        $image_width = 280;
        $text_font = "./times.ttf";
        $text_size = 40;
        $text_angle = 0;
        $text_x = 70 + rand(-50,50);
        $text_y = 55;
        $image = imagecreate($image_width, $image_height);
        $background_color = imagecolorallocate($image, 0xee, 0xee, 0xff);
        
    //imagettftext($image, $text_size, $text_angle, $text_x, $text_y, $text_color, $text_font, $text);
    for ($i = 0; $i < strlen($text); $i++) {
        $rand_x = $text_x + $text_size*(7/10)*$i + rand(-1,4);
        $rand_y = $text_y + rand(-5,5);
        $rand_angle = rand(-10,10);
        $rand_size = $text_size + rand(-10,20);
        $rand_r = rand(-50,50);
        $rand_g = rand(-50,50);
        $rand_b = rand(-50,50);
        $rand_color = imagecolorallocate($image, $rand_r, $rand_g, $rand_b);
        imagettftext($image, $rand_size, $rand_angle, $rand_x, $rand_y, $rand_color, $text_font, $text[$i]);
    }
    
    // we distort the image by drawing $num_lines horintal lines
    // that are the same color as the background
    // and then apply a convolution matrix
    $num_lines = 20;
    for ($i = 0; $i < $num_lines; $i++) {
        $rand_y1 = rand(0,$image_height);
        $rand_y2 = rand(0,$image_height);
        imageline($image,0,$rand_y1,$image_width,$rand_y2,$background_color);
    }
    return $image;
  } else {
        return false;
  }
}

// to generate captcha text, call:                  $_SESSION['captcha'] = generateRandomString(4,'1234567890');
// show image on desired page with this IMG tag:    <img class="captcha" src="captcha.php" alt="CAPTCHA security code" />

session_start();
$_SESSION['captcha'] = generateRandomString(4,'1234567890');
$captcha = makeCaptcha($_SESSION['captcha']);
$captcha = gaussianBlur($captcha,1);
Header('Content-type: image/png');
imagepng($captcha);
imagedestroy($captcha);

?>

