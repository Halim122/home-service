const hamburger = document.querySelector(".hamurger");
const navlist = document.querySelectorAll(".nav-list");

if(hamburger){
    hamburger.addEventListener('click',()=>{
        navlist.classlist.toggle("open");
    })
    
}