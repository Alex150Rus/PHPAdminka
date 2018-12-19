<?php
session_start();
function index()
{
    if (empty ($_SESSION['goods'])) {
        $str = "<p>Корзина пуста</p>";
    } else {

        $id = implode(', ', array_keys($_SESSION['goods']));
        $sql = "SELECT id, altName, MiniFileName, counter FROM images WHERE id IN ($id)";
        $res = mysqli_query(connect(), $sql);

        $_SESSION['arrayOrder'] = [];

        define('DIR_IMG', 'image');

        while ($row = mysqli_fetch_assoc($res)) {
            $getStr = "?page=singleProduct&func=index&id={$row['id']}";
            $getStrSecond = "?page=basket&func=add&id={$row['id']}";
            $getStrThird = "?page=basket&func=remove&id={$row['id']}";
            $str .= "<div class = 'imageWrapper'><a href= " . $getStr . " ><img id = " . $row['id']
                . " src = " . DIR_IMG . "/" . $row['MiniFileName'] . " width = '150px' height = '100px'  alt = "
                . $row['altName'] . "></a><p>{$row['altName']}</p><p>Цена: " . $row['counter']
                . "$</p><div class ='buttonsMinusBuyPlus'><form method='post'>"
                . "<button formaction='$getStrThird'>-</button>{$_SESSION['goods'][$row['id']]}"
                . "<button formaction='$getStrSecond'>+</button></form></div></div>";

            $str = "<div class = 'basketProductsWrapper'>$str</div>";

            array_push($_SESSION['arrayOrder'], ['id: ' . $row['id'] . ', price: ' . $row['counter']
                . ', q-ty: ' . $_SESSION['goods'][$row['id']]]);

        }

        $str .= "<form action='?page=basket&func=basketSendOrder' method='post'>
          <label>Имя<br><input type='text' name = 'userName' placeholder='Введите имя'><br><br>
          </label><label>Адрес<br><input type='text' maxlength='200' placeholder='Ввведите адрес' name='address'>
          </label><br><br><label>Телефон<br><input type='text' name = 'telephone' placeholder='Введите телефон'><br><br>
          <button name='sendOrder' value='Отправить заказ'>Отправить заказ</button>
          <p>{$_SESSION['msgBasket']}</p></form>";

        $str = "<div class = 'basketWrapper'>$str</div>";

        return $str;
    }
    return $str;
}

function add()
{
    $id = (int)$_GET['id'];
    if (!empty($_SESSION['goods'][$id])) {
        $_SESSION['goods'][$id] += 1;
    } else {
        $_SESSION['goods'][$id] = 1;
    }
    header('Location:' . $_SERVER['HTTP_REFERER']);
    exit;
}

function remove()
{
    $id = (int)$_GET['id'];
    if (!empty($_SESSION['goods'][$id])) {
        $_SESSION['goods'][$id] -= 1;
    }

    if ($_SESSION['goods'][$id] < 1) {
        unset($_SESSION['goods'][$id]);
    }

    header('Location:' . $_SERVER['HTTP_REFERER']);
    exit;
}

function basketSendOrder()
{
    if (strlen($_POST['userName']) != 0 && strlen($_POST['address']) != 0 && strlen($_POST['telephone']) != 0) {
        accountOrders();

        $userName = clearStr($_POST['userName']);
        $address = clearStr($_POST['address']);
        $telephone = clearStr($_POST['telephone']);
        $orderInfo = json_encode($_SESSION['arrayOrder']);
        $registeredUser = $_SESSION['IS_USER'];

        $sql = "INSERT INTO orders (userName, address, telephone, orderInfo, registeredUser, status) 
          VALUES ('$userName', '$address', '$telephone', '$orderInfo', '$registeredUser', 'new')";
        mysqli_query(connect(), $sql);

        unset($_SESSION['goods']);
    }

    $_SESSION['msgBasket'] = 'поля не заполнены';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

function accountOrders()
{
    if (!empty ($_SESSION['IS_USER'])) {
        $_SESSION['orders'] += 1;
    }
}



/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 15.12.2018
 * Time: 17:06
 */