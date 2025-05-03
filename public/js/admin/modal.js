// CREATE
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modal");
  const openModalButton = document.getElementById("openModal");
  const closeModalButton = document.getElementById("closeModal");

  // Show modal when clicking "Add a New Pet"
  openModalButton.addEventListener("click", function () {
      modal.classList.remove("hidden");
  });

  // Hide modal when clicking the close button
  closeModalButton.addEventListener("click", function () {
      modal.classList.add("hidden");

      const successMessage = document.querySelector(".add-success");
      if (successMessage) {
        successMessage.classList.add("hidden");
      }
  });

  // Preview selected image to upload (CREATE)
  const imageInput = document.getElementById("imageInput");
  const imagePreview = document.getElementById("imagePreview");
  const imagePlaceholder = document.getElementById("imagePlaceholder");

  imageInput.addEventListener("change", function (event) {
    const file = event.target.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        imagePreview.src = e.target.result;
        imagePreview.classList.remove("hidden");
        imagePlaceholder.classList.add("hidden");
      };
      reader.readAsDataURL(file);
    } else {
      imagePreview.classList.add("hidden");
      imagePlaceholder.classList.remove("hidden");
      imagePreview.src = "";
    }
  });

  if ("{{ session('modal_open') }}" === "add") {
    document.getElementById("modal").classList.remove("hidden");
  } 
});

// EDIT
document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(".edit-btn");
  const editModal = document.getElementById("editModal");
  const closeEditModal = document.getElementById("closeEditModal");
  const editImageInput = document.getElementById("editImageInput");
  const editImagePreview = document.getElementById("editImagePreview");
  const editImagePlaceholder = document.getElementById("editImagePlaceholder");

  editImagePlaceholder.classList.add("hidden");

  editButtons.forEach(button => {
      button.addEventListener("click", function() {
          const petId = this.getAttribute("data-id");
          const petImagePath = this.getAttribute("data-image");

          document.getElementById("editPetId").value = petId;
          document.getElementById("editPetNumber").value = this.getAttribute("data-number");
          document.getElementById("editPetName").value = this.getAttribute("data-name");
          document.getElementById("editSpecies").value = this.getAttribute("data-species");
          document.getElementById("editAge").value = this.getAttribute("data-age");
          document.getElementById("editAgeUnit").value = this.getAttribute("data-age-unit");
          document.getElementById("editSex").value = this.getAttribute("data-sex");
          document.getElementById("editReproStatus").value = this.getAttribute("data-repro-status");
          document.getElementById("editColor").value = this.getAttribute("data-color");
          document.getElementById("editSource").value = this.getAttribute("data-source");

          const successMessage = document.querySelector(".edit-success");
          if (successMessage) {
              successMessage.classList.add("hidden");
          }

          // Update Image Preview
          if (petImagePath && petImagePath.trim() !== "") {
              editImagePreview.src = petImagePath;
              editImagePreview.classList.remove("hidden");
              editImagePlaceholder.classList.add("hidden"); // Hide placeholder
          } else {
              editImagePreview.src = "";
              editImagePreview.classList.add("hidden");
              editImagePlaceholder.classList.remove("hidden"); // Show placeholder
          }

          // Set form action dynamically
          document.getElementById('editPetForm').action = `/admin/pet-profiles/${petId}`;

          editModal.classList.remove("hidden");
      });
  });

  closeEditModal.addEventListener("click", function() {
      editModal.classList.add("hidden");
  });

  // Handle image preview when selecting a new image
  editImageInput.addEventListener("change", function (event) {
      const file = event.target.files[0];

      if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
              editImagePreview.src = e.target.result;
              editImagePreview.classList.remove("hidden");
              editImagePlaceholder.classList.add("hidden");
          };
          reader.readAsDataURL(file);
      } else {
          editImagePreview.classList.add("hidden");
          editImagePlaceholder.classList.remove("hidden");
          editImagePreview.src = "";
      }
  });

  // Ensure modal remains open if session indicates so
  if ("{{ session('modal_open') }}" === "edit") {
      document.getElementById("editModal").classList.remove("hidden");
  }
});

// DELETE
document.addEventListener("DOMContentLoaded", function () {
  const deleteButtons = document.querySelectorAll(".delete-btn");
  const deleteModal = document.getElementById("deleteModal");
  const closeDeleteModal = document.getElementById("closeDeleteModal");
  const deletePetForm = document.getElementById("deletePetForm");
  const deletePetIdText = document.getElementById("deletePetIdText");

  deleteButtons.forEach(button => {
      button.addEventListener("click", function() {
          const petId = this.getAttribute("data-id");
          const petNumber = this.getAttribute("data-number");

          // Set the Pet ID in the modal text
          deletePetIdText.textContent = petNumber;

          // Set the correct form action dynamically
          deletePetForm.action = `/admin/pet-profiles/${petId}`;

          // Show delete modal
          deleteModal.classList.remove("hidden");
      });
  });

  closeDeleteModal.addEventListener("click", function() {
      deleteModal.classList.add("hidden");
  });
});

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

// Approve Adoption Application
document.addEventListener("DOMContentLoaded", function () {
  const approveModal = document.getElementById("approveModal");
  const closeApproveModal = document.getElementById("closeApproveModal");
  const pickupDateInput = document.getElementById("pickupDate");
  const applicationIdInput = document.getElementById("applicationId");

  function setPickupDateRange() {
      const today = new Date();
      let tomorrow = new Date(today);
      tomorrow.setDate(today.getDate() + 1);

      const maxDate = new Date(today);
      maxDate.setDate(today.getDate() + 7);

      // Function to format date as YYYY-MM-DD
      const formatDate = (date) => date.toISOString().split("T")[0];

      // Function to check if a date falls on a weekend (Saturday or Sunday)
      const isWeekend = (date) => date.getDay() === 0 || date.getDay() === 6;

      // Ensure the initial minimum date is not a weekend
      while (isWeekend(tomorrow)) {
          tomorrow.setDate(tomorrow.getDate() + 1);
      }

      // Ensure the max date doesn't include weekends
      let adjustedMaxDate = new Date(maxDate);
      while (isWeekend(adjustedMaxDate)) {
          adjustedMaxDate.setDate(adjustedMaxDate.getDate() - 1);
      }
    
      // Set restrictions
      pickupDateInput.min = formatDate(tomorrow);
      pickupDateInput.max = formatDate(adjustedMaxDate);

    }

  document.querySelectorAll(".approve-btn").forEach(button => {
      button.addEventListener("click", function () {
          const applicationId = this.getAttribute("data-id");

          applicationIdInput.value = applicationId;
          pickupDateInput.value = ""; // Reset date input

          // Set date range restrictions
          setPickupDateRange();

          // Show the modal
          approveModal.classList.remove("hidden");
      });
  });

  closeApproveModal.addEventListener("click", function () {
      approveModal.classList.add("hidden");
  });
});


// Reject Adoption Application
document.addEventListener("DOMContentLoaded", function () {
  const rejectModal = document.getElementById("rejectModal");
  const closeRejectModal = document.getElementById("closeRejectModal");
  const rejectForm = document.getElementById("rejectForm");
  const rejectApplicationIdInput = document.getElementById("rejectApplicationId");

  document.querySelectorAll(".reject-btn").forEach(button => {
      button.addEventListener("click", function () {
          const applicationId = this.getAttribute("data-id");
          rejectApplicationIdInput.value = applicationId;
          rejectModal.classList.remove("hidden");
      });
  });

  closeRejectModal.addEventListener("click", function () {
      rejectModal.classList.add("hidden");
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

// report abused acknowledge and reject modal
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('confirmationModal');
  const closeBtn = document.getElementById('closeConfirmationModal');
  const cancelBtn = document.getElementById('cancelAction');
  const confirmBtn = document.getElementById('confirmButton');
  const actionForm = document.getElementById('actionForm');
  const messageEl = document.getElementById('confirmationMessage');
  const reportIdInput = document.getElementById('modalReportId');
  const actionTypeInput = document.getElementById('modalActionType');

  // Handle acknowledge buttons
  document.querySelectorAll('.acknowledge-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const reportId = this.dataset.reportId;
      const actionType = this.dataset.actionType;
      
      reportIdInput.value = reportId;
      actionTypeInput.value = actionType;
      messageEl.innerHTML = 'Are you sure you want to acknowledge this report?<br><span style="color: green; font-size: 0.875rem;">The user will be notifed via email.</span>';
      confirmBtn.className = 'px-4 py-2 bg-green-500 text-white rounded-md';
      confirmBtn.textContent = 'Acknowledge';
      actionForm.action = '/admin/abused-or-stray-pets/acknowledge';
      
      modal.classList.remove('hidden');
    });
  });

  // Handle reject buttons
  document.querySelectorAll('.reject-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const reportId = this.dataset.reportId;
      const actionType = this.dataset.actionType;
      
      reportIdInput.value = reportId;
      actionTypeInput.value = actionType;
      messageEl.innerHTML = 'Are you sure you want to reject this report?<br><span style="color: green; font-size: 0.875rem;">The user will be notifed via email.</span>';
      confirmBtn.className = 'px-4 py-2 bg-red-500 text-white rounded-md';
      confirmBtn.textContent = 'Reject';
      actionForm.action = '/admin/abused-or-stray-pets/reject';
      
      modal.classList.remove('hidden');
    });
  });

  // Close modal handlers
  [closeBtn, cancelBtn].forEach(btn => {
    btn.addEventListener('click', () => {
      modal.classList.add('hidden');
    });
  });
});