<?php
// def img

$width = 820;
$height = 250;
$im = imagecreatetruecolor($width,$height);
$bgcolor = imagecolorallocate($im, 255,255,255);

imagefilledrectangle($im, 0, 0, $width, $height, $bgcolor);

$linecolor = imagecolorallocate($im, 3,3,3);
$textcolor = $linecolor;

// osie x,y
imageline($im, 50, 45, 50, 205, $linecolor);
imageline($im, 45, 200, 770, 200, $linecolor);

$array_of_x = array();
$array_of_y = array();

// linie przerywane + numerki
$dashed = array($linecolor, $linecolor, $linecolor, $bgcolor, $bgcolor, $bgcolor);
$red = imagecolorallocate($im, 255, 0 ,0);
imagesetstyle($im, $dashed);

$temperatures = array(0 => "37.2", 1 => "37.0", 2 => "36.8", 3 => "36.6", 4 => "36.4", 5 => "36.2");

for($i = 0; $i<6; $i++){
    $temp = 50 + $i*25;
    $tempNum = 37.2 - 0.2*$i;
    $tempNum = number_format((float)$tempNum, 1, '.', '');
    imageline($im, 55, $temp, 770, $temp, IMG_COLOR_STYLED);
    imagestring($im, 2, 20, $temp-5, "{$tempNum}", $textcolor);
    imageline($im, 47.5, $temp, 53, $temp, $linecolor);
    array_push($array_of_y, $temp);
}

for($i = 0; $i<28; $i++){
    $temp = 75+ $i*25;
    $tempNum = $i+1;
    imageline($im, $temp, 45, $temp, 194, IMG_COLOR_STYLED);
    imagestring($im, 2, $temp-3, 205, "{$tempNum}", $textcolor);
    imageline($im, $temp, 195, $temp, 203, $linecolor);
    array_push($array_of_x, $temp);
}

// text
$txt1 = "dzien miesiaca";
$txt2 = mb_convert_encoding($txt1, "UTF-8"); // ENCODE ??
imagestring($im, 3, ($width-100)/2, $height-20, $txt2, $textcolor);
imagestringup($im, 3, 2, ($height+50)/2, $_GET["nazwa"], $textcolor);

// ---

imageline($im, 55, 75, 770, 75, $red);
$col_ellipse = imagecolorallocate($im, 0, 0, 255);
// imagefilledellipse($im, $array_of_x[0], $array_of_y[0], 10, 10, $col_ellipse);

// connect to database

$link = mysqli_connect("localhost", "root", "", "wykres");
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
                $temp_a = $temp_a/0.008;  // 0.2 == 25px 1px == 0.008
                $temp_y = 200-$temp_a;
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
                $temp_y = 200;
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

    // show img
    header('Content-Type: image/png');


    imagepng($im);
    imagedestroy($im);
}
else{
    
    echo "cannot connect to database";
}




?>