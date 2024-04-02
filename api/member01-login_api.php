<?php
//input: {"Username":"XX", "PWD":"XXX"}
/*
    {"state" : true, "data":"登入者的相關資料(密碼除外)","message" : "登入成功"}
    {"state" : false, "message" : "帳號或密碼錯誤"}
    {"state" : false, "message" : "傳遞參數格式錯誤!"}
    {"state" : false, "message" : "未傳遞任何參數!"}
    */

$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["Username"]) && isset($mydata["PWD"]) && $mydata["Username"] != "" && $mydata["PWD"] != "") {
        $p_Username = $mydata["Username"];
        $p_Password = $mydata["PWD"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $dbname = "testdb11";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線失敗" . mysqli_connect_error());
        }

        $sql = "SELECT Username, Power, PWD, Email FROM member01 WHERE Username = '$p_Username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            // 帳號符合，密碼待確
            $row = mysqli_fetch_assoc($result);
            if (password_verify($p_Password, $row["PWD"])) {
                // 密碼比對正確，撈取使用者資料(密碼除外)並產生uid
                $uid = substr(hash("sha256", uniqid(time())), 0, 8);
                // 更新uid至資料庫
                $sql = "UPDATE member01 SET UID01 = '$uid' WHERE Username = '$p_Username'";
                if (mysqli_query($conn, $sql)) {
                    $sql = "SELECT Username, Power, Email, UID01 FROM member01 WHERE Username = '$p_Username'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $mydata = array();
                    $mydata[] = $row;

                    echo '{"state" : true, "data": ' . json_encode($mydata) . ',"message" : "登入成功"}';
                } else {
                    // uid更新錯誤
                    echo '{"state" : false, "message" : "uid更新錯誤!"}';
                }
            } else {
                // 密碼比對錯誤
                echo '{"state" : false, "message" : "帳號或密碼錯誤!"}';
            }
        } else {
            // 確認帳號不符，登入失敗
            echo '{"state" : false, "message" : "帳號或密碼錯誤!"}';
        }

        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "帳號或密碼錯誤!"}';
    }
} else {
    echo '{"state" : false, "message" : "帳號或密碼錯誤!"}';
}
