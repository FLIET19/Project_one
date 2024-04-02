<?php
$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["name"]) && $mydata["name"] != "") {
        $p_sort = $mydata["name"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $dbname = "testdb11";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線失敗" . mysqli_connect_error());
        }

        $sql = "INSERT INTO sort name VALUES $p_sort')";
        if (mysqli_query($conn, $sql)) {
            echo '{"state" : true, "message" : "新增成功!"}';
        } else {
            echo '{"state" : false, "message" : "新增失敗!"}';
        }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
} else {
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}

mysqli_close($conn);
