<?php

function createImg(){

$width = 820;
    
$height = 250;

$im = imagecreatetruecolor($width,$height);
$bgcolor = imagecolorallocate($im, 255,255,255);

imagefilledrectangle($im, 0, 0, $width, $height, $bgcolor);

$linecolor = imagecolorallocate($im, 3,3,3);
$textcolor = $linecolor;

// osie x,y
imageline($im, 50, 45, 50, $height-45, $linecolor);
imageline($im, 45, $height-50, $width-50, $height-50, $linecolor);

$array_of_x = array();
$array_of_y = array();

// linie przerywane + numerki
$dashed = array($linecolor, $linecolor, $linecolor, $bgcolor, $bgcolor, $bgcolor);
$red = imagecolorallocate($im, 255, 0 ,0);
imagesetstyle($im, $dashed);

$temperatures = array(0 => "37.2", 1 => "37.0", 2 => "36.8", 3 => "36.6", 4 => "36.4", 5 => "36.2");

for($i = 0; $i<6; $i++){
    $temp = 50 + $i*(($height-100)/6);
    $tempNum = 37.2 - 0.2*$i;
    $tempNum = number_format((float)$tempNum, 1, '.', '');
    imageline($im, 55, $temp,  $width-50, $temp, IMG_COLOR_STYLED);
    imagestring($im, 2, 20, $temp-5, "{$tempNum}", $textcolor);
    imageline($im, 47.5, $temp, 53, $temp, $linecolor);
    array_push($array_of_y, $temp);
}

for($i = 0; $i<28; $i++){
    $temp = 75+ $i*(($width-100)/28);
    $tempNum = $i+1;
    imageline($im, $temp, 45, $temp, $height-50, IMG_COLOR_STYLED);
    imagestring($im, 2, $temp-3, $height-45, "{$tempNum}", $textcolor);
    imageline($im, $temp, $height-47, $temp, $height-57, $linecolor);
    array_push($array_of_x, $temp);
}

// text
$txt1 = "dzień miesiąca";
$font = "tcpdf/fonts/open-sans-ttf/OpenSans-Bold.ttf";
imagettftext($im, 8, 0, ($width-100)/2, $height-20, $textcolor, $font, $txt1);
$txt2 = "temperatura";
imagettftext($im, 8, 90, 10, ($height+50)/2, $textcolor, $font, $txt2);

// ---

imageline($im, 55, 50+($height-100)/6,  $width-50, 50+($height-100)/6, $red);
$col_ellipse = imagecolorallocate($im, 0, 0, 255);
// imagefilledellipse($im, $array_of_x[0], $array_of_y[0], 10, 10, $col_ellipse);

// connect to database

// $link = mysqli_connect("localhost", "root", "", "wykres");
include("data.php");
$link = mysqli_connect($host, $user, $pass, $db);
if($link){

    $query = "SELECT * FROM pomiary";
    $result = mysqli_query($link, $query);
    
    if (mysqli_num_rows($result) > 0) {

        $last_x_y = array(0,0);

        while($row = mysqli_fetch_assoc($result)) {
        //   echo "id: " . $row["id"]. " - pomiar: " . $row["pomiar"]. " - dzien: " . $row["dzien"]. "<br>";
            $temp_x = $row["dzien"];
            if(is_numeric($row["pomiar"])){
                $temp_a = floatval($row["pomiar"])-36;
                // $temp_pxl = floatval(0.2/($height-100));
                // $temp_pxl = floatval($temp_pxl/6);
                // $temp_a = $temp_a/$temp_pxl;  // 0.2 == 25px 1px == 0.008
                $temp_y = $height-50-($temp_a/(0.2/(($height-100)/6))); // 0.2 == 34px // 
                $col_ellipse = imagecolorallocate($im, 0, 0, 255);
                imagefilledellipse($im, $array_of_x[$temp_x-1], $temp_y, 7, 7, $col_ellipse);

                if($last_x_y[0] == 0 && $last_x_y[1] == 0){
                    $last_x_y[0] = $array_of_x[$temp_x-1];
                    $last_x_y[1] = $temp_y;
                }
                else{
                    imageline($im, $last_x_y[0], $last_x_y[1], $array_of_x[$temp_x-1], $temp_y, $col_ellipse);
                    $last_x_y[0] = $array_of_x[$temp_x-1];
                    $last_x_y[1] = $temp_y;
                }
            }
            else{
                $temp_y = $height-50;
                if($row["pomiar"] == "brak"){
                    $col_ellipse = imagecolorallocate($im, 83, 83, 83);
                }
                else{
                    $col_ellipse = imagecolorallocate($im, 255, 0, 0);
                }
                imagefilledellipse($im, $array_of_x[$temp_x-1], $temp_y, 7, 7, $col_ellipse);

                $last_x_y = array(0,0);
            }
        }
      } else {
        // echo "0 results";
      }
    }

    return $im;

}


?>