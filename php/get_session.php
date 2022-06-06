<?php


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require("connect.php");

    session_start();
    $msg = array("status" => false, "message" => "");
    if (!array_key_exists('u_id',$_SESSION)) {
        $msg['message'] = "未找到session";
    } else {
        $u_id = $_SESSION['u_id'];
        $dbConn = db_connect();
        $ip = getClientIP();
        $login_check = "SELECT * FROM login_data WHERE `user_id` = '{$u_id}'";
        $result = mysqli_query($dbConn, $login_check);
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if ($ip == $row['user_ip']) {
                //獲取成功
                $msg['status'] = true;
                $msg['message'] = $_SESSION['u_id'];
            } else {
                $msg['message'] = "你已在別的地方登入";
                unset($_SESSION['u_id']);
            }
        } else {
            $msg['message'] = "你已在別的地方登入";
            unset($_SESSION['u_id']);
        }
    }
    echo json_encode($msg);
}


?>