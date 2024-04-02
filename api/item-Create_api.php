<?php
//input: {"sort_name":"XX", "name":"XX", "content":"XXX", "price":"XXXXX", "amount":"XXXXX", "sell":"XXXXX"}
// {"state" : true, "message" : "新增成功!"}
// {"state" : false, "message" : "新增失敗!"}
// {"state" : false, "message" : "傳遞參數格式錯誤!"}
// {"state" : false, "message" : "未傳遞任何參數!"}

$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["sort_name"]) && isset($mydata["name"]) && isset($mydata["content"]) && isset($mydata["price"]) && isset($mydata["image"]) && isset($mydata["amount"]) && isset($mydata["sell"]) && $mydata["sort_name"] != "" && $mydata["name"] != "" && $mydata["price"] != "" && $mydata["image"] != "" && $mydata["amount"] != "" && $mydata["sell"] != "") {
        $p_sort = $mydata["sort_name"];
        $p_name = $mydata["name"];
        $p_content = $mydata["content"];
        $p_price = $mydata["price"];
        $p_amount = $mydata["amount"];
        $image = $mydata["image"];
        $p_sell = $mydata["sell"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $dbname = "testdb11";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線失敗" . mysqli_connect_error());
        }

        $sql = "INSERT INTO goods(sort_name, name, content, price, amount, image, sell) VALUES('$p_sort', '$p_name', '$p_content', '$p_price', '$p_amount', '$image', '$p_sell')";
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
