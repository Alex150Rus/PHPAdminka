<?php

session_start();

function index()
{

    if (empty($_SESSION['IS_USER']) && empty($_SESSION['IS_ADMIN'])) {
        $str = "<div><p>Добро пожаловать на регистрацию</p>
    <form action='?page=register&func=register' method='post'><label>логин:<br><input type='text' name = login>"
            . "</label><br><br><label>пароль:<br><input type='password' name='password'></label><br><br>"
            . "<button type='submit'>отправить</button></form><p>{$_SESSION['msg']}</p></div>";
        return $str;
    }
}

function register()
{

    if (!empty($_POST)) {
        $login = clearStr($_POST['login']);
        $password = md5(md5($_POST['password']));
        $sql = "SELECT login FROM users WHERE login = '$login'";
        $res = mysqli_query(connect(), $sql);
        $row = mysqli_fetch_assoc($res);

        if ($login !== $row['login']) {

            $sql = "INSERT INTO users (login, password, role) VALUES ('$login', '$password', 'user')";
            $res = mysqli_query(connect(), $sql);

            $str = $login . ', спасибо за регистрацию';
            $_SESSION['IS_USER'] = $_POST['login'];
            return $str;
        }
        $str = 'такой пользователь уже существует';
        header('Location:' . $_SERVER['HTTP_REFERER']);
        exit;
        return $_SESSION['msg'] = $str;

    }
}

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 16.12.2018
 * Time: 0:27
 */