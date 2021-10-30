<?php
    session_start();
    if (isset($_SESSION['id_unique'])){
        include_once "config.php";
        $id_outgoing = mysqli_real_escape_string($conn, $_POST['id_outgoing']);
        $id_incoming = mysqli_real_escape_string($conn, $_POST['id_incoming']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        if (!empty($message)){
            $sql = mysqli_query($conn, "INSERT INTO message (id_incoming_message, id_outgoing_message, message)
                                                    VALUES ({$id_incoming}, {$id_outgoing}, '{$message}')") or die();//dừng chương trình
        }
    
    } else {
        header("../login.php");
    }
?>