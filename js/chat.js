const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector(".send-btn"),
chatBox = document.querySelector(".chat-box"),
sendImage = form.querySelector("#image-upload");

form.onsubmit = (e) => {
    e.preventDefault(); /* ngăn form submit thay vì trả về return false */
}

  

sendBtn.onclick = () => {
    //Start Ajax
    let xhr = new XMLHttpRequest(); //Tạo đối tượng XML (object để giao tiếp bất đồng bộ)
    xhr.open("POST","php/insert-chat.php", true); /* (phương thức HTTP, URL mà ta sẽ gửi yêu cầu, yêu cầu có đồng bộ hay không) */
    xhr.responseType = 'text';    
    xhr.onload = () => { /* xử lí những request mà chúng ta nhận được */
        if (xhr.readyState === XMLHttpRequest.DONE){/* if (xhr.readyState === XMLHttpRequest.readyState.4)*//* chỉ định trạng thái yêu cầu */ /* request đã xong và dữ liệu trả về đã sẵn sàng để xử lí */
            if (xhr.status === 200){ /* Trạng thái của request: "OK"  để xác định request có thành công hay không*/
                inputField.value = "";  //Mỗi lần tin nhắn đc gửi thì input khởi tạo trống
                // let element =  $("#mytext").emojioneArea();
                // element[0].emojioneArea.setText("");
                $(".emojionearea-editor").html('');
                scrollToBottom();
            }
        }
    }
    //Chúng ta cần gửi form dữ liệu qua Ajax đến php
    let formData = new FormData(form); //Khởi tạo đối tượng formData
    xhr.send(formData);
}

//dừng function khi người dùng cuộn lên
chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

setInterval( () => {
    //Start Ajax
    let xhr = new XMLHttpRequest(); //Tạo đối tượng XML (object để giao tiếp bất đồng bộ)
    xhr.open("POST","php/get-chat.php", true); /* (phương thức HTTP, URL mà ta sẽ gửi yêu cầu, yêu cầu có đồng bộ hay không) */ /* Dùng GET vì chúng ta nhận thôi chứ không gửi */
    xhr.responseType = 'text';    
    xhr.onload = () => { /* xử lí những request mà chúng ta nhận được */
        if (xhr.readyState === XMLHttpRequest.DONE){/* if (xhr.readyState === XMLHttpRequest.readyState.4)*//* chỉ định trạng thái yêu cầu */ /* request đã xong và dữ liệu trả về đã sẵn sàng để xử lí */
            if (xhr.status === 200){ /* Trạng thái của request: "OK"  để xác định request có thành công hay không*/
                let data = xhr.responseText.trim();
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")){ //Nếu mà con trỏ chuột ở trong chat box thì người dùng có thể cuộn
                    scrollToBottom();
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}, 500); //function này sẽ chạy mỗi lần sau 500ms

//Scroll tin nhắn xuống bottom
function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}

$(document).ready(function(){
    $("#mytext").emojioneArea({
        pickerPosition: "top",
        toneStyle: "bullet",
        inline: true,
        hidePickerOnBlur: true,
        autocomplete: false,
        events: {
            keyup: function(editor, event) {
                // catches everything but enter
                var el = $("#mytext").emojioneArea();
                if (event.which == 13) {
                 //Start Ajax
                    let xhr = new XMLHttpRequest(); //Tạo đối tượng XML (object để giao tiếp bất đồng bộ)
                    xhr.open("POST","php/insert-chat.php", true); /* (phương thức HTTP, URL mà ta sẽ gửi yêu cầu, yêu cầu có đồng bộ hay không) */
                    xhr.responseType = 'text';    
                    xhr.onload = () => { /* xử lí những request mà chúng ta nhận được */
                        if (xhr.readyState === XMLHttpRequest.DONE){/* if (xhr.readyState === XMLHttpRequest.readyState.4)*//* chỉ định trạng thái yêu cầu */ /* request đã xong và dữ liệu trả về đã sẵn sàng để xử lí */
                            if (xhr.status === 200){ /* Trạng thái của request: "OK"  để xác định request có thành công hay không*/
                                // console.log(el[0].emojioneArea.getText());
                                // editor.value = ""; //Mỗi lần tin nhắn đc gửi thì input khởi tạo trống
                                // let element =  $("#mytext").emojioneArea();
                                // element[0].emojioneArea.setText("");
                                $(".emojionearea-editor").html('');
                                scrollToBottom();
                            }
                        }
                    }
                    //Chúng ta cần gửi form dữ liệu qua Ajax đến php
                    let formData = new FormData(form); //Khởi tạo đối tượng formData
                    formData.append('message', el[0].emojioneArea.getText());
                    xhr.send(formData);
                }
            }
        }
    })
});


$(document).on('click', '.delete-btn', function(){
    var chat_message_id = $(this).attr('id');
    /* console.log(chat_message_id); */
    if (confirm("Bạn muốn xóa tin nhắn này thiệt hôn ?")){
        $.ajax({
            url:"php/remove-chat.php",
            method:"POST",
            data:{id_message:chat_message_id},
            success:function(data){
                console.log(data);
            }
        })

    }
});



/* document.getElementById("image-upload").onchange = function () {
    if(document.getElementById("image-upload").files.length != 0 ){
        if (confirm("Bạn muốn gửi hình hôn ?")){
            var path_image = document.getElementById("image-upload").value;
            $.ajax({
                url:"php/image-chat.php",
                method:"POST",
                data:{path_image:path_image},
                success:function(data){
                    console.log(path_image);
                }
            })
            document.getElementById("image-upload").value=null; 
        }
        else {
            document.getElementById("image-upload").value=null; 
        }
    }
} */

sendImage.onchange = () => {
    //Start Ajax
    let ok = 0;
    let path_image =  sendImage.value;
    let xhr = new XMLHttpRequest(); //Tạo đối tượng XML (object để giao tiếp bất đồng bộ)
    xhr.open("POST","php/image-chat.php", true); /* (phương thức HTTP, URL mà ta sẽ gửi yêu cầu, yêu cầu có đồng bộ hay không) */
    xhr.responseType = 'text';    
    xhr.onload = () => { /* xử lí những request mà chúng ta nhận được */
        if (xhr.readyState === XMLHttpRequest.DONE){/* if (xhr.readyState === XMLHttpRequest.readyState.4)*//* chỉ định trạng thái yêu cầu */ /* request đã xong và dữ liệu trả về đã sẵn sàng để xử lí */
            if (xhr.status === 200){ /* Trạng thái của request: "OK"  để xác định request có thành công hay không*/
                scrollToBottom();
                console.log(path_image);
            }
        }
    }
    //Chúng ta cần gửi form dữ liệu qua Ajax đến php
    let formData = new FormData(form); //Khởi tạo đối tượng formData
    if (confirm("Bạn muốn gửi hình hôn ?")){
        ok = 1;
    }
    if (ok==1){
        xhr.send(formData);
        sendImage.value=null;
    } else {
        sendImage.value=null;
    }
}