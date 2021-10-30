<?php
    session_start();
    include_once "config.php"; //import file php config.php vào file hiện tại
    //Kiểm tra người dùng có upload tệp chưa
    $id_outgoing = mysqli_real_escape_string($conn, $_POST['id_outgoing']);
    $id_incoming = mysqli_real_escape_string($conn, $_POST['id_incoming']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (isset($_FILES['myfile'])){//Nếu file đã upload
        $img_name = $_FILES['myfile']['name']; //Lấy tên ảnh người dùng đã upload 
        $img_type = $_FILES['myfile']['type']; //Lấy kiểu ảnh người dùng
        $tmp_name = $_FILES['myfile']['tmp_name']; //Tên tạm thời được sử dụng để lưu/di chuyển file trong thư mục của chúng ta
    
        //explode image (chuyển tên file img thành các phần tử trong mảng) và lấy phần mở rộng của file ảnh (png, jpeg, jpg)
        $img_explode = explode('.', $img_name);//Chuyển tên file thành mảng mỗi phần tử được xác định qua dấu . ở đây là tên file và phần mở rộng
        $img_ext = end($img_explode); //Lấy phần tử của của mảng img_explode (phần mở rộng) 
    
        $extensions = ['png', 'jpeg', 'jpg'];
        if (in_array($img_ext, $extensions) == true){ //Nếu phần mở rộng của ảnh mà người dùng up lên match với phần tử trong mảng extensions
            $time = time(); //Trả về thời gian hiện tại..
                            //Chúng ta cần thời gian này bởi vì khi mình up file ảnh vào trong folder thì chúng ta đặt tên file với current time (unique)
                            //Vì thế tất cả các file ảnh sẽ unique
            //Chuyển file đã upload vào 1 thư mục cụ thể 
            //Chúng ta không lưu file ở database mà chỉ save URL. File thực tế sẽ lưu trữ ở 1 thư mục cụ thể               
            $new_img_name = $time.$img_name; //current time (concat with) tên file ảnh để đề phòng trường hợp người dùng tải cả 2 ảnh khác nhau cùng tên
            if (move_uploaded_file($tmp_name, "images/".$new_img_name)){ //nếu ảnh người dùng upload di chuyển vào thư mục thành công
                //Insert tất cả dữ liệu user vào bảng
                $sql2 =  mysqli_query($conn, "INSERT INTO message (id_incoming_message, id_outgoing_message, message, type)
                                                            VALUES ({$id_incoming}, {$id_outgoing}, '{$new_img_name}','image')");
            }
        } else {
            echo "Vui lòng chọn file ảnh - png, jpg, jpeg !!!";
        }
    }

?> 