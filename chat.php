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
        <section class="chat-area">
            <header>
                <?php
                    include_once "php/config.php";
                    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                    $sql = mysqli_query($conn, "SELECT * FROM user WHERE id_unique={$user_id}");
                    if (mysqli_num_rows($sql) > 0){
                        $row = mysqli_fetch_assoc($sql);
                    }
                ?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['image']?>" alt="">
                <div class="details">
                    <span><?php echo $row['first_name'] ." ". $row['last_name'] ?></span>
                    <p><?php echo $row['status']?></p>   
                </div>
            </header>
            <div class="chat-box">
                
            </div>
            <form action="#" class="typing-area">
            <input type="text" name="id_outgoing" id="outgoing" value="<?php echo $_SESSION['id_unique']; ?>" hidden>
            <input type="text" name="id_incoming" id="incoming" value="<?php echo $user_id; ?>" hidden>
                <label>
                    <img src="php/images/sendimage4.png" id="select-image">
                    <input type="file" id="image-upload" name="myfile" style="display:none">
                </label>
                <input type="text" name="message" class="input-field" id="mytext" placeholder="Nhập tin nhắn..." data-emojiable="true" data-emoji-input="unicode">
                <button class="send-btn"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>    
    </div>
    <script src="./js/chat.js"></script>
    <script>
        
    </script>
</body>
</html>