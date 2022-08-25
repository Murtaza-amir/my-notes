<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header("Access-Control-Allow-Headers: X-Requested-With");

include './db.php';

if($ACTION === "add"){

    $typeName = $_POST['typeName'];
    $type_color = $_POST['type_color'];
    $type_mode = $_POST['type_mode'];

    $sql = mysqli_query($conn, "INSERT INTO notes_type(user_id, type, color, mode) VALUE('{$USER_ID}', '{$typeName}', '{$type_color}', '{$type_mode}')");

    if($sql) {
        echo json_encode(array('status'=>true));
    }

}
else if($ACTION === "get"){
    $sql = "SELECT * FROM notes_type WHERE user_id = '{$USER_ID}' OR user_id = ''";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($output);
    }else {
        echo json_encode(array('status' => false, 'message' => 'No Record Found'));
    }
}
else if($ACTION === "getSingle"){

    $filter_Type_id = $_POST['filter_Type_id'];
    
    $sql = "SELECT * FROM notes_type WHERE type_id = '{$filter_Type_id}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $output = mysqli_fetch_assoc($result);
        echo json_encode($output);
    }else {
        echo json_encode(array('message' => 'No Record Found', 'status' => false));
    }
}
else if($ACTION === "update"){}
else if($ACTION === "delete"){}

?>