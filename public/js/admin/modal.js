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
          document.getElementById("editSpecies").value = this.getAttribute("data-species");
          document.getElementById("editBreed").value = this.getAttribute("data-breed");
          document.getElementById("editAge").value = this.getAttribute("data-age");
          document.getElementById("editAgeUnit").value = this.getAttribute("data-age-unit");
          document.getElementById("editSex").value = this.getAttribute("data-sex");
          document.getElementById("editColor").value = this.getAttribute("data-color");

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
