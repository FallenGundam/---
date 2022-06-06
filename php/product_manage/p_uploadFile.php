<?php


require_once("../connect.php");

$dbConn = db_connect();

$target_dir = "../../img_data/";






switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":


        $product_data = json_decode($_POST['data_model'], true);


        //上傳圖片
        //並將圖片檔名添加到圖片列表中
        if (isset($_FILES['newimg']['error'])) {
            $newimglist  = [];
            foreach ($_FILES['newimg']['error'] as $key => $error) {
                if ($error == 0) {
                    $name = $_FILES['newimg']['name'][$key];
                    $splitstr = explode(".", $name);
                    $ext = end($splitstr);
                    //echo $name."<br>";
                    $fileName = uuid() . "." . $ext;
                    $target_file = $target_dir . $fileName;
                    // echo "<br>".$target_file;
                    move_uploaded_file($_FILES['newimg']['tmp_name'][$key], $target_file);
                    array_push($newimglist, $fileName);
                }
            }
        }
        //上傳封面
        //並儲存上傳圖片的檔名
        if (isset($_FILES['first_img']['error'])) {
            $name = $_FILES['first_img']['name'];
            $splitstr = explode(".", $name);
            $ext = end($splitstr);
            $fileName = uuid() . "." . $ext;
            $target_file = $target_dir . $fileName;
            move_uploaded_file($_FILES['first_img']['tmp_name'], $target_file);

            $first_img_name = $fileName;
        }



        //準備寫入資料庫
        $u_id = $product_data['u_id'];
        $p_name = $product_data['name'];
        $p_type = $product_data['type'];
        $p_city = $product_data['city'];
        $p_districts = $product_data['districts'];
        $p_unit = $product_data['unit'];
        $p_introduction = $product_data['introduction'];
        $p_trade_type = $product_data['trade_type'];
        $p_amount = $product_data['amount'];
        $p_price = $product_data['price'];



        //判定是否為編輯模式
        if (isset($product_data['p_id'])) {

            //編輯
            $p_id = $product_data['p_id'];

            //刪除捨棄的相片


            //保留的圖片列表
            //echo "保留的圖片<br>";
            if (isset($_POST['oldsrc'])) {
                $keepimg = [];
                foreach ($_POST['oldsrc'] as $key => $value) {
                    $tempstr = explode("/", $value);
                    $fname =  $tempstr[array_key_last($tempstr)];
                    array_push($keepimg, $fname);
                    echo $fname . "<br>";
                }
            }

            //echo "目前所有圖片<br>";
            $getAllImgsql = "SELECT * FROM img_list WHERE `p_id` = '$p_id'";
            $allimg = mysqli_query($dbConn, $getAllImgsql);
            $allimgdata = mysqli_fetch_all($allimg, MYSQLI_ASSOC);
            for ($i = 0; $i < count($allimgdata); $i++) {
                $src = $allimgdata[$i]['img_name'];
                echo $src . '<br>';
                if (!in_array($src, $keepimg)) {
                    if (file_exists(($target_dir . $src))) {
                        unlink($target_dir . $src);
                    } else {
                        echo '檔案不存在,系統錯誤<br>';
                    }

                    $delimgsql = "DELETE FROM img_list WHERE `img_list`.`img_name` = '$src'";
                    mysqli_query($dbConn, $delimgsql);

                    echo "已刪除圖片 " . $target_dir . $src . "<br>";
                }
            }


            //更新資料
            $sqltext = "UPDATE `product` SET `p_unit` = '$p_unit', `p_price` = '$p_price', `p_name` = '$p_name', `p_introduction` = '$p_introduction', `p_amount` = '$p_amount', `p_city` = '$p_city', `p_type` = '$p_type', `p_trade_type` = '$p_trade_type', `p_districts` = '$p_districts' WHERE `product`.`p_id` = '$p_id'";
            $reslut = mysqli_query($dbConn, $sqltext);
         
        } else {
            //創建資料
            $sqltext = "INSERT INTO `product` (`p_id`, `u_id`, `p_unit`, `p_price`, `p_name`, `p_introduction`, `p_amount`, `p_city`, `p_type`, `p_trade_type`, `p_districts`, `p_upload_date`) VALUES (null, '$u_id', '$p_unit', '$p_price', '$p_name', '$p_introduction', '$p_amount', '$p_city', '$p_type', '$p_trade_type', '$p_districts', current_timestamp())";
            $reslut = mysqli_query($dbConn, $sqltext);

            //取得p_id
            $getpidsql = "SELECT * FROM product WHERE `p_name` = '$p_name' ";
            $pidquery = mysqli_query($dbConn, $getpidsql);
            $piddata = mysqli_fetch_all($pidquery, MYSQLI_ASSOC);
            $p_id = $piddata[0]['p_id'];
        }

        //將上傳的圖片名稱寫入資料庫
        if (isset($newimglist)) {
            foreach ($newimglist as $key => $value) {
                $imgsql = "INSERT INTO `img_list` (`img_id`,`p_id`,`img_name`,`img_first`) VALUES (NULL, '$p_id','$value','0')";
                mysqli_query($dbConn, $imgsql);
            }
        }
        if (isset($first_img_name)) {
            $firstimgsql = "INSERT INTO `img_list` (`img_id`,`p_id`,`img_name`,`img_first`) VALUES (NULL, '$p_id','$first_img_name','1')";
            mysqli_query($dbConn, $firstimgsql);
        }




        if (!$reslut) {
            die('Error: ' . mysqli_connect_error()); //如果sql執行失敗輸出錯誤
        } else {
            echo '儲存成功!';
        }
}
