<?php


require_once("connect.php");

$dbConn = db_connect();



switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        $p_id = $_POST['p_id'];
        $u_id = $_POST['u_id'];
        $sql = "DELETE FROM `shop_car` WHERE `shop_car`.`p_id` = '$p_id' AND `shop_car`.`u_id` = '$u_id'";
        $result = mysqli_query($dbConn, $sql);

        if (!$result) {
            die('Error: ' . mysqli_connect_error()); //如果sql執行失敗輸出錯誤
        } else {
            echo '刪除成功!';
        }
}
