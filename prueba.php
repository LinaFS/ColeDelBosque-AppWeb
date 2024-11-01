<?php
    $matricula= "OHE120912";
    $matricula = hash("sha512",$matricula);
    echo $matricula;
?>