<?php

function injuryRisk($load){

    if($load > 80){
        return "HIGH";
    }

    elseif($load > 50){
        return "MEDIUM";
    }

    else{
        return "LOW";
    }

}

?>