<?php
session_start();


function index()
{
    if (empty($_SESSION['IS_USER']) && empty($_SESSION['IS_ADMIN'])) {
        $str = "<div><p>Добро пожаловать</p>
    <form action='?page=account&func=index' method='post'><label>логин:<br><input type='text' name = login></label><br><br>
    <label>пароль:<br><input type='password' name='password'></label><br><br>
    <button type='submit'>отправить</button></form><p>{$_SESSION['msg']}</p></div>";
        return $str;
    } else {
        $str = '<p><a href="?page=index&func=userExit">Выйти</a></p>';
        return $str;
    }
}

function userExit()
{
    unset ($_SESSION['orders.php']);
    unset($_SESSION['IS_USER']);
    unset($_SESSION['IS_ADMIN']);
    session_destroy();
    header('Location: ?');
    exit;
}

?>