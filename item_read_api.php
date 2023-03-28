<?php

// 此支API目的為取出DB資料顯示

require_once("dbtools.php");
$link = create_connect();
$sql = "SELECT * FROM items";
$result = execute_sqli($link,"naru_db",$sql);
// 只要SQL有取到data就會大於0
if(mysqli_num_rows($result)>0){
    $mydata = array();
    while($row = mysqli_fetch_assoc($result)){
        $mydata[] = $row;
    }
    echo '{"state": true, "message":"商品讀取成功!", "data" : '.json_encode($mydata).'}';

    mysqli_close($link);
}else{
    echo '{"state": false, "message":"商品讀取失敗!'.mysqli_error($link).'"}';
}


?>