// USER MODAL.JS

// Delete/Cancel Adoption Application
function openCancelModal(applicationId, event) {
  if (event) event.preventDefault();
  document.getElementById('cancelModal').classList.remove('hidden');
  document.getElementById('deleteForm').action = "/transactions/" + applicationId;
}

function closeCancelModal(event) {
  if (event) event.preventDefault();
  document.getElementById('cancelModal').classList.add('hidden');
}

function openResendModal(applicationId, event) {
  if (event) event.preventDefault();
  document.getElementById('resendForm').action = `/transactions/${applicationId}/resend-email`;
  document.getElementById('resendModal').classList.remove('hidden');
}

function closeResendModal(event) {
  if (event) event.preventDefault();
  document.getElementById('resendModal').classList.add('hidden');
}

// Valid IDs Modal
function openValidIdModal(event) {
  if (event) event.preventDefault();
  document.getElementById('validIdModal').classList.remove('hidden');
  document.body.classList.add('overflow-hidden');
}

function closeValidIdModal(event) {
  if (event) event.preventDefault();
  document.getElementById('validIdModal').classList.add('hidden');
  document.body.classList.remove('overflow-hidden');
}

// Show more of Reports Additional Text
document.addEventListener('DOMContentLoaded', function () {
  const showMoreButtons = document.querySelectorAll('.show-more-btn');
  const notesModal = document.getElementById('notesModal');
  const fullNotesText = document.getElementById('fullNotesText');
  const closeNotesModal = document.getElementById('closeNotesModal');

  showMoreButtons.forEach(button => {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      const fullNotes = this.getAttribute('data-notes');
      fullNotesText.textContent = fullNotes;
      notesModal.classList.remove('hidden');
    });
  });

  closeNotesModal.addEventListener('click', function (event) {
    event.preventDefault();
    notesModal.classList.add('hidden');
  });
});

// incident photo modal
document.addEventListener('DOMContentLoaded', function () {
  const showImageButtons = document.querySelectorAll('.show-image-btn');
  const imageModal = document.getElementById('imageModal');
  const closeImageModal = document.getElementById('closeImageModal');
  const modalImage = document.getElementById('modalImage');

  showImageButtons.forEach(button => {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      const imageSrc = this.getAttribute('data-image');
      console.log(imageSrc);
      modalImage.src = imageSrc;
      imageModal.classList.remove('hidden');
    });
  });

  closeImageModal.addEventListener('click', function (event) {
    event.preventDefault();
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
    btn.addEventListener('click', function(event) {
      event.preventDefault();
      const reportId = this.dataset.reportId;
      const reportNumber = this.dataset.reportNumber;
      
      deleteReportId.value = reportId;
      deleteMessage.innerHTML = `Are you sure you want to delete report #${reportNumber}?<br><span class="text-red-600 font-medium">This action cannot be undone.</span>`;
      deleteForm.action = `/transactions/abused-status/${reportId}`;
      
      deleteModal.classList.remove('hidden');
    });
  });

  [closeDeleteBtn, cancelDeleteBtn].forEach(btn => {
    btn.addEventListener('click', (event) => {
      event.preventDefault();
      deleteModal.classList.add('hidden');
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const scrollIntoNextSection = document.getElementById('scrollIntoNextSection');
  const elementToScrollInto = document.getElementById('elementToScrollInto');

  scrollIntoNextSection.addEventListener('click', function () {
    const offset = window.innerHeight * 0.1; // 10% of the viewport height
    const elementPosition = elementToScrollInto.getBoundingClientRect().top + window.scrollY;

    window.scrollTo({
      top: elementPosition - offset,
      behavior: 'smooth'
    });
  });
});