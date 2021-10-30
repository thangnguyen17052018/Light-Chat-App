<?php 
    session_start();
    if (isset($_SESSION['id_unique'])){
        include_once "config.php";
        $id_outgoing = mysqli_real_escape_string($conn, $_POST['id_outgoing']);
        $id_incoming = mysqli_real_escape_string($conn, $_POST['id_incoming']);
        $output = "";
        
        $sql = "SELECT * 
                FROM message
                LEFT JOIN user ON user.id_unique = message.id_outgoing_message /*  trả về tất cả các bản ghi từ bảng bên trái (bảng message), ngay cả khi không có kết quả phù hợp với thông tin trong bảng bên phải (user). */ 
                WHERE (id_outgoing_message = {$id_outgoing} AND id_incoming_message = {$id_incoming})
                OR (id_outgoing_message = {$id_incoming} AND id_incoming_message = {$id_outgoing}) ORDER BY id_message"; 
        $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0){
            while ($row = mysqli_fetch_assoc($query)){
                if ($row['id_outgoing_message'] === $id_outgoing){//Nếu bằng thì chính là người gửi tin nhắn
                    if ($row['message']=='Tin nhắn đã xóa'){
                        $output .= '<div class="chat outgoing">
                                        <div class="details">
                                        <button class="delete-btn" id="'.$row['id_message'].'"><i class="far fa-minus-square"></button></i><p style="background-color: #f77373">'. $row['message'] .'</p>
                                        </div>
                                    </div>';
                    } else if ($row['type']!=null){ //Trường hợp ảnh
                        $output .= '<div class="chat outgoing">
                                        <div class="details">
                                        <button class="delete-btn" id="'.$row['id_message'].'"><i class="far fa-minus-square"></button></i><p><img src="php/images/'. $row['message'] .'" alt=""></p>
                                        </div>
                                    </div>';
                        } else {
                            $output .= '<div class="chat outgoing">
                                            <div class="details">
                                            <button class="delete-btn" id="'.$row['id_message'].'"><i class="far fa-minus-square"></button></i><p>'. $row['message'] .'</p>
                                            </div>
                                        </div>';
                        }
                } else { //người nhận tin nhắn
                    if ($row['message']=='Tin nhắn đã xóa'){
                        $output .= '<div class="chat incoming">
                                        <img id="ava" src="php/images/'. $row['image'] .'" alt="">
                                        <div class="details">
                                        <p style="background-color: #f77373">'. $row['message'] .'</p><button class="delete-btn" id="'.$row['id_message'].'"><i class="far fa-minus-square"></button></i>
                                        </div>
                                    </div>';
                    } else if ($row['type']!=null){ //Trường hợp ảnh
                        $output .= '<div class="chat incoming">
                                        <img id="ava" src="php/images/'. $row['image'] .'" alt="">
                                        <div class="details">
                                        <p> <img src="php/images/'. $row['message'] .'" alt=""></p><button class="delete-btn" id="'.$row['id_message'].'"><i class="far fa-minus-square"></button></i>
                                        </div>
                                    </div>';
                        } else { 
                        $output .= '<div class="chat incoming">
                                        <img id="ava" src="php/images/'. $row['image'] .'" alt="">
                                        <div class="details">
                                        <p>'. $row['message'] .'</p><button class="delete-btn" id="'.$row['id_message'].'"><i class="far fa-minus-square"></button></i>
                                        </div>
                                    </div>';
                    }
                }
            }
            echo $output;
        }    
} else {
        header("../login.php");
    }
?>