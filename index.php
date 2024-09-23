<?php 

require_once "header.php";

session_start();

?>

<nav class="sign_nav">
    <a href="signup.php" class="sign_nav__a">Регистрация</a>
    <a href="/" class="sign_nav__a">Вход</a>
</nav>
<div class="container">
    <div class="sign_form">
    <form action="/db/signin_db.php" method="post" class="main_cont">
        <div class="inp">
            <label for="login">Логин</label> <br>
            <input type="text" id="login" name="login" required>
        </div>

        <div class="inp">
            <label for="pass">Пароль</label> <br>
            <input type="password" id="pass" name="pass" required>
        </div>
       
        <button class="form_btn">Войти</button>
        
    </form>
    </div>
</div>

