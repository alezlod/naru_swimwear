<?php

// INPUT: {"item_number":"1","item_name":"peol","item_photo":"hahahyeee","item_color":"babyblue","item_introduction":"toskgisif","item_feature":"OOOOO","item_price":"1000"}

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data,true);

if(isset($mydata["item_number"]) && isset($mydata["item_name"])&& isset($mydata["item_photo"]) && isset($mydata["item_color"])&& isset($mydata["item_introduction"])&& isset($mydata["item_feature"])&& isset($mydata["item_price"]) && isset($mydata["item_status"])){
    if($mydata["item_number"] != "" && $mydata["item_name"] != "" && $mydata["item_photo"] != "" && $mydata["item_color"] != "" && $mydata["item_introduction"] != ""&& $mydata["item_feature"] != ""&& $mydata["item_price"] != "" && $mydata["item_status"]!= ""){
        
        $item_number = $mydata["item_number"];
        $item_name = $mydata["item_name"];
        $item_photo = $mydata["item_photo"];
        $item_color = $mydata["item_color"];
        $item_introduction = $mydata["item_introduction"];
        $item_feature = $mydata["item_feature"];
        $item_price = $mydata["item_price"];
        $item_status = $mydata["item_status"];

        require_once("dbtools.php");
        $link = create_connect();
        $sql = "UPDATE items SET Item_name  = '$item_name', Item_photo = '$item_photo',Item_color = '$item_color', Item_introduction = '$item_introduction', Item_feature = '$item_feature', Item_price = '$item_price', Item_status = '$item_status' WHERE Item_number = '$item_number'";

        if(execute_sqli($link,"naru_db",$sql)){
            echo '{"state": true, "message":"商品更新成功!"}';
        }else{
            echo '{"state": false, "message":"商品更新失敗!"'.mysqli_error($link).'}';
        }
        mysqli_close($link);

    }else{
        echo '{"state": false, "message":"更新商品欄位不得空白!"}';
    }
}else{
    echo '{"state": false, "message":"缺少更新商品欄位!"}';
}


?>