<?php
if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
  if ($_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png") {
    $fileName =  hash("md5", date("YmdHis")) . '_' . $_FILES['file']['name'];
    $nowdir = dirname(__FILE__);
    $locationdir =  dirname(dirname(dirname(__FILE__)));
    $location = $locationdir . '/Cass01_image/admin/product/' . $fileName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
      $datainfo = array();
      $datainfo["name"] = $fileName;
      $datainfo["type"] = $_FILES['file']['type'];
      $datainfo["size"] = $_FILES['file']['size'];
      $datainfo["tmp_name"] = $_FILES['file']['tmp_name'];
      $datainfo["error"] = $_FILES['file']['error'];
      $datainfo["serverFileName"] = $location;
      echo '{"state": true, "datainfo":' . json_encode($datainfo) . ', "msgFile": "檔案上傳成功"}';
    } else {
      $errorinfo = array();
      $errorinfo["info"] = $_FILES['file']['error'];
      $errorinfo["tmp_name"] = $_FILES['file']['tmp_name'];
      $errorinfo["location"] = $location;
      $errorinfo["locationdir"] = $locationdir;

      echo '{"state": false, "error_info":' . json_encode($errorinfo) . ', "msgFile": "檔案上傳失敗"}';
    }
  } else {
    echo '{"state": false, "msgFile": "檔案格式錯誤，必須為 jpeg 或 png !"}';
  }
} else {
  echo '{"state":false, "msgFile":"檔案不存在"}';
}
