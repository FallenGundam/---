<?php

    require("connect.php");
    $dbConn=db_connect();
    $u_id = 1;
    $ip=getClientIP();
    $login_check = "SELECT * FROM login_data WHERE `user_id` = '{$u_id}'";
    $result = mysqli_query($dbConn,$login_check);
    if ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        foreach ($row as $key => $value) {
            echo "key: ".$key." value: ".$value."<br>";
        }
    }else{
        echo "未找到";
    }
    

    mysqli_close($dbConn);
    //echo $_row->user_ip;









?>