<?php
    session_start();
    include_once "config.php";
    $id_outgoing = $_SESSION['id_unique'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    //echo $searchTerm;
    $output = "";
    $sql = mysqli_query($conn,"SELECT * FROM user WHERE NOT id_unique={$id_outgoing} AND (first_name LIKE '%{$searchTerm}%' OR last_name LIKE '%{$searchTerm}%' OR concat(first_name,' ',last_name) LIKE'%{$searchTerm}%' )");
    if (mysqli_num_rows($sql) > 0){
        include "data.php";
    } else {
        $output .= "Không tìm thấy kết quả!!!";
    }

    echo $output;
?>