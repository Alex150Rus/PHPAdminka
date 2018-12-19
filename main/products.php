<?php

session_start();

function index()
{

    $sql = 'SELECT id, altName, MiniFileName, counter FROM images';
    $res = mysqli_query(connect(), $sql);

    define('DIR_IMG', 'image');

    while ($row = mysqli_fetch_assoc($res)) {
        $getStr = "?page=singleProduct&func=index&id={$row['id']}";
        $getStrSecond = "?page=basket&func=add&id={$row['id']}";
        $str .= "<div class = 'imageWrapper'><a href= " . $getStr
            . " ><img id = " . $row['id'] . " src = " . DIR_IMG . "/"
            . $row['MiniFileName'] . " width = '150px' height = '100px'  alt = " . $row['altName']
            . "></a><p>{$row['altName']}</p><p>Цена: " . $row['counter']
            . "$</p><form action='$getStrSecond' method='post'><button name = {$row['id']} value={$row['id']}>"
            . "в корзину</button></form></div>";
    }
    return $str;
}
