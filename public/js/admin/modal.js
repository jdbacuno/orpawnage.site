// ADMIN MODAL.JS

// CREATE
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modal");
  const openModalButton = document.getElementById("openModal");
  const closeModalButton = document.getElementById("closeModal");

  // Show modal when clicking "Add a New Pet"
  openModalButton.addEventListener("click", function (e) {
    e.preventDefault();
    modal.classList.remove("hidden");
  });

  // Hide modal when clicking the close button
  closeModalButton.addEventListener("click", function (e) {
    e.preventDefault();
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
    event.preventDefault();
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
    button.addEventListener("click", function(e) {
      e.preventDefault();
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

  closeEditModal.addEventListener("click", function(e) {
    e.preventDefault();
    editModal.classList.add("hidden");
  });

  // Handle image preview when selecting a new image
  editImageInput.addEventListener("change", function (event) {
    event.preventDefault();
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

// Pet Info Modal
document.addEventListener('DOMContentLoaded', function () {
  const petInfoModal = document.getElementById('petInfoModal');
  const closePetInfoModal = document.getElementById('closePetInfoModal');

  document.querySelectorAll(".pet-info-btn").forEach(button => {
    button.addEventListener("click", function (e) {
      e.preventDefault();

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

  closePetInfoModal.addEventListener('click', function (e) {
    e.preventDefault();
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