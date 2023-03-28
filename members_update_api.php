<?php

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data, true);

if(isset($mydata["email"]) && isset($mydata["location"]) && isset($mydata["id"])){
    if($mydata["email"]!= "" && $mydata["location"]!="" && $mydata["id"]){
        
        $email = $mydata["email"];
        $location = $mydata["location"];
        $id = $mydata["id"];
        
        require_once("dbtools.php");
        $link = create_connect();
        $sql = "UPDATE members SET Email = '$email', Location = '$location' WHERE ID = '$id'";
        if(execute_sqli($link, "naru_db", $sql) && mysqli_affected_rows($link) == 1){
            echo '{"state": true, "message":"更新商品狀態成功!"}';
            }else{
                echo '{"state": false, "message":"更新商品狀態失敗!'.mysqli_error($link).$sql.'"}';
            }
        mysqli_close($link);
    }else{
        echo '{"state": false, "message":"更新會員欄位不得空白!"}';
    }

}else{
    echo '{"state": false, "message":"更新會員欄位缺少!"}';
}




?>