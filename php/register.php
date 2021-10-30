<?php
    session_start();
    include_once "config.php"; //import file php config.php vào file hiện tại
    $fname = mysqli_real_escape_string($conn, $_POST['first-name']);
    $lname = mysqli_real_escape_string($conn, $_POST['last-name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); //Hàm xử lí kí tự đặc biệt để tránh làm cho câu query bị lỗi cú pháp

    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        //Kiểm tra xem email người dùng có hợp lệ hay không
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {//Nếu email hợp lệ
            //Kiểm tra xem email có tồn tại trong database chưa
            $sql = mysqli_query($conn, "SELECT email FROM user WHERE email = '{$email}'");
            if (mysqli_num_rows($sql) > 0){//Nếu email đã tồn tại
                echo "$email - Email đã tồn tại";
            } else {
                //Kiểm tra người dùng có upload tệp chưa
                if (isset($_FILES['image'])){//Nếu file đã upload
                    $img_name = $_FILES['image']['name']; //Lấy tên ảnh người dùng đã upload 
                    $img_type = $_FILES['image']['type']; //Lấy kiểu ảnh người dùng
                    $tmp_name = $_FILES['image']['tmp_name']; //Tên tạm thời được sử dụng để lưu/di chuyển file trong thư mục của chúng ta
                
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
                            $status = "Đang hoạt động"; //Mỗi lần người dùng đăng kí thì trạng thái sẽ là Đang hoạt động
                            $random_id = rand(time(), 10000000); //Tạo id randome cho user  
                            
                            //Insert tất cả dữ liệu user vào bảng
                            $sql2 =  mysqli_query($conn, "INSERT INTO user (id_unique, first_name, last_name, email, password, image, status) 
                                                  VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");
                            if ($sql2){//Nếu dữ liệu đã được insert
                                $sql3 = mysqli_query($conn, "SELECT * FROM user WHERE email='{$email}'");
                                if (mysqli_num_rows($sql3) > 0){
                                    $row = mysqli_fetch_assoc($sql3);//Tìm và trả về câu truy vấn dưới dạng mảng thích hợp
                                    $_SESSION['id_unique'] = $row['id_unique']; //Sử dụng session chúng ta sử dụng ở các file php khác
                                    echo "success";
                                } else {
                                    echo "Email không tồn tại";
                                }
                            } else {
                                echo "Có gì đó sai!";
                            }
                        }
                    } else {
                        echo "Vui lòng chọn file ảnh - png, jpg, jpeg !!!";
                    }
                } else {
                    echo "Vui lòng chọn file ảnh !";
                }
            }
        } else {
            echo "$email - Đây không phải là một email hợp lệ!!!";
        }
    } else {
        echo "Tất cả các trường đều không được để trống";
    }
?> 