/*
*    JS for cookies modal
*/

let cookieModal = document.querySelector(".cookie-consent-modal")
let cancelCookieBtn = document.querySelector(".btn-cook.cancel")
let acceptCookieBtn = document.querySelector(".btn-cook.accept")

/* DIRIGIR AL HOME */
cancelCookieBtn.addEventListener("click", function (){
    // cookieModal.classList.remove("active")
    window.location.assign("./index.html");
})

acceptCookieBtn.addEventListener("click", function (){
    cookieModal.classList.remove("active")
    localStorage.setItem("cookieAccepted", "yes")
})

setTimeout(function (){
    let cookieAccepted = localStorage.getItem("cookieAccepted")
    if (cookieAccepted != "yes"){
        cookieModal.classList.add("active")
    }
}, 1000)
