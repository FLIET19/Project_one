<?php
    //input: {"Username":"XX"}
    // {"state" : true, "message" : "帳號可使用!"}
    // {"state" : false, "message" : "帳號已存在"}
    // {"state" : false, "message" : "傳遞參數格式錯誤!"}
    // {"state" : false, "message" : "未傳遞任何參數!"}

    $data = file_get_contents("php://input", "r");
    if($data != ""){
        $mydata = array();
        $mydata = json_decode($data, true);
        if(isset($mydata["Username"]) && $mydata["Username"] != ""){
            $p_Username = $mydata["Username"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "testdb11";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("連線失敗".mysqli_connect_error());
            }

            $sql = "SELECT Username FROM member01 WHERE Username = '$p_Username'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 0){
                echo '{"state" : true, "message" : "帳號可使用!"}';
            }else{
                echo '{"state" : false, "message" : "帳號已存在!"}';
            }

            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }
    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }
?>