<?php
function connect()
{
    static $link;
    if (empty($link)) {
        $link = mysqli_connect('localhost', 'root', '', 'gallery');
    }
    return $link;
}

function clearStr($str)
{
    return mysqli_real_escape_string(connect(), strip_tags(trim($str)));
}

?>