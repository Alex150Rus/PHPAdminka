<?php

session_start();
include('feedback.php');

function index()
{
    $getStr = $_GET['id'];
    $sql = "SELECT id, altName, LargeJpgFileName, counter FROM images WHERE id=$getStr";
    $res = mysqli_query(connect(), $sql);

    define('DIR_IMG', '../image');
    while ($row = mysqli_fetch_assoc($res)) {
        $getStrSecond = "?page=basket&func=add&id={$row['id']}";
        $getStrThird = "?page=basket&func=remove&id={$row['id']}";
        $str = "<div><p>Цена: " . $row['counter'] . "$</p><p>Количество: {$_SESSION['goods'][$row['id']]}</p>"
            . "<div class='buttonsMinusBuyPlus'><form method='post'><button formaction='$getStrThird'>-</button>"
            . "<button formaction='$getStrSecond'>в корзину</button><button formaction='$getStrSecond'>+</button>"
            . "</form></div><img src = " . DIR_IMG . "/" . $row['LargeJpgFileName']
            . " width = '400' height= '200px' alt = " . $row['altName'] . "></div>";

    }

    $str .= showFeedBacks();
    $str = "<div class = 'product'>$str</div>";
    return $str;
}

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 15.12.2018
 * Time: 16:12
 */