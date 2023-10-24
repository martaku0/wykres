<?php

function getPomiars(){

    
$pomiars = array();

include("data.php");
$link = mysqli_connect($host, $user, $pass, $db);
if($link){

    $query = "SELECT * FROM pomiary";
    $result = mysqli_query($link, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $day = $row["dzien"];
            if(is_numeric($row["pomiar"])){
                $p = $row["pomiar"];
            }
            else{
                if($row["pomiar"] == "brak"){
                    $p = "brak";
                }
                else{
                    $p = "choroba";
                }
            }

            $pomiars[$day] = $p;

        }
    }

    // print_r($pomiars);
}
else{
    
    echo "cannot connect to database";
}

return $pomiars;



}

$data = getPomiars();
echo json_encode($data);



?>