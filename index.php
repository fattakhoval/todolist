<?php 

require_once "header.php";

session_start();

?>

<nav class="sign_nav">
    <a href="signup.php" class="sign_nav__a">регистрация</a>
    <a href="/" class="sign_nav__a">вход</a>
</nav>
<div class="container">
    <div class="sign_form">
    <form action="/db/signin_db.php" method="post" class="main_cont">
        <div class="inp">
            <label for="login">login</label> <br>
            <input type="text" id="login" name="login">
        </div>

        <div class="inp">
            <label for="pass">password</label> <br>
            <input type="password" id="pass" name="pass">
        </div>
       
        <button class="form_btn">войти</button>
        
    </form>
    </div>
</div>

