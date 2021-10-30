<?php
    session_start();
    if (isset($_SESSION['id_unique'])){
        include_once "config.php";
        $id_message = mysqli_real_escape_string($conn, $_POST['id_message']);
            $sql = mysqli_query($conn, 
            "UPDATE message
            SET message='Tin nhắn đã xóa'
            WHERE id_message=$id_message;
            "
            ) or die();//dừng chương trình

    } else {
        header("../login.php");
    }
?>