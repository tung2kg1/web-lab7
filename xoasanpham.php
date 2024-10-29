<?php
    require('ketNoiDatabase.php');
    $id = $_GET['id'];
    $img = 'SELECT imgURL FROM sanpham WHERE masp = '.$id;
    $query = mysqli_query($conn, $img);
    $after = mysqli_fetch_assoc($query);

    if (file_exists('./images/' . $after['imgURL'])) {
        unlink('./images/' . $after['imgURL']);
    }

    $sql = "DELETE FROM sanpham WHERE masp = '$id'";
    mysqli_query($conn, $sql);
    header("Location: trangchu.php");
?>