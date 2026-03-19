document.addEventListener('DOMContentLoaded', () => {
  const el = document.querySelector('.bcn-community-slider');
  if (!el) return;

  new Swiper(el, {
    loop: true,
    speed: 700,
    spaceBetween: 24,
    autoHeight: true,
    autoplay: {
      delay: 4500,
      disableOnInteraction: false,
    },
    pagination: {
      el: el.querySelector('.swiper-pagination'),
      clickable: true,
    },
    navigation: {
      nextEl: el.querySelector('.swiper-button-next'),
      prevEl: el.querySelector('.swiper-button-prev'),
    },
  });
});
