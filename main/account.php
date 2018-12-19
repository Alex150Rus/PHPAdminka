<?php

session_start();

function index()
{
    $login = clearStr($_POST['login']);
    $password = md5(md5($_POST['password']));
    $sql = "SELECT login, password, role FROM users WHERE login = '$login'";
    $res = mysqli_query(connect(), $sql);
    $row = mysqli_fetch_assoc($res);

    if (!empty($_POST) && $row['login'] === $login && $row['password'] === $password) {
        if ($row['role'] === "admin") {
            $_SESSION['IS_ADMIN'] = $_POST['login'];
            $str = "<div><div><p>{$_SESSION['IS_ADMIN']}(администратор), добро пожаловать в личный кабинет</p>
              <a class='center' href=\"?page=index&func=userExit\">Выйти</a>
              <a class='center' href=\"?page=manageProducts&func=index\">Работа с товарами</a>
              <p>История заказов:</p></div>" . showAdminMenu() . showHistory() . "</div>";
            return $str;
        } else {
            $_SESSION['IS_USER'] = $_POST['login'];

            $str = "<div><div><p>$login, добро пожаловать в личный кабинет</p>
              <a class='center' href=\"?page=index&func=userExit\">Выйти</a><p>История заказов:</p>
              </div>" . showHistory() . "</div>";

            unset($_SESSION['msg']);
            return $str;
        }
    } elseif (!empty($_GET) && (!empty($_SESSION['IS_USER']) || !empty($_SESSION['IS_ADMIN']))) {
        if (!empty($_SESSION['IS_ADMIN'])) {
            $str = "<div><div><p>{$_SESSION['IS_USER']}{$_SESSION['IS_ADMIN']}, добро пожаловать в личный кабинет</p>
              <a class='center' href=\"?page=index&func=userExit\">Выйти</a>
              <a class='center' href=\"?page=manageProducts&func=index\">Работа с товарами</a>
              <p>История заказов:</p></div>" . showAdminMenu() . showHistory() . "</div>";
            return $str;
        } else {
            $str = "<div><div><p>{$_SESSION['IS_USER']}{$_SESSION['IS_ADMIN']}, добро пожаловать в личный кабинет</p>
              <a class='center' href=\"?page=index&func=userExit\">Выйти</a>
              <p>История заказов:</p></div>" . showHistory() . "</div>";
            return $str;
        }
    }
    $_SESSION['msg'] = 'неверное имя пользователя или пароль';
    header('Location: ?page=index');
    exit;
}

function showHistory()
{
    if ($_SESSION['IS_USER']) {
        $user = $_SESSION['IS_USER'];
        return renderOrders($user);

    } else {
        $user = $_SESSION['IS_ADMIN'];
        return renderOrders($user);
    }

}

function renderOrders($user)
{
    $sql = "SELECT idOrder, userName, address, telephone, orderInfo,
      registeredUser, status FROM orders WHERE registeredUser='$user' ORDER BY idOrder DESC ";
    $res = mysqli_query(connect(), $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $str .= "<div class='order'><p>заказ №:{$row['idOrder']}</p><p>Имя получателя: {$row['userName']}</p>
          <p>Адрес доставки: {$row['address']}</p><p>Контактный телефон: {$row['telephone']}</p>
          <p>Пользователь: {$row['registeredUser']}</p><p>Статус заказа: <span class='colorRed'>{$row['status']}</span>
          </p></div>";

    }

    return "<div>$str</div>";
}

function showAdminMenu()
{

    return "<div><form action='?page=orders&func=ordersStatus' method='post'>
      <select name='status'>заказы<option value='new'>новые заказы</option>
      <option value='payed'>оплаченные заказы</option><option value='sent'>отправленные заказы</option>
      <option value='delivered'>доставленные заказы</option></select>
      <button style='margin-left: 10px; height: 20px' >Показать</button></form></div>";

}
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 15.12.2018
 * Time: 22:53
 */