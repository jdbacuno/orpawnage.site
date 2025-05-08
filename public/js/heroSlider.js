const carousel = document.querySelector('#default-carousel');
let index = 0;
let slideInterval;

// Initialize the carousel
function startCarousel() {
  slideInterval = setInterval(() => {
    slideNext();
  }, 10000); // Change slide every 10 seconds
}

// Go to specific slide
function goToSlide(slideIndex) {
  index = slideIndex;
  updateCarousel();
  resetInterval();
}

// Next slide
function slideNext() {
  index = (index >= 2) ? 0 : index + 1;
  updateCarousel();
  resetInterval();
}

// Previous slide
function slidePrev() {
  index = (index <= 0) ? 2 : index - 1;
  updateCarousel();
  resetInterval();
}

// Update carousel position
function updateCarousel() {
  carousel.style.transform = `translateX(-${index * 100}%)`;
  updateIndicators();
}

// Update active indicator
function updateIndicators() {
  const indicators = document.querySelectorAll('[onclick^="goToSlide"]');
  indicators.forEach((indicator, i) => {
    if (i === index) {
      indicator.classList.remove('bg-white/50');
      indicator.classList.add('bg-yellow-400', 'w-8');
    } else {
      indicator.classList.add('bg-white/50');
      indicator.classList.remove('bg-yellow-400', 'w-8');
    }
  });
}

// Reset the auto-slide interval
function resetInterval() {
  clearInterval(slideInterval);
  startCarousel();
}

// Start the carousel when page loads
document.addEventListener('DOMContentLoaded', () => {
  startCarousel();
  updateIndicators();
});