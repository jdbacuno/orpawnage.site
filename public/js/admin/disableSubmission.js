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

  const deleteArchivedForm = document.getElementById("deleteForm");
  if (deleteArchivedForm) {
    deleteArchivedForm.addEventListener("submit", function () {
      const submitBtn = deleteArchivedForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Deleting...";
      }
    });
  }

  // ========= APPROVE =========
  const pickupForm = document.getElementById("pickupForm");
  if (pickupForm) {
    pickupForm.addEventListener("submit", function () {
      const submitBtn = pickupForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Completing...";
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
        submitBtn.innerHTML = "Notifiying...";
      }
    });
  }

  // ========= ARCHIVING/UNARCHIVING =========
  const archiveForm = document.getElementById("archiveForm");
  if (archiveForm) {
    archiveForm.addEventListener("submit", function () {
      const submitBtn = archiveForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Archiving...';
      }
    });
  }

  const archivePetForm = document.getElementById("archivePetForm");
  if (archivePetForm) {
    archivePetForm.addEventListener("submit", function () {
      const submitBtn = archivePetForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Archiving...';
      }
    });
  }

  const unarchiveForm = document.getElementById("unarchiveForm");
  if (unarchiveForm) {
    unarchiveForm.addEventListener("submit", function () {
      const submitBtn = unarchiveForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Unarchiving...';
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

  // ========= SETTINGS =========
  const scheduleForm = document.getElementById("scheduleForm");
  if (scheduleForm) {
    scheduleForm.addEventListener("submit", function () {
      const submitBtn = scheduleForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Sending...';
      }
    });
  }
});