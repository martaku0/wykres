<?php
// header('Content-Type: image/png');

// def img

$width = 820;
$height = 250;
$im = imagecreatetruecolor(800,400);
$bgcolor = imagecolorallocate($im, 255,255,255);

imagefilledrectangle($im, 0, 0, $width, $height, $bgcolor);

$linecolor = imagecolorallocate($im, 3,3,3);
$textcolor = $linecolor;

// osie x,y
imageline($im, 50, 45, 50, 205, $linecolor);
imageline($im, 45, 200, 770, 200, $linecolor);

// linie przerywane + numerki
$dashed = array($linecolor, $linecolor, $linecolor, $bgcolor, $bgcolor, $bgcolor);
$red = imagecolorallocate($im, 255, 0 ,0);
imagesetstyle($im, $dashed);

for($i = 0; $i<6; $i++){
    $temp = 50 + $i*25;
    $tempNum = 37.2 - 0.2*$i;
    $tempNum = number_format((float)$tempNum, 1, '.', '');
    imageline($im, 55, $temp, 770, $temp, IMG_COLOR_STYLED);
    imagestring($im, 2, 20, $temp-5, "{$tempNum}", $textcolor);
    imageline($im, 47.5, $temp, 53, $temp, $linecolor);
}

for($i = 0; $i<28; $i++){
    $temp = 75+ $i*25;
    $tempNum = $i+1;
    imageline($im, $temp, 45, $temp, 194, IMG_COLOR_STYLED);
    imagestring($im, 2, $temp-3, 205, "{$tempNum}", $textcolor);
    imageline($im, $temp, 195, $temp, 203, $linecolor);
}

// text
$txt1 = mb_convert_encoding("dzień miesiąca", "UTF-8"); // ENCODE ??
imagestring($im, 3, ($width-100)/2, $height-20, $txt1, $textcolor);
imagestringup($im, 3, 2, ($height+50)/2, 'temperatura', $textcolor);


// ---

imageline($im, 55, 75, 770, 75, $red);


// show img

imagepng($im);
imagedestroy($im);
?>