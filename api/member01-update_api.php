<?php
// input:{"ID":"X","Email":"XXXXX"}
// output:
// {"state" : true, "message" : "更新成功!"}
// {"state" : false, "message" : "更新失敗!"}
// {"state" : false, "message" : "傳遞參數格式錯誤!"}
// {"state" : false, "message" : "未傳遞任何參數!"}

// 接收json資料
$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["ID"]) && isset($mydata["Email"]) && $mydata["ID"] != "" && $mydata["Email"] != "") {

        $ID = $mydata["ID"];
        $email = $mydata["Email"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $db = "testdb11";

        $conn = mysqli_connect($servername, $username, $password, $db);

        if (!$conn) {
            die("連線失敗!" . mysqli_connect_error());
        }

        $sql = "UPDATE member01 SET Email = '$email' WHERE ID = '$ID'";
        if (mysqli_query($conn, $sql)) {
            echo '{"state" : true, "message" : "更新成功!"}';
        } else {
            echo '{"state" : false, "message" : "更新失敗! . $sql ' . mysqli_error($conn) . '"}';
        }

        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
} else {
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}
?>