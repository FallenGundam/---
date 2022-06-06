<?php

require_once("../connect.php");

$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":

        $target_dir = "../../img_data/"; //圖片庫


        $p_id=$_POST['p_id'];


  
        //刪除照片
        $get_image_name_sql = "SELECT * FROM img_list WHERE `p_id` = '{$p_id}'";
        $get_image_name=mysqli_query($dbConn,$get_image_name_sql); //取得相片名稱
        

        //刪除該商品的所有圖片
        if(mysqli_num_rows($get_image_name) > 0){
            
            $data = mysqli_fetch_all($get_image_name, MYSQLI_ASSOC);	
            $total=mysqli_num_rows($get_image_name);
            for ($i=0; $i < $total; $i++) { 
               //$data[$i]['i_name']
               $filename= $target_dir . $data[$i]['img_name'];
               if(file_exists($filename)){
                  unlink($filename);
               }
            }
        }


        //刪除資料表
        $sql = "DELETE FROM `product` WHERE `product`.`p_id` = '$p_id'";

        $reslut=mysqli_query($dbConn,$sql);  


        if (!$reslut){
            die('Error: ' . mysqli_connect_error());//如果sql執行失敗輸出錯誤
        }else{
            echo '成功刪除 ';
        }



}
