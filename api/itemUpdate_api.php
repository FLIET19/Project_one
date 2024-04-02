<?php
//input: {"id":"XX", "content":"XXX", "price":"XXXXX", "amount":"XXXXX"}
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
    if (isset($mydata["id"]) && isset($mydata["content"]) && isset($mydata["price"]) && isset($mydata["amount"]) && $mydata["id"] != "" && $mydata["price"] != "" && $mydata["amount"] != "") {

        $id = $mydata["id"];
        $p_content = $mydata["content"];
        $p_price = $mydata["price"];
        $p_amount = $mydata["amount"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $db = "testdb11";

        $conn = mysqli_connect($servername, $username, $password, $db);

        if (!$conn) {
            die("連線失敗!" . mysqli_connect_error());
        }

        $sql = "UPDATE goods SET content = '$p_content', price = '$p_price', amount = '$p_amount' WHERE id = '$id'";
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
