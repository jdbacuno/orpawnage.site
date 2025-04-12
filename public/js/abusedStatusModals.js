// Show more of Reports Additional Text
document.addEventListener('DOMContentLoaded', function () {
  const showMoreButtons = document.querySelectorAll('.show-more-btn');
  const notesModal = document.getElementById('notesModal');
  const fullNotesText = document.getElementById('fullNotesText');
  const closeNotesModal = document.getElementById('closeNotesModal');

  showMoreButtons.forEach(button => {
    button.addEventListener('click', function () {
      const fullNotes = this.getAttribute('data-notes');
      fullNotesText.textContent = fullNotes;
      notesModal.classList.remove('hidden');
    });
  });

  closeNotesModal.addEventListener('click', function () {
    notesModal.classList.add('hidden');
  });
});

// incident photo modal
document.addEventListener('DOMContentLoaded', function () {
  const showImageButtons = document.querySelectorAll('.show-image-btn');
  const imageModal = document.getElementById('imageModal');
  const closeImageModal = document.getElementById('closeImageModal');
  const modalImage = document.getElementById('modalImage'); // ✅ define this!

  showImageButtons.forEach(button => {
    button.addEventListener('click', function () {
      const imageSrc = this.getAttribute('data-image');
      console.log(imageSrc);
      modalImage.src = imageSrc;
      imageModal.classList.remove('hidden');
    });
  });

  closeImageModal.addEventListener('click', function () {
    imageModal.classList.add('hidden');
    modalImage.src = ''; // optional: reset image
  });
});