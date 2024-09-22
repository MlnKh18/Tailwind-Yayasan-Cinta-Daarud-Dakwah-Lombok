//  POPUP
const popupNav = document.getElementById("popup-nav");
const menuToggle = document.getElementById("menu-toggle");
const closePopup = document.getElementById("close-popup");

function handleNavClick(e) {
  e.preventDefault();
  const targetId = this.getAttribute("href");
  const targetElement = document.querySelector(targetId);

  targetElement.scrollIntoView({
    behavior: "smooth",
    block: "start",
  });

  popupNav.classList.add("hidden");
}

document.querySelectorAll(".nav-properti").forEach(function (navItem) {
  navItem.addEventListener("click", handleNavClick);
});

menuToggle.addEventListener("click", () => {
  popupNav.classList.toggle("hidden");
});

closePopup.addEventListener("click", () => {
  popupNav.classList.add("hidden");
});

// Swipper
document.addEventListener("DOMContentLoaded", function () {
  const swiperPaginationBullets = document.querySelectorAll(
    ".swiper-pagination-bullet"
  );

  if (swiperPaginationBullets.length > 0) {
    swiperPaginationBullets.forEach((bullet) => {
      bullet.classList.add("wide");
    });
  }
});

var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1.5,
  spaceBetween: 30,
  centeredSlides: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
breakpoints: {
    640: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 3,
    },
  },
});
