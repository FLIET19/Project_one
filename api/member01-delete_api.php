<?php
// input:{"ID":"X"}
// output:
// {"state" : true, "message" : "刪除成功!"}
// {"state" : false, "message" : "刪除失敗!"}
// {"state" : false, "message" : "傳遞參數格式錯誤!"}
// {"state" : false, "message" : "未傳遞任何參數!"}


// 接收json資料
$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["ID"]) && $mydata["ID"] != "") {

        $ID = $mydata["ID"];               

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $db = "testdb11";

        $conn = mysqli_connect($servername, $username, $password, $db);

        if (!$conn) {
            die("連線失敗!" . mysqli_connect_error());
        }

        $sql = "DELETE FROM member01 WHERE ID = $ID";
        if (mysqli_query($conn, $sql)) {
            echo '{"state" : true, "message" : "刪除成功!"}';
        } else {
            echo '{"state" : false, "message" : "刪除失敗! . $sql ' . mysqli_error($conn) . '"}';
        }

        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
} else {
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}
?>