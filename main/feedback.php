<?php
include('crud.php');

if (!empty($_POST)) {

    doFeedbackAction($_POST);

}

function showFeedBacks()
{
    $getStr = $_GET['id'];
    $sql = "SELECT id, author, text, productID FROM feedbacks WHERE productID = $getStr";
    $res = mysqli_query(connect(), $sql);

    if ($_SESSION['IS_ADMIN']) {
    $feedBacks = " 
    <form action='?page=crud&func=doFeedbackAction&id=$getStr' method='post'>
  <label for='author'>Автор:<br>
    <input id='author' type='text' name='author'><br>
  </label>
  <label for='feedback'>Отзыв:<br>
    <textarea id='feedback' cols='150' rows='5' maxlength='750' name='text'></textarea><br>
  </label><br>
  <button value='add' name='add'>добавить</button>
</form>";

    while ($row = mysqli_fetch_assoc($res)) {
        $feedBacks .= "<hr>
    <form action='?page=crud&func=doFeedbackAction&id={$row['id']}' method='post'>
    <label for='author'>Автор:<br>
        <input id='author' type='text' name='author' value='{$row['author']}'><br>
    </label>
    <label for='feedback'>Отзыв:<br>
        <textarea id='feedback' cols='150' rows='5' maxlength='750' name='text' >{$row['text']}</textarea><br>
    </label><br>
    <button value = 'edit' name = 'edit'>редактировать</button>
    <button value = 'del' name = 'del'>удалить</button>
</form>";
    }

    return $feedBacks;
    } else {
        $feedBacks = " 
    <form action='?page=crud&func=doFeedbackAction&id=$getStr' method='post'>
  <label for='author'>Автор:<br>
    <input id='author' type='text' name='author'><br>
  </label>
  <label for='feedback'>Отзыв:<br>
    <textarea id='feedback' cols='150' rows='5' maxlength='750' name='text'></textarea><br>
  </label><br>
  <button  value='add' name='add'>добавить</button>
</form>";

        while ($row = mysqli_fetch_assoc($res)) {
            $feedBacks .= "<hr>
    <form action='?id=$getStr&id2={$row['id']}' method='post'>
    <label for='author'>Автор:<br>
        <input id='author' type='text' name='author' value='{$row['author']}'><br>
    </label>
    <label for='feedback'>Отзыв:<br>
        <textarea id='feedback' cols='150' rows='5' maxlength='750' name='text' >{$row['text']}</textarea><br>
    </label><br>
</form>";
        }

        return $feedBacks;
    }
}

?>

