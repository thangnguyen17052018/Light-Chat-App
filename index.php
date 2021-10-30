<?php
    session_start();
    if (isset($_SESSION['id_unique'])){//Nếu người dùng đã đăng nhập rồi
        header("location: users.php");
    }
?>

<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="form register">
            <header>Light Chat App</header>
            <form action="#" enctype="multipart/form-data" autocomplete="off"> <!-- Không được quên thêm thuộc tính enctype (multipart/form-data biểu mẫu khi người dùng muốn tải lên tệp) khi sử dụng thẻ input file -->
                <div class="error-text"></div>
                <div class="name-details">
                    <div class="field input">
                        <label>Tên</label>
                        <input type="text" name="first-name" placeholder="" required>
                    </div>
                    <div class="field input">
                        <label>Họ</label>
                        <input type="text" name="last-name" placeholder="" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="" required>
                </div>
                <div class="field input">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field image">
                    <label>Ảnh đại diện</label>
                    <input type="file" name="image" required>
                </div>
                <div class="field btn">
                    <input type="submit" name="submit" value="Tiếp tục để Chat">
                </div>
            </form>
            <div class="link">Bạn đã có tài khoản? <a href="login.php"> Đăng nhập ngay</a></div>
        </section>
    </div>
    <script src="./js/pass-show-hide.js"></script>
    <script src="./js/register.js"></script>       
</body>
</html>