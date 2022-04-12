<?php
require_once("connect.php");
$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $username=$inputData['username'];
        $password=md5($inputData['password']);

        

        if (strstr($username, '@')){
            $sql = "SELECT * FROM user WHERE `u_mail` = '{$username}' AND `u_password` = '{$password}'";
        }else{
            $sql = "SELECT * FROM user WHERE `u_name` = '{$username}' AND `u_password` = '{$password}'";
        }
		

        $query= mysqli_query($dbConn,$sql);
        

        
        if(mysqli_num_rows($query) > 0)
        {
            $data = mysqli_fetch_all($query, MYSQLI_ASSOC);	
            $u_name=$data[0]['u_name'];
            $id=$data[0]['u_id'];
    
            $result = Array( "is_pass" => true, "u_id" => $id, "token" => $u_name);
        }
        else{
            $result = Array( "is_pass" => false);
        }
        echo json_encode($result);
        break;

}


?>