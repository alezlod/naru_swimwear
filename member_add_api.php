<?php

/*{"Username": "owner", "Password": "123456", "Email": "thisisme@gmail.com"}*/

/* OUTPUT: 
{"state": true, "message":"註冊會員成功!"}
{"state": false, "message":"註冊會員失敗!錯誤代碼或相關訊息"}
{"state": false, "message":"欄位不得為空白!"}
{"state": false, "message":"缺少規定欄位!"}*/

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data,true);

if(isset($mydata["username"]) && isset($mydata["password"]) && isset($mydata["email"]) && isset($mydata["location"])){
    if($mydata["username"]!= "" && $mydata["password"]!= ""  && $mydata["email"]!= "" && $mydata["location"]!= ""){
        
        $username = $mydata["username"];
        $password = $mydata["password"]; //password_hash
        // substr 擷取部分字串，自行設定長度 substr($string,$start,$length)
        $password = password_hash($password, PASSWORD_DEFAULT);
        $email = $mydata["email"];
        $location = $mydata["location"];
        $subscription = $mydata["subscription"];
        $userstate = $mydata["userstate"];

        require_once("dbtools.php");
        $link = create_connect();
        $sql = "INSERT INTO members(Username, Password, Email, Location, Subscription, UserState) VALUES ('$username','$password','$email','$location','$subscription','$userstate')";
        if(execute_sqli($link, "naru_db", $sql)){
            echo '{"state": true, "message":"註冊會員成功!"}';
        }else{
            echo '{"state": false, "message":"註冊會員失敗!錯誤代碼或相關訊息"'.mysqli_error($link).'}';
        }
        mysqli_close($link);
    }else{
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
}else{
    echo '{"state": false, "message":"缺少規定欄位!"}';
}





 

