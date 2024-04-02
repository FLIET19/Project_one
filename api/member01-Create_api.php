<?php
    //input: {"Username":"XX", "Password":"XXX", "Email":"XXXXX"}
    // {"state" : true, "message" : "註冊成功!"}
    // {"state" : false, "message" : "註冊失敗!"}
    // {"state" : false, "message" : "傳遞參數格式錯誤!"}
    // {"state" : false, "message" : "未傳遞任何參數!"}

    $data = file_get_contents("php://input", "r");
    if($data != ""){
        $mydata = array();
        $mydata = json_decode($data, true);
        if(isset($mydata["Username"]) && isset($mydata["PWD"]) && isset($mydata["Email"]) && $mydata["Username"] != "" && $mydata["PWD"] != "" && $mydata["Email"] != ""){
            $p_Username = $mydata["Username"];
            $p_Password = password_hash($mydata["PWD"], PASSWORD_DEFAULT);
            $p_Email = $mydata["Email"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "testdb11";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("連線失敗".mysqli_connect_error());
            }

            $sql = "INSERT INTO member01(Username, PWD, Email) VALUES('$p_Username', '$p_Password', '$p_Email')";
            if(mysqli_query($conn, $sql)){
                //新增成功
                echo '{"state" : true, "message" : "註冊成功!"}';
            }else{
                //新增失敗
                echo '{"state" : false, "message" : "註冊失敗!"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }
    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }
?>