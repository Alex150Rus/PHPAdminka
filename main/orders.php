<?php

function renderStatus($status)
{
    $sql = "SELECT idOrder, userName, address, telephone, orderInfo, registeredUser, status 
      FROM orders WHERE status='$status' ORDER BY idOrder";
    $res = mysqli_query(connect(), $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $str .= "<div class='order'><p>заказ №:{$row['idOrder']}</p><p>Имя получателя: {$row['userName']}</p>
          <p>Адрес доставки: {$row['address']}</p><p>Контактный телефон: {$row['telephone']}</p>
          <p>Пользователь: {$row['registeredUser']}</p><p>Статус заказа: <span class='colorRed'>{$row['status']}</span>
          </p>" . showAdminMenu() . changeStatus($row['idOrder']) . "</div>";

    }
    return "<div>$str</div>";
}


function index()
{
    $status = $_POST['status'];
    return renderStatus($status);
}

;

function showAdminMenu()
{

    return "<div><form action='?page=orders&func=index' method='post'>
      <select name='status'>заказы<option value='new'>новые заказы</option>
      <option value='payed'>оплаченные заказы</option><option value='sent'>отправленные заказы</option>
      <option value='delivered'>доставленные заказы</option></select>
      <button style='margin: 5px; height: 20px' >Показать</button></form></div>";

}

function changeStatus($id)
{

    return "<div><form action='?page=orders&func=baseRequest&id=$id' method='post'>
      <select name='status'>заказы<option value='new'>новый заказ</option>
      <option value='payed'>оплаченный заказ</option>
      <option value='sent'>отправленный заказ</option>
      <option value='delivered'>доставленный заказ</option>
      </select><button style='margin: 5px; height: 20px' >Изменить статус</button>
      <br><button name='delete' value='delete'>Удалить заказ</button></form></div>";

}


function baseRequest()
{
    if (empty($_POST['delete'])) {
        $id = $_GET['id'];
        $status = $_POST['status'];
        $sql = "UPDATE orders SET status = '$status' WHERE idOrder = '$id'";
        mysqli_query(connect(), $sql);
        header('Location:?page=account');
        exit;
    } else {
        $id = $_GET['id'];
        $sql = "DELETE FROM orders WHERE idOrder = '$id'";
        mysqli_query(connect(), $sql);
        header('Location: ?page=account');
        exit;
    }
}
