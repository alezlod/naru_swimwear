<?php

// 順序如下
// 連接db -> 輸入SQL語法(給指令) -> 將輸入的值設定變數 -> 將變數設條件(不可空白)


// input 規定 json 格式
// {"item_name":"phildunphy","item_photo":"trampling123","item_color":"yes","item_introduction":"phildunpy@gmail.com","item_feature":"OOOOO","item_price":"2500", "item_status":"Y"}


$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data,true);

if(isset($mydata["item_name"]) && isset($mydata["item_photo"]) && isset($mydata["item_color"])&& isset($mydata["item_introduction"])&& isset($mydata["item_feature"])&&($mydata["item_price"]) && isset($mydata["item_status"]) ){
    if($mydata["item_name"] != "" && $mydata["item_color"] != "" && $mydata["item_introduction"] != "" && $mydata["item_feature"] != "" && $mydata["item_price"] != "" && $mydata["item_status"]){

        $item_name = $mydata["item_name"];
        $item_color = $mydata["item_color"];
        $item_photo = $mydata["item_photo"];
        $item_introduction = $mydata["item_introduction"];
        $item_feature = $mydata["item_feature"];
        $item_price = $mydata["item_price"];
        $item_status = $mydata["item_status"];

        require_once("dbtools.php");
        $link = create_connect();
        $sql = "INSERT INTO items(Item_name, Item_photo, Item_color,Item_Introduction, Item_feature, Item_price, Item_status) VALUES ('$item_name','$item_photo','$item_color','$item_introduction','$item_feature','$item_price','$item_status')";
        if(execute_sqli($link,"naru_db",$sql)){
            echo '{"state":true,"message":"新增商品成功"}';
        }else{
            echo '{"state":false,"message":"新增商品失敗"'.mysqli_error($link).'}';
        }
        mysqli_close($link);
    }else{
        echo '{"state":false,"message":"商品欄位不得空白"}';
    }
}else{
    echo '{"state":false,"message":"缺少商品欄位"}';
}



?>