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
  const deleteForm = document.getElementById("deleteForm");
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

  // ========= APPLICATION =========
  const applicationForm = document.getElementById("applicationForm");
  if (applicationForm) {
    applicationForm.addEventListener("submit", function () {
      const submitBtn = applicationForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Submitting application...";
      }
    });
  }

  // ========= REPORT =========
  const reportForm = document.getElementById("reportForm");
  if (reportForm) {
    reportForm.addEventListener("submit", function () {
      const submitBtn = reportForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Submitting report...";
      }
    });
  }

  // ========= SCHEDULE =========
  const scheduleForm = document.getElementById("scheduleForm");
  if (scheduleForm) {
    scheduleForm.addEventListener("submit", function () {
      const submitBtn = scheduleForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Scheduling...";
      }
    });
  }

  // ========= LOGIN =========
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", function () {
      const submitBtn = loginForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Signing in...';
      }
    });
  }

  // ========= REGISTER =========
  const registerForm = document.getElementById("registerForm");
  if (registerForm) {
    registerForm.addEventListener("submit", function () {
      const submitBtn = registerForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Signing up...';
      }
    });
  }

  // ========= FORGOT PASSWORD =========
  const forgotPasswordForm = document.getElementById("forgotPasswordForm");
  if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener("submit", function () {
      const submitBtn = forgotPasswordForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting...';
      }
    });
  }

  // ========= RESET PASSWORD =========
  const resetPasswordForm = document.getElementById("resetPasswordForm");
  if (resetPasswordForm) {
    resetPasswordForm.addEventListener("submit", function () {
      const submitBtn = resetPasswordForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting...';
      }
    });
  }
  
  // ========= RESENDING VERIFICATION EMAIL =========
  const verificationForm = document.getElementById("verificationForm");
  if (verificationForm) {
    verificationForm.addEventListener("submit", function () {
      const submitBtn = verificationForm.querySelector("button[type='submit']");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Resending...';
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

  // ========= DELETE ACCOUNT =========
  const deleteBtn = document.getElementById("deleteBtn");
  if (deleteBtn) {
    deleteBtn.addEventListener("click", function () {
      deleteBtn.disabled = true;
      deleteBtn.innerHTML = 'Deleting...';
    });
  }
});