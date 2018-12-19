<?php


function doFeedbackAction()
{
    if (!empty($_POST['add']) && (strlen($_POST['text'])) > 0) {
        $author = clearStr($_POST['author']);
        $text = clearStr($_POST['text']);
        $productId = (int)($_GET['id']);
        $sql = "INSERT INTO feedbacks (author, text, productId) VALUES ('$author', '$text', $productId)";
        mysqli_query(connect(), $sql);
        $location = "Location: " . $_SERVER['HTTP_REFERER'];
        header($location);
        exit;
    }
    if (!empty($_POST['edit'])) {
        $getStr = $_GET['id'];
        $author = clearStr($_POST['author']);
        $text = clearStr($_POST['text']);
        $sql = "UPDATE feedbacks SET author='$author',text = '$text' WHERE id =$getStr";
        mysqli_query(connect(), $sql);
        $location = "Location: " . $_SERVER['HTTP_REFERER'];
        header($location);
        exit;
    }
    if (!empty($_POST['del'])) {
        $getStr = $_GET['id'];
        $sql = "DELETE FROM feedbacks WHERE id =$getStr";
        mysqli_query(connect(), $sql);
        $location = "Location: " . $_SERVER['HTTP_REFERER'];
        header($location);
        exit;
    }
}
