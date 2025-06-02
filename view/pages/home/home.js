document.addEventListener("DOMContentLoaded", function () {
  const backToTop = document.getElementById("back-to-top");

  window.addEventListener("scroll", function () {
    if (window.pageYOffset > 300) {
      backToTop.style.display = "block";
    } else {
      backToTop.style.display = "none";
    }
  });

  backToTop.addEventListener("click", function (event) {
    event.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});

let currentIndex = 1;

function moveSlide(direction) {
  const slides = document.querySelectorAll('.slide');
  currentIndex += direction;

  if (currentIndex < 0) {
    currentIndex = slides.length - 1;
  } else if (currentIndex >= slides.length) {
    currentIndex = 0;
  }

  updateSlides(slides);
}

function selectSlide(index) {
  currentIndex = index;
  const slides = document.querySelectorAll('.slide');
  updateSlides(slides);
}

function updateSlides(slides) {
  slides.forEach((slide, i) => {
    const username = slide.querySelector('.large__slide-username');
    const feedback = slide.querySelector('.large__slide-feedback');
    const stars = slide.querySelector('.stars');

    if (!username || !feedback || !stars) return;

    slide.classList.remove('large');
    slide.classList.add('non-selected');

    if (i === currentIndex) {
      slide.classList.add('large');
      username.style.fontSize = '30px';
      feedback.style.fontSize = '15px';
      stars.style.display = 'block';
    } else {
      username.style.fontSize = '20px';
      feedback.style.fontSize = '10px';
      stars.style.display = 'none';
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const slides = document.querySelectorAll('.slide');
  updateSlides(slides);
});

// Слайдер
document.addEventListener('DOMContentLoaded', function () {
  const bannerSlider = document.getElementById('banner-slider');
  const images = [
    '/view/general/images/slider_1.png',
    '/view/general/images/slider_2.png',
    '/view/general/images/slider_3.png',
  ];
  let currentImageIndex = 0;

  function changeBackground() {
    bannerSlider.style.backgroundImage = `url(${images[currentImageIndex]})`;
    currentImageIndex = (currentImageIndex + 1) % images.length;
  }

  setInterval(changeBackground, 5000);
});

document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById("myModal");
  const btns = document.querySelectorAll(".openModalBtn");
  const span = document.querySelector(".close-button");

  btns.forEach(btn => {
    btn.addEventListener("click", function(e) {
      e.preventDefault();
      modal.style.display = "block";

      // Инициализируем Inputmask здесь, после открытия модального окна
      $('#phone').inputmask({
        mask: '+7 (999) 999-99-99',
        placeholder: '+7 (___) ___-__-__',
        showMaskOnHover: false,
        showMaskOnFocus: true,
        onBeforePaste: function (pastedValue, opts) {
          var processedValue = pastedValue.replace(/^8/, '+7');
          return processedValue;
        }
      });
    });
  });

  span.addEventListener("click", function() {
    modal.style.display = "none";
  });

  window.addEventListener("click", function(event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});
