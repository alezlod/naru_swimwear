<?php

//INPUT: {"username":"owner", "password":"123456"}
//Output:
// {"state": true, "message":"登入會員成功!"}
// {"state": false, "message":"登入會員失敗!錯誤代碼或相關訊息"}
// {"state": false, "message":"欄位不得為空白!"}
// {"state": false, "message":"缺少規定欄位!"}

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data, true);

if(isset($mydata["username"]) && isset($mydata["password"])){
    if($mydata["username"]!= "" && $mydata["password"]!= ""){
        $username = $mydata["username"];
        $password = $mydata["password"];

        require_once("dbtools.php");
        $link = create_connect();
        // 抓資料出來 找出相同帳號的那一筆
        $sql = "SELECT Username, Password, UserState FROM members WHERE Username = '$username'";
        $result = execute_sqli($link,"naru_db",$sql);
        if(mysqli_num_rows($result) == 1 ){
            //如果取出的資料有一筆就會執行以下
            //password_verify('輸入的帳號',$hash或其他格式)
            $row = mysqli_fetch_assoc($result);
            // 取出陣列裡的password值，設為變數$password_hash
            $password_hash = $row["Password"];
            // 開始判定db取出的password是否跟輸入的相同
            if(password_verify($password,$password_hash)){
                //密碼驗證成功
                //產生UID並更新於資料庫
                $uid = substr(md5(hash('sha256',uniqid())),0, 6);
                $uid2 = substr(md5(hash('sha256',rand())),0, 6);
                $sql = "UPDATE members SET UID01 = '$uid',UID02 = '$uid2' WHERE Username = '$username'";
                execute_sqli($link, "naru_db", $sql);

                //撈取除了密碼以外的資料
                $sql = "SELECT ID, Username, UserState, UID01, UID02 FROM members WHERE Username = '$username' ";
                $result = execute_sqli($link, "naru_db", $sql);
                $row = mysqli_fetch_assoc($result);
                $userData = array();
                $userData[] = $row;

                echo '{"state": true, "message":"登入會員成功!","data": '.json_encode($userData).'}';
            }else{
                //密碼驗證失敗
                echo '{"state": false, "message":"登入會員失敗!'.mysqli_error($link).'"}';
                }
        }else{
            //該筆帳號不存在
            echo '{"state": false, "message":"該筆帳號不存在!'.mysqli_error($link).'"}';
        }
        mysqli_close($link);
                
    }else{
       echo '{"state": false, "message":"欄位不得為空白!"}';
    }
}else{
    echo '{"state": false, "message":"缺少規定欄位!"}';
}




?>