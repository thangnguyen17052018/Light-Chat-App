const searchBar = document.querySelector(".users .search input"),
    searchBtn = document.querySelector(".users .search button");
    userList = document.querySelector(".users .users-list");

searchBtn.onclick = () => {
    searchBar.classList.toggle("active"); /* toggle: có rồi thì bỏ chưa có thì thêm */
    searchBar.focus(); /* focus vào search bar */
    searchBtn.classList.toggle("active");   
    searchBar.value = ""; //Gán thanh searchBar trống mỗi khi bật nút qua lại
}


searchBar.onkeyup = () => {//kích hoạt khi người dùng thả 1 phím đã nhấn trong thẻ
    let searchTerm = searchBar.value;
    /* Chỉ thêm lớp active khi người dùng đang tìm và chỉ chạy setInterval khi bỏ active */
    if (searchTerm != ""){
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }
    //Start Ajax
    let xhr = new XMLHttpRequest(); //Tạo đối tượng XML (object để giao tiếp bất đồng bộ)
    xhr.open("POST","php/search.php", true); /* (phương thức HTTP, URL mà ta sẽ gửi yêu cầu, yêu cầu có đồng bộ hay không) */ /* Dùng GET vì chúng ta nhận thôi chứ không gửi */
    xhr.responseType = 'text';    
    xhr.onload = () => { /* xử lí những request mà chúng ta nhận được */
        if (xhr.readyState === XMLHttpRequest.DONE){/* if (xhr.readyState === XMLHttpRequest.readyState.4)*//* chỉ định trạng thái yêu cầu */ /* request đã xong và dữ liệu trả về đã sẵn sàng để xử lí */
            if (xhr.status === 200){ /* Trạng thái của request: "OK"  để xác định request có thành công hay không*/
                let data = xhr.responseText.trim();
                userList.innerHTML = data;
            }
        }
    }
    /* Kiểu mã hoá: application/x-www-form-urlencoded hay multipart/form-data. Dùng mã hoá nhiều phần cho dữ liệu nhị phân */
    /* POST data = HTML form*/
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");//Thiết lập thông tin (dạng cặp label/value) đến header được gửi.
    xhr.send("searchTerm=" + searchTerm); //Gửi searchTerm của người dùng đến file php với Ajax
}


setInterval( () => {
    //Start Ajax
    let xhr = new XMLHttpRequest(); //Tạo đối tượng XML (object để giao tiếp bất đồng bộ)
    xhr.open("GET","php/users.php", true); /* (phương thức HTTP, URL mà ta sẽ gửi yêu cầu, yêu cầu có đồng bộ hay không) */ /* Dùng GET vì chúng ta nhận thôi chứ không gửi */
    xhr.responseType = 'text';    
    xhr.onload = () => { /* xử lí những request mà chúng ta nhận được */
        if (xhr.readyState === XMLHttpRequest.DONE){/* if (xhr.readyState === XMLHttpRequest.readyState.4)*//* chỉ định trạng thái yêu cầu */ /* request đã xong và dữ liệu trả về đã sẵn sàng để xử lí */
            if (xhr.status === 200){ /* Trạng thái của request: "OK"  để xác định request có thành công hay không*/
                let data = xhr.responseText.trim();
                if (!searchBar.classList.contains("active")){//Nếu searchBar không chứa lớp active thì chèn dữ liệu
                    userList.innerHTML = data;
                }  
            }
        }
    }
    xhr.send();
}, 500); //function này sẽ chạy mỗi lần sau 500ms
