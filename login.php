<?php
    session_start();
    if (isset($_SESSION['id_unique'])){//Nếu người dùng đã đăng nhập rồi
        header("location: users.php");
    }
?>
<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="form login">
            <header>Light Chat App</header>
            <form action="#" autocomplete="off">
                <div class="error-text"></div>
                <div class="field input">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="" required>
                </div>
                <div class="field input">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field btn">
                    <input type="submit" name="submit" value="Đăng nhập">
                </div>
            </form>
            <div class="link">Chưa có tài khoản? <a href="index.php"> Đăng ký ngay</a></div>
        </section>
    </div>
    <script src="./js/pass-show-hide.js"></script>
    <script src="./js/login.js"></script>
</body>
</html>