const loginSection = document.getElementsByClassName("login-section")[0];
const registerSection = document.getElementsByClassName("register-section")[0];
const message = document.getElementById("success-message");
const successSection = document.getElementById("success-section");


if(window.location.pathname=="/productive/public/register.php"){
    loginSection.style.height="60vh";
    if(message.innerText=="User registered"){
        loginSection.style.display="none";
        registerSection.style.display="none";
        successSection.classList.add("registered");
        successSection.style.display="block";
    }else{
        loginSection.style.display="block";
        registerSection.style.display="block";
        successSection.style.display="none";
    }
}
