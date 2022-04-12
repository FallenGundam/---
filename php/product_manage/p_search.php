




<?php
//取得使用者所有以建立的商品


require_once("../connect.php");
$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $u_id=$inputData['u_id'];
        $searchstr=$inputData['searchstr'];

        if($searchstr==""){
            $sql = "SELECT * FROM product WHERE `u_id` = '{$u_id}'";
        }else{
            $sql = "SELECT * FROM product WHERE `u_id` = '{$u_id}'";
        }

        $query= mysqli_query($dbConn,$sql);
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);	
        if(mysqli_num_rows($query) > 0){
            $total=mysqli_num_rows($query);
            $finalarray=array();
            for ($i=0; $i < $total; $i++) { 
                $name= $data[$i]['p_name'];
                $price= $data[$i]['p_price'];
                $id=$data[$i]['p_id'];
                $unit=$data[$i]['p_unit'];
                $introduction=$data[$i]['p_introduction'];
                $city=$data[$i]['p_city'];
                $amount=$data[$i]['p_amount'];
                $result = Array( "count"=>$i+1,"id"=>$id, "name" => $name, "price" => $price, "unit" => $unit,
                "introduction" => $introduction,"city" => $city,"amount"=>$amount);
                
                array_push($finalarray,json_encode($result));
            }
            

            
        }
        else{
            $finalarray = Array( "is_pass" => false);
        }
        echo json_encode($finalarray);
 }

        








?>