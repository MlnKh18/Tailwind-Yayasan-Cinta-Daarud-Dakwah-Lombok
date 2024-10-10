// POPUP NAVIGATION
const popupNav = document.getElementById("popup-nav");
const menuToggle = document.getElementById("menu-toggle");
const closeNavPopup = document.getElementById("close-popup");

// Smooth Scroll and Close Popup
function handleNavClick(e) {
  e.preventDefault();
  const targetId = this.getAttribute("href");

  // Check if the targetId starts with '#' for IDs
  let targetElement;
  if (targetId.startsWith('#')) {
    targetElement = document.querySelector(targetId);
  } else {
    // If it's not an ID, try to extract from URL if needed
    const urlPattern = /#(.+)/;
    const match = targetId.match(urlPattern);
    if (match) {
      targetElement = document.querySelector(`#${match[1]}`);
    }
  }

  if (targetElement) {
    targetElement.scrollIntoView({
      behavior: "smooth",
      block: "start",
    });
  } else {
    console.error(`Element not found for selector: ${targetId}`);
  }

  popupNav.classList.add("hidden"); // Ensure popup closes after navigation
}


// Add smooth scroll event to navigation items
document.querySelectorAll(".nav-properti").forEach((navItem) => {
  navItem.addEventListener("click", handleNavClick);
});

// Toggle popup navigation
menuToggle?.addEventListener("click", () => {
  popupNav.classList.toggle("hidden");
});

// Close popup
closeNavPopup?.addEventListener("click", () => {
  popupNav.classList.add("hidden");
});

// SWIPER INITIALIZATION
document.addEventListener("DOMContentLoaded", () => {
  const swiperPaginationBullets = document.querySelectorAll(".swiper-pagination-bullet");

  if (swiperPaginationBullets.length > 0) {
    swiperPaginationBullets.forEach((bullet) => {
      bullet.classList.add("wide");
    });
  }
});

new Swiper(".mySwiper", {
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

// CARD PAGE NAVIGATION BASED ON TITLE
document.querySelectorAll('.show-more-button').forEach(button => {
  button.addEventListener('click', (event) => {
    const card = event.target.closest('.card');
    const title = card.getAttribute('data-title');
    const formattedTitle = title.toLowerCase().replace(/\s+/g, '-');
    window.location.href = `./pages/details-image-${formattedTitle}.html`;
  });
});
