/*  trả về phần tử đầu tiên là phần tử con của phần tử mà nó được gọi ra khớp với nhóm bộ chọn được chỉ định */
const passwordField = document.querySelector(".form .field input[type='password']"),
    toggleBtn = document.querySelector(".form .field i");

toggleBtn.onclick = () => {
    if (passwordField.type == "password"){
        passwordField.type = "text";
        toggleBtn.classList.add("active");
    } else {
        passwordField.type = "password";
        toggleBtn.classList.remove("active");
    }
}