<?php

function editData(){
        
    $day = $_GET["day"];
    $new = $_GET["new"];

    include("data.php");
    $link = mysqli_connect($host, $user, $pass, $db);
    if($link){
        $query = "UPDATE `pomiary` SET `pomiar`='$new' WHERE `dzien`=$day";
        mysqli_query($link, $query);
    }
}

editData();

?>