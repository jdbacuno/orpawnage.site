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
  });
});
