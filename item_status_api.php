<?php

//INPUT: {"item_number":"XXX", "item_status": "y"}

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data, true);

if(isset($mydata["item_number"]) && isset($mydata["item_status"])){
    if($mydata["item_number"] != "" && $mydata["item_status"] != ""){

        $item_number = $mydata["item_number"];
        $item_status = $mydata["item_status"];

        require_once("dbtools.php");
        $link = create_connect();
        $sql = "UPDATE items SET Item_status = '$item_status' WHERE Item_number = '$item_number'";
        if(execute_sqli($link,"naru_db",$sql) && mysqli_affected_rows($link) == 1){
            echo '{"state": true, "message":"更新商品狀態成功!"}';
        }else{
            echo '{"state": false, "message":"更新商品狀態失敗!'.mysqli_error($link).$sql.'"}';
        }
        mysqli_close($link);
    }else{
        echo '{"state": false, "message":"更新商品狀態不得為空!"}';
    }
}else{
    echo '{"state": false, "message":"更新商品狀態欄位缺少!"}';
}



?>
