// POPUP NAVIGATION
const popupNav = document.getElementById("popup-nav");
const menuToggle = document.getElementById("menu-toggle");
const closeNavPopup = document.getElementById("close-popup");

// Fungsi untuk menangani klik pada navigasi
function handleNavClick(e) {
  e.preventDefault();
  const targetId = this.getAttribute("href");
  const targetElement = document.querySelector(targetId);

  if (targetElement) {
    targetElement.scrollIntoView({
      behavior: "smooth",
      block: "start",
    });
  }

  if (popupNav) {
    popupNav.classList.add("hidden");
  }
}

// Menambahkan event listener pada setiap item navigasi
document.querySelectorAll(".nav-properti").forEach(function (navItem) {
  navItem.addEventListener("click", handleNavClick);
});

// Menangani toggle popup navigasi
if (menuToggle) {
  menuToggle.addEventListener("click", () => {
    popupNav?.classList.toggle("hidden");
  });
}

// Menutup popup navigasi saat tombol ditutup ditekan
if (closeNavPopup) {
  closeNavPopup.addEventListener("click", () => {
    popupNav.classList.add("hidden");
  });
}

// POPUP GALLERY
const closeGalleryPopupBtn = document.getElementById("close-gallery-popup"); // Tombol tutup popup galeri

function openGalleryPopup() {
  document.getElementById('popup').classList.remove('hidden');
}

function closeGalleryPopup() {
  document.getElementById('popup').classList.add('hidden');
}

// Menambahkan event listener pada tombol "Lihat Selengkapnya"
document.querySelectorAll('.show-more-button').forEach(button => {
  button.addEventListener('click', function() {
    openGalleryPopup();

    // Ambil data gambar dari card yang diklik
    const card = this.closest('.card');
    const images = JSON.parse(card.getAttribute('data-images'));

    // Menambahkan gambar ke popup galeri
    const popupImagesContainer = document.getElementById('popup-images');
    popupImagesContainer.innerHTML = ''; // Kosongkan konten sebelumnya

    images.forEach(image => {
      const imgElement = document.createElement('img');
      imgElement.src = image;
      imgElement.alt = 'popup image';
      imgElement.className = 'w-[300px] h-[200px] rounded-xl object-cover';
      popupImagesContainer.appendChild(imgElement);
    });
  });
});

// Menambahkan event listener pada tombol tutup popup galeri
if (closeGalleryPopupBtn) {
  closeGalleryPopupBtn.addEventListener('click', closeGalleryPopup);
}

// SWIPER
document.addEventListener("DOMContentLoaded", function () {
  const swiperPaginationBullets = document.querySelectorAll(".swiper-pagination-bullet");

  if (swiperPaginationBullets.length > 0) {
    swiperPaginationBullets.forEach((bullet) => {
      bullet.classList.add("wide");
    });
  }
});

// Inisialisasi Swiper
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
