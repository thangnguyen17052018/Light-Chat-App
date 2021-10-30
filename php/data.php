<!-- Vì user list và search term dùng cùng 1 code hiển thị  -->
<?php 
    while($row = mysqli_fetch_assoc($sql)){
        $sql2 = "SELECT * FROM message WHERE (id_incoming_message = {$row['id_unique']}
                OR id_outgoing_message = {$row['id_unique']}) AND (id_outgoing_message = {$id_outgoing}
                OR id_incoming_message = {$id_outgoing}) ORDER BY id_message DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        
        if (mysqli_num_rows($query2) > 0){
            if($row2['type']!=null){
                $result="Tin nhắn dạng hình ảnh";
            } else {
                $result = $row2['message'];
            }
        } else {
                $result = "Không có tin nhắn hiển thị";    
        }

    /* trimming message if word are more than 40 */
        (strlen($result) > 36) ? $message = substr($result, 0,36).'...' : $message =  $result;
        $you ="";
        if (isset($row2)){
           ($id_outgoing == $row2['id_outgoing_message']) ? $you = "Bạn: " : $you = "";
        }

        //Kiểm tra người dùng online hay offline
        ($row['status'] == "Không hoạt động") ? $offline = "off" : $offline ="";


        $output .= '<a href="chat.php?user_id='. $row['id_unique'].'">
                    <div class="content">
                        <img src="php/images/'. $row['image'] .'" alt="">
                        <div class="details">
                            <span>'. $row['first_name'] ." ". $row['last_name'] .'</span>
                            <p>'. $you . $message .'</p>
                        </div>
                    </div>
                    <div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
                    </a>';
    }
?>       

