<?php
    session_start();
    if (isset($_SESSION['id_unique'])){//nếu người dùng đã đăng nhặp sau đó đến trang này thay vì đến trang login page
        include_once "config.php";
        $id_logout = mysqli_real_escape_string($conn, $_GET['id_logout']);
        if (isset($id_logout)){//Nếu id_logout đã được đặt
            $status = "Không hoạt động";
            //Mỗi lần người dùng đăng xuất chúng ta sẽ update status thành Không hoạt động (offline) và đến form login
            //Chúng ta sẽ update lại status thành Đang hoạt động (online) nếu user đăng nhập thành công
            $sql = mysqli_query($conn, "UPDATE user SET status = '{$status}' WHERE id_unique={$id_logout}");
            if ($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        } else {
            header("location: ../users.php");    
        }
    } else {
        header("location: ../login.php");
    }
?>