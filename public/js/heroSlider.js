const carousel = document.querySelector('#default-carousel');
let index = 0;

function slideNext() {
  if (index >= 2) return;
  index++;
  carousel.style.transform = `translateX(-${index * 100}%)`;
}

function slidePrev() {
  if (index <= 0) return;
  index--;
  carousel.style.transform = `translateX(-${index * 100}%)`;
}
