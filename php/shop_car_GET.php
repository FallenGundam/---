<?php


require_once("connect.php");

$dbConn = db_connect();



switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $u_id = $_GET["u_id"];
        $sql = "SELECT * FROM shop_car WHERE `u_id` = '{$u_id}'";
        $query = mysqli_query($dbConn, $sql);
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
        $result = array();
        if (count($data)>0){
            for ($i=0; $i <count($data) ; $i++) { 
                $p_id = $data[$i]['p_id'];
                $sqltemp = "SELECT * FROM product WHERE `p_id` = '$p_id' ";
                $pidquery = mysqli_query($dbConn, $sqltemp);
                $piddata = mysqli_fetch_all($pidquery, MYSQLI_ASSOC);

                $name = $piddata[0]['p_name'];
                $amount = $piddata[0]['p_amount'];
                $city = $piddata[0]['p_city'];


                $sqltemp2 = "SELECT * FROM img_list WHERE `p_id` = '$p_id' ";
                $imgquery = mysqli_query($dbConn, $sqltemp2);
                $imgdata = mysqli_fetch_all($imgquery, MYSQLI_ASSOC);
                if (count($imgdata)>0){
                    for ($j=0; $j < count($imgdata) ; $j++) { 
                        if ($imgdata[$j]['img_first'] == 1) {
                            $img_src = $imgdata[$j]['img_name'];
                        }
                    }
                }



                $temp = [
                    'p_id' => $p_id,
                    'name' => $name,
                    'amount' => $amount,
                    'city' => $city,
                    'img_src' => $img_src
                ];

                array_push($result,json_encode($temp));
            }
        }
        echo json_encode($result);




    }

?>