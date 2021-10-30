<?php
    session_start();
    include_once "config.php"; //import file php config.php vào file hiện tại
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); //Hàm xử lí kí tự đặc biệt để tránh làm cho câu query bị lỗi cú pháp
    
    if (!empty($email) && !empty($password)){
        //Kiểm tra email và password xem có match với database chưa
        $sql = mysqli_query($conn, "SELECT * FROM user WHERE email='{$email}' AND password='{$password}'");
        if (mysqli_num_rows($sql) > 0){//Nếu matched
            $row = mysqli_fetch_assoc($sql);
            //Cập nhật status thành active nếu user login thành công
            $status = "Đang hoạt động";
            $sql2 = mysqli_query($conn, "UPDATE user SET status = '{$status}' WHERE id_unique={$row['id_unique']}");
            if ($sql2){
                $_SESSION['id_unique'] = $row['id_unique']; //Sử dụng session chúng ta sử dụng ở các file php khác
                echo "success";
            }
        } else {
            echo "Email hoặc mật khẩu không đúng !!!";
        }
    } else {
        echo "Tất cả trường không được để trống !!!";
    }
?>