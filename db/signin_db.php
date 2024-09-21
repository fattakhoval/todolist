<?php 
require_once "connect.php";
session_start();

$login = isset($_POST['login'])?$_POST['login']:false;
$pass = isset($_POST['pass'])?$_POST['pass']:false;
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

if($login and $pass){

    
    $check = mysqli_query($con, "SELECT * FROM `user`");

    if(mysqli_num_rows($check)!=0){

        $sql = mysqli_query($con, "SELECT * FROM `user` WHERE `login` = '$login'");

        if($sql){
            $user = mysqli_fetch_assoc($sql);

            if($login = $user['login']){
                if (password_verify($pass, $hashed_password)){
                      $_SESSION['id_user'] = $user['id_user'];
                header("Location: ../test.php");
                }else{
                    echo"<script>alert('ошибка пароля')</script>";
                }
              
            }

        }
    }
}

?>