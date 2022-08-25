<?php

session_start();

$conn = mysqli_connect("localhost", "root", "", "notes") or die("Connection Error!");

$ACTION = $_GET['action'];
$USER_ID = $_SESSION['userId'];
$USER_NAME = $_SESSION['userName'];
$USER_EMAIL = $_SESSION['userEmail'];

?>