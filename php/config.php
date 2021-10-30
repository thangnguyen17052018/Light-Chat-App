<?php
    $conn = mysqli_connect("localhost", "root", "", "chat");
    mysqli_set_charset($conn, "utf8mb4");
    if (!$conn) {
        echo "Database not connected" . mysqli_connect_error();
    } 

?>