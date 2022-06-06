<?php



require_once("connect.php");
require_once("searchAPI.php");
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":

        $pagetotal = $_GET['pagetotal'];  //一個頁面要載入多少商品

        $page = $_GET['page'];



        $keywords = $_GET['keywords'];
        if ($keywords == "") {
            $sqltext = "SELECT * FROM product";
        } else {
            $sqltext = "SELECT * FROM product WHERE `p_name` LIKE '%$keywords%'";
        }
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            $temp = str_contains($sqltext, 'WHERE') ? 'AND' : 'WHERE';
            $sqltext = $sqltext . " {$temp} `p_type` = '$type' ";
        }
        if (isset($_GET['city'])) {
            $city = $_GET['city'];
            $temp = str_contains($sqltext, 'WHERE') ? 'AND' : 'WHERE';
            $sqltext = $sqltext . " {$temp} `p_city` = '$city' ";
        }

        //sort
        if (isset($_GET['date_sort'])) {
            $date_sort = $_GET['date_sort'];
            $sqltext = $sqltext . " ORDER BY `p_upload_date` $date_sort ";
        }
        if (isset($_GET['price_sort'])) {
            $price_sort = $_GET['price_sort'];
            $temp = str_contains($sqltext, 'ORDER BY') ? ',' : 'ORDER BY ';
            $sqltext = $sqltext . " {$temp} `p_price` $price_sort ";
        }


        // echo $sqltext;
        echo searchAPI($sqltext,$page,$pagetotal);




}
