<?php

require_once("dbtools.php");
$link = create_connect();
$sql = "SELECT count(Item_status) as num, Item_status FROM items group by Item_status";
$result = execute_sqli($link,"naru_db",$sql);
if(mysqli_num_rows($result) > 0){
    $mydata = array();
    while ($row = mysqli_fetch_assoc($result))
    {
        $mydata[] = $row;
    }
    echo '{"state": true, "message":"商品數量讀取成功!", "data" : '.json_encode($mydata). '}';

    mysqli_close($link);
}else{
    echo '{"state": false, "message":"商品讀取失敗" '.mysqli_error($link).'}';

}

?>