const swiper = new swiper('.heroslider',{
    spaceBetween: 30,
    slidesPerView: 1,
    loop: true, 
    autiplay:{
        delay: 2500,
         disableOnInteraction: false,
    },
    effect: 'fade',
    navigation: {
       nextEl: "swiper-button-next",
       prevEl: "swiper-button-prev",
    },
  })