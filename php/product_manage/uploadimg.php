<?php
/*
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/11/23
 * Time: 10:57
 
header("Access-Control-Allow-Origin:*");
// 響應型別
header('Access-Control-Allow-Methods:POST');
// 響應頭設定
header('Access-Control-Allow-Headers:x-requested-with, content-type');
header("Content-type: text/html; charset=utf-8");
$file = $_FILES["file"];
if ($file["error"] > 0) {
    echo "錯誤：" . $file["error"];
} else {
    $name = iconv('utf-8', 'gb2312', "upload/" . $file["name"]);
    echo "檔名稱：" . $file["name"] . "</br>";
    echo "檔案型別：" . $file["type"] . "</br>";
    echo "檔案大小：" . ($file["size"] / 1024) . "K</br>";
    echo "檔案臨時儲存的位置：" . $file["tmp_name"] . "</br>";


    //儲存上傳的檔案
    if (file_exists("upload" . $file["name"])) {
        echo $file["name"] . "檔案已經存在";
    } else {
        //如果目錄不存在則將該檔案上傳
        if (move_uploaded_file($file['tmp_name'], $name)) {
            move_uploaded_file($file['tmp_name'], "upload/" . $file["name"]);
        }
    }
}*/





header('Content-Type: text/html; charset=utf-8');  //傳送出去的編碼
ini_set("display_errors", "On");
error_reporting(E_ALL & ~E_NOTICE);

// 取得副檔名

$new_array = explode(".", $_FILES['the_file']['name']);
$ext = end($new_array);

$target_dir = "../../img_data/"; // 目標路徑
$new_filename = time() . "_" . rand(10,100) . "." . $ext; // 新的檔名
$target_file = $target_dir . $new_filename; // 存的位置 + 檔名
move_uploaded_file($_FILES["the_file"]["tmp_name"], $target_file);



echo ($new_filename);
?>