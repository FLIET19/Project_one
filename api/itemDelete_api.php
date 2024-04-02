<?php
// input:{"id":"X"}
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
    if (isset($mydata["id"]) && $mydata["id"] != "") {

        $id = $mydata["id"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $db = "testdb11";

        $conn = mysqli_connect($servername, $username, $password, $db);

        if (!$conn) {
            die("連線失敗!" . mysqli_connect_error());
        }

        $sql_img = "SELECT image FROM goods WHERE id = $id";
        $result_img = mysqli_query($conn, $sql_img);
        $row_img = mysqli_fetch_assoc($result_img);
        $image_name = $row_img['image'];
        // 設定相對路徑
        $localdir =  dirname(dirname(dirname(__FILE__)));
        $image_path = $localdir . "/Cass01_image/admin/product/" . $image_name;
        // 刪除圖片
        unlink($image_path);

        $sql = "DELETE FROM goods WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo '{"state" : true, "message" : "刪除成功!"}';
        } else {
            echo '{"state" : false, "message" : "刪除失敗! ' . mysqli_error($conn) . '"}';
        }

        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
} else {
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}
