// DISABLES SUBMIT BUTTON WHEN SUBMITTING
document.addEventListener("DOMContentLoaded", function () {
  // ========= CREATE =========
  const createForm = document.getElementById("addPetForm");
  if (createForm) {
    createForm.addEventListener("submit", function () {
      const submitBtn = createForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Saving...";
      }
    });
  }

  // ========= EDIT =========
  const editForm = document.getElementById("editPetForm");
  if (editForm) {
    editForm.addEventListener("submit", function () {
      const submitBtn = editForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Updating...";
      }
    });
  }

  // ========= DELETE =========
  const deleteForm = document.getElementById("deletePetForm");
  if (deleteForm) {
    deleteForm.addEventListener("submit", function () {
      const submitBtn = deleteForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Deleting...";
      }
    });
  }

  // ========= APPROVE =========
  const approveForm = document.getElementById("approveForm");
  if (approveForm) {
    approveForm.addEventListener("submit", function () {
      const submitBtn = approveForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Approving...";
      }
    });
  }

  // ========= REJECT =========
  const rejectForm = document.getElementById("rejectForm");
  if (rejectForm) {
    rejectForm.addEventListener("submit", function () {
      const submitBtn = rejectForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Rejecting...";
      }
    });
  }

  // ========= REPORT ACTION (ACKNOWLEDGE / REJECT) =========
  const actionForm = document.getElementById("actionForm");
  if (actionForm) {
    actionForm.addEventListener("submit", function () {
      const submitBtn = actionForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = submitBtn.textContent + "...";
      }
    });
  }

  // ========= SETTINGS =========
  const settingsForm = document.getElementById("settingsForm");
  if (settingsForm) {
    settingsForm.addEventListener("submit", function () {
      const submitBtn = settingsForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting...';
      }
    });
  }
});