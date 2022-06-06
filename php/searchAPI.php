<?php

function searchAPI($sqltext, $page, $pagetotal)
{
    $dbConn = db_connect();
    $query = mysqli_query($dbConn, $sqltext);
    $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
    if (count($data) > 0) {
        $resultarray = [
            'found' => true,
            'count' => count($data),
            'list' => []
        ];
        for ($i = 0; $i < $pagetotal; $i++) {
            $index = $i + $pagetotal * ($page - 1);
            if ($index == count($data)) {
                break;
            }
            //獲取封面
            $p_id = $data[$index]['p_id'];
            $imgsqltext = "SELECT * FROM `img_list` WHERE p_id = '$p_id' AND img_first = 1";
            $imgquery = mysqli_query($dbConn, $imgsqltext);
            $imgdata = mysqli_fetch_all($imgquery, MYSQLI_ASSOC);
            if (count($imgdata) > 0) {
                $imgsrc = $imgdata[0]['img_name'];
            } else {
                $imgsrc = "notfound";
            }

            $element = [
                'p_id' => $p_id,
                //'u_id' => $data[$index]['u_id'],
                'p_name' => $data[$index]['p_name'],
                'p_unit' => $data[$index]['p_unit'],
                'img_src' => $imgsrc,
                'p_price' => $data[$index]['p_price'],
                'p_date' => $data[$index]['p_upload_date'],
                'p_city' => $data[$index]['p_city'],
                'p_amount' => $data[$index]['p_amount']
            ];
            array_push($resultarray['list'],json_encode($element));
        }
    } else {
        $resultarray = [
            'found' => false
        ];
    }
    return json_encode($resultarray);



}
