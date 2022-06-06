<?php
require_once("connect.php");
$dbConn = db_connect();
$target_dir = "../img_data/member/";

switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":


        $inputData = json_decode($_POST['member_data'], true);

        if (isset($_FILES['img']['error'])) {
            $name = $_FILES['img']['name'];
            $splitstr = explode(".", $name);
            $ext = end($splitstr);
            $fileName = uuid() . "." . $ext;
            $target_file = $target_dir . $fileName;
            move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
        }


        $location = $inputData["location"];
        $phone = $inputData["phone"];
        $description = $inputData["description"];
        $u_id = $inputData["u_id"];
        $name = $inputData["name"];



        $search = mysqli_query($dbConn, "SELECT * FROM `member` WHERE `u_id` = '$u_id'");
        if (mysqli_num_rows($search) == 0) {

            $sql = "INSERT INTO `member` (`m_location`, `m_phone`, `m_introduction`, `u_id` , `m_img`, `m_name`) VALUES ('$location', '$phone', '$description', '$u_id', '$fileName', '$name')";
        } else {
            if (isset($fileName)) {
                $sql = "UPDATE `member` SET `m_name` = '$name', `m_location` = '$location' , `m_phone` = '$phone' , `m_introduction` = '$description', `m_img` = '$fileName'  WHERE `member`.`u_id` = '$u_id'";
                $oldimg = mysqli_fetch_all($search,MYSQLI_ASSOC)[0]['m_img'];
                if (file_exists($target_dir.$oldimg)){
                    unlink($target_dir.$oldimg);
                }
               



            }else{
                $sql = "UPDATE `member` SET  `m_name` = '$name', `m_location` = '$location' , `m_phone` = '$phone' , `m_introduction` = '$description' WHERE `member`.`u_id` = '$u_id'";
            }
        }

        $reslut = mysqli_query($dbConn, $sql);

        if (!$reslut) {
            die('Error: ' . mysqli_connect_error()); //如果sql執行失敗輸出錯誤
        } else {
            echo '儲存成功!';
        }
}
