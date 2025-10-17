const carousel = document.querySelector('#default-carousel');
let index = 1;
let slideInterval;

// Initialize the carousel
function startCarousel() {
  slideInterval = setInterval(() => {
    slideNext();
  }, 15000); // Change slide every 15 seconds
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
let startX = 0;
let endX = 0;

document.addEventListener('DOMContentLoaded', () => {
  updateCarousel();
  startCarousel();

  // Add swipe support for mobile
  const carousel = document.querySelector('#default-carousel');
  if (carousel) {
    carousel.addEventListener('touchstart', (e) => {
      startX = e.changedTouches[0].screenX;
    });

    carousel.addEventListener('touchend', (e) => {
      endX = e.changedTouches[0].screenX;
      handleSwipe();
    });
  }
});

function handleSwipe() {
  const threshold = 50; // Minimum swipe distance
  const diff = startX - endX;

  if (Math.abs(diff) > threshold) {
    if (diff > 0) {
      // Swipe left - next slide
      slideNext();
    } else {
      // Swipe right - previous slide
      slidePrev();
    }
  }
}
