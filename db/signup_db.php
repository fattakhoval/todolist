<?php 
require_once "connect.php";


session_start();

$login = isset($_POST['login'])?$_POST['login']:false;
$pass = isset($_POST['pass'])?$_POST['pass']:false;

if($login and $pass){
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    $check = mysqli_query($con, "SELECT * FROM `user` WHERE `login` = '$login'");

    if(mysqli_num_rows($check)==0){
        $sql = mysqli_query($con, "INSERT INTO `user`(`login`, `pass`) VALUES ('$login','$hashed_password')");
        if($sql){
            header("Location: /");
        }
    }else {
        $_SESSION['message']=  'такой логин уже есть';
        header("Location: /signup.php");
        
    }
}