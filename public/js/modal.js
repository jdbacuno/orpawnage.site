function openValidIdModal(event) {
  if (event) event.preventDefault();
  document.getElementById('validIdModal').classList.remove('hidden');  document.getElementById('validIdModal').classList.remove('hidden');
  document.body.classList.add('overflow-hidden');
}

function closeValidIdModal(event) {
  if (event) event.preventDefault();
  document.getElementById('validIdModal').classList.add('hidden');  document.getElementById('validIdModal').classList.add('hidden');
  document.body.classList.remove('overflow-hidden');
}

function openImageModal(imageSrc, petName) {
  const modal = document.getElementById('imageModal');
  const modalImage = document.getElementById('modalImage');
  const imageCaption = document.getElementById('imageCaption');
  
  modalImage.src = imageSrc;
  imageCaption.textContent = petName;
  modal.classList.remove('hidden');
  document.body.classList.add('overflow-hidden');
}

function closeImageModal() {
  document.getElementById('imageModal').classList.add('hidden');
  document.body.classList.remove('overflow-hidden');
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeImageModal();
  }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' && !document.getElementById('imageModal').classList.contains('hidden')) {
    closeImageModal();
  }
});