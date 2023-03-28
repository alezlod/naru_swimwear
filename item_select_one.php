<?php

//選擇一個商品資料

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data,true);

if(isset($mydata["item_number"])){
    if($mydata["item_number"] != ""){      
        $item_number = $mydata["item_number"];

        require_once("dbtools.php");
        $link = create_connect();
        $sql = "SELECT Item_number, Item_name, Item_photo, Item_color, Item_introduction, Item_feature, Item_price, Item_status FROM items  WHERE Item_number = '$item_number'";
        $result = execute_sqli($link,"naru_db",$sql);
        if(mysqli_num_rows($result) == 1 ){
            //正確找到item_number所對應的資料
            $row = mysqli_fetch_assoc($result);
            echo '{"state": true, "message":"讀取成功!","data":'.json_encode($row).' }';
        }else{
            //查無資料
            echo '{"state": false, "message":"讀取失敗"'.mysqli_error($link).'}';
        }

        mysqli_close($link);
    }else{
        echo '{"state": false, "message":"欄位不得為空"}';
    }
}else{
    echo '{"state": false, "message":"缺少欄位"}';
}



?>