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

  document.querySelectorAll(".pet-info-btn").forEach(button => {
    button.addEventListener("click", function() {
        const image = this.getAttribute("data-image");
        const number = this.getAttribute("data-number");
        const name = this.getAttribute("data-name");
        const species = this.getAttribute("data-species");
        const age = this.getAttribute("data-age");
        const ageUnit = this.getAttribute("data-age-unit");
        const color = this.getAttribute("data-color");
        const source = this.getAttribute("data-source");
        const sex = this.getAttribute("data-sex");
        const reproductiveStatus = this.getAttribute("data-repro-status");

        // Make the unit singular if age is 1
        const ageUnitSingular = (age === 1) ? (ageUnit === "weeks" ? "week" : (ageUnit === "months" ? "month" : "year")) : ageUnit;
        
        document.getElementById("petImage").src = image;
        document.getElementById("petNumber").textContent = number;
        document.getElementById("petName").textContent = name;
        document.getElementById("petSpecies").textContent = species;
        document.getElementById("petAge").textContent = age;
        document.getElementById("petAgeUnit").textContent = ageUnitSingular;
        document.getElementById("petColor").textContent = color;
        document.getElementById("petSource").textContent = source;
        document.getElementById("petSex").textContent = sex;
        document.getElementById("petReproStatus").textContent = reproductiveStatus;

        petInfoModal.classList.remove("hidden");
    });
  });

  closePetInfoModal.addEventListener('click', function () {
      petInfoModal.classList.add('hidden');
  });

});

// Adopter Info Modal
document.addEventListener('DOMContentLoaded', function () {
  const adopterInfoModal = document.getElementById('adopterInfoModal');
  const closeAdopterInfoModal = document.getElementById('closeAdopterInfoModal');
  
  document.querySelectorAll(".adopter-info-btn").forEach(button => {
    button.addEventListener("click", function() {
        const name = this.getAttribute("data-name");
        const email = this.getAttribute("data-email");
        const age = this.getAttribute("data-age");
        const birthdate = this.getAttribute("data-birthdate");
        const address = this.getAttribute("data-address");
        const phone = this.getAttribute("data-phone");
        const civilStatus = this.getAttribute("data-civil");
        const citizenship = this.getAttribute("data-citizenship");
  
        document.getElementById("adopterName").textContent = name;
        document.getElementById("adopterEmail").textContent = email;
        document.getElementById("adopterAge").textContent = age;
        document.getElementById("adopterBirthdate").textContent = birthdate;
        document.getElementById("adopterAddress").textContent = address;
        document.getElementById("adopterPhone").textContent = phone;
        document.getElementById("adopterCivilStatus").textContent = civilStatus;
        document.getElementById("adopterCitizenship").textContent = citizenship;
  
        document.getElementById("adopterInfoModal").classList.remove("hidden");
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