<?php

function index()
{
    $sql = 'SELECT id, altName, MiniFileName, LargeJpgFileName, counter FROM images';
    $res = mysqli_query(connect(), $sql);

    define('DIR_IMG', 'image');

    while ($row = mysqli_fetch_assoc($res)) {
        $getStrDel = "?page=manageProducts&func=deleteProduct&id={$row['id']}";
        $getStrEdit = "?page=manageProducts&func=editProduct&id={$row['id']}";
        $getStrAdd = "?page=manageProducts&func=addProduct";
        $str .= "<div class = 'imageWrapper'><img id = " . $row['id'] . " src = " . DIR_IMG . "/"
            . $row['MiniFileName'] . " width = '150px' height = '100px'  alt = " . $row['altName']
            . "><form  method='post'><label>Наименование:<br>
            <input style='width: 143px' name = 'altName' type='text' value='{$row['altName']}'></label><br>
            <label>Цена: <br><input type='text' style='width: 143px' name='price' value='{$row['counter']}'>"
            . "</label><br><label>Маленькая картинка:<br>
            <input style='width: 143px' type='text' name = 'mini' value='{$row['MiniFileName']}'></label><br>"
            . "<label>Большая картинка:<br>
            <input style='width: 143px' type='text' name = 'large' value='{$row['LargeJpgFileName']}'></label><br>"
            . "<button style='margin: 2px' formaction='$getStrEdit' name = 'edit' value= 'edit'>"
            . "изменить</button><br><button style='margin: 2px' formaction='$getStrDel' name = 'delete' value='delete'>"
            . "удалить</button><br><button style='margin: 2px' formaction='$getStrAdd' name = 'add' value='add'>"
            . "добавить</button><br></form></div>";
    }
    return $str;
}

function deleteProduct()
{
    $id = $_GET['id'];
    $sql = "DELETE FROM images WHERE id = '$id'";
    mysqli_query(connect(), $sql);
    header('Location: ?page=manageProducts&func=index');
    exit;
}

function addProduct()
{
    $altName = $_POST['altName'];
    $MiniFileName = $_POST['mini'];
    $LargeJpgFileName = $_POST['large'];
    $counter = $_POST['price'];
    $sql = "INSERT  INTO images (altName, MiniFileName, LargeJpgFileName, counter) 
      VALUES ('$altName', '$MiniFileName', '$LargeJpgFileName', '$counter')";
    mysqli_query(connect(), $sql);
    header('Location: ?page=manageProducts&func=index');
    exit;
}

function editProduct()
{
    $id = $_GET['id'];
    $altName = $_POST['altName'];
    $MiniFileName = $_POST['mini'];
    $LargeJpgFileName = $_POST['large'];
    $counter = $_POST['price'];
    $sql = "UPDATE images SET altName = '$altName', MiniFileName = '$MiniFileName', 
      LargeJpgFileName = '$LargeJpgFileName', counter = '$counter' WHERE id = '$id'";
    mysqli_query(connect(), $sql);
    header('Location: ?page=manageProducts&func=index');
    exit;
}

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 19.12.2018
 * Time: 0:38
 */