<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header("Access-Control-Allow-Headers: X-Requested-With");

include './db.php';

$ACTION = $_GET['action'];

if($ACTION === "login"){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' && password = '{$password}'");
    
    if(mysqli_num_rows($sql) > 0){
        
        $output = mysqli_fetch_assoc($sql);
        
        session_start();

        $_SESSION['userId'] = $output['id'];
        $_SESSION['userName'] = $output['name'];
        $_SESSION['userEmail'] = $output['email'];

        echo json_encode(array('status' => true));
    }else {
        echo json_encode(array('status' => false, 'message' => 'Email or Password is Incorrect!'));
    }
    
}else if($ACTION === "signup") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $isUser = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

    if(mysqli_num_rows($isUser) > 0) {
        echo json_encode(array('status' => false, 'message' => 'User Already Exist! Please use Another Email...'));
    }else{
        $sql = mysqli_query($conn, "INSERT INTO users(name, email, password) VALUE('{$name}', '{$email}', '{$password}')");
        if($sql) {
            echo json_encode(array('status'=>true));
        }
    }



}

?>