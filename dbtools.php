<?php

function create_connect(){
    $link = mysqli_connect("localhost","admin","123456")
        or die("connection failture".mysqli_connect_error());
     
        return $link;
}

function  execute_sqli($link,$dbname,$sql){
    mysqli_select_db($link,$dbname)
        or die("connection failture".mysqli_error($link));

    $result = mysqli_query($link,$sql);

    return $result;
    }

?>