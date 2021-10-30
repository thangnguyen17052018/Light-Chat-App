<?php 
    session_start();
    if (!isset($_SESSION['id_unique'])){
        header("location: login.php");
    }
    //=>Nếu user chưa login vào thì không thể truy cập vào bên trong trang user
?>

<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="users">
            <header>
            <?php
                include_once "php/config.php";
                $sql = mysqli_query($conn, "SELECT * FROM user WHERE id_unique={$_SESSION['id_unique']}");
                if (mysqli_num_rows($sql) > 0){
                    $row = mysqli_fetch_assoc($sql);

                }
            ?>
                <div class="content">
                    <img src="php/images/<?php echo $row['image']?>" alt="">
                    <div class="details">
                        <span><?php echo $row['first_name'] ." ". $row['last_name'] ?></span>
                        <p><?php echo $row['status']?></p>
                    </div>       
                </div>
                <a href="php/logout.php?id_logout=<?php echo $row['id_unique']?>" class="logout">Đăng xuất</a>
            </header>    
            <div class="search">
                <span class="text">Chọn người dùng để chat</span>
                <input type="text" placeholder="Nhập tên để tìm....">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                
            </div>
        </section>    
    </div>
    <script src="./js/users.js"></script>
</body>
</html>