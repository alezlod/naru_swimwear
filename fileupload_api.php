<?php
    if(isset($_FILES['file']["name"]) && $_FILES['file']["name"]!=""){
        if($_FILES['file']["type"] == "image/png" || $_FILES['file']["type"] == "image/jpeg"){
            // echo $_FILES['file']["name"]."<br/>";
            // echo $_FILES['file']["type"]."<br/>";
            // echo $_FILES['file']["size"]."<br/>";
            // echo $_FILES['file']["tmp_name"]."<br/>";
            // echo $_FILES['file']["error"]."<br/>";

            //日期為依據 產生上傳檔案的檔名
            //將$_FILES['file']["name"] 附檔取出 檔名格式 upload/20230204104410.png
            $filename = $_FILES['file']["name"];

            $location = "upload/".$filename; //檔案儲存的路徑
            // echo $location;

            if(move_uploaded_file($_FILES['file']["tmp_name"], $location)){
                //檔案傳輸成功, 收集檔案相關資訊
                //{"state": true, "message":"檔案上傳成功!", "data": json格式的檔案相關資訊}

                //將檔案路徑存入資料

                $datainfo = array();
                $datainfo["name"] = $_FILES['file']["name"]; //原始檔名
                $datainfo["type"] = $_FILES['file']["type"]; //格式
                $datainfo["size"] = $_FILES['file']["size"]; //檔案大小
                $datainfo["tmp_name"] = $_FILES['file']["tmp_name"]; //暫存檔名稱
                $datainfo["error"] = $_FILES['file']["error"]; //錯誤代碼
                $datainfo["filename"] = $filename;
                echo '{"state": true, "message":"檔案上傳成功!", "data": '.json_encode($datainfo).'}';
            }else{
                //檔案傳輸失敗
                echo '{"state": false, "message":"檔案上傳失敗!"}';
            }
        }else{
            echo '{"state": false, "message":"檔案格式錯誤(png or jpeg)!"}';
        }
    }else{
        echo '{"state": false, "message":"檔案不存在或未選取檔案!"}';
    }

?>