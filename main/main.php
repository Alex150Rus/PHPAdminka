<?php
session_start();
$dir = __DIR__ . '/';
include($dir . 'connect.php');

$page = !empty($_GET['page']) ? $_GET['page'] : 'index';
$func = !empty($_GET['func']) ? $_GET['func'] : 'index';

if (file_exists($dir . $page . '.php')) {
    include($dir . $page . '.php');
};

if (!function_exists($func)) {
    $func = 'index';
};

$links = '<ul class="menu">
  <li class="menuList"><a class = "menuListLink" href="?page=index&func=index">Главная</a></li>
  <li class="menuList"><a class = "menuListLink" href="?page=account&func=index"><span class = "qty">_oqy</span>Личный кабинет</a></li>
  <li class="menuList"><a class = "menuListLink" href="?page=register&func=index">Зарегистрироваться</a></li>
  <li class="menuList"><a class = "menuListLink" href="?page=products&func=index">Товары</a></li>
  <li class="menuList"><a class = "menuListLink" href="?page=basket&func=index">
  <span class = "qty">_qy</span>Корзина</a></li>
</ul>';

$patternFile = __DIR__ . '/' . 'pattern.html';
if (file_exists($patternFile)) {

    $html = file_get_contents($patternFile);
    $html = str_replace('linksPhp', $links, $html);
    $html = str_replace('contentPhp', $func(), $html);
    $html = str_replace('_qy', count($_SESSION['goods']), $html);
    $html = str_replace('_oqy', ($_SESSION['orders']), $html);
    echo $html;
}

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 15.12.2018
 * Time: 14:11
 */