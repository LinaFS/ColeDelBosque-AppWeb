<?php
    include 'php/crypto.php';

    echo "Comparativa: Encriptada con mi algoritmo:\n";
    $matricula= "OHE120912";
    $matricula= encrypt($matricula);
    echo $matricula;
    echo "\n\n";
    echo "\n\n\n\nDesencriptando...\n\n\n";
    $matricula=decrypt($matricula);
    echo $matricula;
   

    echo "\n\n\n";
    echo "\n\nComparativa: Encriptada con mi algoritmo:\n";
    $matricula= "CFG171080";
    $matricula= encrypt($matricula);
    echo $matricula;
    echo "\n\n";
    echo "\n\n\n\nDesencriptando...\n\n\n";
    $matricula=decrypt($matricula);
    echo $matricula;
    
    echo "\n\n\n";
    echo "\n\nComparativa: Encriptada con mi algoritmo:\n";
    $matricula = "PFS200702";
    $matricula= encrypt($matricula);
    echo $matricula;
    echo "\n\n";
    echo "\n\n\n\nDesencriptando...\n\n\n";
    $matricula=decrypt($matricula);
    echo $matricula;

?>