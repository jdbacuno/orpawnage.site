// Delete/Cancel Adoption Application
function openCancelModal(applicationId) {
  document.getElementById('cancelModal').classList.remove('hidden');
  document.getElementById('deleteForm').action = "/transactions/" + applicationId;
}

function closeCancelModal() {
  document.getElementById('cancelModal').classList.add('hidden');
}

// Pet Info Modal
document.addEventListener('DOMContentLoaded', function () {
  const petInfoModal = document.getElementById('petInfoModal');
  const closePetInfoModal = document.getElementById('closePetInfoModal');
  
  // Add event listeners for pet info buttons
  document.querySelectorAll(".pet-info-btn").forEach(button => {
      button.addEventListener("click", function () {
          // Debugging: Log button data to verify correct data attributes
          console.log('Button clicked', this);

          // Populate modal inputs with the button's data-attributes
          document.getElementById("petNumber").value = this.getAttribute("data-number");
          document.getElementById("petName").value = this.getAttribute("data-name");
          document.getElementById("petSpecies").value = this.getAttribute("data-species");
          document.getElementById("petAge").value = this.getAttribute("data-age") + " " + this.getAttribute("data-age-unit");
          document.getElementById("petColor").value = this.getAttribute("data-color");
          document.getElementById("petSex").value = this.getAttribute("data-sex");
          document.getElementById("petReproStatus").value = this.getAttribute("data-repro-status");
          document.getElementById("petSource").value = this.getAttribute("data-source");

          // Debugging: Log modal data to check if the data is being populated
          console.log('Modal data populated:', {
              number: this.getAttribute("data-number"),
              name: this.getAttribute("data-name"),
              species: this.getAttribute("data-species"),
              age: this.getAttribute("data-age")
          });

          // Assign pet image to modal
          const image = this.getAttribute("data-image");
          document.getElementById("petImage").src = image;

          // Show modal
          petInfoModal.classList.remove("hidden");

          // Debugging: Log modal visibility
          console.log('Modal should be visible:', petInfoModal.classList.contains("hidden"));
      });
  });

  // Close the modal when the close button is clicked
  closePetInfoModal.addEventListener('click', function () {
      petInfoModal.classList.add('hidden');
  });
});

// Adopter's Info Modal
document.addEventListener('DOMContentLoaded', function () {
  const adopterInfoModal = document.getElementById('adopterInfoModal');
  const closeAdopterInfoModal = document.getElementById('closeAdopterInfoModal');

  document.querySelectorAll(".adopter-info-btn").forEach(button => {
    button.addEventListener("click", function() {
        // Assign to modal
        document.getElementById("adopterName").value = this.getAttribute("data-name");
        document.getElementById("adopterEmail").value = this.getAttribute("data-email");
        document.getElementById("adopterAge").value = this.getAttribute("data-age") + " years old";
        document.getElementById("adopterBirthdate").value = this.getAttribute("data-birthdate");
        document.getElementById("adopterAddress").value = this.getAttribute("data-address");
        document.getElementById("adopterPhone").value = this.getAttribute("data-phone");
        document.getElementById("adopterCivilStatus").value = this.getAttribute("data-civil");
        document.getElementById("adopterCitizenship").value = this.getAttribute("data-citizenship");
        document.getElementById("adopterReason").value = this.getAttribute("data-reason");
        document.getElementById("adopterVisitVet").value = this.getAttribute("data-visitvet");
        document.getElementById("adopterExistingPets").value = this.getAttribute("data-existingpets");
        document.getElementById("adopterValidId").href = this.getAttribute("data-validid");

        adopterInfoModal.classList.remove("hidden");
    });
  });

  closeAdopterInfoModal.addEventListener('click', function () {
      adopterInfoModal.classList.add('hidden');
  });
});

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