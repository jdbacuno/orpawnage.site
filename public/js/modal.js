// Delete/Cancel Adoption Application
function openCancelModal(applicationId) {
  document.getElementById('cancelModal').classList.remove('hidden');
  document.getElementById('deleteForm').action = "/transactions/" + applicationId;
}

function closeCancelModal() {
  document.getElementById('cancelModal').classList.add('hidden');
}

function openResendModal(applicationId) {
  document.getElementById('resendForm').action = `/transactions/${applicationId}/resend-email`;
  document.getElementById('resendModal').classList.remove('hidden');
}

function closeResendModal() {
  document.getElementById('resendModal').classList.add('hidden');
}

// Pet Info Modal
document.addEventListener('DOMContentLoaded', function () {
  const petInfoModal = document.getElementById('petInfoModal');
  const closePetInfoModal = document.getElementById('closePetInfoModal');

  document.querySelectorAll(".pet-info-btn").forEach(button => {
    button.addEventListener("click", function () {
      // Calculate and display humanized time ago
      const createdAt = this.getAttribute("data-created-at");
      if (createdAt) {
        const timeAgo = timeSince(new Date(createdAt));
        document.getElementById("petTimeAgo").textContent = `Added ${timeAgo}`;
      }

      // Set pet image
      const image = this.getAttribute("data-image");
      document.getElementById("petImage").src = image;
      
      // Set pet name and number
      document.getElementById("petName").textContent = this.getAttribute("data-name");
      document.getElementById("petNumber").textContent = `#${this.getAttribute("data-number")}`;
      
      // Set species with icon
      const species = this.getAttribute("data-species");
      document.getElementById("petSpecies").textContent = species === 'feline' ? 'Cat' : 'Dog';
      document.getElementById("speciesIcon").className = species === 'feline' ? 
        'ph-fill ph-cat mr-1' : 'ph-fill ph-dog mr-1';
      
      // Set age
      const age = this.getAttribute("data-age");
      const ageUnit = this.getAttribute("data-age-unit");
      document.getElementById("petAge").textContent = 
        `${age} ${ageUnit}`;
      
      // Set sex with appropriate styling
      const sex = this.getAttribute("data-sex");
      const sexContainer = document.getElementById("sexContainer");
      const sexLabel = document.getElementById("sexLabel");
      
      if (sex === 'male') {
        sexContainer.className = 'bg-blue-50 text-blue-800 border-blue-100 px-4 py-3 rounded-lg border flex flex-col';
        sexLabel.className = 'text-xs font-medium text-blue-600 flex items-center';
        sexLabel.querySelector('i').className = 'ph-fill ph-gender-male mr-1';
      } else {
        sexContainer.className = 'bg-pink-50 text-pink-800 border-pink-100 px-4 py-3 rounded-lg border flex flex-col';
        sexLabel.className = 'text-xs font-medium text-pink-600 flex items-center';
        sexLabel.querySelector('i').className = 'ph-fill ph-gender-female mr-1';
      }
      document.getElementById("petSex").textContent = sex.charAt(0).toUpperCase() + sex.slice(1);
      
      // Set reproductive status with appropriate styling
      const reproStatus = this.getAttribute("data-repro-status");
      const reproContainer = document.getElementById("reproStatusContainer");
      const reproIcon = document.getElementById("reproStatusIcon");
      
      if (reproStatus === 'neutered') {
        reproContainer.className = 'bg-red-50 text-red-800 border-red-100 px-4 py-3 rounded-lg border flex flex-col';
        reproIcon.className = 'ph-fill ph-scissors mr-1';
      } else if (reproStatus === 'intact') {
        reproContainer.className = 'bg-green-50 text-green-800 border-green-100 px-4 py-3 rounded-lg border flex flex-col';
        reproIcon.className = 'ph-fill ph-scissors mr-1';
      } else {
        reproContainer.className = 'bg-amber-50 text-amber-800 border-amber-100 px-4 py-3 rounded-lg border flex flex-col';
        reproIcon.className = species === 'feline' ? 
          'ph-fill ph-cat mr-1' : 'ph-fill ph-dog mr-1';
      }

      document.getElementById("petReproStatus").textContent = reproStatus.charAt(0).toUpperCase() + reproStatus.slice(1);
      
      // Set color and source
      document.getElementById("petColor").textContent = this.getAttribute("data-color");
      document.getElementById("petSource").textContent = this.getAttribute("data-source");
      
      // Show modal
      petInfoModal.classList.remove("hidden");
    });
  });

  closePetInfoModal.addEventListener('click', function () {
    petInfoModal.classList.add('hidden');
  });

  // Improved timeSince function
  function timeSince(date) {
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    
    if (seconds < 60) return "just now";
    
    const intervals = {
      year: 31536000,
      month: 2592000,
      week: 604800,
      day: 86400,
      hour: 3600,
      minute: 60
    };
    
    let parts = [];
    
    // Calculate years first
    const years = Math.floor(seconds / intervals.year);
    if (years > 0) {
      parts.push({
        unit: 'year',
        value: years
      });
      seconds -= years * intervals.year;
    }
    
    // Calculate remaining months (max 11)
    const months = Math.floor(seconds / intervals.month);
    if (months > 0) {
      // If we have exactly 12 months total (0 years + 12 months), convert to 1 year
      if (years === 0 && months === 12) {
        return "1 year ago";
      }
      // Otherwise show months if we have 1-11 months
      if (months < 12) {
        parts.push({
          unit: 'month',
          value: months
        });
      }
    }
    
    // For durations less than 1 month
    if (parts.length === 0) {
      const weeks = Math.floor(seconds / intervals.week);
      if (weeks > 0) {
        parts.push({
          unit: 'week',
          value: weeks
        });
        seconds -= weeks * intervals.week;
      }
      
      const days = Math.floor(seconds / intervals.day);
      if (days > 0) {
        parts.push({
          unit: 'day',
          value: days
        });
      }
    }
    
    // For durations less than 1 day
    if (parts.length === 0) {
      const hours = Math.floor(seconds / intervals.hour);
      if (hours > 0) {
        return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
      }
      
      const minutes = Math.floor(seconds / intervals.minute);
      if (minutes > 0) {
        return `${minutes} minute${minutes !== 1 ? 's' : ''} ago`;
      }
    }
    
    // Format the output
    if (parts.length === 0) return "just now";
    
    const formattedParts = parts.slice(0, 2).map(part => {
      return `${part.value} ${part.unit}${part.value !== 1 ? 's' : ''}`;
    });
    
    return formattedParts.join(' and ') + ' ago';
  }
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