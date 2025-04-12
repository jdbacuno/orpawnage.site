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

// report delete
document.addEventListener('DOMContentLoaded', function() {
  // Delete Modal Handling
  const deleteModal = document.getElementById('deleteModal');
  const deleteForm = document.getElementById('deleteForm');
  const deleteMessage = document.getElementById('deleteMessage');
  const deleteReportId = document.getElementById('deleteReportId');
  const closeDeleteBtn = document.getElementById('closeDeleteModal');
  const cancelDeleteBtn = document.getElementById('cancelDelete');

  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const reportId = this.dataset.reportId;
      const reportNumber = this.dataset.reportNumber;
      
      deleteReportId.value = reportId;
      deleteMessage.innerHTML = `Are you sure you want to delete report #${reportNumber}?<br><span class="text-red-600 font-medium">This action cannot be undone.</span>`;
      deleteForm.action = `/transactions/abused-status/${reportId}`;
      
      deleteModal.classList.remove('hidden');
    });
  });

  [closeDeleteBtn, cancelDeleteBtn].forEach(btn => {
    btn.addEventListener('click', () => {
      deleteModal.classList.add('hidden');
    });
  });

});