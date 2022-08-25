<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header("Access-Control-Allow-Headers: X-Requested-With");

include './db.php';

if($ACTION === "add"){

    $typeId = $_POST['typeId'];
    $noteText = str_replace("'", "''", $_POST['noteText']);
    $date = date("M j, Y");

    $sql = mysqli_query($conn, "INSERT INTO notes(users_id, note_text, note_type, date) VALUE('{$USER_ID}','{$noteText}', '{$typeId}', '{$date}')");

    if($sql) {
        echo json_encode(array('status'=>true));
    }

}
else if($ACTION === "getSingle"){

    $noteID = $_POST['noteID'];
    $sql = "SELECT * FROM notes LEFT JOIN notes_type ON notes.note_type = notes_type.type_id WHERE id = '{$noteID}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $output = mysqli_fetch_assoc($result);
        echo json_encode($output);
    }else {
        echo json_encode(array('message' => 'No Record Found', 'status' => false));
    }

}
else if($ACTION === "getFilter"){

    $filter_Type_id = $_POST['filter_Type_id'];
    $sql = "SELECT * FROM notes WHERE note_type = '{$filter_Type_id}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($output);
    }else {
        echo json_encode(array('message' => 'No Record Found', 'status' => false));
    }

}
else if($ACTION === "search"){

    $search_value = str_replace("'", "''", $_POST['search_value']);
    
    $result = mysqli_query($conn, "SELECT * FROM notes LEFT JOIN notes_type ON notes.note_type = notes_type.type_id WHERE note_text LIKE '%{$search_value}%' AND users_id = '{$USER_ID}'");
    if(mysqli_num_rows($result) > 0){
        $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($output);
    }else {
        echo json_encode(array('message' => 'No Record Found', 'status' => false));
    }

}
else if($ACTION === "get"){
    $sql = "SELECT * FROM notes LEFT JOIN notes_type ON notes.note_type = notes_type.type_id WHERE users_id = '{$USER_ID}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($output);
    }else {
        echo json_encode(array('message' => 'No Record Found', 'status' => false));
    }
}
else if($ACTION === "update"){

    $editNoteId = $_POST['editNoteId'];
    $editTypeId = $_POST['editTypeId'];
    $editTypeText = $_POST['editTypeText'];
    $date = date("M j, Y");

    $sql = mysqli_query($conn, "UPDATE notes SET note_text = '{$editTypeText}', note_type = '{$editTypeId}', date = '{$date}' WHERE id = '{$editNoteId}'");
   
    if($sql) {
        echo json_encode(array('status'=>true));
    }

}
else if($ACTION === "delete"){

    $noteID = $_POST['noteID'];

    $sql = mysqli_query($conn, "DELETE FROM notes WHERE id = '{$noteID}'");

    if($sql) {
        echo json_encode(array('status'=>true));
    }

}

?>