<?php


require_once("../connect.php");
$dbConn = db_connect();
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        //$body = file_get_contents('php://input');
        //$inputData = json_decode($body, true);

        $p_id = $_GET["p_id"];

        $sql = "SELECT * FROM product WHERE `p_id` = '{$p_id}'";

        $query = mysqli_query($dbConn, $sql);

        
        //抓取圖片檔名
        $imgsql = "SELECT * FROM img_list WHERE `p_id` = '$p_id'";
        $imgquery = mysqli_query($dbConn, $imgsql);
        $imgdata = mysqli_fetch_all($imgquery, MYSQLI_ASSOC);
        $imgdataAmount = count($imgdata);
        $imgsrc="";
        $imgfirst='';
        for ($i=0; $i < $imgdataAmount; $i++) { 
            if ($imgdata[$i]['img_first']==1){
                $imgfirst = $imgdata[$i]['img_name'];
            }else{
                $imgsrc = $imgsrc.",".$imgdata[$i]['img_name'];
            }
            
        }

        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_all($query, MYSQLI_ASSOC);

            $u_id = $data[0]['u_id'];
            $districts = $data[0]['p_districts'];
            $trade_type = $data[0]['p_trade_type'];
            $name = $data[0]['p_name'];
            $price = $data[0]['p_price'];
            $unit = $data[0]['p_unit'];
            $introduction = $data[0]['p_introduction'];
            $amount = $data[0]['p_amount'];
            $city = $data[0]['p_city'];
            $type = $data[0]['p_type'];
            $date = $data[0]['p_upload_date'];



            $result = array(

                "p_id" => $p_id,
                "u_id" => $u_id,
                "img_src" => $imgfirst.$imgsrc,
                "type" => $type,
                "city" => $city,
                "districts"=>$districts,
                "name" => $name,
                "price" => $price,
                "unit" => $unit,
                "amount" => $amount,
                "introduction" => $introduction,
                "trade_type"=>$trade_type,
                "date"=>$date
                
            
            );
        }
        echo json_encode($result);
        return;
}
