<?php


require_once("../connect.php");
require_once("../searchAPI.php");
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":

        $pagetotal = $_GET['pagetotal'];  //一個頁面要載入多少商品

        $u_id = $_GET['u_id'];
        $page = $_GET['page'];

        $sqlarr = [
            " `u_id` = '$u_id' "
        ];


        if (isset($_GET['keywords'])) {
            $keywords = $_GET['keywords'];
            array_push($sqlarr, " `p_name` LIKE '%$keywords%' ");
        }
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            array_push($sqlarr, " `p_type` = '$type' ");
        }

        $sqltext = "SELECT * FROM product WHERE";
        foreach ($sqlarr as $key => $value) {
            if ($key == 0) {
                $sqltext = $sqltext . $value;
            } else {
                $sqltext = $sqltext . "AND" . $value;
            }
        }
        //echo $sqltext;

        echo searchAPI($sqltext,$page,$pagetotal);
}
