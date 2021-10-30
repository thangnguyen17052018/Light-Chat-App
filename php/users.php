<?php 
    session_start();
    include_once "config.php";
    $id_outgoing = $_SESSION['id_unique'];
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE NOT id_unique={$id_outgoing}");
    $output = "";
    if (mysqli_num_rows($sql) == 1){
        $output .= "Không có người dùng để chat";
    } elseif (mysqli_num_rows($sql) > 0){
        include "data.php";
    }
    echo $output;
?>